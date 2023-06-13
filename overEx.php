<?php
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

  $sql = "SELECT event.event_Time AS 'time' FROM event LEFT JOIN user ON event.user_id = user.user_id
          WHERE event.state = 'ING' OR event.state = 'OK'  ORDER BY event.post_Time DESC;";

  $stat = mysqli_stmt_init($conn);

  if(! mysqli_stmt_prepare($stat, $sql)){
    die(mysqli_error($conn));
  }

  $result = mysqli_query($conn, $sql);
     
  $currentTime = date('Y-m-d H:i:s');
  $offset = '+6 hours';

  $nowTime = date('Y-m-d H:i:s', strtotime($currentTime . ' ' . $offset));

  while($row = mysqli_fetch_assoc($result)){
    $time = $row['time'];
    $eventTime = substr($time, 0, 16);
              
    if($nowTime > $eventTime){
        $sql = "UPDATE event SET state ='OVER' WHERE event_id =?";
  
        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
            die(mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stat, "s", $id);

        mysqli_stmt_execute($stat);
    }    
  }                

  header("Location: posts.php");
?>