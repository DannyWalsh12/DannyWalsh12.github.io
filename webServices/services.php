<<<<<<< HEAD
<?php
//session_start();

/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 2/3/2017
 * Time: 10:38 AM
 */
require_once ("session.php");

// Pull in various service brokers
require_once("broker/security.php");
require_once ("broker/task.php");

$session=new session();
$session->startSession();

/*
 * Step 1 - Extract Service Path and Process It
 *
 * Service Path Examples: security/login, notes/add, notes/delete, notes/update
 *
 * Service Request Contains JSON that service needs
 */

$servicePath = $_POST["servicePath"]; // e.g. /security/login, /security/logoff, /notes/add,

/*
 * Take the service path, and break it into an array
 * [0] = null
 * [1] = broker name
 * [2] = service name
 */
$serviceParts = explode("/", $servicePath);

// Store the parts into meaningful variable names
$brokerName = $serviceParts[1] . "Broker"; // Append Broker to end for appropriate Class
$serviceName = $serviceParts[2];

/*
 * Step 2 - Decode JSON data from serviceRequest
 *
 * PHP automatically creates an object from decoded JSON data, no need to declare Class
 */
$serviceRequest = json_decode($_POST["serviceRequest"]);

/*
 * Step 3 - Dynamically invoke broker and service based on service path. Pass serviceRequest object
 */
$broker = new $brokerName; // Creates new broker object
$serviceResponse = $broker->$serviceName($serviceRequest); // Dynaically invokes service

// Send back response encoded in JSON
echo json_encode($serviceResponse);

=======
<?php
//session_start();

/**
 * Created by PhpStorm.
 * User: Danny
 * Date: 2/3/2017
 * Time: 10:38 AM
 */
require_once ("session.php");

// Pull in various service brokers
require_once("broker/security.php");
require_once ("broker/task.php");

$session=new session();
$session->startSession();

/*
 * Step 1 - Extract Service Path and Process It
 *
 * Service Path Examples: security/login, notes/add, notes/delete, notes/update
 *
 * Service Request Contains JSON that service needs
 */

$servicePath = $_POST["servicePath"]; // e.g. /security/login, /security/logoff, /notes/add,

/*
 * Take the service path, and break it into an array
 * [0] = null
 * [1] = broker name
 * [2] = service name
 */
$serviceParts = explode("/", $servicePath);

// Store the parts into meaningful variable names
$brokerName = $serviceParts[1] . "Broker"; // Append Broker to end for appropriate Class
$serviceName = $serviceParts[2];

/*
 * Step 2 - Decode JSON data from serviceRequest
 *
 * PHP automatically creates an object from decoded JSON data, no need to declare Class
 */
$serviceRequest = json_decode($_POST["serviceRequest"]);

/*
 * Step 3 - Dynamically invoke broker and service based on service path. Pass serviceRequest object
 */
$broker = new $brokerName; // Creates new broker object
$serviceResponse = $broker->$serviceName($serviceRequest); // Dynaically invokes service

// Send back response encoded in JSON
echo json_encode($serviceResponse);

>>>>>>> 6a9fdbfc676670cc19a7f3c2370addd31c043665
