<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome | U-Music</title>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");
    @font-face {
            font-family: 'Transity';
            src: url("fonts/BeautifulDream.otf") format('opentype');
        }
    @font-face {
            font-family: 'Lucy';
            src: url("fonts/Lucy.ttf") format('truetype');
        }


    :root {
      --white-color: #ffffff;
      --black-color: #000000;
      --orange-color: #ff8800;
      --body-font: "Poppins", sans-serif;
      --h1-font-size: 2rem;
      --normal-font-size: 1rem;
      --font-medium: 500;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-size: var(--normal-font-size);
      color: var(--white-color);
      background-color: #111;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem 1rem;
      min-height: 100vh;
      text-align: center;
    }

    h1 {

      font-family: 'Poppins';
     font-size: 3.0rem;
      margin-bottom: 0.5rem;
    }

    .brand {
      font-family: 'Transity';
      font-size: 3.0rem;
      font-weight: var(--font-medium);
      color: var(--orange-color);
      margin-bottom: 1rem;
    }

    .quote {
      font-family: 'Lucy';
      font-size: 1.8rem;
      margin-bottom: 2rem;
      max-width: 600px;
    }

    .main-img {
      width: 100%;
      max-width: 250px;
      height: 400px;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
    }

    .welcome__button {
      font-family: 'Poppins';
      padding: 1rem 2rem;
      background-color: var(--white-color);
      color: var(--black-color);
      border-radius: 0.5rem;
      font-weight: var(--font-medium);
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .welcome__button:hover {
      background-color:#ff8800
    }
  </style>
</head>
<body>
  <h1>Welcome</h1>
  <br>
  <div class="brand">U-Music</div>
  <p class="quote">"Your personalized music experience starts here".</p>
  <img src="Wel.jpeg" alt="U-Music Showcase" class="main-img" />
  <a href="Home.php" class="welcome__button">Get Started</a>
</body>
</html>
