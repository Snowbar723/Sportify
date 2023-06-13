<?php
  session_start();
  $user = $_SESSION['id'];
?>

<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>給個評價吧</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      min-height: 800px;
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
      margin-left: 12px;
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
      
      background-color: #473952;
      border-radius: 24px;
      padding: 25px;
    }

    .information{
        text-align: center;
        margin-top: -20px;
    }

    .img {
      flex:1;
      max-width: 1/4%;
      height: 70px;
      border-radius: 50%;
      margin-bottom: 0px;
    }

    .name{
        margin-bottom: 5px;
        margin-top: 30px;
        font-size: 23px;;
    }
    .comment{
        margin-top: 12px;
    }

    textarea{
        background-color: #787878;
        color: whitesmoke;
        margin-top: 10px;
        padding:8px;
        border-radius: 15px;
        letter-spacing: 1.5px;
    }

    textarea::placeholder {
    color: rgb(196, 194, 194);
    }

    input[type="button"] {
    display: block;
    width: 100px;
    margin: 0 auto;
    padding: 10px;
    font-size: 19px;
    border-radius: 25px;
    background-color: #664D9A;
    border: none;
    color: #fff;
    cursor: pointer;
    margin-bottom: -5px;
    }

    

    /*五星*/
    .rating {
      direction: rtl;
      unicode-bidi: bidi-override;
      text-align: left;
    }

    .rating input[type="radio"] {
      display: none;
    }

    .rating label {
      font-size: 24px;
      color: gray;
      cursor: pointer;
    }

    .rating label:before{
      content: "\2605";
      position:relative;
    }


    .rating input[type="radio"]:checked ~ label:before,
    .rating input[type="radio"]:hover ~ label:before {
      background: linear-gradient(to right, gold 0%, gold 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    
  </style>



</head>
<body>
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

        //確認該活動有沒有評價過了
        $sql = "SELECT review_id FROM review WHERE user_id_From = '$user' AND event_id = '$event_ID'";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);

        while(($row = mysqli_fetch_assoc($result))){
          header("Location: posts.php");
        }

        //將活動設為成功
        $sql = "UPDATE event SET state = 'success' WHERE event_id =?";

        $stat = mysqli_stmt_init($conn);
      
        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        //Bind
        mysqli_stmt_bind_param($stat, "s", $event_ID);

        mysqli_stmt_execute($stat);

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

  <div class="container">
    <h2>給 個 評 價 吧 🙂</h2>
    
    <div class ="profile-stat" id="ps">
        <div class="information">
                  <h3 style="font-size: 23px;"><?php echo($sport) ?> <?php echo($location) ?></h3>
                  <p><?php echo($eventTime) ?>，已完成</p>
                  <p>- - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - -</p>
        </div>

    <?php
      class Person{
        public $id;
        public $nickname;
        public $picsrc;

        public function __construct($id, $nickname, $picsrc){
          $this->id = $id;
          $this->nickname = $nickname;
          $this->picsrc = $picsrc;
        }
      };

      $sql = "SELECT DISTINCT user.user_id AS 'userId', user.user_Nickname AS 'nickname', user.gender AS 'gender'
              FROM user LEFT JOIN queue ON queue.waiting_id = user.user_id
              LEFT JOIN event ON event.user_id = user.user_id
              WHERE (queue.event_id = '$event_ID' AND queue.state = 'picked')
              OR (event.event_id = '$event_ID')";

      $stat = mysqli_stmt_init($conn);

      if(! mysqli_stmt_prepare($stat, $sql)){
        die(mysqli_error($conn));
      }

      $result = mysqli_query($conn, $sql);
      $people = array();
      while($row = mysqli_fetch_assoc($result)){
        if($row['userId'] != $user){
          $id = $row['userId'];
          $nickname = $row['nickname'];
          $gender = $row['gender'];
          if($gender === "male"){
            $picsrc = "男.jpg";
          }else if($gender === "female"){
            $picsrc = "女.jpg";
          }

          $person = new Person($id, $nickname, $picsrc);
          $people[] = $person;
        }
      }
    ?>
    
    <script>
      var postsData = [];
      var obj = '<?= json_encode($people) ?>';
      postsData = JSON.parse(obj);

      for(var i=0; i<postsData.length; i++){
          post = postsData[i];
          post_id = i+1;

          var statContainer = document.getElementById('ps');
          //statContainer.className = 'profile-stat';

          var leftContainer = document.createElement('div');
          leftContainer.className = 'left';

          var imgElement = document.createElement('img');
          imgElement.className = 'img';
          imgElement.src = post.picsrc;
          leftContainer.appendChild(imgElement);
          statContainer.appendChild(leftContainer);

          var centerContainer = document.createElement('div');
          centerContainer.className = 'center';

          var nicknameElement = document.createElement('h3');
          nicknameElement.className = 'name';
          nicknameElement.textContent = post.nickname;
          centerContainer.appendChild(nicknameElement);

          var ratingContainer = document.createElement('div');
          ratingContainer.className = 'rating';

          var star1 = document.createElement('input');
          star1.type = 'radio';
          star1.id = 'star1'+ post_id;
          star1.name = 'rating' + post_id;
          star1.value = '5';

          var label1 = document.createElement('label');
          label1.htmlFor = 'star1'+ post_id;

          var star2 = document.createElement('input');
          star2.type = 'radio';
          star2.id = 'star2'+ post_id;
          star2.name = 'rating' + post_id;
          star2.value = '4';

          var label2 = document.createElement('label');
          label2.htmlFor = 'star2'+ post_id;

          var star3 = document.createElement('input');
          star3.type = 'radio';
          star3.id = 'star3'+ post_id;
          star3.name = 'rating' + post_id;
          star3.value = '3';

          var label3 = document.createElement('label');
          label3.htmlFor = 'star3'+ post_id;

          var star4 = document.createElement('input');
          star4.type = 'radio';
          star4.id = 'star4'+ post_id;
          star4.name = 'rating' + post_id;
          star4.value = '2';

          var label4 = document.createElement('label');
          label4.htmlFor = 'star4'+ post_id;

          var star5 = document.createElement('input');
          star5.type = 'radio';
          star5.id = 'star5'+ post_id;
          star5.name = 'rating' + post_id;
          star5.value = '1';

          var label5 = document.createElement('label');
          label5.htmlFor = 'star5'+ post_id;

          if(post.score == 5){
            star1.checked = true;
            //console.log("5分");
          }else if(post.score == 4){
            star2.checked = true;
          }else if(post.score == 3){
            star3.checked = true;
          }else if(post.score == 2){
            star4.checked = true;
          }else if(post.score == 1){
            star5.checked = true;
          }

          ratingContainer.appendChild(star1);
          ratingContainer.appendChild(label1);
          ratingContainer.appendChild(star2);
          ratingContainer.appendChild(label2);
          ratingContainer.appendChild(star3);
          ratingContainer.appendChild(label3);
          ratingContainer.appendChild(star4);
          ratingContainer.appendChild(label4);
          ratingContainer.appendChild(star5);
          ratingContainer.appendChild(label5);
          centerContainer.appendChild(ratingContainer);

          var commentElement = document.createElement('textarea');
          commentElement.name = 'mytext'+ post_id;
          commentElement.rows = '4';
          commentElement.cols = '27';
          commentElement.required = true;
          commentElement.placeholder = "我想說......";
          centerContainer.appendChild(commentElement);
          statContainer.appendChild(centerContainer);

          var space = document.createElement('br');
          var space2 = document.createElement('br');
          statContainer.appendChild(space);
          statContainer.appendChild(space2);
        }
    </script>
        
          <input type="button" onclick="submitValues()" value="O K">
    </div>
  </div>
      
    <script>
      function submitValues(){
        var ids = [];
        var starValues = [];
        var comments = [];

        for(var j=0; j<postsData.length; j++){
          var id = j+1;
          var starName = "rating" + id;
          var commentName = "mytext" + id;
          var selectStar = "input[name=" + starName + "]:checked";
          var selectComment = "textarea[name=" + commentName + "]";
          //使用者id部分
          var personId = postsData[j].id;
          ids.push(personId);
          //分數部分
          var starValue = document.querySelector(selectStar).value;
          starValues.push(starValue);
          //評論部分
          var comment = document.querySelector(selectComment).value;
          comments.push(comment);
        }
        var url = "giveRateEx.php?id=<?php echo $event_ID ?>
                  &users=" + encodeURIComponent(ids.join(',')) + 
                  "&rates=" +encodeURIComponent(starValues.join(',')) + 
                  "&comments=" + encodeURIComponent(comments.join(','));
        location.href = url;
        
        alert("感謝您給予隊友評價！");
      }  
    </script>



</body>
</html>