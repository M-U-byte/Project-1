<?php
session_start();
$conn = new mysqli("localhost", "root", "1234", "u-music");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$searchTerm = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
  $searchTerm = trim($_GET['search']);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_history'])) {
  if (isset($_SESSION['user_id'], $_POST['song_id'])) {
    $user_id = $_SESSION['user_id'];
    $song_id = intval($_POST['song_id']);

    $stmt = $conn->prepare("INSERT INTO history (user_id, song_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $song_id);

    if ($stmt->execute()) {
      echo "Recorded";
    } else {
      http_response_code(500);
      echo "Database error";
    }

    $stmt->close();
  } else {
    http_response_code(400);
    echo "Invalid user or song ID";
  }
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: text/plain');

  if (isset($_POST['record_history']) && isset($_SESSION['user_id'], $_POST['song_id'])) {
    $user_id = $_SESSION['user_id'];
    $song_id = intval($_POST['song_id']);

    $stmt = $conn->prepare("INSERT INTO history (user_id, song_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $song_id);

    echo $stmt->execute() ? "Recorded" : "Database error";
    $stmt->close();
    exit;
  }

  # Favourite toggle
  if (isset($_POST['song_id'], $_POST['action'], $_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $song_id = intval($_POST['song_id']);
    $action = $_POST['action'];

    if ($action === 'add') {
      $stmt = $conn->prepare("INSERT IGNORE INTO favourite (user_id, song_id) VALUES (?, ?)");
      $stmt->bind_param("ii", $user_id, $song_id);
      $stmt->execute();
      echo "added";
      $stmt->close();
      exit;
    } elseif ($action === 'remove') {
      $stmt = $conn->prepare("DELETE FROM favourite WHERE user_id = ? AND song_id = ?");
      $stmt->bind_param("ii", $user_id, $song_id);
      $stmt->execute();
      echo "removed";
      $stmt->close();
      exit;
    }
  }

  exit("Invalid request");
}
# Favourite
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['favourite_list']) && isset($_SESSION['user_id'])) {
  header('Content-Type: application/json');

  $user_id = $_SESSION['user_id'];
  $result = $conn->query("SELECT song_id FROM favourite WHERE user_id = $user_id");

  $favs = [];
  while ($row = $result->fetch_assoc()) {
    $favs[] = (string) $row['song_id'];
  }
  echo json_encode($favs);
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Gallery - U-Music</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");

    @font-face {
      font-family: 'Lucy';
      src: url("fonts/Lucy.ttf") format('truetype');
    }

    @font-face {
      font-family: 'Transity';
      src: url("fonts/BeautifulDream.otf") format('opentype');
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: url('Background.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      color: #fff;
    }

    .main {
      display: flex;
      min-height: 100vh;
      padding-left: 50px;
      padding-top: 0px;
      transition: padding-left 0.3s ease;
    }

    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      width: 80px;
      height: 100vh;
      background: url('Background.jpg') no-repeat center center fixed;
      background-size: cover;
      backdrop-filter: blur(6px);
      transition: width 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .sidebar.expanded {
      width: 220px;
    }

    .sidebar-toggle {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      color: #fff;
      font-size: 20px;
      cursor: pointer;
      z-index: 2;
    }

    .sidebar-buttons {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
      gap: 30px;
    }

    .sidebar-buttons button {
      background: none;
      border: none;
      color: white;
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .sidebar-buttons button i {
      color: #ff7200;
      font-size: 24px;
      transition: transform 0.3s, color 0.3s, text-shadow 0.3s;
    }

    .sidebar-buttons button:hover i {
      transform: scale(1.2);
      color: rgb(243, 185, 138);
      text-shadow: 0 0 8px #ff7200;
    }

    .sidebar.expanded .sidebar-buttons span {
      display: inline-block;
    }

    .sidebar.collapsed .sidebar-buttons span {
      display: none;
    }

    .content {
      flex: 1;
      padding: 20px;
      z-index: 1;
      transition: margin-left 0.3s ease;
      margin-left: 50px;
    }

    .navbar {
      position: relative;
      top: 0;
      left: 50px;
      width: calc(100% - 50px);
      max-width: 1100px;
      height: 75px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      background-color: transparent;
    }

    .logo {
      display: flex;
      align-items: center;
      font-size: 48px;
      font-weight: 700;
      letter-spacing: 2px;
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
      color: transparent;
      -webkit-text-fill-color: transparent;
      animation: shine 3s linear infinite;
      text-shadow: 2px 2px 10px rgba(255, 114, 0, 0.5);
    }

    @keyframes shine {
      0% {
        background-position: 0% center;
      }

      100% {
        background-position: 200% center;
      }
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
      transition: 0.3s ease-in-out;
    }

    .menu ul li a:hover {
      color: #ff7200;
    }

    .logout {
      display: flex;
      align-items: center;
      margin-left: 40px;
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
      overflow: hidden;
      transition: background 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #fff;
    }

    .logout-btn img {
      width: 45px;
      height: 45px;
      pointer-events: none;
    }

    .search-bar-container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      margin: 30px 50px 0 0;
      backdrop-filter: blur(4px);
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 30px;
      padding: 6px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
      max-width: 280px;
      position: absolute;
      right: 250px;
    }

    .search-bar {
      padding: 10px 14px;
      border: none;
      border-radius: 20px 0 0 20px;
      outline: none;
      font-size: 16px;
      width: 180px;
      background-color: transparent;
      color: white;
      height: 40px;
    }

    .search-bar::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }

    .search-button {
      padding: 10px 14px;
      border: none;
      background: linear-gradient(135deg, #ff7200, #ff9d00);
      color: white;
      border-radius: 0 20px 20px 0;
      cursor: pointer;
      transition: background 0.3s;
      font-weight: bold;
      height: 40px;
    }

    .search-button:hover {
      background: linear-gradient(135deg, #e66200, #ff8600);
    }

    .gallery-container {
      max-width: 1190px;
      margin-top: 100px;
      margin-left: 20px;
      padding: 20px;
    }

    .gallery-title {
      font-family: 'Transity', sans-serif;
      font-size: 42px;
      margin-bottom: 30px;
      color: #ff7200;
      text-align: center;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 0 40px;
    }

    .gallery-grid img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
      transition: transform 0.3s;
    }

    .gallery-grid img:hover {
      transform: scale(1.05);
    }

    .sidebar-tab {
      display: none;
      padding: 20px;
      margin-top: 100px;
      color: white;
      text-align: center;
    }

    .section-title {
      font-family: 'Transity', sans-serif;
      font-size: 42px;
      margin-bottom: 40px;
      color: #ff7200;
      text-align: center;
    }


    .song-item {
      background-color: rgba(255, 255, 255, 0.08);
      padding: 12px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .song-item img {
      width: 90%;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 8px;
    }

    .song-item audio {
      width: 100%;
      height: 30px;
      margin: 6px 0;
    }


    .song-title {
      font-size: 18px;
      color: #ffae42;
      font-weight: bold;
      margin-top: 8px;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
    }

    #history table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      color: white;
    }

    #history th,
    #history td {
      padding: 12px 20px;
      text-align: left;
    }

    #history th {
      background-color: #ff7200;
      color: white;
      font-size: 18px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    #history tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.1);
    }

    #history tr:nth-child(odd) {
      background-color: rgba(255, 255, 255, 0.2);
    }

    #history tr:hover {
      background-color: rgba(255, 255, 255, 0.3);
      cursor: pointer;
    }

    #history td {
      font-size: 16px;
      color: rgb(255, 255, 255);
    }

    #history td a {
      color: rgb(255, 255, 255);
      text-decoration: none;
    }

    #history td a:hover {
      text-decoration: underline;
    }

    .song-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }

    .song-info {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      text-align: left;
    }

    .song-title {
      font-size: 18px;
      color: #ffae42;
      font-weight: bold;
      margin: 0;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
    }

    .song-artist {
      font-size: 14px;
      color: #eee;
      margin-top: 4px;
    }

    .fav-icon {
      cursor: pointer;
      color: white;
      font-size: 22px;
      transition: color 0.3s ease;
    }

    .fav-icon.fav-active {
      color: hotpink;
    }

    .display-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background-color: rgba(255, 255, 255, 0.1);
    }

    .display-table th,
    .display-table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
      color: white;
    }

    .display-table th {
      background-color: #ff7200;
      color: black;
    }

    .display-table tr:nth-child(even) {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .display-table tr:hover {
      background-color: rgba(255, 114, 0, 0.5);
    }




    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        height: auto;
        gap: 10px;
      }

      .menu ul {
        flex-direction: column;
        align-items: center;
      }

      .gallery-grid {
        padding: 0 20px;
      }
    }
  </style>
