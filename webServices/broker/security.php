<?php

/**
 * Created by PhpStorm.
 * User: briankrupp
 */
class securityBroker
{
  function authenticate($request) {
    // Create default message
    $response["authenticationStatus"] = "You failed to login";

    //checks for username
    if($request->username == "admin") {
        // Check for password
        if ($request->secretPassword == "password") {
            $response["authenticationStatus"] = "username= ".$request->username."<br />password= ".$request->secretPassword;
        }
    }

        return $response;
  }
}