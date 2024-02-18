
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="../css/login.css"> 
</head>
<body>
    
    <main>
        <section class="form">
           
            <h1 class="form__title">Log in to your Account</h1>
            <p class="form__description">Welcome back! Please, enter your information</p>

            <form action="login.php" method="POST">
                <label class="form-control__label" for="email">email</label>
                <input type="text" class="form-control" id="email" name="email" required>
        
                <label class="form-control__label" for="password">Password</label>
                <div class="password-field">
                    <input type="password" class="form-control"  id="password" name="password" required>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </div>
                <div class="password__settings">
                    <label class="password__settings__remember" for="rememberMe">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        <span class="custom__checkbox">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>                              
                        </span>
                        Remember me
                    </label>
        
                    <a href="../html/forget_password.html">Forgot Password?</a>
                </div>
        
                <button type="submit" class="form__submit" id="submit">Log In</button>
                <a href="project.php"><button type="button" class="home" id="home">Home page</button></a>

            </form>
        
            <p class="form__footer">
                Don't have an account?<br> <a href="registration.php">Create an account</a>
            </p>
        </section>
        
        <section class="form__animation">
            <div id="ball">
                <div class="ball">
                    <div id="face">
                        <div class="ball__eyes">
                            <div class="eye_wrap"><span class="eye"></span></div>
                            <div class="eye_wrap"><span class="eye"></span></div>
                        </div>
                        <div class="ball__mouth"></div>
                    </div>
                </div>
              </div>
              <div class="ball__shadow"></div>
        </section>
    </main>
    <script src="main.js"></script>
</body>
</html>


<?php
include "SQL_connection.php"; // include il connection al database

session_start();

if ($_POST) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!$conn) { // se la connessione fallisce
        die("Database connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT email, password, remember_token FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error executing prepared statement: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $dbEmail, $dbPassword, $dbRememberToken);
        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $dbPassword)) {
            if (isset($_POST['rememberMe'])) {
                $token = hash("sha256", random_bytes(16));// generazione di un cookies token random
                $expiration_time_unix = time();// unlimited time
                $expiration_time_mysql = date('Y-m-d H:i:s', $expiration_time_unix);// variabile per salvare il tempo di scadenza del token in db 

                setcookie("remember_token", $token, $expiration_time_unix, '/', '', false, true); // set del cookies

                $updateStmt = mysqli_prepare($conn, "UPDATE user SET remember_token = ?, expiration_time = ? WHERE email = ?");
                mysqli_stmt_bind_param($updateStmt, "sss", $token, $expiration_time_mysql, $email);

                if (!mysqli_stmt_execute($updateStmt)) {
                    die("Error updating user data: " . mysqli_stmt_error($updateStmt));
                }

                mysqli_stmt_close($updateStmt);
            }
            $_SESSION["email"] = $email;

            sleep(0.7);//dlai per 0.7 secondi

            header("Location: project.php");// reindirizzamento alla pagina principale
            exit;
        } else {
            die("Authentication failed: Invalid email or password");// se la password non corrisponde
        }
    } else {
        echo "Authentication failed: Invalid email or password.";// se l'email non corrisponde
    }

    mysqli_stmt_close($stmt);

    mysqli_close($conn);
}
?>
