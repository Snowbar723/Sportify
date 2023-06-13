<?php
	session_start();
	$nickname = $_POST['nickname'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$school = $_POST['school'];
	$major = $_POST['major'];
	$sport = $_POST['sport'];

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
	
	$sql = "UPDATE user SET user_Nickname=?, phone=?, adress=?, sport_Prefer=?, major=?, school=? WHERE user_id =?";
	
	$stat = mysqli_stmt_init($conn);

	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
	}

	//Bind
	mysqli_stmt_bind_param($stat, "sssssss", $nickname, $phone, $address, $sport, $major, $school, $_SESSION['id']);

	mysqli_stmt_execute($stat);
	
	header("Location: personalPost.php");
	//echo($_SESSION['Acc']);
?>