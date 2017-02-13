<?php
/**
 * Created by PhpStorm.
 * User: Dan Delciappo
 * Date: 2/13/2017
 * Time: 6:39 PM
 */
class tasksBroker{
    function createTasks($request){
        $response["TaskResponse"] = "TaskTitle= ".$request->taskTitle;
        return $response;
    }
}
