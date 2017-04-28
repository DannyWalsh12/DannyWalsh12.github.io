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

    function getUser($userId){
        $db = $this->getDbConnection();

        $query = "SELECT `username` FROM `tblUser` WHERE `userId` = ?";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->bind_param("i",$userId);

        if($sqlStatement->execute() === FALSE){
            return "Error!".$sqlStatement->error;
        }

        $sqlStatement->bind_result($Name);
        $sqlStatement->fetch();

        return $Name;





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
            return false;

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
    function DeleteTask($taskId){
        $db= $this->getDbConnection();

        $query = "DELETE FROM `tblTasks` WHERE `tblTasks`.`TaskId` = ?";
        $sqlStatement = $db->prepare($query);
        $sqlStatement->bind_param("i",$taskId);

        if($sqlStatement->execute() === FALSE){
            return false;
        }
        return true;



    }
    function createList($ListName,$userId){
        $db= $this->getDbConnection();

        $query = "INSERT INTO tblLists (listId, listName, UserId) VALUES (NULL, ?, ?)";
        $sqlStatement=$db->prepare($query);
        $sqlStatement->bind_param("si", $ListName,$userId);

        if($sqlStatement->execute() === FALSE){
            return false;
        }

        return true;

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
    function DeleteList($listId){
        $db = $this->getDbConnection();

        $QueryTaskId = "DELETE FROM `tblTasks` WHERE `listId` = ?";
        $SqlTaskId = $db->prepare($QueryTaskId);
        $SqlTaskId->bind_param("i", $listId);

        if($SqlTaskId->execute() === FALSE){
            echo $SqlTaskId->error;
            return false;
        }

        $QueryListId = "DELETE FROM `tblLists` WHERE `listId` =?";
        $SqlListId = $db->prepare($QueryListId);
        $SqlListId->bind_param("i",$listId);

        if($SqlListId->execute() === FALSE){
            echo $SqlListId->error;
            return false;
        }

        return true;
    }
}