<?php

session_set_cookie_params([
  'lifetime' => 0, 
  'path' => '/',
  'domain' => '',
  'secure' => TRUE, 
  'httponly' => TRUE, 
  'samesite' => 'strict' 
]);
session_start();

// require_once('/home/hagustin2/data/connect.php');
// $connection = db_connect();

require_once('../private/connect.php');
$connection = db_connect();

function authenticate($username, $password)
{
  global $connection;

  $statement = $connection->prepare("SELECT account_id, hashed_pass FROM catalogue_admin WHERE users = ?");
  if (!$statement) {
    die("Prepare failed: " . $connection->error);
  }

  $statement->bind_param("s", $username);
  $statement->execute();

  $statement->store_result();
  if ($statement->num_rows > 0) {
    $statement->bind_result($account_id, $hashed_pass);
    $statement->fetch();

    if (password_verify($password, $hashed_pass)) {
     
      session_regenerate_id(true);

      $_SESSION['user_id'] = $account_id;
      $_SESSION['username'] = $username;
      $_SESSION['last_regeneration'] = time();

      return true;
    }
  }

  return false;
}



 function is_logged_in() {
    return isset($_SESSION['user_id']);
 }


function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}


function logout() {
    
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}


function enforce_session_security() {
  if (isset($_SESSION['last_regeneration'])) {
    if (time() - $_SESSION['last_regeneration'] > 300) { 
      session_regenerate_id(true);
      $_SESSION['last_regeneration'] = time();
    }
  } else {
    $_SESSION['last_regeneration'] = time();
  }
}
?>