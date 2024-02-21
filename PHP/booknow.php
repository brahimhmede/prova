
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/registration1.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form action="registration.php" method="post">
            <label for="firstname">First name:</label>
            <input type="text" id="firstname" name="firstname" required>
            <br><br>

            <label for="lastname">Last name:</label>
            <input type="text" id="lastname" name="lastname" required>
            <br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password"   required>
            

            <br><br>

            <input type="submit" value="Sign Up">
        </form>
        <p>Already have an account? <a class="login-link" href="login.php">Log In</a></p>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          const form = document.querySelector('form');
          const password = document.getElementById('password');
          const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    password.addEventListener('input', function() {
        if (!passwordPattern.test(password.value)) {
            password.setCustomValidity('Password should contain at least 8 characters , at least one uppercase letter, one lowercase letter, one number, and one special character.');
        } else {
            password.setCustomValidity('');
        }
    });

    form.addEventListener('submit', function(event) {
        if (!password.checkValidity()) {
            event.preventDefault();
        }
    });
});
    </script>
</html>

<?php
 include "SQL_connection.php" ;

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $first_name = $_POST["firstname"];
    $last_name = $_POST["lastname"];
    $email = $_POST["email"];
    $pass = $_POST["password"];

    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
   

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    try {
        $sql = "INSERT INTO user (firstname, lastname , email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt) ) {
            header("Location: login.php");
            exit;
        } else {
            echo "Registration failed.";
        }
    } catch (mysqli_sql_exception $ex) {
        echo "name or email already exists.";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
 }
?>

Ibrahim Hamede, [21/02/2024 19:36]
<?php
session_start();
include "navbar.php";

include "SQL_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destination = $_POST["destination"];
    $date = $_POST["date"];
    $promoCode = $_POST["promoCode"];

    if (isset($_SESSION["email"])) {
        $email = $_SESSION["email"];

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

            $defaultDiscountPercentage = 0;

            $promoCodeDiscounts = array(
                "ali" => 10,   
                "era" => 15,   
                "ibra" => 20,  
                "saw" => 25,   
                "unige" => 30  
            );

            // Assign the corresponding discount percentage for the valid promo code
            $discount = isset($promoCodeDiscounts[$promoCode]) ? $promoCodeDiscounts[$promoCode] : $defaultDiscountPercentage;

            $discountpercentage = "($discount%)";

            $sql = "INSERT INTO booking (email, destination, date, promoCode) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $email, $destination, $date, $discountpercentage);

                if (mysqli_stmt_execute($stmt)) {
                    sleep(1);
                    echo "<script>window.onload = function() {
                            document.getElementById('ratingOverlay').style.display = 'flex';
                          }</script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error preparing the statement: " . mysqli_error($conn);
            }
        } 
    }

?>



<!DOCTYPE html>
<html>
<head>
    <title>Book Your Trip</title>
    <link rel="stylesheet" href="../css/booknow.css">

</head>
<body>

<div class="container">
    <h1>Book Your Trip</h1>
    <form action="booknow.php" method="post">
        <label for="destination">Choose your destination:</label>
        <select name="destination" id="destination">
            <option value="Thailand">Thailand</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Rome">Rome</option>
        </select>
        <br>

        <label for="date">Select a date:</label>
        <select name="date" id="date">
            <option value="10/02/2024">10/02/2024</option>
            <option value="17/02/2024">17/02/2024</option>
            <option value="24/02/2024">24/02/2024</option>
        </select>
        <br>

        <label for="promoCode">Enter your promo code:</label>
        <input type="text" name="promoCode" id="promoCode">
        <br>
        <button>Book Now</button>
    </form>
</div>

<div id="ratingOverlay">
    <div id="ratingContainer">
        <h1>Rate Our App</h1>
        <form action="rating.php" method="post">
    <label for="rating">Rate our app:</label>
    <select name="rating" id="rating">
        <option value="😠">😠</option>
        <option value="😞">😞</option>
        <option value="😐">😐</option>
        <option value="😊">😊</option>
        <option value="😍">😍</option>
    </select>
    <br>
    <button>Submit Rating</button>
</form>
    </div>
</div>
</body>
</html>
