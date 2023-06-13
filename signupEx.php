<?php 
	session_start();
	$_SESSION['Acc'] = $_POST['username'];
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	$cpword = $_POST['confirm_password'];

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

	$sql = "SELECT user_Acc FROM user WHERE user_Acc = '$uname'";

	$stat = mysqli_stmt_init($conn);

	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
	}

	$result = mysqli_query($conn, $sql);
	//print($result);
	if(mysqli_num_rows($result) >= 1){
		$row = mysqli_fetch_assoc($result);
		if($row['user_Acc'] == $uname){
			header("Location: signup.php?error=此帳號已被其他使用者註冊");
			exit();
		}
	}else{
			$sqll = "INSERT INTO user(user_Acc, user_Pwd) VALUES (?,?)";
	
			$stat = mysqli_stmt_init($conn);

			if(! mysqli_stmt_prepare($stat, $sqll)){
				die(mysqli_error($conn));
			}

			//Bind
			mysqli_stmt_bind_param($stat, "ss", $uname, $pword);

			mysqli_stmt_execute($stat);

			header("Location: info.html");
			}

 ?>

 