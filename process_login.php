<?php
include "SQL_connection.php";

session_start();

// o possiamo scrivere :
//if ($_SERVER["REQUEST_METHOD"] == "POST") {}

if ($_POST) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  
  if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT username, password, remember_token FROM user WHERE username = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $username);

  if (!mysqli_stmt_execute($stmt)) {
    die("Error executing prepared statement: " . mysqli_stmt_error($stmt));
  }

  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) == 1) {
    mysqli_stmt_bind_result($stmt, $dbUsername, $dbPassword, $dbRememberToken);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $dbPassword)) {
      if (isset($_POST['rememberMe'])) {

        $token = hash("sha256", random_bytes(10));
        $expiration_time_unix = time() ;

        $expiration_time_mysql = date('Y-m-d H:i:s', $expiration_time_unix);

        setcookie("remember_token", $token, $expiration_time_unix, '/', '', false, true);

        $updateStmt = mysqli_prepare($conn, "UPDATE user SET remember_token = ?, expiration_time = ? WHERE username = ?");
        mysqli_stmt_bind_param($updateStmt, "sss", $token, $expiration_time_mysql, $username);

        if (!mysqli_stmt_execute($updateStmt)) {
          die("Error updating user data: " . mysqli_stmt_error($updateStmt));
        }

        mysqli_stmt_close($updateStmt);
      }

      $_SESSION["username"] = $username;
     
      sleep(0.7);

      header("Location: project.php");
      exit;
    } else {
      die("Authentication failed: Invalid username or password.");
    }
  } else {
    echo "Authentication failed: Invalid username or password.";
  }

  mysqli_stmt_close($stmt);

  mysqli_close($conn);
}
