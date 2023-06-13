<?php 
      session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>我的排隊</title>
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

    h2 {
      text-align: center;
      margin-bottom: 15px;
      margin-top: 15px;
      font-size: 2.5em;
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
  margin-left: 100px;
  margin-right: auto;
  display: block;
}


.edit {
  border: none;
  background-color:  #473952;
  height: 35px;
  width: 35px;
  color: whitesmoke;  
  margin-right: 0px;
  cursor: pointer;
}
 /*以上是上半部*/   

.profile-stats {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  margin-top: 20px;
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

/*選上的*/
.profile-stat {
  display: flex;
  flex:2; 
  flex-direction: column;
  justify-content: space-between;
  margin-top: 20px;
  margin-bottom: 20px;
  max-width: 2/3%;
  height: 125px;
  background-color: #587062;
  border-radius: 24px;
  padding: 25px;
}

/*還在等主揪選的(排隊中)*/
  .profile-waiting {
    display: flex;
    flex:2; 
    flex-direction: column;
    justify-content: space-between;
    margin-top: 20px;
    margin-bottom: 20px;
    max-width: 2/3%;
    height: 100px;
    background-color: #615b64;
    border-radius: 24px;
    padding: 25px;
  }
/*落選*/
.profile-fail {
    display: flex;
    flex:2; 
    flex-direction: column;
    justify-content: space-between;
    margin-top: 20px;
    margin-bottom: 20px;
    max-width: 2/3%;
    height: 100px;
    background-color: #623d3d;
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
  margin-left: 25px;
}

.profile-stats span:first-child {
  font-weight: bold;
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
          <span class="popup" onclick="location.href='myPosts.php'">我的揪團
        </span>
        </div>
        <div>
          <span style="text-decoration: underline;">我的排隊
        </span>
        </div>
        <div>
          <span class="popup" onclick="location.href='personalPost.php'">過往 & 評價</span>
        </div>
      </div>

      <?php
          class inLine{
            public $sport;
            public $location;
            public $time;
            public $posterId;
            public $posterNickname;
            public $phone;
            public $state;
            public $estate;

            public function __construct($sport, $location, $time, $posterId, $posterNickname, $phone, $state, $estate){
              $this->sport = $sport;
              $this->location = $location;
              $this->time = $time;
              $this->posterId = $posterId;
              $this->posterNickname = $posterNickname;
              $this->phone = $phone;
              $this->state = $state;
              $this->estate = $estate;
            }
          }

          $sql = "SELECT event.sport AS 'sport', event.location AS 'location', event.event_Time AS 'time',
               event.user_id AS 'posterId', user.user_Nickname AS 'posterNickname', user.phone AS 'phone',
               queue.state AS 'state', event.state AS 'estate' FROM event 
               LEFT JOIN user ON user.user_id = event.user_id
               LEFT JOIN queue ON queue.event_id = event.event_id
               WHERE queue.waiting_id = '$userId' ORDER BY event.event_Time DESC";

          $stat = mysqli_stmt_init($conn);

          if(! mysqli_stmt_prepare($stat, $sql)){
            die(mysqli_error($conn));
          }

          $result = mysqli_query($conn, $sql);

          $inLines = array();
          while($row = mysqli_fetch_assoc($result)){
            $sport = $row['sport'];
            $location = $row['location'];
            $time = $row['time'];
            $eventTime = substr($time, 0, 16);
            $posterId = $row['posterId'];
            $posterNickname = $row['posterNickname'];
            $phone = $row['phone'];
            $state = $row['state'];
            $estate = $row['estate'];

            $inLine = new inLine($sport, $location, $eventTime, $posterId, $posterNickname, $phone, $state, $estate);
            $inLines [] = $inLine;
          }
      ?>
<script>
      var postsData = [];
      var obj = '<?= json_encode($inLines) ?>';
      postsData = JSON.parse(obj);

      for(var i = 0; i < postsData.length; i++){
        var post = postsData[i];
        if(post.state == "picked"){
            if(post.estate == 'OK' || post.estate == 'success'){
              var container = document.createElement('div');
            container.className = 'profile-stat';

            var leftContainer = document.createElement('div');
            leftContainer.className = 'left';

            var imgElement = document.createElement('img');
            imgElement.className = 'img';
            imgElement.src = '成功.jpg';
            leftContainer.appendChild(imgElement);
            container.appendChild(leftContainer);

            var centerContainer = document.createElement('div');
            centerContainer.className = 'center';

            var locationElement = document.createElement('h3');
            locationElement.textContent = post.sport + " " + post.location;
            centerContainer.appendChild(locationElement);

            var eventTimeElement = document.createElement('p');
            eventTimeElement.textContent = "時間：" + post.time;
            centerContainer.appendChild(eventTimeElement);

            var spanElement = document.createElement('span');
            spanElement.textContent = "主揪：";
            centerContainer.appendChild(spanElement);

            var linkElement = document.createElement('a');
            linkElement.href = "#";
            linkElement.id = post.posterId;
            linkElement.textContent = post.posterNickname;
            linkElement.style.color = 'rgb(44, 181, 255)';
            linkElement.onclick = function(){
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
            centerContainer.appendChild(linkElement);

            var phoneElement = document.createElement('p');
            phoneElement.textContent = '聯絡電話：0' + post.phone;
            centerContainer.appendChild(phoneElement);
            container.appendChild(centerContainer);

            document.getElementById('ps').appendChild(container);
          }else{
            var container = document.createElement('div');
            container.className = 'profile-waiting';

            var leftContainer = document.createElement('div');
            leftContainer.className = 'left';

            var imgElement = document.createElement('img');
            imgElement.className = 'img';
            imgElement.src = '等待.jpg';
            leftContainer.appendChild(imgElement);
            container.appendChild(leftContainer);

            var centerContainer = document.createElement('div');
            centerContainer.className = 'center';

            var locationElement = document.createElement('h3');
            locationElement.textContent = post.sport + " " + post.location;
            centerContainer.appendChild(locationElement);

            var eventTimeElement = document.createElement('p');
            eventTimeElement.textContent = "時間：" + post.time;
            centerContainer.appendChild(eventTimeElement);
            container.appendChild(centerContainer);

            document.getElementById('ps').appendChild(container);
          }
            

        }else if(post.state == 'waiting'){
            var container = document.createElement('div');
            container.className = 'profile-waiting';

            var leftContainer = document.createElement('div');
            leftContainer.className = 'left';

            var imgElement = document.createElement('img');
            imgElement.className = 'img';
            imgElement.src = '等待.jpg';
            leftContainer.appendChild(imgElement);
            container.appendChild(leftContainer);

            var centerContainer = document.createElement('div');
            centerContainer.className = 'center';

            var locationElement = document.createElement('h3');
            locationElement.textContent = post.sport + " " + post.location;
            centerContainer.appendChild(locationElement);

            var eventTimeElement = document.createElement('p');
            eventTimeElement.textContent = "時間：" + post.time;
            centerContainer.appendChild(eventTimeElement);
            container.appendChild(centerContainer);

            document.getElementById('ps').appendChild(container);
        }else{
            var container = document.createElement('div');
            container.className = 'profile-fail';

            var leftContainer = document.createElement('div');
            leftContainer.className = 'left';

            var imgElement = document.createElement('img');
            imgElement.className = 'img';
            imgElement.src = '失敗.jpg';
            leftContainer.appendChild(imgElement);
            container.appendChild(leftContainer);

            var centerContainer = document.createElement('div');
            centerContainer.className = 'center';

            var locationElement = document.createElement('h3');
            locationElement.textContent = post.sport + " " + post.location;
            centerContainer.appendChild(locationElement);

            var eventTimeElement = document.createElement('p');
            eventTimeElement.textContent = "時間：" + post.time;
            centerContainer.appendChild(eventTimeElement);
            container.appendChild(centerContainer);

            var stateElement = document.createElement('p');
            if(post.state == 'canceled'){
              stateElement.textContent = '該活動已取消';
            }else if(post.state == 'unpicked'){
              stateElement.textContent = '落選該活動';
            }
            stateElement.style.color = 'red';
            centerContainer.appendChild(stateElement);
            container.appendChild(centerContainer);

            document.getElementById('ps').appendChild(container);

        }
      }
</script>

<br><br><br>
      <div class="button-container2 ">
        <button class="small" onclick="location.href='posts.php'"><i class="fa-solid fa-house fa-l"></i></button>
        <button class="small" onclick="location.href='createPost.html'"><i class="fa-solid fa-plus fa-xl"></i></button>
        <button class="big"><i class="fa-solid fa-user fa-2xl"></i></button>
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


  

</script>