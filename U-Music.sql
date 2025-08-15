CREATE DATABASE `u-music`;
USE `u-music`;

-- Table: songs
CREATE TABLE songs (
  song_id int(11) NOT NULL AUTO_INCREMENT,
  s_name varchar(255) NOT NULL,
  artist varchar(255) NOT NULL,
  added_at timestamp NOT NULL DEFAULT current_timestamp(),
  path varchar(700) NOT NULL,
  PRIMARY KEY (song_id)
);

-- Table: users
CREATE TABLE users (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL,
  pwd varchar(30) NOT NULL,
  register_date date DEFAULT curdate(),
  email varchar(50) NOT NULL,
  PRIMARY KEY (user_id)
);

-- Table: favourite
CREATE TABLE favourite (
  fav_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  song_id int(11) NOT NULL,
  added_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (fav_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (song_id) REFERENCES songs(song_id)
);

-- Table: history
CREATE TABLE history (
  history_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  song_id int(11) NOT NULL,
  listened_at timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (history_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (song_id) REFERENCES songs(song_id)
);
