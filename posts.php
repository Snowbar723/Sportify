<?php 
  session_start();
  $userId = $_SESSION['id']; 

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

  $sql = "SELECT user_Nickname FROM user WHERE user_id = '$userId';";

  $stat = mysqli_stmt_init($conn);

  if(! mysqli_stmt_prepare($stat, $sql)){
     die(mysqli_error($conn));
  }

  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)){
    $userNickname = $row['user_Nickname'];
  }

  //檢查是否有已結束之活動
  $sql = "SELECT event.event_id AS 'eid', event.user_id AS 'uid' FROM event 
          LEFT JOIN queue ON event.event_id = queue.event_id 
          WHERE event.state = 'OVER'";

  $stat = mysqli_stmt_init($conn);

  if(! mysqli_stmt_prepare($stat, $sql)){
    die(mysqli_error($conn));
    echo "error when connect";
  }

  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_assoc($result)){
    if($row['uid'] == $userId){
      $id = $row['eid'];
      header("Location: YorN.php?id=".$id);
    }
  }

  //檢查是否有已結束但未評價之活動
    $sql1 = "SELECT DISTINCT event.event_id AS 'eid', event.user_id AS 'uid' FROM event 
          LEFT JOIN queue ON event.event_id = queue.event_id 
          WHERE event.state = 'success' AND queue.waiting_id = '$userId' AND queue.state = 'picked'";

    $stat = mysqli_stmt_init($conn);

    if(! mysqli_stmt_prepare($stat, $sql1)){
      die(mysqli_error($conn));
      echo "error when connect";
    }

    $result2 = mysqli_query($conn, $sql1);

    while($row = mysqli_fetch_assoc($result2)){
      $id = $row['eid'];
      //echo $id;

      //確認該活動有沒有評價過了
        $sql = "SELECT review_id FROM review WHERE user_id_From = '$userId' AND event_id = '$id'";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);
        $row_count = mysqli_num_rows($result);
        //print_r($result);
        if($row_count == 0){
          //echo("oo");
          header("Location: giveRate.php?id=".$id);
        }

      
      }

    
    
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>Posts</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 0px;
      padding: 25px;
      background-color: #322C3F;
      border-radius: 24px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      min-height: 850px;
    }

    .logo{
      display: block;  
      margin: 0 auto;
      margin-top: 0px;
      height: 80px;
      margin-bottom: 0px;
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

    .button-container {
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
/*
    .pageBtn{
      display: block;
      padding: 5px 10px;
      margin-right: 10px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 30px;
      position: relative;
      cursor: pointer;
    }

    .lastPageBtn { 
      display: flex;
      margin-top: -3px;
      margin-left: 90px;
      padding: 5px 10px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      position: absolute;
    }

    .nextPageBtn { 
      display: flex;
      margin-top: -40.5px;
      margin-left: 250px;
      padding: 5px 10px;
      background-color: #664D9A;
      color: white;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      position: absolute;
    }

    .page{
      position: relative;
      margin-top: 17px;
      color: white;
      text-align: center; //設定為水平置中
    }
    */
	</style>

</head>
<body>


    <div class="container" id="ps">
      <img class="logo" src="logo.png" > 

        

        <!--抓資料回來OK，但無法顯示在對應位置-->
        <?php

        $sql = "SELECT event.event_id AS 'id', event.sport AS 'sport', event.location AS 'location', event.people_Needed AS 'number', event.ability AS 'ability', event.event_Time AS 'time', user.user_Nickname AS 'author', user.gender AS 'gender',event.user_id AS 'posterId', event.state AS 'state' FROM event LEFT JOIN user ON event.user_id = user.user_id WHERE event.state = 'ING' OR event.state = 'OK'  ORDER BY event.event_Time ASC;";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);
     
      $currentTime = date('Y-m-d H:i:s');
      $offset = '+6 hours';

      $nowTime = date('Y-m-d H:i:s', strtotime($currentTime . ' ' . $offset));
      //echo $nowTime;

        class Post {
           public $id;
           public $author;
           public $picsrc;
           public $sport;
           public $location;
           public $number;
           public $ability;
           public $eventTime;
           public $poster;

           public function __construct($id, $author, $sport, $location, $number, $ability, $eventTime, $picsrc, $poster) {
              $this->id = $id;
              $this->author = $author;
              $this->sport = $sport;
              $this->location = $location;
              $this->number = $number;
              $this->ability = $ability;
              $this->eventTime = $eventTime;
              $this->picsrc = $picsrc;
              $this->poster = $poster;
          }
        }

        class inLine {
            public $nickname;
            public $gender;
            public $eventId;

            public function __construct($nickname, $gender, $eventId) {
              $this->eventId = $eventId;
              $this->nickname = $nickname;
              $this->gender = $gender;
            }
        }

            $results = array();   //設定array為空陣列
            while($row = mysqli_fetch_assoc($result)){
              $id = $row['id'];
              $author = $row['author'];
              $gender = $row['gender'];
              $sport = $row['sport'];
              $location = $row['location'];
              $number = $row['number'];
              $ability = $row['ability'];
              $time = $row['time'];
              $poster = $row['posterId'];
              $eventTime = substr($time, 0, 16);
              if($gender === "male"){
                $picsrc = "男.jpg";
              }else if($gender === "female"){
                $picsrc = "女.jpg";
              }
              $state = $row['state'];

              if($nowTime > $eventTime){
                  $sql = "UPDATE event SET state ='OVER' WHERE event_id =?";
  
                  $stat = mysqli_stmt_init($conn);

                  if(! mysqli_stmt_prepare($stat, $sql)){
                        die(mysqli_error($conn));
                  }

                  mysqli_stmt_bind_param($stat, "s", $id);

                  mysqli_stmt_execute($stat);
              }else if($state == 'ING'){
                  $post = new Post($id, $author, $sport, $location, $number, $ability, $eventTime, $picsrc, $poster);   //創造新物件
                  $results[] = $post;   //將物件加入陣列
              }
            }   



            $sql = "SELECT queue.event_id AS 'eventId', user.user_Nickname AS 'nickname', user.gender AS 'gender' FROM queue LEFT JOIN user ON queue.waiting_id = user.user_id;";

            $stat = mysqli_stmt_init($conn);

            if(! mysqli_stmt_prepare($stat, $sql)){
              die(mysqli_error($conn));
            }

            $lineResult = mysqli_query($conn, $sql);

            $inLines = array();
            while($row = mysqli_fetch_assoc($lineResult)){
              $id = $row['eventId'];
              $nickName = $row['nickname'];
              $gender = $row['gender'];

              $inLine = new inLine($nickName, $gender, $id);
              $inLines[] = $inLine;
            }
        ?>
      
        <div>
          <script>
      var postsData = [];
      var obj = '<?= json_encode($results) ?>';
      postsData = JSON.parse(obj);

      var inLineData = [];
      var obj2 = '<?= json_encode($inLines) ?>';
      inLineData = JSON.parse(obj2);

      for (var i = 0; i < postsData.length; i++) {
        var post = postsData[i];
        var id = i+1;
        var btnId = 'hiddenPost' + id;
        var event_time = new Date(post.eventTime);
        
        var nameContainer = document.createElement('div');
        nameContainer.className = 'nameContainer';
        
        var btnonclick = document.createElement('a');
        btnonclick.href = "#";
        btnonclick.id = post.poster;
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
        btnonclick.appendChild(imgElement);
        nameContainer.appendChild(btnonclick);

        var authorElement = document.createElement('p');
        authorElement.className = 'author';
        authorElement.textContent = post.author;
        nameContainer.appendChild(authorElement);
        document.getElementById('ps').appendChild(nameContainer);

        var postContainer = document.createElement('div');
        postContainer.className = 'post';

        var twoThingContainer1 = document.createElement('div');
        twoThingContainer1.className = "twoThings";

        var sportElement = document.createElement('span');
        sportElement.className = 'sport';
        sportElement.textContent =  '項目：' + post.sport;
        twoThingContainer1.appendChild(sportElement);

        var locationElement = document.createElement('span');
        locationElement.className = 'location';
        locationElement.textContent = "地點：" + post.location;
        twoThingContainer1.appendChild(locationElement);
        postContainer.appendChild(twoThingContainer1);

        var twoThingContainer2 = document.createElement('div');
        twoThingContainer2.className = "twoThings";

        var numberElement = document.createElement('span');
        numberElement.className = 'number';
        numberElement.textContent = '人數：' + post.number + '人';
        twoThingContainer2.appendChild(numberElement);

        var abilityElement = document.createElement('span');
        abilityElement.className = 'ability';
        if(post.ability == ""){
          abilityElement.textContent = '能力：無限制' + post.ability;
        }else{
          abilityElement.textContent = '能力：' + post.ability;
        }
        
        twoThingContainer2.appendChild(abilityElement);
        postContainer.appendChild(twoThingContainer2);
  
        var eventTimeElement = document.createElement('p');
        eventTimeElement.className = 'eventTime';
        eventTimeElement.textContent = "時間：" + post.eventTime;
        postContainer.appendChild(eventTimeElement);

        
        if(post.poster != '<?php echo($userId); ?>'){
          //加一按鈕
          var btnElement = document.createElement('button');

          btnElement.onclick = function(){
            var Id = this.id;
            var ID = 'hiddenPost' + Id;
            if(this.textContent == "+1"){
              plus1(ID);
              this.textContent = '-1';
            }else if(this.textContent == "-1"){
              minus1(ID);
              this.textContent = '+1';
            }
          };
          btnElement.id = i+1;
          btnElement.className = "joinbtn";
          btnElement.textContent = '+1';
          //console.log(buttonElement.onclick);

          postContainer.appendChild(btnElement);
        }
        
        var buttonElement = document.createElement('button');

        //console.log(btnId);
        buttonElement.onclick = function(){
          var Id = this.id;
          var ID = 'hiddenPost' + Id;
          
          toggleContainer(ID); //ID值傳不進去
        };
        buttonElement.id = i+1;
        buttonElement.className = 'linebtn';
        buttonElement.textContent = '排隊情況';
        //console.log(buttonElement.onclick);
        
        postContainer.appendChild(buttonElement);

        var hiddenContainer = document.createElement('div');
        hiddenContainer.className = 'hidden-post';
        hiddenContainer.id = btnId;
        hiddenContainer.name = post.id;
        //Set style
        hiddenContainer.style.display = "none"; 
        hiddenContainer.style.borderBottomRightRadius = '24px'; 
        hiddenContainer.style.borderTopRightRadius = '24px'; 
        hiddenContainer.style.height = '170px';
        hiddenContainer.style.width = '110px'; 
        hiddenContainer.style.padding = '10px'; 
        hiddenContainer.style.backgroundColor = '#ffffff';
        hiddenContainer.style. position = 'relative';
        hiddenContainer.style.left = '250px';
        hiddenContainer.style.bottom = '185px';
        hiddenContainer.style.overflowY = 'scroll';
        //hiddenContainer.style.whiteSpace = 'pre';
        
        for(var j = 0; j < inLineData.length; j++){
          var inLine = inLineData[j];
          if(inLine.eventId == post.id){
            var person = document.createElement('p');
            person.textContent = inLine.nickname;
            hiddenContainer.appendChild(person);
            if(inLine.nickname == '<?php echo($userNickname); ?>'){
              btnElement.textContent = "-1";
              person.id = hiddenContainer.id + "person";
            }
          }
        }

        postContainer.appendChild(hiddenContainer);

        document.getElementById('ps').appendChild(postContainer);
        
      }

    /*排隊列表出現跟隱藏*/
    //var isHidden = true;
    function toggleContainer(hiddenPost) {
      //console.log(hiddenPost);
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

    function plus1(hiddenPost){
      //加名字
      var hiddenContainer = document.getElementById(hiddenPost);
      var person = document.createElement('p');
      person.id = hiddenContainer.id + "person";
      person.textContent = '<?php echo($userNickname); ?>';
      hiddenContainer.appendChild(person);

      var postID = hiddenContainer.name;
      
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'inLineEx.php?id=' + postID + '&name=plus', true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Handle the response from PHP if needed
          var response = xhr.responseText;
          console.log(response);
        }
      };
      xhr.send();
    }

    function minus1(hiddenPost){
      //移除名字
      var pID = hiddenPost + "person";
      var person = document.getElementById(pID);
      person.remove();

      var hiddenContainer = document.getElementById(hiddenPost); 
      var postID = hiddenContainer.name;
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'inLineEx.php?id=' + postID + '&name=minus', true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Handle the response from PHP if needed
          var response = xhr.responseText;
          console.log(response);
        }
      };
      xhr.send();
    }
    </script>
    </div>
    <br><br><br>
    <div class="button-container ">
    <button class="big" onclick="location.href='posts.php'"><i class="fa-solid fa-house fa-2xl"></i></button>
    <button class="small" onclick="location.href='createPost.html'"><i class="fa-solid fa-plus fa-xl"></i></button>
    <button class="small" onclick="location.href='myPosts.php'"><i class="fa-solid fa-user fa-lg"></i></button>
    </div> 
        
        
 </div>

  </body>
</html>