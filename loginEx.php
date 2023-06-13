<?php 
	session_start();
	$uname = $_POST["username"];
	$pword = $_POST['password'];

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

	//echo "Connection successful.";
	//SQL語法
	$sql = "SELECT user_id, user_Acc, user_Pwd FROM user WHERE user_Acc = '$uname'";

	$stat = mysqli_stmt_init($conn);

	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
		echo "error when connect";
	}

	$result = mysqli_query($conn, $sql);
	//print(mysqli_num_rows($result));
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		if($row['user_Acc'] == $uname && $row['user_Pwd'] == $pword){  //登入成功
			$_SESSION['Acc'] = $_POST['username'];	//暫存使用者帳號
			$_SESSION['id'] = $row['user_id'];	//暫存使用者ID
			header("Location: overEx.php");
		}else{
			header("Location: login.php?error=使用者帳號或密碼輸入錯誤");
			exit();
		}
	}else{
		header("Location: login.php?error=使用者帳號或密碼輸入錯誤");
		exit();
	}
 ?>