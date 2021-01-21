<?php
//Implements Customers End Point
include_once(__DIR__.'/jwtHTTPTrait.php'); 
class Customers
{
    use jwtHTTPTrait;
    public $type;
    public $id;
    public $username;
    public $companyname;
    public $taxable;
    public $discount;
    public $opt_out_email;
    public $opt_out_text;
    public $date_created;
    public $first_name;
    public $last_name;
    
    public function getOneCustomer($course_id,$customer_id)
    {
        //Get Customer record for a specific Course and customer id.
        $uri = str_replace("courseId",$course_id,URL_GETONE_CUSTOMER);
        $uri = str_replace("customerId",$customer_id,$uri);
        $method = "GET";
        $response_obj = $this->getjwtHTTPResponse($uri,$method);
        self::MapResponse($response_obj[0]);
    }
    
    public function createCustomer($course_id,$customerArray)
    {
        //Inserts Customer record for a specifc Course.
        $uri = str_replace("courseId",$course_id,URL_CREATE_CUSTOMER);
        $method = "POST";
        $jsonapibody = "{\"data\": { \"type\": \"customer\", \"attributes\":" .  json_encode($customerArray) . "}}";
        $response_obj = $this->getjwtHTTPResponse($uri,$method,$jsonapibody);
        self::MapResponse($response_obj);
        
    }
    
    protected function MapResponse($response_obj)
    {
        $this->id = $response_obj->contact_info['id'];
        $this->first_name = $response_obj->contact_info['first_name'];
        $this->last_name = $response_obj->contact_info['last_name'];
        $this->type = $response_obj->type;
        $this->username = $response_obj->username;
        $this->companyname = $response_obj->company_name;
        $this->taxable = $response_obj->taxable;
        $this->discount = $response_obj->discount;
        $this->opt_out_email = $response_obj->opt_out_email;
        $this->opt_out_text = $response_obj->opt_out_text;
        $this->date_created = $response_obj->date_created;
    }
}

