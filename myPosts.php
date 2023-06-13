<?php 
      session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>PersonalPost</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f2f0f3;  
  }

    .container {
      max-width: 400px;
      min-height: 850px;
      margin: 0 auto;
      padding: 25px;
      background-color: #322C3F;
      border-radius: 24px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      justify-content: center;
      align-items: center;
      /* 設定高度以便於示範效果 */
      color: whitesmoke;
      
    }

.profile {
  display: flex;
  align-items: center;
 
}



.profile-header img {
  flex:1;
  max-width: 1/3%;
  height: 120px;
  border-radius: 50%;
  margin-bottom: 10px;
  
}

.discription {
  flex:2; 
  max-width: 2/3%;
  height: 120px;
  background-color: #473952;
  border-radius: 24px;
  padding: 25px;
  margin-bottom: 10px;
  margin-left: 20px;
  text-align: center;
}

.discription-text {
  display: flex;
  align-items: center;
}

.first-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 45px;
}

.left {
  margin-right: auto;
  font-size: 25px ;
}

.right {
  margin-left: auto;
}

.center {
  margin-top: -100px;  
  margin-left: auto;
  margin-right: auto;
  display: block;
}


.edit{
  border: none;
  background-color:  #473952;
  height: 35px;
  width: 35px;
  color: whitesmoke;  
  margin-right: 0px;
  cursor: pointer;
}

b_button {
      display: block;
      margin-top: -80px;
      margin-left: 205px;
      padding: 5px 10px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
    }
 /*以上是上半部*/   

.profile-stats {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  margin-top: 20px;
}

.profile-stat {
  display: flex;
  flex:2; 
  flex-direction: column;
  justify-content: space-between;
  margin-top: 20px;
  margin-bottom: 20px;
  max-width: 2/3%;
  height: 100px;
  background-color: #473952;
  border-radius: 24px;
  padding: 25px;
}
.img {
  flex:1;
  max-width: 1/4%;
  height: 70px;
  border-radius: 50%;
  margin-bottom: 0px;
}

.profile-stats div {
  flex: 1;
  margin-left: 45px;
}

.profile-stats span:first-child {
  font-weight: bold;
}
.popup {
    cursor: pointer;
}

.popup .popuptext {
    visibility: hidden;
}

.popup .show {
    visibility: visible;
}


.post {
        justify-content: flex-start;
        width: 340px;
        height: 130px;
        border-radius: 24px;
        padding: 30px;
        margin-top: 30px;
        margin-bottom: 0px;
        background-color: #473952;
        
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

    .post button {
      display: block;
      margin-top: 0px;
      margin-left: 175px;
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
      margin-left: -12px;
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
    }

    .button-container2 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60px; /* 設定高度以便於示範效果 */
    width: 380px;
    position: fixed;
    bottom: 20px;
    background: rgba(0,0,0.5,0.4);/*半透明度*/
    border-radius: 50px;
    border: 4px solid #664D9A;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
    }

    button {
    /*margin: 0 100px;  設定按鈕之間的間距 */
     border: none;
     background-color:  #664D9A;
     border-radius: 50px;
     
     margin: 0 30px;   
    }

    .small{
      height: 30px;
      width: 30px;
    }

    .big{
      height: 45px;
      width: 45px;
    }

    .notyet {
      text-align: center;
      margin-bottom: 15px;
      margin-top: 200px;
    }
 </style></head>

