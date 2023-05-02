# Webhook Subscriptions - PHP API Client

<p>API Subscriptions<p> <p>Esta API te permite administrar tus subscripciones de Webhook para recibir notificaciones asíncronas por parte de las APIs de Círculo de Crédito.</p><br/><img src='https://github.com/APIHub-CdC/imagenes-cdc/blob/master/circulo_de_credito-apihub.png' height='37' width='160'/><br/>

## Requisitos

PHP >= 7.3.20
### Dependencias adicionales
- Composer [vea como instalar][1]
- Se debe contar con las siguientes dependencias de PHP:
    - ext-curl
    - ext-mbstring
    - OpenSSL
```sh
# RHEL distros
yum install php-mbstring
yum install curl
yum install openssl

# Debian distros
apt-get install php-mbstring
apt-get install php-curl
apt-get install openssl
```

## Instalación

Ejecutar: `composer install`

## Guía de inicio

### Paso 1. Generar llave y certificado

- Se tiene que tener un contenedor en formato PKCS12.
- En caso de no contar con uno, ejecutar las instrucciones contenidas en **lib/Interceptor/key_pair_gen.sh** o con los siguientes comandos.

**Opcional**: Para cifrar el contenedor, colocar una contraseña en una variable de ambiente.
```sh
export KEY_PASSWORD=your_password
```
- Definir los nombres de archivos y alias.
```sh
export PRIVATE_KEY_FILE=pri_key.pem
export CERTIFICATE_FILE=certificate.pem
export SUBJECT=/C=MX/ST=MX/L=MX/O=CDC/CN=CDC
export PKCS12_FILE=keypair.p12
export ALIAS=circulo_de_credito
```
- Generar llave y certificado.
```sh
#Genera la llave privada.
openssl ecparam -name secp384r1 -genkey -out ${PRIVATE_KEY_FILE}
#Genera el certificado público.
openssl req -new -x509 -days 365 \
    -key ${PRIVATE_KEY_FILE} \
    -out ${CERTIFICATE_FILE} \
    -subj "${SUBJECT}"
```
- Generar contenedor en formato PKCS12.
```sh
# Genera el archivo pkcs12 a partir de la llave privada y el certificado.
# Deberá empaquetar la llave privada y el certificado.
openssl pkcs12 -name ${ALIAS} \
    -export -out ${PKCS12_FILE} \
    -inkey ${PRIVATE_KEY_FILE} \
    -in ${CERTIFICATE_FILE} -password pass:${KEY_PASSWORD}
```

### Paso 2. Cargar el certificado dentro del portal de desarrolladores

 1. Iniciar sesión, da clic en la esquina superior derecha donde se encuentra el texto "Iniciar sesión".
 2. Ingresa tu usuario y contraseña para iniciar sesión en el portal.
 3. Una vez iniciada la sesión exitasamente, en la esquina superior derecha, dar clic en "**Mi cuenta**" esto desplegará un sub-menú, dar clic en la opción "**Apps**".
 4. Selecciona la applicación deseada o crea una nueva.
 5. Una vez seleccionada la aplicación deseada, al final de la pantalla se encuenta un botón con la leyenda "**Certificados**" dar clic.
 6. Cargar/subir el certificado público generado en el paso 1.

### Paso 3. Descargar el certificado de Círculo de Crédito dentro del portal de desarrolladores

 1. Iniciar sesión, da clic en la esquina superior derecha donde se encuentra el texto "Iniciar sesión".
 2. Ingresa tu usuario y contraseña para iniciar sesión en el portal.
 3. Una vez iniciada la sesión exitasamente, en la esquina superior derecha, dar clic en "**Mi cuenta**" esto desplegará un sub-menú, dar clic en la opción "**Apps**".
 4. Selecciona la applicación deseada o crea una nueva.
 5. Una vez seleccionada la aplicación deseada, al final de la pantalla se encuenta un botón con la leyenda "**Certificados**" dar clic.
 6. Descargar el certificado público de Círculo de Crédito.
 

 > Es importante que este contenedor sea almacenado en la siguiente ruta:
 > **/path/to/repository/lib/Interceptor/keypair.p12**
 >
 > Así mismo el certificado proporcionado por Círculo de Crédito en la siguiente ruta:
 > **/path/to/repository/lib/Interceptor/cdc_cert.pem**
