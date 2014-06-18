<?php 
	require('new_connection.php');
	
	//MAKING A POST -----------------------------------------
	if($_POST['action'] == "post")
	{
		$id = $_POST['id'];
		$content = escape_this_string($_POST['post']);
		
		if(strlen($content) < 2)
		{
			header('Location: main.php');
			die();
		}
		else
		{
			$query = "INSERT INTO walls.posts (content, created_at, users_id) VALUES ('$content', NOW(), $id)";
			run_mysql_query($query);
			header('Location: main.php');
			die();
		}
		
	}
	
?>