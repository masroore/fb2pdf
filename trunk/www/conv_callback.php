<?php
require_once 'awscfg.php';
require_once 'db.php';
require_once 'utils.php';

global $secret;
global $dbServer, $dbName, $dbUser, $dbPassword;

error_log("FB2PDF INFO. conv_callback POST=" . var_export($_POST, TRUE)); 

$password = trim($_POST['pass']);
$email    = trim($_POST['email']);
$key      = trim($_POST['key']);
$status   = trim($_POST['status']);

if (isset ($_POST['ver']))
    $ver = trim($_POST['ver']);
else
    $ver = 0;

// check parameters
if (!$key)
{
    error_log("FB2PDF ERROR. Callback: Missing or wrong parameter key"); 
    send_response("400 Bad Request", "Missing or wrong parameter key");
    die;
}

if ($status != "r" and $status != "e")
{
    error_log("FB2PDF ERROR. Callback: Missing or wrong parameter status"); 
    send_response("400 Bad Request", "Missing or wrong parameter status");
    die;
}

// check password
if ($password != md5($secret . $key))
{
    error_log("FB2PDF ERROR. Callback: Incorrect password"); 
    send_response("400 Bad Request", "Incorrect password");
    die;
}

// update status in the DB
$db = new DB($dbServer, $dbName, $dbUser, $dbPassword);
error_log("FB2PDF INFO. Updating books status $key: Status=$status, Version=$ver"); 
if (!$db->updateBookStatus($key, $status, $ver))
    error_log("FB2PDF ERROR. Callback: Unable to update book status. Key=$key"); 


// send email to user
if ($email)
    notifyUserByEmail($email, $key);

send_response("200 OK", "");

function send_response($httpCode, $message)
{
    header("HTTP/1.0 $httpCode");
    header('Content-type: text/html');    
    if ($message)
        echo "<html><body>$message</body></html>";
}

?>