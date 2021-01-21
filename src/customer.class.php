<?php
//Implements Customers End Point
include_once(__DIR__.'/jwtHTTPTrait.php'); 
class Customers implements JsonSerializable
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
    public $phone_number;
    public $cell_phone_number;
    public $email;
    public $birthday;
    public $address1;
    public $address2;
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
        $this->MapResponse($response_obj[0]);
    }
    
    public function createCustomer($course_id)
    {
        //Inserts Customer record for a specifc Course.
        $uri = str_replace("courseId",$course_id,URL_CREATE_CUSTOMER);
        $method = "POST";
        $jsonapibody = json_encode($this->jsonSerialize());
        $response_obj = $this->getjwtHTTPResponse($uri,$method,$jsonapibody);
        $this->MapResponse($response_obj);
    }
    
    protected function MapResponse($response_obj)
    {
        $this->type = $response_obj->type;
        $this->username = $response_obj->username;
        $this->companyname = $response_obj->company_name;
        $this->taxable = $response_obj->taxable;
        $this->discount = $response_obj->discount;
        $this->opt_out_email = $response_obj->opt_out_email;
        $this->opt_out_text = $response_obj->opt_out_text;
        $this->date_created = $response_obj->date_created;
        $this->id = $response_obj->contact_info['id'];
        $this->first_name = $response_obj->contact_info['first_name'];
        $this->last_name = $response_obj->contact_info['last_name'];
        $this->phone_number = $response_obj->contact_info['phone_number'];
        $this->cell_phone_number = $response_obj->contact_info['cell_phone_number'];
        $this->email = $response_obj->contact_info['email'];
        $this->birthday = $response_obj->contact_info['birthday'];
        $this->address1 = $response_obj->contact_info['address_1'];
        $this->address2 = $response_obj->contact_info['address_2'];
        $this->city = $response_obj->contact_info['city'];
        $this->state = $response_obj->contact_info['state'];
        $this->zip = $response_obj->contact_info['zip'];
        $this->country = $response_obj->contact_info['country'];
        $this->handicap_account_number = $response_obj->contact_info['handicap_account_number'];
        $this->handicap_score = $response_obj->contact_info['handicap_score'];
        $this->comments = $response_obj->contact_info['comments'];
    }
    
    public function jsonSerialize() 
    {
        return 
        ['data' => 
            ['type' => $this->type, 'attributes' =>
                [
                    'username' => $this->username,
                    'company_name' => $this->companyname,
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
                            "address_1" => $this->address1,
                            "address_2" => $this->address2,
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

