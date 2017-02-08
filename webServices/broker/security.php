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

    // Check for password
    if ($request->secretPassword == "Notes!") {
      $response["authenticationStatus"] = "You are logged in!";
    }

    return $response;
  }
}