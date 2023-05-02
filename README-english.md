# Webhook Subscriptions - PHP API Client

<p>API Subscriptions<p> <p>This API allows you to manage your Webhook subscriptions to receive asynchronous notifications from the APIs of Círculo de Crédito.</p><br/><img src='https://github.com/APIHub-CdC/imagenes-cdc/blob/master/circulo_de_credito-apihub.png' height='37' width='160'/><br/>

## Requirements

PHP >= 7.3.20
### Additional dependencies
- Composer [See how to install][1]
- You must have the following PHP dependencies:
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

## Installation

Run the command: `composer install`

## Start guide

### Step 1. Generate key and certificate

- You have to have a container in format PKCS12.
- If you do not have one, execute the instructions contained in **lib/Interceptor/key_pair_gen.sh** o con los siguientes comandos.

**Optional**: To encrypt the container, put a password in an environment variable.
```sh
export KEY_PASSWORD=your_password
```
- Define environment variables for certificates generation.
```sh
export PRIVATE_KEY_FILE=pri_key.pem
export CERTIFICATE_FILE=certificate.pem
export SUBJECT=/C=MX/ST=MX/L=MX/O=CDC/CN=CDC
export PKCS12_FILE=keypair.p12
export ALIAS=circulo_de_credito
```
- Generate key and certificate.
```sh
#Create private key.
openssl ecparam -name secp384r1 -genkey -out ${PRIVATE_KEY_FILE}

#Create public certificate.
openssl req -new -x509 -days 365 \
    -key ${PRIVATE_KEY_FILE} \
    -out ${CERTIFICATE_FILE} \
    -subj "${SUBJECT}"
```
- Create container PKCS12.
```sh
# Create the file pkcs12 from the private key and certificate.
openssl pkcs12 -name ${ALIAS} \
    -export -out ${PKCS12_FILE} \
    -inkey ${PRIVATE_KEY_FILE} \
    -in ${CERTIFICATE_FILE} -password pass:${KEY_PASSWORD}
```

### Step 2. Upload your public certificate in the developer portal of Círculo de Crédito

 1. Log in, click on the upper right corner where the "Iniciar sesión" label is.
 2. Enter your username and password to log in.
 3. Once logged in successfully, in the upper right corner, click on the "**Mi cuenta**" label which will display a submenu, click on the "**Apps**" option.
 4. Select the desired application or create a new one.
 5. Once the desired application is selected, at the bottom of the screen click on the button with the "**Certificados**" label.
 6. Upload your public certificate generated in step 1.

### Step 3. Download the certificate of Círculo de Crédito from the developer portal

 1. Log in, click on the upper right corner where the "Iniciar sesión" label is.
 2. Enter your username and password to log in.
 3. Once logged in successfully, in the upper right corner, click on the "**Mi cuenta**" label which will display a submenu, click on the "**Apps**" option.
 4. Select the desired application.
 5. Once the desired application is selected, at the bottom of the screen click on the button with the "**Certificados**" label.
 6. Download the Círculo de Crédito public certificate by clicking the button labeled "**Descargar**".

 ### Step 4. Modify the URL and the access credentials

 Modify the URL and the access credentials to the request in ***test/Api/WebhookSubscriptionApiTest.php***, as shown in the following code snippet:

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
 
### Step 5. Capture the data of the corresponding operation in the API and make the request.

> **NOTE:** The data in the following request is representative only.

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

## Unit Test

Disable the execution of some test method by adding the annotation **`@group skip`**

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

 - To run **all** unit tests remove the @group skip annotation on each test method and run:

```sh

./vendor/bin/phpunit

```

 - To run specific unit tests, use the annotation
   `@group skip` and the option `--exclude` in phpunit to exclude the methods you do NOT want to execute:

```sh

./vendor/bin/phpunit --exclude skip

```

[1]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos

---
[CONDITIONS OF USE, REPRODUCTION AND DISTRIBUTION](https://github.com/APIHub-CdC/licencias-cdc)

[1]: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos