<?php
//Implements Courses End Point
include_once(__DIR__.'/jwtHTTPTrait.php');
class Courses
{
    use jwtHTTPTrait;
    public $id;
    public $title;
    public $street;
    public $state;
    public $zip;
    public $phone;
    public $summary;
    
    function __construct($id = "")
    {
        $this->id = "$id";
    }
    
    public function GetCourseList()
    {
        //Get the accessible Courses for session JWT.
        $uri = URL_COURSELIST;
        $method = "GET";
        $jsonapibody = "";
        $response_obj = $this->getjwtHTTPResponse($uri,$method,$jsonapibody);
        //Assuming this is a single item, which may not be true.
        //        print_r($response_obj);
        //        exit;
        $this->id = $response_obj[0]->id;
        $this->title = $response_obj[0]->title;
        $this->street = $response_obj[0]->street;
        $this->state = $response_obj[0]->state;
        $this->zip = $response_obj[0]->zip;
        $this->phone = $response_obj[0]->phone;
        $this->summary = $response_obj[0]->course_summary;
        
    }
    
}

