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

        $userId= $session->getSessionUserId();

        $response["TaskResponse"] = "Never entered loop";
        if($db->createTask($request->taskTitle,$request->taskDescrip,$userId,$request->listId)){
            $response["TaskResponse"] = "The task has been created";
        }
        else{
            $response["TaskResponse"] = "Failed to create task";
        }

        return $response;


    }
}