</head>

<body>
  <div class="main">

    <!-- Sidebar -->
    <div class="sidebar collapsed" id="sidebar">
      <button class="sidebar-toggle" onclick="toggleSidebar()" title="Toggle Sidebar">
        <i class="fas fa-angle-double-left" id="toggle-icon"></i>
      </button>
      <div class="sidebar-buttons">
        <button type="button" onclick="toggleSidebar()">
          <i class="fas fa-user-circle"></i>
          <span><?php echo $_SESSION['username'] ?? 'Username'; ?></span>
        </button>
        <button type="button" onclick="showSidebarSection('favourites')">
          <i class="fas fa-star"></i>
          <span>Favourites</span>
        </button>
        <button type="button" onclick="showSidebarSection('history')">
          <i class="fas fa-clock-rotate-left"></i>
          <span>History</span>
        </button>
      </div>
    </div>


    <div class="content">
      <div class="navbar">
        <a href="Gallery.php" class="logo" style="text-decoration: none;">
          <span class="logo-u">U</span><span class="logo-music">-Music</span>
        </a>

        <div class="menu">
          <ul>
            <li><a href="Home.php">Home</a></li>
            <li><a href="Gallery.php">Gallery</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li><a href="Manage.php">Manage</a></li>
            <?php endif; ?>
            <li><a href="Contact.php">Contact</a></li>
            <li><a href="About.php">About</a></li>
          </ul>
        </div>
        <div class="logout">
          <a href="Login.php" class="logout-btn" title="Logout">
            <img src="logout.png" alt="Logout">
          </a>
        </div>
      </div>

      <form method="GET" class="search-bar-container">
        <input type="text" class="search-bar" name="search" placeholder="Search..."
          value="<?php echo htmlspecialchars($_GET['search'] ?? '') ?>">
        <button class="search-button"><i class="fas fa-search"></i></button>
      </form>



      <div class="gallery-container">
        <h2 class="gallery-title">Gallery</h2>
        <div class="gallery-grid">
          <?php
          if (!empty($searchTerm)) {
            $stmt = $conn->prepare("
                SELECT song_id, s_name, path, artist, added_at 
                FROM songs 
                WHERE s_name LIKE ? OR artist LIKE ? OR added_at LIKE ?
            ");
            $like = "%" . $searchTerm . "%";
            $stmt->bind_param("sss", $like, $like, $like);
            $stmt->execute();
            $result = $stmt->get_result();
          } else {
            $result = $conn->query("SELECT song_id, s_name, path, artist, added_at FROM songs");
          }


          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $song_id = (int) $row['song_id'];
              $song_name = htmlspecialchars($row['s_name']);
              $artist = htmlspecialchars($row['artist']);
              $audio_path = htmlspecialchars($row['path']);
              $image_path = file_exists("s_img/{$song_name}.jpg") ? "s_img/{$song_name}.jpg" : "images/songs/default.jpg";

              echo <<<HTML
                    <div class="song-item">
                      <img src="{$image_path}" alt="Song Cover">
                      <audio controls data-song-id="{$song_id}">
                        <source src="{$audio_path}" type="audio/mpeg">
                        Your browser does not support the audio element.
                      </audio>
                      <div class="song-meta">
                        <div class="song-info">
                          <p class="song-title">{$song_name}</p>
                          <p class="song-artist">{$artist}</p>
                        </div>
                        <div class="fav-icon" data-song-id="{$song_id}">
                          <i class="fas fa-heart"></i>
                        </div>
                      </div>
                    </div>
                    HTML;

            }
          } else {
            echo "<p>No songs available.</p>";
          }
          ?>
        </div>
      </div>


      <div id="favourites" class="sidebar-tab">
        <h2 class="section-title">Your Favourites</h2>

        <?php
        if (isset($_SESSION['user_id'])) {
          $user_id = $_SESSION['user_id'];
          $stmt = $conn->prepare("
          SELECT f.fav_id, s.s_name, f.added_at
          FROM favourite f
          JOIN songs s ON f.song_id = s.song_id
          WHERE f.user_id = ?
          ORDER BY f.added_at DESC
      ");
          $stmt->bind_param("i", $user_id);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result && $result->num_rows > 0) {
            echo "<table class='display-table'>";
            echo "<thead><tr><th>ID</th><th>Song</th><th>Added At</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
              $id = htmlspecialchars($row['fav_id']);
              $song = htmlspecialchars($row['s_name']);
              $added = htmlspecialchars($row['added_at']);
              echo "<tr><td>{$id}</td><td>{$song}</td><td>{$added}</td></tr>";
            }
            echo "</tbody></table>";
          } else {
            echo "<p>No favourite songs yet.</p>";
          }
          $stmt->close();
        } else {
          echo "<p>You must be logged in to view favourites.</p>";
        }
        ?>
      </div>

      <div id="history" class="sidebar-tab">
        <h2 class="section-title">History</h2>

        <?php
        if (isset($_SESSION['user_id'])) {
          $user_id = $_SESSION['user_id'];
          $stmt = $conn->prepare("
          SELECT h.history_id, s.s_name, h.listened_at
          FROM history h
          JOIN songs s ON h.song_id = s.song_id
          WHERE h.user_id = ?
          ORDER BY h.listened_at DESC
      ");
          $stmt->bind_param("i", $user_id);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result && $result->num_rows > 0) {
            echo "<table class='display-table'>";
            echo "<thead><tr><th>ID</th><th>Song</th><th>Listened At</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
              $id = htmlspecialchars($row['history_id']);
              $song = htmlspecialchars($row['s_name']);
              $time = htmlspecialchars($row['listened_at']);
              echo "<tr><td>{$id}</td><td>{$song}</td><td>{$time}</td></tr>";
            }
            echo "</tbody></table>";
          } else {
            echo "<p>No listening history yet.</p>";
          }
          $stmt->close();
        } else {
          echo "<p>You must be logged in to view history.</p>";
        }
        ?>
      </div>


    </div>
  </div>

  <!-- Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const postForm = data =>
        fetch(location.href, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams(data)
        }).then(res => res.text());

      const setupAudioTracking = () => {
        document.querySelectorAll('audio').forEach(audio => {
          let recorded = false;

          audio.addEventListener('play', () => {
            if (!recorded) {
              postForm({ record_history: 1, song_id: audio.dataset.songId }).then(console.log);
              recorded = true;
            }
          });

          audio.addEventListener('ended', () => (recorded = false));

          audio.addEventListener('seeked', () => {
            if (audio.currentTime < 1) recorded = false;
          });
        });
      };

      const loadFavourites = () => {
        fetch('?favourite_list=1')
          .then(res => res.json())
          .then(favs => {
            document.querySelectorAll('.fav-icon').forEach(icon => {
              icon.classList.toggle('fav-active', favs.includes(icon.dataset.songId));
            });
          });
      };

      const setupFavouriteToggles = () => {
        document.querySelectorAll('.fav-icon').forEach(icon => {
          icon.addEventListener('click', () => {
            const songId = icon.dataset.songId;
            const isFav = icon.classList.contains('fav-active');

            postForm({
              song_id: songId,
              action: isFav ? 'remove' : 'add'
            }).then(response => {
              icon.classList.toggle('fav-active', response === 'added');
            });
          });
        });
      };

      // Initialize all features
      setupAudioTracking();
      loadFavourites();
      setupFavouriteToggles();
    });


    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const icon = document.getElementById('toggle-icon');
      sidebar.classList.toggle('collapsed');
      sidebar.classList.toggle('expanded');
      icon.classList.toggle('fa-angle-double-left');
      icon.classList.toggle('fa-angle-double-right');
    }

    function showSidebarSection(sectionId) {
      document.querySelectorAll('.sidebar-tab').forEach(tab => tab.style.display = 'none');
      document.querySelector('.gallery-container').style.display = 'none';
      document.querySelector('.search-bar-container').style.display = 'none';
      const target = document.getElementById(sectionId);
      if (target) target.style.display = 'block';
    }
  </script>


</body>

</html>

<?php $conn->close(); ?>