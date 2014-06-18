<?php 
	require_once('new_connection.php');
	session_start(); 
	$id = $_SESSION['id'];
	$users_query = "SELECT * FROM users";
	$users = fetch_all($users_query);
	$posts_query = "SELECT walls.posts.content, walls.posts.created_at, walls.users.first_name, walls.users.last_name FROM walls.posts LEFT JOIN walls.users ON walls.posts.users_id = walls.users.id";
	$posts = fetch_all($posts_query);

?>
<html>
<head>
	<title>The Wall</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> 
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container header">
		<div class="col-sm-10">
			<h1>The Wall</h1><br>
		</div>
		<div class="col-sm-2">
			<br>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="sign_out">
				<input type="submit" value="Sign Out" class="btn btn-primary">
			</form>
		</div>
	</div>
	<div class="container">
		<?php echo "<p>Welcome, " . $_SESSION['first_name'] . ".</p>"; ?>
	</div>
	<div class="container">
		<div class="col-md-3">
			<h4>All Users:</h4>
			<?php 
				if($users != null)
				{
					foreach ($users as $user)
					{
						if($user['id'] != $id)
						{
							echo "<br><h5>" . $user['first_name'] . " " . $user['last_name'] . "</h5>";
							echo "<p>" . $user['email'] . "</p>";
						}
					}
				}
			?>
		</div>
		<div class="col-md-9">
			<h4>Leave a Post: </h4>
			<br>
			<form action="post_process.php" method="post">
				<input type="hidden" name="action" value="post">
				<?php echo "<input type='hidden' name='id' value='$id'>"; ?>
				<textarea id="post-box" name="post" placeholder="What's on your mind?"></textarea>
				<input id="post-submit" type="submit" class="btn btn-primary">
			</form>
			<?php 
				if($posts != null)
				{
					foreach (array_reverse($posts) as $post)
					{
						echo "<div class='col-md-12 post'>";
						echo "<h5>" . $post['content'] . "</h5>";
						echo "<p> - " . $post['first_name'] . " " . $post['last_name'] . " (" . $post['created_at'] . ")</p>";
						echo "</div>";
					}
				}
			?>
		</div>
	</div>
</body>
</html>