- En caso de que no se almacene así, se debe especificar la ruta donde se encuentra el contenedor y el certificado. Ver el siguiente ejemplo:
```php
$password = getenv('KEY_PASSWORD');
$this->signer = new KeyHandler(
    "/example/route/keypair.p12",
    "/example/route/cdc_cert.pem",
    $password
);
```
 > **NOTA:** Solamente en caso de que el contenedor se haya cifrado, debe colocarse la contraseña en una variable de ambiente e indicar el nombre de la misma, como se ve en la imagen anterior.

 
### Paso 4. Modificar URL y credenciales

 Modificar la URL y las credenciales de acceso a la petición en ***test/Api/WebhookSubscriptionApiTest.php***, como se muestra en el siguiente fragmento de código:

```php
...
public function setUp(): void
{
    $this->username = "your_circulodecredito_username";
    $this->password = 'your_circulodecredito_password';
    $this->apiKey   = "your_circulodecredito_apikey";

    $apiUrl              = "https://services.circulodecredito.com.mx/v1/subscriptions";
    $keystorePassword    = "your_keystore_password";
    $keystore            = "your-keystore.p12";
    $cdcCertificate      = "your.cdc_cert.pem";

    $this->webhookToken = new WebhookToken($cdcCertificate, $keystore, $keystorePassword);

    $signer = new KeyHandler($keystore, $cdcCertificate, $keystorePassword);

    $events = new MiddlewareEvents($signer);
    $handler = HandlerStack::create();
    $handler->push($events->add_signature_header('x-signature'));
    $handler->push($events->verify_signature_header('x-signature'));

    $this->config = new Configuration();
    $this->config->setHost($apiUrl);

    $this->httpClient = new HttpClient([
        'handler' => $handler
    ]);
}
...
 ```
 
### Paso 5. Capturar los datos y realizar la petición

> **NOTA:** Los datos de la siguiente petición son solo representativos.

```php
...
public function testCreateNewSubscription()
{
    try {
        $body = new Subscription();
        $body->setWebHookUrl("https://your-webhook-url");
        $body->setEnrollmentId($this->uuid());
        $body->setEventType("");

        $x_webhook_jwt_auth = $this->webhookToken->generateJwtAuth("your-webhook-user", "your-webhook-password");

        $api = new WebhookSubscriptionApi($this->httpClient, $this->config);
        $response = $api->createNewSubscription($this->apiKey, $this->username, $this->password, $x_webhook_jwt_auth, $body);

        print ("[INFO  ]HTTP Response body:\n $response");

    } catch  (ApiException $exception)  {
        print("\nThe HTTP request failed, an error occurred: ".($exception->getMessage()));
        print("\n".$exception->getResponseObject());
    }

    $this->assertNotNull($response);
}
...
```

## Pruebas unitarias

Deshabilita la ejecución de algún método test agregando la anotación **`@group skip`**

```php
...

/**
 * 
 * @group skip
 */
public function testGetSubscriptionById()
{
...
}
...
```

 - Para ejecutar **todas** las pruebas unitarias elimina la anotación @group skip en cada método test y ejecuta:

```sh

./vendor/bin/phpunit

```

 - Para ejecutar pruebas unitarias específicas, utiliza la anotación
   `@group skip` y la opción `--exclude` en phpunit para excluir las métodos que NO deseas ejecutar:

```sh

./vendor/bin/phpunit --exclude skip

```

[1]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos

---
[CONDICIONES DE USO, REPRODUCCIÓN Y DISTRIBUCIÓN](https://github.com/APIHub-CdC/licencias-cdc)

[1]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos