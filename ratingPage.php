<?php 
      session_start();
     
?>
<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>評價</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
      min-height: 600px;
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
      min-height: 100px;
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

    .name{
        margin-bottom: 8px;
        margin-top: 25px;
        font-size: 23px;;
    }
    .comment{
        margin-top: 12px;
        margin-bottom: 0px;
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

    .notyet {
      text-align: center;
      margin-bottom: 15px;
      margin-top: 200px;
    }

    
  </style>



</head>
<body>


  <div class="container" id="ps">
    <h2>評 價</h2>

    <?php  
        if (isset($_GET['id'])){
          $event_ID = $_GET['id'];
        }

        if (isset($_GET['name'])){
          $userId = $_GET['name'];
        }else{
           $userId = $_SESSION['id'];
        }

        class rating {
          public $nickname;
          public $picsrc;
          public $score;
          public $content;

          public function __construct($nickname, $picsrc, $score, $content){
            $this->nickname = $nickname;
            $this->picsrc = $picsrc;
            $this->score = $score;
            $this->content = $content;
          }
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

        $sql = "SELECT user.user_Nickname AS 'nickname', user.gender AS 'gender', review.score AS 'score', review.content AS 'content' FROM user LEFT JOIN review ON user.user_id = review.user_id_From 
        WHERE review.event_id = '$event_ID' AND review.user_id_To = '$userId'";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);

        $ratings = array();
        while($row = mysqli_fetch_assoc($result)){
          $nickname = $row['nickname'];
          $gender = $row['gender'];
          $score = $row['score'];
          $content = $row['content'];
          if($gender === "male"){
            $picsrc = "男.jpg";
          }else if($gender === "female"){
            $picsrc = "女.jpg";
          }
          $rating = new rating($nickname, $picsrc, $score, $content);
          $ratings[] = $rating;
        }

        //print_r($ratings);
    ?>

    <div>
      <script>
        var postsData = [];
        var obj = '<?= json_encode($ratings) ?>';
        postsData = JSON.parse(obj);

        if(postsData.length == 0){
          var notYetCon = document.createElement('div');
          notYetCon.className = "notyet";

          var notYet = document.createElement('h3');
          notYet.textContent = "很  抱  歉 ，在  此  活  動  中";
          notYetCon.appendChild(notYet);

          var notYet2 = document.createElement('h3');
          notYet2.textContent = "該  使  用  者  目  前  沒  有  評  價";
          notYetCon.appendChild(notYet2);

          document.getElementById('ps').appendChild(notYetCon);
        }

        for(var i=0; i<postsData.length; i++){
          post = postsData[i];
          post_id = i+1;

          var statContainer = document.createElement('div');
          statContainer.className = 'profile-stat';

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
          star1.id = 'star1';
          star1.name = 'rating' + post_id;
          star1.value = '5';

          var label1 = document.createElement('label');
          label1.for = 'star1';

          var star2 = document.createElement('input');
          star2.type = 'radio';
          star2.id = 'star2';
          star2.name = 'rating' + post_id;
          star2.value = '4';

          var label2 = document.createElement('label');
          label2.for = 'star2';

          var star3 = document.createElement('input');
          star3.type = 'radio';
          star3.id = 'star3';
          star3.name = 'rating' + post_id;
          star3.value = '3';

          var label3 = document.createElement('label');
          label3.for = 'star3';

          var star4 = document.createElement('input');
          star4.type = 'radio';
          star4.id = 'star4';
          star4.name = 'rating' + post_id;
          star4.value = '2';

          var label4 = document.createElement('label');
          label4.for = 'star4';

          var star5 = document.createElement('input');
          star5.type = 'radio';
          star5.id = 'star5';
          star5.name = 'rating' + post_id;
          star5.value = '1';

          var label5 = document.createElement('label');
          label5.for = 'star5';

          if(post.score == 5){
            star1.checked = true;
            console.log("5分");
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

          var commentElement = document.createElement('p');
          commentElement.className = 'comment';
          commentElement.textContent = post.content;
          centerContainer.appendChild(commentElement);
          statContainer.appendChild(centerContainer);

          document.getElementById('ps').appendChild(statContainer);
        }
      </script>
    </div>

    
    </div>
  </div>
    
    
      

      <script>
        const ratingInputs1 = document.querySelectorAll('input[name="rating1"]');
        ratingInputs1.forEach(input => {
        input.addEventListener('change', () => {
        console.log('第一组评分：', input.value);
        });
        });

        const ratingInputs2 = document.querySelectorAll('input[name="rating2"]');
        ratingInputs2.forEach(input => {
        input.addEventListener('change', () => {
        console.log('第二组评分：', input.value);
        });
        });

        const ratingInputs3 = document.querySelectorAll('input[name="rating3"]');
        ratingInputs3.forEach(input => {
        input.addEventListener('change', () => {
        console.log('第三组评分：', input.value);
        });
        });



      </script>



</body>
</html>