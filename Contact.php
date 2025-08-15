<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact - U-Music</title>
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .navbar {
            width: 100%;
            height: 75px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0;
            margin-top: 20px;
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

        .contact-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 40px 0;
            gap: 40px;
            margin-top: 20px;
        }

        .contact-container {
            flex: 1;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.26);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 114, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .contact-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #ff7200;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 15px;
            border: 2px solid #444;
            border-radius: 8px;
            background-color: #222;
            color: #fff;
            font-size: 16px;
            resize: none;
            transition: border 0.3s ease;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #ff7200;
            outline: none;
        }

        .contact-form button {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-form button:hover {
            background-color: #ff7200;
        }

        .contact-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }

        .image-box {
            width: 300px;
            height: 100%;
            min-height: 400px;
            background-color: #fff;
            background-image: url('div.jpg');
            /* Replace with your image */
            background-size: cover;
            background-position: center;
            border-radius: 12px;
        }

        .social-icons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-icons a {
            color: #fff;
            font-size: 24px;
            transition: color 0.3s;
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

        @media (max-width: 900px) {
            .contact-wrapper {
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
            }

            .image-box {
                width: 100%;
                max-width: 300px;
                height: 400px;
            }

            .social-icons {
                margin-top: 10px;
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

    <div class="container">
        <div class="navbar">
            <h2 class="logo"><span class="logo-u">U</span><span class="logo-music">-Music</span></h2>
            <div class="menu">
                <ul>
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="Gallery.php">Gallery</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li><a href="Manage.php">Manage</a></li>
                    <?php endif; ?>
                    <li><a href="#">Contact</a></li>
                    <li><a href="About.php">About</a></li>
                </ul>
            </div>
            <a href="Login.php" class="logout-btn" title="Logout">
                <img src="logout.png" alt="Logout">
            </a>
        </div>

        <div class="contact-wrapper">
            <div class="contact-container">
                <h1>Contact Us</h1>
                <form class="contact-form" action="#" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>

            <div class="contact-right">
                <div class="image-box"></div>
                <div class="social-icons">
                    <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="x-twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="youtube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="discord"><i class="fab fa-discord"></i></a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>