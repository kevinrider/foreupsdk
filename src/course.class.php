<?php
//Implements Courses End Point
include_once(__DIR__.'/jwtHTTPTrait.php');
class Courses
{
    use jwtHTTPTrait;
    public $type;
    public $id;
    public $title;
    public $street;
    public $state;
    public $zip;
    public $phone;
    public $course_summary;
    public $base_color;
    
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
        //Could be handled in jsonResponseMap if more than one.
        $this->jsonResponseMap($response_obj);
    }
    
}

