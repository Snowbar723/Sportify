<!DOCTYPE html>

<html>
<head>
    <script>
        function msg() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
        if (password === confirm_password) {
          window.location.href = "signup.php"
         } else {
        alert("密碼與確認密碼不符！");
        }

    }
        </script>
  <meta charset="UTF-8">
  <title>網站註冊頁面</title>

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

    .image{
      display: block;  
      margin: 0 auto;
      margin-top: 30px;
      height: 80px;
    }

    h2 {
      text-align: center;
      margin-bottom: 15px;
      margin-top: 15px;
      font-size: 2.5em;
    }

    
    input[type="text"], input[type="password"],input[type="password"] {
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

    p{
      text-align: center;
    }

    input[type="submit"] {
      display: block;
      width: 55px;
      height: 55px;
      border-radius: 50px;
      background-color: #664D9A;
      color: #fff;
      cursor: pointer;
      margin-top: 180px;
    }

    .error-message {
      color: #f00;
      margin-bottom: 10px;
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
    <img class="image" src="logo.png">  
    <h2 style="color:#ffffff">註 冊</h2>
    <div class="form-container">
    <form action="signupEx.php" method="post">
      <label><input type="text" name="username"  placeholder="帳號" required></label>
      <?php if(isset($_GET['error'])){ ?>
          <p class="error-message"><?php echo $_GET['error']; ?></p>
      <?php } ?>
      <label><input type="password" name="password" id="password" placeholder ="密碼" required></label>
      <label><input type="password" name="confirm_password" id="confirm_password" placeholder ="確認密碼" required  oninput="setCustomValidity('');" onchange="if(document.getElementById('password').value != document.getElementById('confirm_password').value){setCustomValidity('密碼與確認密碼不符！');}"></label>
       <input type="submit" value="註冊">
    </form>
    </div>
  </div>
</body>
</html>