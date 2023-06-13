<?php 
	session_start();
	$userId = $_SESSION['id'];
	$event_id = $_GET['id'];
	$users = $_GET['users'];
	$stars = $_GET['rates'];
	$texts = $_GET['comments'];
	$count = 0;

	// Decode the URL-encoded items value
	$decodedUsers = urldecode($users);
	$decodedStars = urldecode($stars);
	$decodedTexts = urldecode($texts);

	// Split the decoded items string into an array
	$people = explode(',', $decodedUsers);
	$rates = explode(',', $decodedStars);
	$comments = explode(',', $decodedTexts);

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

	while($count < count($people)){
		$person = $people[$count];
		$rate = $rates[$count];
		$comment = $comments[$count];

		$sql = "INSERT INTO review(event_id, user_id_From, user_id_To, score, content) VALUES(?,?,?,?,?)";

		$stat = mysqli_stmt_init($conn);
	
		if(! mysqli_stmt_prepare($stat, $sql)){
			die(mysqli_error($conn));
		}

		//Bind
		mysqli_stmt_bind_param($stat, "sssss", $event_id, $userId, $person, $rate, $comment);

		mysqli_stmt_execute($stat);

		header("Location: posts.php");
		//echo($person . $rate . $comment);
		$count++;
	}
?>