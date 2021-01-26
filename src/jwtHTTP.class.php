<?php
include_once(__DIR__.'/../vendor/autoload.php');
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

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
        //Returns json decoded object that can be mapped to class variables with jsonResponseMap
        //Assumes JWT constant has been set already.
        if(null == JWT)
        {
            print "JWT must be acquired and validated first.";
            exit;
        }
        $headers = ['Content-Type' => 'application/json', 'x-authorization', "Bearer " . JWT];
        try
        {
            if($method == "GET")
            {
                $request = new Request('GET', $uri, $headers, "");
            }
            elseif($method == "POST")
            {
                $request = new Request('POST', $uri, $headers, $jsonapibody);
            }
            else 
            {
                //No other methods at the moment
            }
            $client = new Client();
            $response = $client->send($request);
            $response_obj = json_decode($response->getBody()->getContents());
        }
        catch (Exception $e)
        {   
            print_r($e);
        }
        return $response_obj;
    }
    
    public function AccessToken()
    {
        //Get JWT Token
        $login['email'] = APP_USER;
        $login['password'] = APP_PASSWORD;
        $body = json_encode($login);
        $headers = ['Content-Type' => 'application/json'];
        $request = new Request('POST', REQUEST_TOKEN_URL, $headers, $body);
        $client = new Client();
        //print_r($request);
        $response = $client->send($request);
        $body = json_decode($response->getBody()->getContents());
        $this->jwt = (string) $body->data->id;
    }
    
    public function ValidateToken()
    {
        //Validate JWT
        $validate_url = VALIDATE_TOKEN_URL . "/$this->jwt";
        $body = "";
        $headers = ['Content-Type' => 'application/json', 'x-authorization', "Bearer $this->jwt"];
        $request = new Request('GET', $validate_url, $headers, $body);
        $client = new Client();
        //print_r($request);
        $response = $client->send($request);
        if($response->getStatusCode() == "200")
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
