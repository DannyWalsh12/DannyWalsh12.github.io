<?php

/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 2/22/2017
 * Time: 10:31 AM
 */
require_once ("session.php");

class db {
    function getDbConnection() {
        // Setup DB Connection Information
        $servername = "localhost";
        $username = "trello20";
        $password = "uaK1hGc0Kmpq4jOX";
        $database = "trello20";

        // Establish DB Connection
        $dbConnection = new mysqli($servername, $username, $password, $database);

        if ($dbConnection->connect_error) {
            echo "Cannot connect to DB " . $dbConnection->connect_error;
            return false;
        }

        return $dbConnection;
    }

    function authenticateUser($username, $password){
        $db = $this->getDbConnection();

        $sqlStatement = $db->prepare("SELECT userId FROM tblUser WHERE username =? AND password =?");
        $sqlStatement->bind_param("ss",$username,$password);

        if($sqlStatement->execute() === FALSE){
            return "Error!". $sqlStatement->error;
        }

        $sqlStatement->bind_result($userID);
        $sqlStatement->fetch();

        $userID = $userID;

        if($userID > 0){

            return $userID;
        }
        else{
            return false;
        }

    }

    function createUserAccount($username,$password,$email,$verificationCode){
        $db = $this->getDbConnection();

        $sqlStatement = $db->prepare("INSERT INTO tblUser (username, password, email, verification, userId) VALUES (?, ?, ?, ?, NULL )");

        $sqlStatement->bind_param("ssss", $username, $password, $email, $verificationCode);



        if($sqlStatement->execute() === FALSE){
            echo "issue creating account".$sqlStatement->error;
            return false;
        }

        return true;

    }

    function createTask($taskTitle,$taskDescription,$userId,$listId){
        $db = $this->getDbConnection();

        $query = "INSERT INTO `tblTasks` (`TaskTitle`, `TaskDescrip`, `DateOfCreation`, `TaskId`, `userId`, `listId`) VALUES (?, ?, CURRENT_TIME(), NULL, ?, ?)";
        $sqlStatement = $db->prepare($query);

        $sqlStatement->bind_param("ssii", $taskTitle, $taskDescription, $userId, $listId);

        if($sqlStatement->execute() === FALSE){
            return "issue with creating Tasks".$sqlStatement->error;

        }
        return true;


    }

    function getTasks($userId,$listId){
        $db = $this->getDbConnection();

        $query = "SELECT TaskTitle, TaskDescrip, TaskId FROM tblTasks WHERE userId = ? AND listId = ?";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->bind_param("ii", $userId,$listId);

        $results = array();

        if($sqlStatement->execute() === FALSE){
            echo $sqlStatement->error;
        }

        $sqlStatement->bind_result($Title,$Descrip,$TaskId);

        while($sqlStatement->fetch()){
            $temp["TaskTitle"] = $Title;
            $temp["taskDescription"] = $Descrip;
            $temp["taskId"] = $TaskId;

            array_push($results, $temp);
        }

        return $results;


    }
    function getLists($userId){
        $db = $this->getDbConnection();

        $query = "SELECT listId, listName FROM tblLists WHERE UserId = ?";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->bind_param("i", $userId);

        $results = array();

        if($sqlStatement->execute() === FALSE){
            echo $sqlStatement->error;
        }

        $sqlStatement->bind_result( $listId, $listTitle);

        while($sqlStatement->fetch()){
            $temp["Title"] = $listTitle;
            $temp["Id"] = $listId;

            array_push($results,$temp);
        }

        return $results;


    }

    function searchNote($noteContentLike){
        $db = $this->getDbConnection();

        $sqlStatement = $db->prepare("SELECT noteId, noteTitle, noteContents FROM tblNotes WHERE noteContents LIKE ? ");

        $noteContentLike = "%".$noteContentLike."%";
        $sqlStatement->bind_param("s", $noteContentLike);

        $Result = array();



        if($sqlStatement->execute() === FALSE){
            echo "Issue executing SQL" . $sqlStatement->error();
            return false;
        }

        $sqlStatement->bind_result($noteId, $noteTitle, $noteContents);

        while($sqlStatement->fetch()) {
            $note["noteId"] = $noteId;
            $note["noteTitle"] = $noteTitle;
            $note["noteContents"] = $noteContents;

            array_push($Result, $note);
        }

        return $Result;



    }
    function updateNote($noteId, $noteTitle, $noteContents) {
        $db = $this->getDbConnection();

        // Step 1 - Prepare a statement
        $sqlStatement = $db->prepare("UPDATE tblNotes SET noteTitle = ?, noteContents = ? WHERE noteId = ?");

        // Step 2 - Bind parameters
        $sqlStatement->bind_param("ssi", $noteTitle, $noteContents, $noteId);

        // Step 3 - Execute
        if ($sqlStatement->execute() === FALSE) {
            echo "Issue executing SQL" . $sqlStatement->error();
            return false;
        }
        return true;
    }
    function deleteNote($noteId) {
        $db = $this->getDbConnection();

        // Step 1 - Prepare a statement
        $sqlStatement = $db->prepare("DELETE FROM tblNotes where noteId = ?");

        // Step 2 - Bind parameters
        $sqlStatement->bind_param("i", $noteId);

        // Step 3 - Execute
        if ($sqlStatement->execute() === FALSE) {
            echo "Issue executing SQL" . $sqlStatement->error();
            return false;
        }
        return true;
    }
    function getNotes($userId,$listId) {
        $db = $this->getDbConnection();

        // Step 1 - Prepare a statement
        $sqlStatement = $db->prepare("SELECT noteId, noteTitle, noteContents FROM tblNotes WHERE userId = ? and listId = ?");

        // Step 2 - Bind parameters
        $sqlStatement->bind_param("ii", $userId, $listId);

        $noteResults = array();

        // Step 3 - Execute step
        if ($sqlStatement->execute() === FALSE) {
            echo $sqlStatement->error;
        }
        // Step 4 - Bind results
        $sqlStatement->bind_result($noteId, $noteTitle, $noteContents);

        // Step 5 - Go through each row
        while($sqlStatement->fetch()) {
            $note["noteId"] = $noteId;
            $note["noteTitle"] = $noteTitle;
            $note["noteContents"] = $noteContents;

            array_push($noteResults, $note);
        }

        return $noteResults;

    }
}