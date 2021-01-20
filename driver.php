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

//Build New Customer Array
$customer["username"] = "someusername";
$customer["company_name"] = "None LLC";
$customer["taxable"] = true;
$customer["discount"] = 0;
$customer["opt_out_email"] = false;
$customer["opt_out_text"] = false;
$customer["date_created"] = "2019-01-09T06:07:00-0700";
$customer["contact_info"]["id"] = "2073";
$customer["contact_info"]["first_name"] = "Some";
$customer["contact_info"]["last_name"] = "Name";
$customer["contact_info"]["phone_number"] = "801";
$customer["contact_info"]["cell_phone_number"] = "123";
$customer["contact_info"]["email"] = "foreup@fake.com";
$customer["contact_info"]["birthday"] = "2017-01-09T06:07:00-0700";
$customer["contact_info"]["address1"] = "101 Test Way";
$customer["contact_info"]["address2"] = "Apt #13";
$customer["contact_info"]["city"] = "Lindon";
$customer["contact_info"]["state"] = "UT";
$customer["contact_info"]["zip"] = "12345";
$customer["contact_info"]["country"] = "USA";
$customer["contact_info"]["handicap_account_number"] = "1";
$customer["contact_info"]["handicap_score"] = "12";
$customer["contact_info"]["comments"] = "The best!";

$customer_obj = new Customers();
$customer_obj->createCustomer($course_id,$customer);

//Entered a Customer
print "$customer_obj->id : $customer_obj->first_name : $customer_obj->last_name : $customer_obj->username : $customer_obj->companyname\n";

