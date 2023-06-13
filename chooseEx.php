<?php 
	$eventId = $_GET['id'];
	$items = $_GET['items'];
	$count = 0;

	// Decode the URL-encoded items value
	$decodedItems = urldecode($items);

	// Split the decoded items string into an array
	$itemArray = explode(',', $decodedItems);

	// Remove any empty elements from the array
	$itemArray = array_filter($itemArray, 'strlen');

	//print_r($itemArray);

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

	$sql = "UPDATE queue SET state = 'waiting' WHERE event_id =?";

		$stat = mysqli_stmt_init($conn);
	
		if(! mysqli_stmt_prepare($stat, $sql)){
			die(mysqli_error($conn));
		}

		//Bind
		mysqli_stmt_bind_param($stat, "s", $eventId);

		mysqli_stmt_execute($stat);

	foreach ($itemArray as $item) {
		$userId = $item;
		$count++;
		$sql = "UPDATE queue SET state = 'picked' WHERE event_id =? AND waiting_id =?";

		$stat = mysqli_stmt_init($conn);
	
		if(! mysqli_stmt_prepare($stat, $sql)){
			die(mysqli_error($conn));
		}

		//Bind
		mysqli_stmt_bind_param($stat, "ss", $eventId, $userId);

		mysqli_stmt_execute($stat);
	}

	$sql = "SELECT people_Needed AS 'number' FROM event WHERE event_id = '$eventId'";

	$stat = mysqli_stmt_init($conn);

	if(! mysqli_stmt_prepare($stat, $sql)){
		die(mysqli_error($conn));
		echo "error when connect";
	}

	$result = mysqli_query($conn, $sql);
	
	$row = mysqli_fetch_assoc($result);

	echo $count;

	if($count == $row['number']){
		//將活動狀態設為OK
		$sql = "UPDATE event SET state = 'OK' WHERE event_id =?";

		$stat = mysqli_stmt_init($conn);
	
		if(! mysqli_stmt_prepare($stat, $sql)){
			die(mysqli_error($conn));
		}

		mysqli_stmt_bind_param($stat, "s", $eventId);

		mysqli_stmt_execute($stat);

		//將沒被選到的人狀態設為unpicked
		$sqll = "UPDATE queue SET state = 'unpicked' WHERE event_id =? AND state = 'waiting'";

		$stat = mysqli_stmt_init($conn);
	
		if(! mysqli_stmt_prepare($stat, $sqll)){
			die(mysqli_error($conn));
		}

		//Bind
		mysqli_stmt_bind_param($stat, "s", $eventId);

		mysqli_stmt_execute($stat);
	}

	header("Location: myPosts.php");
?>