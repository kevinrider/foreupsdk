<?php

trait jwtHTTPTrait 
{
    public function getjwtHTTPResponse($uri,$method,$jsonapibody = "")
    {
        //JWT Wrapper function
        $jwtHTTP = new JWTHTTP();
        $response_object = $jwtHTTP->GetResponse($uri,$method,$jsonapibody);
        return $response_object;
    }
    
    public function jsonResponseMap($body_obj,$depth = 0)
    {
        //Recursively step through array or objects or a combination of the two.
        //Assign each key as a class variable with its value.
  
        //Probably will not work for an array with same components. i.e customer1 -> name customer2 -> name
        //However the response_obj could be broken into individual arrays then processed
        //through this function (foreach in the calling class method).
        
        foreach($body_obj as $key => $value)
        {
            if((is_object($value) || is_array($value)) && $depth < 25)
            {
                $depth++;
                $this->jsonResponseMap($value,$depth);
            }
            elseif($depth > 25)
            {
                print "Object too deep. Stopped recursion.\n";
                return false;
            }
            else 
            {
                $this->$key = $value;
            }
        }
    }
}
