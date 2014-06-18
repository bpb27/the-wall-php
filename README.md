the-wall-php
============

Login/Registration page with validations, leading to a wall/forum for anyone to post on

Set to work with mySQL DB
- DB schema name is walls (change in new_connection.php line six)
- DB has two tables:
  - users: id, first_name, last_name, email, password, created_at
  - posts: id, content, created_at, users_id
