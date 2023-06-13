<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>活動到期通知</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      height:650px;
      margin: 0 auto;
      padding: 25px;
      background-color: #322C3F;
      border-radius: 24px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      /*justify-content: center;
      align-items: center;*/
      /* 設定高度以便於示範效果 */
      color: whitesmoke;
    }

    .header{
      margin-bottom: 10px;
      margin-top: 100px;
      display: flex;
      text-align: center;
      justify-content: center;
      align-items: center;
      margin-right: 15px;
    }

    .warning_text{
        margin-left: 10px;
    }

    h2 {
      font-size: 2.3em;
    }

    .center {
      margin-top: -100px;  
      margin-left: 100px;
      margin-right: auto;
      display: block;
    }

    

    .profile-stat {
      display: flex;
      flex:2; 
      flex-direction: column;
      /*justify-content: space-between;*/
      margin-top: 0px;
      margin-bottom: 20px;
      max-width: 2/3%;
      height: 250px;
      background-color: #473952;
      border-radius: 24px;
      padding: 25px;
    }
    

    

    .information{
        text-align: center;
        margin-top: -20px;
    }

    .button-container{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    button{ 
      margin-right: 20px;
      margin-left: 20px;
      margin-top: 15px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      width: 100px; /* 設定按鈕的寬度 */
      height: 60px; /* 設定按鈕的高度 */
      justify-content: center;
      font-size: 15px;
  
    }
    
  </style>



</head>
<body>
  <div class="container">
    <div class="header">
    <i class="fa-solid fa-triangle-exclamation fa-2xl" style="color: #f0d000;"> </i>
    <h2 class="warning_text">活 動 到 期 通 知</h2>
    </div>
    <?php
        if(isset($_GET['id'])){
          $event_ID = $_GET['id'];
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

        $sql = "SELECT sport, location, people_Needed, event_Time
                FROM event WHERE event_id = '$event_ID'";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);
        $sport = $row['sport'];
        $location = $row['location'];
        $number = $row['people_Needed'];
        $time = $row['event_Time'];
        $eventTime = substr($time, 0, 16);
    ?>
    
    <div class ="profile-stat">
        <div class="information">
                  <h3 style="font-size: 23px;"><?php echo($sport) ?> <?php echo($location) ?></h3>
                  <p>媒合<?php echo($number) ?>人</p>
                  <p><?php echo($eventTime) ?></p>
                  <p>時效已過，約成了嗎 > < </p>
        </div>

        
        
        
        <div class="button-container">
            <button type="button" onclick= "location.href='giveRate.php?id=<?php echo $event_ID; ?>'">成功</button>  
            <button type="button" onclick="fail();">失敗</button>
        </div>    
        </div>
    </div>
    
    <script>
      function fail(){
        location.href = 'fail.php?id=<?php echo $event_ID; ?>' ;

        alert("已將此活動標註為失敗。");
      }
    </script>
</body>
</html>