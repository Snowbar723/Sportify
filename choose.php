<!DOCTYPE html>

<html>
<head>
  <meta charset="UTF-8">
  <script src="https://kit.fontawesome.com/385564b33e.js" crossorigin="anonymous"></script>
  <title>選擇隊友</title>
  <style>
    /* 頁面樣式設計 */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f0f3;
    }

    .container {
      max-width: 400px;
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

      background-color: #473952;
      border-radius: 24px;
      padding: 25px;
    }

    input[type="submit"] {
    display: block;
    width: 140px;
    margin: 0 auto;
    padding: 10px;
    font-size: 19px;
    border-radius: 18px;
    background-color: #664D9A;
    border: none;
    color: #fff;
    cursor: pointer;
    margin-bottom: -5px;
    margin-top: 20px;
    margin-right: 20px;
    }

    .notYet {
      text-align: center;
      margin-bottom: 150px;
      margin-top: 150px;
    }
  </style>



</head>
<body>
  <?php
        if(isset($_GET['id'])){
          $eventId = $_GET['id'];
          //echo ($_GET['id']);
        }

        class inLine {
          public $userId;
          public $nickname;
          public $state;

          public function __construct($userId, $nickname, $state){
            $this->userId = $userId;
            $this->nickname = $nickname;
            $this->state = $state;
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

        $sql = "SELECT event.people_Needed AS 'number', user.user_Nickname AS 'nickname', 
                       user.user_id AS 'userId', queue.state AS 'state' FROM `queue` 
                LEFT JOIN `user` ON  queue.waiting_id = user.user_id
                LEFT JOIN `event` ON event.event_id = queue.event_id
                WHERE queue.event_id = '$eventId';";

        $stat = mysqli_stmt_init($conn);

        if(! mysqli_stmt_prepare($stat, $sql)){
          die(mysqli_error($conn));
        }

        $result = mysqli_query($conn, $sql);

        $inLines = array();
        $number = 0;
        while($row = mysqli_fetch_assoc($result)){
          $number = $row['number'];
          $nickname = $row['nickname'];
          $userId = $row['userId'];
          $state = $row['state'];

          $inLine = new inLine($userId, $nickname, $state);
          $inLines[] = $inLine;

          //print_r($inLines);
        }

        
  ?>
  <div class="container" id="ps">
    <h2>排隊的人</h2>
    
    <script>
        var listItems = [];
        var obj = '<?= json_encode($inLines) ?>';
        listItems = JSON.parse(obj);
        //console.log(listItems);

        if(<?php echo($number) ?> > 0){
          var container = document.createElement('div');
          container.className = 'profile-stat';

          var text = document.createElement('label');
          var content = document.createElement('h3');
          content.textContent = '請選擇 <?php echo($number) ?> 位隊友：';
          var brElement = document.createElement('br');
          text.appendChild(content);
          container.appendChild(text);
          container.appendChild(brElement);

          var list = document.createElement('ul');
          list.id = "myList";
          var selectedCount = 0; 
          var maxSelection = <?php echo($number) ?>; 

          for (var i = 0; i < listItems.length; i++) {
          var person = listItems[i];
          var itemId = 'item' + (i + 1);
          var listItem = document.createElement('li');
          var checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.id = itemId;
          checkbox.name = person.userId;
          checkbox.onchange = function() {
          updateItem(this.id);
          };
           console.log(person.state);
          if(person.state == 'picked'){
            checkbox.checked = true;}

          var label = document.createElement('label');
          label.htmlFor = itemId;

          var linkElement = document.createElement('a');
            linkElement.href = "#";
            linkElement.id = person.userId;
            linkElement.textContent = "    " + person.nickname;
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
          label.appendChild(linkElement);

          //var text = document.createElement('span');
          var space = document.createElement('br');
          //text.textContent = "      " + person.nickname;
          //console.log(listItem.nickname);
          //label.appendChild(text);

          listItem.appendChild(checkbox);
          listItem.appendChild(label);
          list.appendChild(listItem);
          list.appendChild(space);
          }

          var submit = document.createElement('input');
          submit.type = 'submit';
          submit.value = "確定";
          submit.onclick = function(){
            var checkboxes = document.querySelectorAll('#myList input[type="checkbox"]');
            var selectedItems = [];
            
            checkboxes.forEach(function(checkbox) {
              if (checkbox.checked) {
                selectedItems.push(checkbox.name);
              }
            });
            console.log(selectedItems);
  
          var url = "chooseEx.php?id=<?php echo $eventId ?>&items=" + encodeURIComponent(selectedItems.join(','));
          location.href = url;

          alert("您已完成選擇隊友！")
          }

          container.appendChild(list);
          container.appendChild(submit);

          function updateItem(itemId) {
          var item = document.getElementById(itemId);
          var label = document.querySelector('label[for=' + itemId + ']');

          if (item.checked) {
              selectedCount++;
              if (selectedCount > maxSelection) {
                  item.checked = false; // 取消勾選
                  selectedCount--;
                  label.style.textDecoration = 'none';
          }
              } else {
                  selectedCount--;
                  label.style.textDecoration = 'none';
              }
      
          }
          document.getElementById('ps').appendChild(container);
        }else{
          var container = document.createElement('div');
          container.className = 'profile-stat';

          var content = document.createElement('h3');
          content.className = "notYet";
          content.textContent = '本 活 動 目 前 無 人 排 隊';
          container.appendChild(content);

          document.getElementById('ps').appendChild(container);
        }

        

    </script>
    </div>
    </div> 




</body>
</html>