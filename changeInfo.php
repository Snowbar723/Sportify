
<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <title>編輯基本資料</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      height: 750px;
      margin: 0 auto;
      padding: 25px;
      background-color: #322C3F;
      border-radius: 24px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container .form-container input{
    border: none;
    outline: none;
    background: #473952;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
    }

    
    input[type="text"], input[type="date"], input[type="submit"] {
    display: block;
    width: 63%;
    margin: 0 auto; /* 左右外邊距設為auto，讓元素水平置中 */
    margin-right: 30px;
    margin-bottom: 15px;
    padding: 13px;
    font-size: 16px;
    border-radius: 25px;
    border: 1px solid #ccc;
    color: whitesmoke;
    }   

    input[type="submit"] {
      display: block;
      width: 280px;
      margin: 0 auto;
      margin-bottom: 15px;
      padding: 13px;
      font-size: 16px;
      border-radius: 25px;
      background-color: #664D9A;
      border: none;
      color: #fff;
      cursor: pointer;
    }

    .error-message {
      color: #f00;
      margin-bottom: 10px;
    }

    .image{
      display: block;  
      margin: 0 auto;
      margin-top: 30px;
      height: 80px;
    }

    label {
    display: block;
    margin-bottom: 10px;
    text-align: center;
    }

    p{
      color: whitesmoke;
      margin-bottom: -30px;
      margin-left: -320px;
      margin-top: 25px;
    }

    input[type="button"] {
      display: block;
      width: 120px;
      margin: 0 auto;
      margin-bottom: 15px;
      padding: 13px;
      font-size: 16px;
      border-radius: 25px;
      background-color: #92928E;
      border: none;
      color: #fff;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <?php
    session_start();

    $host = "localhost";
    $dbname = "db";
    $username = "root";
    $password = "";
    $userId = $_SESSION['id'];

    $conn = mysqli_connect(hostname: $host,
            username: $username,
            password: $password, 
            database: $dbname);

    if(mysqli_connect_errno()){
      die("Connection error: " . mysqli_connect_error());
    }

    $sql = "SELECT user_Nickname, phone, adress, school, major, sport_Prefer 
            FROM user WHERE user_id = '$userId'";

    $stat = mysqli_stmt_init($conn);

    if(! mysqli_stmt_prepare($stat, $sql)){
      die(mysqli_error($conn));
    }

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    $nickname = $row['user_Nickname'];
    $phone = $row['phone'];
    $adress = $row['adress'];
    $school = $row['school'];
    $major = $row['major'];
    $sport = $row['sport_Prefer']

  ?>
  <div class="container">
     <img class="image" src="logo.png"> <br>
      <div class="title">
        <h2 style="color:#ffffff">編 輯 基 本 資 料</h2>
      </div>
    <div class="form-container">
      <form action="changeInfoEx.php" method="post">
      <label><p>暱稱</p><input type="text" name="nickname" value="<?php echo($nickname) ?>" required></label>
      <label><p>電話</p><input type="text" name="phone" value="0<?php echo($phone) ?>" required></label>
      <label><p>住址</p><input type="text" name="address" value="<?php echo($adress) ?>" required></label>
      <label><p>學校</p><input type="text" name="school" value="<?php echo($school) ?>" required></label>
      <label><p>科系</p><input type="text" name="major" value="<?php echo($major) ?>"></label>
      <label><p>喜歡的運動</p><input type="text" name="sport" value="<?php echo($sport) ?>" required></label>
    </div><br>
      <input type="submit" value="送出"><br><br><br>
      <input type="button" value="登出" onclick="logout();">
    </form>
  </div>
    <script>
      function logout(){
        location.href = 'login.php';
        alert("您已登出！");
      }
    </script>
</body>
</html>
