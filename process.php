<?php 
	session_start();
	require_once('new_connection.php');
	
	function failed_register($post)
	{
		$_SESSION['post'] = $_POST;
		header('Location: index.php');
		die();
	}

	function failed_login()
	{
		$_SESSION['login_error'] = "Could not sign in.";
		header('Location: index.php');
		die();
	}
	
	function insert_new_user($first_name, $last_name, $email, $password)
	{
		$query = "INSERT INTO users (first_name, last_name, email, password, created_at) 
		VALUES ('$first_name', '$last_name', '$email', '$password', NOW())";
		run_mysql_query($query);
	}

	function start_new_session($user)
	{
		$_SESSION['id'] = $user['id'];
		$_SESSION['first_name'] = $user['first_name'];
		$_SESSION['last_name'] = $user['last_name'];
		$_SESSION['email'] = $user['email'];
		header('Location: main.php');
		die();
	}

	if($_POST['action'] == "login")
	{
		$email = escape_this_string($_POST['email']);
		$password = escape_this_string(md5($_POST['password']));

		$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
		$user = fetch_record($query);
		
		if($user == null)
		{ 
			failed_login();
		}
		else
		{ 
			start_new_session($user);
		}
	}

	if($_POST['action'] == "register")
	{
		//VALIDATION ERRORS CHECK
		foreach ($_POST as $item) 
		{
			if(strlen($item) == 0)
			{
				$_SESSION['errors'][] = "Please fill out each category.";
				failed_register($_POST);
			}
		}
		if(strlen($_POST['password']) < 5)
		{
			$_SESSION['errors'][] = "Password must be more than five characters.";
		}
		if($_POST['password'] !== $_POST['confirm_password'])
		{
			$_SESSION['errors'][] = "Passwords don't match.";
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "Please enter a valid email.";
		}

		if(isset($_SESSION['errors']))
		{
			failed_register($_POST);
		}		
		//NO VALIDATION ERRORS, INSERT INTO DATABASE
		else
		{
			//CHECK IF EMAIL IS ALREADY REGISTERED
			$email_check = $_POST['email'];
			$query = "SELECT * FROM users WHERE email = '$email_check'";
			$user = fetch_record($query);
			if($user != null)
			{
				$_SESSION['errors'][] = "This email address is already registered.";	
				failed_register($_POST);
			}

			//ADD TO DATABASE
			$first_name = escape_this_string($_POST['first_name']);
			$last_name = escape_this_string($_POST['last_name']);
			$email = escape_this_string($_POST['email']);
			$password = escape_this_string(md5($_POST['password']));

			insert_new_user($first_name, $last_name, $email, $password);
			$query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
			$user = fetch_record($query);

			start_new_session($user);
		}
	
	}//END REGISTER

	if($_POST['action'] == "sign_out")
	{
		session_destroy();
		header('Location: index.php');
		die();
	}

?>