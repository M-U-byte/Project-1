# Project-1
 -Music streaming site -Creating a project for 4th semester
 With Database Management
 
Website Name : U-Music

Design Document

Functional Requirments :

The basic Function that the website would do:
1. User Accounts
• Users can register with username, email, and password.
• Users can log in and log out

2. Music Library
• Songs are stored with metadata: title, artist, file path.
• Users can browse all available songs.
• Users can search songs by name, artist or date

3. Streaming
• Users can click on a song and stream it.
• The site should not allow downloading of audio files (stream only).

5. Favorites/History
• Users can mark songs as favorites.
• Users can view a list of their favorite songs.
• Users can view the song name he has listened in history tab

6. Admin Panel
• Admin can add, update, or delete songs.
• Admin can manage user accounts.

7.Indexing
• Admin can Index any column in a table or drop any indexed column

Database Requirements:

The following entities will be created along with their attributes:

• users – user_id, username, email, pwd,registered_at ,role.
• songs – song_id, title, artist, path,added_at
• favorites – fav_id, user_id, song_id,added_at.
• history – history_id,user_id,song_id,Listened_time



























