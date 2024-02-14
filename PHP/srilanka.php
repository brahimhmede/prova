<?php
session_start();

include "SQL_connection.php"; 

$sql = "SELECT * FROM query WHERE destination = 'sri lanka'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row_query = mysqli_fetch_assoc($result);
    $destination = $row_query['destination'];
    $dates = json_decode($row_query['date']);
    $prices = json_decode($row_query['price']);
} else {
    $destination = "N/A";
    $dates = [];
    $prices = [];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sri Lanka</title>
    <link rel="stylesheet" href="../css/Srilaka.css"> 

    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
        }

        .card {
            width: 200px;
            border: 3px solid green;
            padding: 10px;
            text-align: center;
            background-color: white;
            margin: 10px;
            border-radius: 20px;
            box-sizing: border-box;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .back {
            color: white;
            background-color: black;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 30px;
            cursor: pointer;
            z-index: 0; /* Ensure the button is above the cards */
        }

        .back:hover {
            background-color: green;
        }

        @media only screen and (max-width: 600px) {
            .back{
                font-size:15px;
            }
            .card {
                text-align: center;
                width: calc(70% - 20px);
            }
        }

        @media only screen and (min-width: 601px) and (max-width: 1024px) {
            .card {
                font-size:15px;
                width: calc(40% - 20px);
            }
        }
    </style>
</head>

<body>
   <a href="project.php"> <button class="back">Back Home</button></a>
    <h1>Sri Lanka</h1>

    <div class="card-container">
        <div class="card">
            <img src="https://www.jacadatravel.com/wp-content/uploads/2017/04/sri-lanka-tea-plantations.jpg" alt="Image 1">
            <p>Date: <?php echo $dates[0]; ?></p>
            <p>Price: <?php echo $prices[0]; ?></p>
            <button class="book-button" onclick()>Book</button>

        </div>

        <div class="card">
            <img src="https://www.planetware.com/wpimages/2020/01/sri-lanka-best-places-to-visit-kandy.jpg" alt="Image 2">
            <p>Date: <?php echo $dates[1]; ?></p>
            <p>Price: <?php echo $prices[1]; ?></p>
            <button class="book-button" onclick()>Book</button>

        </div>

        <div class="card">
            <img src="https://franks-travelbox.com/wp-content/uploads/2017/11/sri-lanka-der-hocc88hlentempel-von-dambulla-liegt-etwa-150km-occ88stlich-der-hauptstadt-colombo-sri-lanka-er-ist-der-grocc88sste-und-besterhaltene-buddhistische-hocc88hlentempel-des-landes-2048x1365.jpg" alt="Image 3">
            <p>Date: <?php echo $dates[2]; ?></p>
            <p>Price: <?php echo $prices[2]; ?></p>
            <button class="book-button" onclick()>Book</button>

        </div>
    </div>
</body>
<script>
        document.querySelectorAll('.book-button').forEach(function(button) {
            button.addEventListener('click', function () {
                <?php
                if (isset($_SESSION['email'])) {
                    echo 'window.location.href = "booknow.php";';
                } else {
                    echo 'var confirmRedirect = confirm("You need to log in first. Continue or cancel?");
                            if (confirmRedirect) {
                                window.location.href = "login.php";
                            }';
                }
                ?>
            });
        });
    </script>

</html>
