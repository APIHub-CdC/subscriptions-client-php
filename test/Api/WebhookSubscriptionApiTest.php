<?php
namespace CirculoDeCredito\Subscriptions\Client;

use CirculoDeCredito\Subscriptions\Client\Api\WebhookSubscriptionApi;
use CirculoDeCredito\Subscriptions\Client\Model\Subscription;

use \CirculoDeCredito\Subscriptions\Client\Configuration;
use \CirculoDeCredito\Subscriptions\Client\ApiException;
use \CirculoDeCredito\Subscriptions\Client\ObjectSerializer;
use \CirculoDeCredito\Subscriptions\Client\WebhookToken;

use Signer\Manager\Interceptor\MiddlewareEvents;
use Signer\Manager\Interceptor\KeyHandler;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;

class WebhookSubscriptionApiTest extends \PHPUnit\Framework\TestCase
{
    
    private $username;
    private $password;
    private $apiKey;
    private $httpClient;
    private $config;
    private $webhookToken;

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
    
    /**
     * 
     * @group 
     */
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
    
    /**
     * 
     * @group skip
     */
    public function testGetSubscriptionById()
    {
        try {
            $subscription_id = "";

            $api = new WebhookSubscriptionApi($this->httpClient, $this->config);
            $response = $api->getSubscriptionById($subscription_id, $this->apiKey, $this->username, $this->password);

            print ("[INFO  ]HTTP Response body:\n $response");

        } catch  (ApiException $exception)  {
            print("\nThe HTTP request failed, an error occurred: ".($exception->getMessage()));
            print("\n".$exception->getResponseObject());
        }
    
        $this->assertNotNull($response);
    }
    
    /**
     * 
     * @group skip
     */
    public function testListAllSubscriptions()
    {
        try {
            $page = 1;
            $per_page = 15;

            $api = new WebhookSubscriptionApi($this->httpClient, $this->config);
            $response = $api->listAllSubscriptions($this->apiKey, $this->username, $this->password, $page, $per_page);

            print ("[INFO  ]HTTP Response body:\n $response");

        } catch  (ApiException $exception)  {
            print("\nThe HTTP request failed, an error occurred: ".($exception->getMessage()));
            print("\n".$exception->getResponseObject());
        }
    
        $this->assertNotNull($response);
    }

    /**
     * 
     * @group skip
     */
    public function testDeleteSubscriptionById()
    {
        try {
            $subscription_id = "";

            $api = new WebhookSubscriptionApi($this->httpClient, $this->config);
            $response = $api->deleteSubscriptionById($subscription_id, $this->apiKey, $this->username, $this->password);

            print ("[INFO  ]HTTP Response body:\n $response");

        } catch  (ApiException $exception)  {
            print("\nThe HTTP request failed, an error occurred: ".($exception->getMessage()));
            print("\n".$exception->getResponseObject());
        }
    
        $this->assertNotNull($response);
    }

    /**
     * Generates UUID v4.
     */
    public function uuid():string {
        $bytes = random_bytes(16);

        $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));

        return $uuid;
    }
}
