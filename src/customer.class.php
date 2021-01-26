<?php
//Implements Customers End Point
include_once(__DIR__.'/jwtHTTPTrait.php'); 
class Customers implements JsonSerializable
{
    use jwtHTTPTrait;
    public $type;
    public $id;
    public $username;
    public $company_name;
    public $taxable;
    public $discount;
    public $opt_out_email;
    public $opt_out_text;
    public $date_created;
    public $first_name;
    public $last_name;
    public $phone_number;
    public $cell_phone_number;
    public $email;
    public $birthday;
    public $address_1;
    public $address_2;
    public $city;
    public $state;
    public $zip;
    public $country;
    public $handicap_account_number;
    public $handicap_score;
    public $comments;
    
    public function getOneCustomer($course_id,$customer_id)
    {
        //Get Customer record for a specific Course and customer id.
        $uri = str_replace("courseId",$course_id,URL_GETONE_CUSTOMER);
        $uri = str_replace("customerId",$customer_id,$uri);
        $method = "GET";
        $response_obj = $this->getjwtHTTPResponse($uri,$method);
        $this->jsonResponseMap($response_obj);
    }
    
    public function createCustomer($course_id)
    {
        //Inserts Customer record for a specifc Course.
        $uri = str_replace("courseId",$course_id,URL_CREATE_CUSTOMER);
        $method = "POST";
        $jsonapibody = json_encode($this->jsonSerialize());
        $response_obj = $this->getjwtHTTPResponse($uri,$method,$jsonapibody);
        $this->jsonResponseMap($response_obj);
    }
    
    public function jsonSerialize() 
    {
        return 
        ['data' => 
            ['type' => $this->type, 'attributes' =>
                [
                    'username' => $this->username,
                    'company_name' => $this->company_name,
                    'taxable' => $this->taxable,
                    'discount' => $this->discount,
                    'opt_out_email' => $this->opt_out_email,
                    'opt_out_text' => $this->opt_out_text,
                    'date_created' => $this->date_created,
                    'contact_info' =>
                        [
                            "id" => $this->id,
                            "first_name" => $this->first_name,
                            "last_name" => $this->last_name,
                            "phone_number" => $this->phone_number,
                            "cell_phone_number" => $this->cell_phone_number,
                            "email" => $this->email,
                            "birthday" => $this->birthday,
                            "address_1" => $this->address_1,
                            "address_2" => $this->address_2,
                            "city" => $this->city,
                            "state" => $this->state,
                            "zip" => $this->zip,
                            "country" => $this->country,
                            "handicap_account_number" => $this->handicap_account_number,
                            "handicap_score" => $this->handicap_score,
                            "comments" => $this->comments
                        ]

                ]
            ]
        ];
    }
}

