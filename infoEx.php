<?php
	session_start();
	$realname = $_POST['realname'];
	$nickname = $_POST['nickname'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$school = $_POST['school'];
	$major = $_POST['major'];
	$birthday = $_POST['birthday'];
	$gender = $_POST['gender'];
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
	
	$sql = "UPDATE user SET user_Name=?, user_Nickname=?, gender=?, sport_Prefer=?, phone=?, adress=?, school=?, major=?, birthday=? WHERE user_Acc =?";
	
	$stat = mysqli_stmt_init($conn);

	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
	}

	//Bind
	mysqli_stmt_bind_param($stat, "ssssssssss", $realname, $nickname, $gender, $sport, $phone, $address, $school, $major, $birthday, $_SESSION['Acc']);

	mysqli_stmt_execute($stat);
	
	header("Location: login.php");
	//echo($_SESSION['Acc']);
?>