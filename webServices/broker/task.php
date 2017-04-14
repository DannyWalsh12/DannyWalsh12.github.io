<?php
/**
 * Created by PhpStorm.
 * User: Dan Delciappo
 * Date: 2/13/2017
 * Time: 6:39 PM
 */
require_once ("db.php");

class taskBroker{
    function createTasks($request){
        $db = new db();

        if($db->createTask($request->taskTitle,$request->taskDescrip,$request->userId,$request->listId)){
            $response["TaskResponse"] = "The task has been created";
        }
        else{
            $response["TaskResponse"] = "Failed to create task";
        }

        return $response;


    }
}
