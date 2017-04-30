<?php
/**
 * this is the piece that talks to the db layer for everything
 * that has to do with tasks or lists.
 * each function makes sure that the user has a valid session and are logged in before
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
    function createList($request){
        $db = new db();
        $session = new session();

        if($session->isSessionValid()){
            if($db->createList($request->ListTitle, $session->getSessionUserId())){
                $response["ListResponse"] = "The List has been created";
            }
            else {
                $response["ListResponse"] = "Failed to Create List";
            }
            return $response;
        }
        return $response["ListResponse"] = "Invalid Session Id";

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
    function EditTasks($request){
        $db = new db();
        $session = new session();

        if($session->isSessionValid()){
            return $db->EditTasks($request->taskId);
        }
    }
    function MobileGetList($request){
        $db = new db();

        if($request->userId > 0){
            return $db->getLists($request->userId);
        }
        return $response["session"] = "not a valid session";

    }
    function MobileGetTasks($request){
        $db = new db();

        if($request->userId) {
            return $db->getTasks($request->userId, $request->listId);
        }

        return $response["session"] = "not a valid session Id";

    }
    function MobileCreateTasks($request){
        $db = new db();

        if ($db->createTask($request->taskTitle, $request->taskDescrip, $request->userId, $request->listId)) {
            $response["TaskResponse"] = "The task has been created";
        }
        else {
            $response["TaskResponse"] = "Failed to create task";
        }

        return $response;

    }
    function DeleteTasks($request){
        $db = new db();
        $session = new session();

        if($session->isSessionValid()){
            return $db->DeleteTask($request->taskId);
        }
        return $response["session"] = "Not a valid session Id";
    }

    function DeleteList($request){
        $db = new db();
        $session = new session();

        if($session->isSessionValid()){
            return $db->DeleteList($request->listId);
        }
        return "Not a valid session Id";
    }
}
