<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - U-Music</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />


    <style>
        @font-face {
            font-family: 'Lucy';
            src: url("fonts/Lucy.ttf") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url(Background.jpg) center/cover no-repeat;
            color: #fff;
        }

        .main {
            width: 100%;
            height: 100vh;
            background: url(Background.jpg) center/cover no-repeat;
        }

        .navbar {
            width: 100%;
            max-width: 1200px;
            height: 75px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: relative;
            top: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 48px;
            letter-spacing: 2px;
            font-weight: 700;
            cursor: default;
        }

        .logo-u {
            font-family: 'Lucy';
            font-size: 70px;
            color: rgb(233, 36, 36);
            margin-right: 6px;
            text-shadow: 2px 2px 10px rgba(255, 207, 0, 0.8);
        }

        .logo-music {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            background: linear-gradient(90deg, #ff3c00, #ffa600, #ff3c00);
            background-size: 200% auto;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 3s linear infinite;
            text-shadow: 2px 2px 10px rgba(255, 114, 0, 0.5);
        }

        .menu ul {
            display: flex;
            list-style: none;
        }

        .menu ul li {
            margin-left: 40px;
        }

        .menu ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: 0.3s;
        }

        .menu ul li a:hover {
            color: #ff7200;
        }

        .logout-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            background-color: #ff7200;
            border-radius: 50%;
            text-decoration: none;
        }

        .logout-btn img {
            width: 45px;
            height: 45px;
        }

        .portrait-container {
            position: absolute;
            top: 200px;
            /* moves it DOWN */
            right: 300px;
            /* moves it LEFT */
            max-width: 300px;
        }

        .portrait-img {
            height: 400px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .about-section {
            padding: 100px 60px 60px;
            max-width: 800px;
            margin-left: 150px;
        }

        .about-section h1 {
            font-size: 42px;
            color: #ff7200;
            margin-bottom: 20px;
        }

        .about-section p {
            font-size: 18px;
            line-height: 1.8;
            letter-spacing: 0.5px;
        }

        .social-icons {
            margin-left: 1010px;
            display: flex;
            gap: 20px;
        }

        .social-icons a {
            font-size: 30px;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .social-icons a:hover {
            transform: scale(1.2);
        }

        .social-icons .facebook {
            color: #3b5998;
            /* Facebook blue */
        }

        .social-icons .x-twitter {
            color: rgb(255, 255, 255);
            /* Black for X */
            background-color: #0000;
        }


        .social-icons .instagram {
            color: #e4405f;
            /* Instagram pink */
        }

        .social-icons .youtube {
            color: #FF0000;
            /* YouTube red */
        }

        .social-icons .discord {
            color: #5865F2;
            /* Discord blurple */
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 10px;
                height: auto;
            }

            .menu ul {
                flex-direction: column;
                gap: 10px;
            }

            .about-section {
                padding: 60px 20px;
            }
        }

        @keyframes shine {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2 class="logo"><span class="logo-u">U</span><span class="logo-music">-Music</span></h2>
        <div class="menu">
            <ul>
                <li><a href="Home.php">Home</a></li>
                <li><a href="Gallery.php">Gallery</a></li>

                <?php if (isset($_SESSION['username']) && $_SESSION['role'] === 'admin'): ?>
                    <li><a href="Manage.php">Manage</a></li>
                <?php endif; ?>

                <li><a href="Contact.php">Contact</a></li>
                <li><a href="About.php">About</a></li>
            </ul>
        </div>
        <a href="Login.php" class="logout-btn" title="Logout">
            <img src="logout.png" alt="Logout">
        </a>
    </div>

    <div class="portrait-container">
        <img src="man.jpg" alt="Portrait" class="portrait-img">
    </div>

    <div class="about-section">
        <h1>About U-Music</h1>
        <p>
            U-Music is more than a platform—it's a passion. Born from the love of melodies, rhythm, and soul,
            U-Music brings together artists and listeners into a shared space of musical expression.<br><br>
            Our mission is to make music discovery and sharing effortless, fun, and inspiring. Whether you're a
            creator or a fan, this is where your musical journey gets louder.<br><br>
            From beats that lift your mood to lyrics that speak your truth, U-Music celebrates the universal
            language of music—one beat at a time.
        </p>
    </div>

    <div class="social-icons">
        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="x-twitter"><i class="fab fa-x-twitter"></i></a>
        <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
        <a href="#" class="discord"><i class="fab fa-discord"></i></a>
    </div>



</body>

</html>