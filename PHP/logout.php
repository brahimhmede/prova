<?php
include "SQL_connection.php";

session_start();

if (isset($_COOKIE['remember_token'])) {
  setcookie('remember_token', false , time() - 3600); // set the expiration time to the past to delete the cookie from the browser 
  unset($_COOKIE['remember_token']);
}

session_destroy();
sleep(0.7);
header("Location: login.php");
?>