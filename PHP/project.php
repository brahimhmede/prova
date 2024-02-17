<?php
session_start(); // Start the session
include "admin_check.php";// include il controllo dell'admin 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traveling</title>

    <link rel="stylesheet" href="../css/project.css"> <<!--//link al file css -->
</head>

<body>
    <header>
        <?php
        include "navbar.php"; // include il file navbar.php cosi se viene vedere il navabar sopra in tutte le pagine
     //   include "sconto_check.php";

        ?>
    </header>
    <div class="intro">
        <h2>Social Expert Traveler Group</h2>
        <h1>Trust Our Experience</h1>
        <button id="bookNowButton">Book Now</button> <<!-- bottone per prenotare -->
        <button id="discount" onclick="openoferta()">Click here to get a discount</button> <<!-- bottone per ottenere uno sconto quando vienne digitata se applica il funzione open oferta  -->
    </div>
    <script>
        function openoferta() {
            <?php
            if (isset($_SESSION['email'])) { // se l'utente è loggato allora si apre la pagina di sconto 
                echo 'window.location.href = "../ruota/ruota.php";';// link al file ruota.php
            }
             else { // altrimenti si apre un messaggio che dice che bisogna loggarsi per ottenere lo sconto
                echo 'var confirmRedirect = confirm("You need to log in first. Continue or cancel?"); 
                            window.location.href = "login.php";
                        }';
            }

            ?>
        };
    
    </script>
    <section id="about" class="about">
     <div class="about_in_home">
        <div class="text-about">
            <h3>About US</h3>
            <p id="coloredText"> <!-- paragrafo con id coloredText che fa il primo lettere con collore verde -->
                At Traveler Group, we're not just travel organizers; we're passionate globetrotters dedicated to crafting unforgettable experiences around the world. Driven by a deep thirst for exploration and cultural immersion, we curate weekly escapes to diverse destinations, igniting your wanderlust and enriching your life with every journey.
            </p>
            <a href="about.php">More about ...</a><!-- link al file about.php -->
        </div>
        <img src="https://th.bing.com/th/id/R.48848c07829ed9fbb312540f3628ae85?rik=vItiarjuto7uXg&pid=ImgRaw&r=0" alt="img2">
    </div>
    </section>
    <script>// funzione per colorare il primo lettere del paragrafo con id coloredText che si trova sopra
        function colorFirstCharacters() {
            const paragraph = document.getElementById("coloredText");
            const words = paragraph.textContent.split(" ");
            const coloredWords = words.map(word => {
                if (word.length > 0) {
                    return `<span class="colored">${word[0]}</span>${word.slice(1)}`;
                }
                return "";
            });
            paragraph.innerHTML = coloredWords.join(" ");
        }

        colorFirstCharacters();
    </script>
    <div id="fragment-overlay">
        <div id="fragment-modal">
            <iframe src="" frameborder="0"></iframe>
            <button id="closefragment" onclick="closefragment()">Close </button>
        </div>
    </div>

    <div class="widget-button"> <!-- bottone per contattare il supporto questi qua e qulla che si trova giu nella pagina project -->
        <img src="https://cdn-icons-png.flaticon.com/128/2936/2936956.png" alt="contact us "> <!-- icona per contattare il supporto(live chat) -->
        <div class="widget-icons">
            <img class="widget-icon" src="https://cdn-icons-png.flaticon.com/512/4494/4494494.png" alt="WhatsApp" onclick="openWhatsApp()">
            <img class="widget-icon" src="https://cdn-icons-png.flaticon.com/128/1603/1603076.png" alt="Telegram" onclick="openTelegram()">
        </div>
    </div>
    <script>
        function openWhatsApp() {
            window.open('https://wa.me/393517267976', '_blank');
        }

        function openTelegram() {
            window.open('telegram link', '_blank');
        }
    </script>
    <div class="second-background">
        <h2>This week trips</h2>
        <div class="image-container">
            <figure>
                <a href="Thailand.php">
                    <img src="../foto/Thailand.jpg" alt="Thailand" >
                    <figcaption>Thailand</figcaption>
                </a>
            </figure>
            <figure>
                <a href="srilanka.php">
                    <img src="../foto/Siri Lanka.jpg" alt="Sirilanka">
                    <figcaption>Sirilanka</figcaption>
                </a>
            </figure>
            <figure>
                <a href="rome.php">
                    <img src="../foto/Roma.jpg" alt="Roma">
                    <figcaption>Roma</figcaption>
                </a>
            </figure>
        </div>
    </div>

    <script>
        document.getElementById('bookNowButton').addEventListener('click', function () {
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
    </script>

    <section id="contact" class="section">
        <div class="form-container">
            <h4>Contact Us</h4>
            <hr>
            <form action="action_page.php" method="POST">
                <div class="info-section">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="Name" required>
                </div>
                <div class="info-section">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="Email" required>
                </div>
                <div class="info-section">
                    <label for="message">Message</label>
                    <input type="text" id="message" name="Message" required>
                </div>
                <button type="submit" class="button">Send Message</button>
            </form>
        </div>
    </section>

    <footer style="background-color: #333; color: white; text-align: center; padding: 20px;">
        <p style="font-size: 18px; margin: 0;">&copy; 2023 Travel Group</p>
        <ul style="list-style: none; padding: 0;">
            <li style="display: inline; margin-right: 20px;"><a href="privacy_policy.html" style="text-decoration: none; color: white;">Privacy Policy</a></li>
            <li style="display: inline;"><a href="#" style="text-decoration: none; color: white;">Terms of Service</a></li>
        </ul>
    </footer>

    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 0) {
                navbar.classList.add('fixed');
            } else {
                navbar.classList.remove('fixed');
            }
        });
    </script>

</body>

</html>
