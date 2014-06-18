<?php 
	session_start();
?>
<html>
<head>
	<title>Welcome to the Wall</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> 
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container header">
		<h1>The Wall</h1>
	</div>
	<div class="container landing">
		<div class="col-sm-6">
			<h3><u>Login</u></h3>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="login">
				<label>Email: </label>
				<input type="text" name="email"><br>
				<label>Password: </label>
				<input type="password" name="password"><br>
				<input type="submit" value="Sign In" class="btn btn-primary">
			</form>
			<?php 
				if(isset($_SESSION['login_error']))
				{
					echo "<p>" . $_SESSION['login_error'] . "</p>";
					session_destroy();
				}
			?>
		</div>
		<div class="col-sm-6">
			<h3><u>Register</u></h3>
			<form action="process.php" method="post">
				<?php 
					//REPOPULATE FORM DATA IF REGISTER FAILS
					if(isset($_SESSION['post']))
					{
						echo "<input type='hidden' name='action' value='register'>
							 <label>First Name: </label>
							 <input type='text' name='first_name' value='".$_SESSION['post']['first_name']."'><br>
							 <label>Last Name: </label>
							 <input type='text' name='last_name' value='".$_SESSION['post']['last_name']."''><br>
							 <label>Email: </label>
							 <input type='text' name='email' value='".$_SESSION['post']['email']."''><br>";
					}
					else
					{ 
						echo "<input type='hidden' name='action' value='register'>
							 <label>First Name: </label>
							 <input type='text' name='first_name'><br>
							 <label>Last Name: </label>
							 <input type='text' name='last_name'><br>
							 <label>Email: </label>
							 <input type='text' name='email'><br>";
					}
				?>
				<label>Password: </label>
				<input type="password" name="password"><br>
				<label>Confirm: </label>
				<input type="password" name="confirm_password"><br>
				<input type="submit" value="Sign Up" class="btn btn-primary">
			</form>
			<?php 
				if(isset($_SESSION['errors']))
				{
					foreach ($_SESSION['errors'] as $error) {
						echo "<p>$error</p>";
					}
					session_destroy();
				}
			?>
		</div>
	</div>
</body>
</html>