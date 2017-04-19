<?php

/**
 * Created by PhpStorm.
 * User: briankrupp
 */

require_once ("db.php");
require_once ("session.php");

class securityBroker
{
  function authenticate($request) {

    $db = new db();

    $userId = $db->authenticateUser($request->username, $this->hashPass($request->secretPassword));

    $response["userId"]=-2;

    if($userId > 0){
        $response["userId"] = $userId;

        $session = new session();
        $session->startSession();
        $session->setSessionUserId($userId);

    }

    return $response;
  }

  function createUser($request){
    $db = new db();

    if($db->createUserAccount($request->username, $this->hashPass($request->Password), $request->Email,$request->Verification)){
        $response["createUser"] = "user account created";
    }
    else{
        $response["createUser"] = "User failed to be created";
    }

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