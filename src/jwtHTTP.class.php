<?php
include_once(__DIR__.'/../vendor/autoload.php');
use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client as GuzzleClient;
use WoohooLabs\Yang\JsonApi\Client\JsonApiClient;
use WoohooLabs\Yang\JsonApi\Request\JsonApiRequestBuilder;
use WoohooLabs\Yang\JsonApi\Hydrator\ClassDocumentHydrator;

//Class sets up JWT Access Token, Validation, and subsequent JWT "wrapped" HTTP requests

class JWTHTTP
{
    function __construct($uri = "",$method = "GET")
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->request = "";
        $this->jwt = "";
    }

    public function GetResponse($uri,$method,$jsonapibody)
    {
        //Handles GET/POST requests with JWT headers set.
        //Dehydrates JSON API response and returns as object.
        //Assumes JWT constant has been set already.
        if(null == JWT)
        {
            print "JWT must be acquired and validated first.";
            exit;
        }
        $requestBuilder = new JsonApiRequestBuilder(new Request("GET", ''));
        $x_auth = "Bearer " . JWT;
        try
        {
            if($method == "GET")
            {
                $request = $requestBuilder
                    ->setMethod("GET")
                    ->setUri($uri)
                    ->setHeader("Content-Type", "application/json")
                    ->setHeader("x-authorization", "$x_auth")
                    ->getRequest();
            }
            elseif($method == "POST")
            {
                $request = $requestBuilder
                    ->setMethod("POST")
                    ->setUri("$uri")
                    ->setHeader("Content-Type", "application/json")
                    ->setHeader("x-authorization", "$x_auth")
                    ->setJsonApiBody($jsonapibody)
                    ->getRequest();
            }
            else 
            {
                //No other methods at the moment
            }
            //Setup guzzle adapter
            $guzzleClient = GuzzleClient::createWithConfig([]);
            $client = new JsonApiClient($guzzleClient);

            // Retrieve response
            $response = $client->sendRequest($request);

            //Deserialize the response
            $hydrator = new ClassDocumentHydrator();
            //Check to see which type of hydration will be need on the object
            if($response->document()->isSingleResourceDocument())
            {
                //Single reponse
                $hydrated_response = $hydrator->hydrateSingleResource($response->document());

            }
            else
            {
                //Collection response (arrays in objects)
                $hydrated_response = $hydrator->hydrateCollection($response->document());
            }
        }
        catch (Exception $e)
        {   
            print_r($e);
        }
        return $hydrated_response;
    }
    
    public function AccessToken()
    {
        //Get JWT Token
        //Build HTTP Request w/ JSON API body
        $requestBuilder = new JsonApiRequestBuilder(new Request("GET", ''));
        $request = $requestBuilder
            ->setMethod("POST")
            ->setUri(REQUEST_TOKEN_URL)
            ->setJsonApiFields(["email" => APP_USER, "password" => APP_PASSWORD])
            ->getRequest();
        //print_r($request);
        //exit;

        //HTTP Client Instance with Guzzle Adapter
        $guzzleClient = GuzzleClient::createWithConfig([]);
        $client = new JsonApiClient($guzzleClient);

        // Retrieve response
        $response = $client->sendRequest($request);

        //Deserialize the response
        $hydrator = new ClassDocumentHydrator();
        $token = $hydrator->hydrateSingleResource($response->document());
        $this->jwt = (string) $token->id;
    }
    
    public function ValidateToken()
    {
        //Validate JWT
        $validate_url = VALIDATE_TOKEN_URL . "/$this->jwt";
        $requestBuilder = new JsonApiRequestBuilder(new Request("GET", ''));
        $request = $requestBuilder
            ->setMethod("GET")
            ->setUri("$validate_url")
            ->setHeader("Content-Type", "application/json")
            ->setHeader("x-authorization", "Bearer $this->jwt")
            ->getRequest();

        $guzzleClient = GuzzleClient::createWithConfig([]);
        $client = new JsonApiClient($guzzleClient);

        // Retrieve response
        // HTTP 200 is only issued on success.  Do not need to inspect body.
        $response = $client->sendRequest($request);
        if($response->isSuccessful())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