<body>
      <?php
      
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

      $sql = "SELECT user_Nickname, gender, school, major, sport_Prefer 
            FROM user WHERE user_id = '$userId'";

      $stat = mysqli_stmt_init($conn);

      if(! mysqli_stmt_prepare($stat, $sql)){
        die(mysqli_error($conn));
      }

      $result = mysqli_query($conn, $sql);

      $row = mysqli_fetch_assoc($result);

      $nickname = $row['user_Nickname'];
      $gender = $row['gender'];
      $school = $row['school'];
      $major = $row['major'];
      $sport = $row['sport_Prefer'];
      $picsrc = "";
      $schoolInfo = $school." ".$major;
      
      if($gender === "male"){
        $picsrc = "男.jpg";
      }else if($gender === "female"){
        $picsrc = "女.jpg";
      }
      

    ?>
    <div class="container" id="ps">
      <div class="profile">
        <div class="profile-header">
          <img src="<?php echo($picsrc) ?>" alt="Profile Picture"></div>
          <div class ="discription">
            <div class="first-container ">
              <p class="left"><?php echo($nickname); ?></p>
              <div class="button-container ">
              <button class="edit" onclick="location.href='changeInfo.php'"><i class="fa-solid fa-pen fa-xl right"></i></button>
              </div>
            </div>  
            <p class="discription-text"><?php echo($schoolInfo); ?></p>
            <p class="discription-text">🤍 <?php echo($sport); ?></p>
          </div>
          
        </div>

      <div class="profile-stats">
        <div>
          <span style="text-decoration: underline;">我的揪團
        </span>
        </div>
        <div>
          <span class="popup" onclick="location.href='inLine.php'">我的排隊
        </span>
        </div>
        <div>
          <span class="popup" onclick="location.href='personalPost.php'">過往 & 評價</span>
        </div>
      </div>

      <?php 
        class postOver {
          public $id;
          public $sport;
          public $location;
          public $number;
          public $time;
          public $state;

          public function __construct($id, $sport, $location, $number, $time, $state){
            $this->id = $id;
            $this->sport = $sport;
            $this->location = $location;
            $this->number = $number;
            $this->time = $time;
            $this->state = $state;
          }
        }

        $sql = "SELECT DISTINCT event.event_id AS 'id', event.sport AS 'sport', event.location AS 'location', event.people_Needed AS 'number', event.event_Time AS 'time', event.state AS 'state' FROM event WHERE (event.state = 'ING' OR event.state = 'OK') AND event.user_id = '$userId'";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);

        $postsOver = array();   //設定array為空陣列
        while($row = mysqli_fetch_assoc($result)){
          $id = $row['id'];
          $sport = $row['sport'];
          $location = $row['location'];
          $number = $row['number'];
          $time = $row['time'];
          $eventTime = substr($time, 0, 16);
          $state = $row['state'];

          $obj = new postOver($id, $sport, $location, $number, $eventTime, $state);
          $postsOver[] = $obj;
        }

      ?>

      <div>
        <script>
          var postsData = [];
          var obj = '<?= json_encode($postsOver) ?>';
          postsData = JSON.parse(obj);

          if(postsData.length == 0){
          var notYetCon = document.createElement('div');
          notYetCon.className = "notyet";

          var notYet = document.createElement('h3');
          notYet.textContent = "您  目  前  還  沒  有  揪  團";
          notYetCon.appendChild(notYet);

          var notYet2 = document.createElement('h3');
          notYet2.textContent = "快   去   建  立  貼  文   吧 ！";
          notYetCon.appendChild(notYet2);

          document.getElementById('ps').appendChild(notYetCon);
          }

          for (var i = 0; i < postsData.length; i++){
            var post = postsData[i];
            console.log(post.state);

            var statContainer = document.createElement('div');
            statContainer.className = 'profile-stat';

            var leftContainer = document.createElement('div');
            leftContainer.className = 'left';

            var imgElement = document.createElement('img');
            imgElement.className = 'img';
            imgElement.src = "<?php echo($picsrc) ?>"
            leftContainer.appendChild(imgElement);
            statContainer.appendChild(leftContainer);

            var centerContainer = document.createElement('div');
            centerContainer.className = 'center';

            var line1Element = document.createElement('h3');
            line1Element.textContent = post.sport + " " + post.location;
            centerContainer.appendChild(line1Element);

            var line2Element = document.createElement('p');
            if(post.state == 'ING'){
              line2Element.textContent = "媒合" + post.number + "人" + ", 未選隊友";
            }else if(post.state == 'OK') {
              line2Element.textContent = "媒合" + post.number + "人" + ", 已選隊友";
            }
            centerContainer.appendChild(line2Element);

            var line3Element = document.createElement('p');
            line3Element.textContent = '時間：' + post.time;
            centerContainer.appendChild(line3Element);
            statContainer.appendChild(centerContainer);

            var rightContainer = document.createElement('div');
            rightContainer.className = 'right';

            if(post.state == 'ING'){
              var buttonElement = document.createElement('b_button');
              buttonElement.onclick = function() {
                var btnId = this.id;
                location.href = "choose.php?id=" + btnId;
                
                console.log(btnId);
                // Create an AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'choose.php?id=' + btnId, true);
                xhr.onreadystatechange = function() {
                  if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from PHP if needed
                    var response = xhr.responseText;
                    console.log(response);
                  }
                };
                xhr.send();
              };
              buttonElement.id = post.id;
              buttonElement.textContent = "選隊友";
            }else if(post.state == 'OK'){
              var buttonElement = document.createElement('b_button');
              buttonElement.onclick = function() {
                var btnId = this.id;
                location.href = "myTeammates.php?id=" + btnId;
                
                console.log(btnId);
                // Create an AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'myTeammates.php?id=' + btnId, true);
                xhr.onreadystatechange = function() {
                  if (xhr.readyState === 4 && xhr.status === 200) {
                    // Handle the response from PHP if needed
                    var response = xhr.responseText;
                    console.log(response);
                  }
                };
                xhr.send();
              };
              buttonElement.id = post.id;
              buttonElement.textContent = "看隊友";
            }
            
            rightContainer.appendChild(buttonElement);
            statContainer.appendChild(rightContainer);

            document.getElementById('ps').appendChild(statContainer);
          }

          if(postsData.length == 1){
            for(var j=0; j<24; j++){
              var brElement = document.createElement('br');
              document.getElementById('ps').appendChild(brElement);
            }
          }else if(postsData.length == 2){
            for(var j=0; j<15; j++){
              var brElement = document.createElement('br');
              document.getElementById('ps').appendChild(brElement);
            }
          }else if(postsData.length == 3){
            for(var j=0; j<5; j++){
              var brElement = document.createElement('br');
              document.getElementById('ps').appendChild(brElement);
            }
          }else{
            for(var j=0; j<2; j++){
              var brElement = document.createElement('br');
              document.getElementById('ps').appendChild(brElement);
            }
          }
        </script>

      <div class="button-container2 ">
      <button class="small" onclick="location.href='posts.php'"><i class="fa-solid fa-house fa-l"></i></button>
      <button class="small" onclick="location.href='createPost.html'"><i class="fa-solid fa-plus fa-xl"></i></button>
      <button class="big" onclick="location.href='personalPost.php'"><i class="fa-solid fa-user fa-2xl"></i></button>
      </div>

    </div>
    </div>
</body>
        
</html>

<script>
/*排隊列表出現跟隱藏*/
//var isHidden = true;
function toggleContainer(hiddenPost) {
  var hiddenContainer = document.getElementById(hiddenPost);
  
  if(hiddenContainer.style.display === ""){
    hiddenContainer.style.display = "none";
  }

  if (hiddenContainer.style.display === "none") {
    showContainer(hiddenContainer);
  } else {
    hideContainer(hiddenContainer);
  }
}

function showContainer(container) {
  container.style.display = "block";
  //isHidden = false;
}

function hideContainer(container) {
  container.style.display = "none";
  //isHidden = true;
}

function ratingPage () {
        var popup = document.getElementById("popup_text");
        popup.classList.toggle("show");
}

  

</script>