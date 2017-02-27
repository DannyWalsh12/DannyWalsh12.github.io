<?php

/**
 * Created by PhpStorm.
 * User: briankrupp
 */

require_once ("db.php");

class securityBroker
{
  function authenticate($request) {

    $db = new db();

    $userId = $db->authenticateUser($request->username, $this->hashPass($request->secretPassword));

    $response["userId"]=-1;

    if($userId > 0){
        $response["userId"] = $userId;
        $_SESSION["userId"] = $userId;
    }

    return $response;
  }

  function createUser($request){
    $db = new db();

    $response["createUser"] = "no User Created";

    if($db->createUserAccount($request->username, $this->hashPass($request->password), $request->Email,$request->Verification)){
        $response["createUser"] = "User Created";
        return $response;
    }
    $response["createUser"] = "User failed to be created";
    return $response;
  }

  function logOff($request){
      session_unset();
      session_destroy();
  }

  function hashPass($password){
      return hash("sha256",$password);
  }
}