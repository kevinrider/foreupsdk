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
}
