
<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>我的隊友</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      min-height: 300px;
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

    h2 {
      text-align: center;
      margin-bottom: 15px;
      margin-top: 15px;
      font-size: 2.5em;
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
      margin-top: 20px;
      margin-bottom: 20px;
      max-width: 2/3%;
      min-height: 200px;
      background-color: #473952;
      border-radius: 24px;
      padding: 25px;
    }



    .post-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        position: absolute;
    }

  .post textarea {
        width: 200%;
        height: 500px;
        border: none;
        resize: none;
    }

    .linebtn {
      display: block;
      margin-top: 5px;
      margin-left: 175px;
      padding: 5px 10px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
    }

    .joinbtn {
      display: block;
      margin-top: -30px;
      margin-left: 212px;
      padding: 5px 10px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
    }

    .post p,span{
      color: white;
      margin-top: 16px;
      margin-bottom: 5px;
      margin-left: 0px;
    }

    .hidden-post p{
      color:black;
      margin-top: 0px;
      margin-bottom: 10px;
      margin-left: 0px;
    }

    .nameContainer p{
      color: white;
      font-size: 20px;
      margin-top: 40px;
      margin-left: 85px;
      position: absolute;
    }

    .twoThings{
      margin-top: 16px;
    }

    .twoThings span{
      display: inline-block;
      color: white;
    
      margin-top: 2px;
      margin-bottom: 0px;
      margin-right: 20px;
    }

    .sport, .number{
      width: 110px;
    }

    .location, .ability{
      width: 200px;
    }
    
    .author{
      position: relative;
      margin-bottom: 5px;
      size: 20px;
    }

        .post {
        justify-content: flex-start;
        width: 200px;
        height: 90px;
        border-radius: 24px;
        padding: 30px;
        margin-top: 50px;
        margin-bottom: 0px;
        margin-left:52px;
        margin-right: 0px;
        
    }
  </style>
</head>

<body>
  <?php
        $eventId = $_GET['id'];
        $host = "localhost";
        $dbname = "db";
        $username = "root";
        $password = "";

        class Person{
          public $nickname;
          public $id;
          public $contact;
          public $picsrc;

          public function __construct($nickname, $id, $contact, $picsrc){
            $this->nickname = $nickname;
            $this->id = $id;
            $this->contact = $contact;
            $this->picsrc = $picsrc;
          }
        }

        $conn = mysqli_connect(hostname: $host,
              username: $username,
              password: $password, 
              database: $dbname);

        if(mysqli_connect_errno()){
          die("Connection error: " . mysqli_connect_error());
        }

        $sql = "SELECT user.user_Nickname AS 'nickname', user.phone AS 'contact',  
                user.gender AS 'gender', user.user_id AS 'userId' FROM `user` 
                LEFT JOIN `queue` ON  queue.waiting_id = user.user_id
                WHERE queue.event_id = '$eventId' AND queue.state = 'picked';";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);

        $teammates = array();
        $count = 0;
        while($row = mysqli_fetch_assoc($result)){
          $nickname = $row['nickname'];
          $userId = $row['userId'];
          $contact = $row['contact'];
          $gender = $row['gender'];
          if($gender === "male"){
            $picsrc = "男.jpg";
          }else if($gender === "female"){
            $picsrc = "女.jpg";
          }

          $person = new Person($nickname, $userId, $contact, $picsrc);
          $teammates[] = $person;
          $count++;
        }
  ?>
  <div class="container">
    <h2>我的隊友</h2>
    <div class ="profile-stat" id="ps">
          <label><h3>以下是您此次活動的<?php echo ($count); ?>位隊友：</h3></label><br>
      </div>  
    </div>
      <script>
      var postsData = [];
      var obj = '<?= json_encode($teammates) ?>';
      postsData = JSON.parse(obj);

      for (var i = 0; i < postsData.length; i++) {
        var post = postsData[i];
        
        var nameContainer = document.createElement('div');
        nameContainer.className = 'nameContainer';
        
        var btnonclick = document.createElement('a');
        btnonclick.href = "#";
        btnonclick.id = post.id;
        btnonclick.textContent = "他的個人主頁";
        if(post.picsrc == "女.jpg"){
          btnonclick.style.color = 'pink';
        }else{
          btnonclick.style.color = 'rgb(44, 181, 255)';
        }
        
        btnonclick.onclick = function(){
              var btnId = this.id;
              location.href = "othersPost.php?id=" + btnId;
              
              console.log(btnId);
              // Create an AJAX request
              var xhr = new XMLHttpRequest();
              xhr.open('GET', 'othersPost.php?id=' + btnId, true);
              xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                  // Handle the response from PHP if needed
                  var response = xhr.responseText;
                  console.log(response);
                }
              };
              xhr.send();
        }

        var imgElement = document.createElement('img');
        imgElement.className = 'post-img';
        imgElement.src = post.picsrc;
        nameContainer.appendChild(imgElement);

        var authorElement = document.createElement('p');
        authorElement.className = 'author';
        authorElement.textContent = post.nickname;
        nameContainer.appendChild(authorElement);
        document.getElementById('ps').appendChild(nameContainer);

        var postContainer = document.createElement('div');
        postContainer.className = 'post';

        var contactElement = document.createElement('p');
        contactElement.textContent = "連絡電話：0" + post.contact;
        postContainer.appendChild(btnonclick);
        postContainer.appendChild(contactElement);

        document.getElementById('ps').appendChild(postContainer);
      }
    </script>



</body>
</html>