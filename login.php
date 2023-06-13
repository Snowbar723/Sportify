<?php
    session_start();
    $_SESSION['id'] = "";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>網站登入頁面</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      height: 645px;
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
      margin-bottom: 15px;
      margin-top: 30px;
      font-size: 2.5em;
    }

    .image{
      display: block;  
      margin: 0 auto;
      margin-top: 120px;
      height: 80px;
    }
    
    input[type="text"], input[type="password"] {
    display: block;
    width: 63%;
    margin: 0 auto; /* 左右外邊距設為auto，讓元素水平置中 */
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

    .want-to-sign-up{
      text-align: center;
      color:#ffffff;
    }

    .link{
        color:#664D9A;
    }

    .error-message {
      color: #f00;
      margin-bottom: 10px;
      text-align: center;
    }

    label {
    display: block;
    margin-bottom: 10px;
    text-align: center;
    }

  </style>
</head>
<body>
  <div class="container">
    <img class="image" src="logo.png" > 
    <h2 style="color:#ffffff">登 入</h2>
    <div class="form-container">
    <form action="loginEx.php" method="post">
      <label><input type="text" name="username" placeholder="帳號" required></label>
      <label><input type="password" name="password" placeholder ="密碼" required></label>
    </div>
      <?php if(isset($_GET['error'])){ ?>
          <p class="error-message"><?php echo $_GET['error']; ?></p>
      <?php } ?>
      <input type="submit" value="登入">
    </form>
    <p class="want-to-sign-up">還沒有帳戶？<a href="signup.php" class="link">點擊這裡</a>註冊。</p>
  </div>
</body>
</html>