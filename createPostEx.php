<?php 
	session_start();

	$poster_id = $_SESSION['id'];
	$sport = $_POST['sport'];
	$time = $_POST['time'];
	$location = $_POST['location'];
	$number = $_POST['players'];
	$ability = $_POST['ability'];
	//$other = $_POST['memo'];
	$postTime = $_POST['postTime'];

	//echo($postTime);

	//連接資料庫
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

	$sql = "INSERT INTO event(user_id, sport, post_Time, event_Time, location, people_Needed, ability, state) VALUES(?,?,?,?,?,?,?,'ING')";

	$stat = mysqli_stmt_init($conn);

	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
	}

	//Bind
	mysqli_stmt_bind_param($stat, "sssssss", $_SESSION['id'], $sport, $postTime, $time, $location, $number, $ability);

	mysqli_stmt_execute($stat);


	header("Location: overEx.php");
 ?>