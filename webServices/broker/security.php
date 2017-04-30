<?php

/**
 * used to talk with the Database
 * Used to authenticate a user and if successful with start a session for the user.
 * also is used for creating users and getting the username of currently logged in user
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

    if($request->Verification == 8675309) {

        if ($db->createUserAccount($request->username, $this->hashPass($request->Password), $request->Email, $request->Verification)) {
            $response["createUser"] = true;
        } else {
            $response["createUser"] = false;
        }
    }
    else{
        $response["createUser"] = false;
    }

    return $response;
  }

  function getUser(){
      $db = new db();
      $session = new session();

      if($session->isSessionValid()){
          $response["name"] = $db->getUser($session->getSessionUserId());
          return $response;
      }
      return "not a valid session Id";

  }

  function LogOut(){
    $session = new session();
    $session->destroySession();
  }

  function hashPass($password){
      return hash("sha256",$password);
  }
}