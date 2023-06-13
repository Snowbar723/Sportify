<?php
	$eventId = $_GET['id'];

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

        //將活動設為失敗
        $sql = "UPDATE event SET state = 'fail' WHERE event_id =?";

        $stat = mysqli_stmt_init($conn);
      
        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stat, "s", $eventId);

        mysqli_stmt_execute($stat);

        //將排隊的人狀態設為canceled
        $sql = "UPDATE queue SET state = 'canceled' WHERE event_id=? ";

        $stat = mysqli_stmt_init($conn);
      
        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stat, "s", $eventId);

        mysqli_stmt_execute($stat);

        header("Location: overEx.php");
?>