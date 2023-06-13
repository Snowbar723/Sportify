<?php 
	session_start();
	$userId = $_SESSION['id'];

	if(isset($_GET['id'])){
		$postId = $_GET['id'];
	}

	$host = "localhost";
	$dbname = "db";
	$username = "root";
	$password = "";

	$conn = mysqli_connect(hostname: $host,
						   username: $username,
						   password: $password, 
						   database: $dbname);

	if(mysqli_connect_errno()){
		die("Connection error: " . mysqli_connect_error());
	}

	if(isset($_GET['name'])){
		if($_GET['name'] == "plus"){
			$sql = "INSERT INTO queue(event_id, waiting_id) VALUES (?,?);";
		}else if($_GET['name'] == "minus"){
			$sql = "DELETE FROM queue WHERE event_id =? AND waiting_id =?;";
		}
	}

	

	$stat = mysqli_stmt_init($conn);
	
	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
	}

	//Bind
	mysqli_stmt_bind_param($stat, "ss", $postId, $userId);

	mysqli_stmt_execute($stat);

 ?>
