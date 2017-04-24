<?php
/**
 * Created by PhpStorm.
 * User: Dan Delciappo
 * Date: 2/13/2017
 * Time: 6:39 PM
 */
require_once ("db.php");
require_once ("session.php");

class taskBroker{
    function createTasks($request){
        $db = new db();
        $session = new session();


        if($session->isSessionValid()) {
            if ($db->createTask($request->taskTitle, $request->taskDescrip, $session->getSessionUserId(), $request->listId)) {
                $response["TaskResponse"] = "The task has been created";
            } else {
                $response["TaskResponse"] = "Failed to create task";
            }

            return $response;
        }
        else{
            return $response["TaskResponse"] = "Invalid Session Id";
        }
    }

    function getTasks($request){
        $db = new db();
        $session = new session();

        if($session->isSessionValid()){
            return $db->getTasks($session->getSessionUserId(),$request->listId);

        }
        return $response["session"] = "not a valid session Id";

    }

    function getList(){
        $db = new db();
        $session = new session();

        if($session->isSessionValid()){
            return $db->getLists($session->getSessionUserId());
        }
        return $response["session"] = "not a valid session Id";

    }
}
