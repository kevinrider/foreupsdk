<?php
include_once('config.php');
include_once(__DIR__.'/src/jwtHTTP.class.php'); 
include_once(__DIR__.'/src/course.class.php'); 
include_once(__DIR__.'/src/customer.class.php'); 

//Get JWT and Validate.  Setup the JWT "session".
$jwtHTTP = new JWTHTTP();
$jwtHTTP->AccessToken();
if($jwtHTTP->jwt != "" && $jwtHTTP->ValidateToken())
{
    //Set JWT as Constant
    defineConst('JWT', "$jwtHTTP->jwt");
    //Examine JWT for session details.
    $jwt_array = explode(".",JWT);
    //print_r($jwt_array);
    $jwt_json = (string) base64_decode($jwt_array[1]);
    $jwt_obj = json_decode($jwt_json);
    $user_id = $jwt_obj->uid;
    $expires = date('Y-m-d H:i:s',$jwt_obj->exp);
    print "JWT token received and validated.\nUser: $user_id Session Expires: $expires.\n";

}
else
{
    print "JWT access/validation failed\n";
    exit;
}

//Find what courses this JWT has access too.
$courses_obj = new Courses();
$courses_obj->GetCourseList();
$course_id = $courses_obj->id;

//Found a course for this JWT
print "$course_id : $courses_obj->title : $courses_obj->street : $courses_obj->state : $courses_obj->zip : $courses_obj->summary\n";

//Build New Customer Object
$customer_obj = new Customers();
$customer_obj->type = "customer";
$customer_obj->username = "someusername";
$customer_obj->company_name = "None LLC";
$customer_obj->taxable = true;
$customer_obj->discount = 0;
$customer_obj->opt_out_email = false;
$customer_obj->opt_out_text = false;
$customer_obj->date_created = "2019-01-09T06:07:00-0700";
$customer_obj->id = "2073";
$customer_obj->first_name = "Some";
$customer_obj->last_name = "Name";
$customer_obj->phone_number = "801";
$customer_obj->cell_phone_number = "123";
$customer_obj->email = "foreup@fake.com";
$customer_obj->birthday = "2017-01-09T06:07:00-0700";
$customer_obj->address1 = "101 Test Way";
$customer_obj->address2 = "Apt #13";
$customer_obj->city = "Lindon";
$customer_obj->state = "UT";
$customer_obj->zip = "12345";
$customer_obj->country = "USA";
$customer_obj->handicap_account_number = "1";
$customer_obj->handicap_score = "12";
$customer_obj->comments = "The best!";

$customer_obj->createCustomer($course_id);

//Entered a Customer
print "$customer_obj->id : $customer_obj->first_name : $customer_obj->last_name : $customer_obj->username : $customer_obj->companyname\n";

//Get One Customer Record
$getone_obj = new Customers();
$getone_obj->getOneCustomer($course_id,$customer_obj->id);
print "GetOne Response: $getone_obj->id : $getone_obj->first_name : $getone_obj->last_name : $getone_obj->username : $getone_obj->companyname\n";

