<?php
  require_once 'controller.php';

  $_SESSION['target'] = "";

  if(isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("select id,name from users where username = ?");
    $stmt->execute([$_SESSION['username']]);
    $getName = $stmt->fetch();
  }

  $stmt = $pdo->prepare("SELECT * FROM users u
  JOIN  friendships f ON u.id = f.user_id_2
  WHERE user_id_1 = ? AND STATUS = 'accepted'
  ");
  $stmt->execute([$getName['id']]);
  $friends = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/fcd689d6ac.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <style>
    .scrollable-chat {
      overflow-y: auto;
      max-height: 70vh;
    }
    .scrollable-chat::-webkit-scrollbar{
      display: none;
    }
    .scrollable-list {
      overflow-y: auto;
      max-height: 80vh;
    }
    .scrollable-list::-webkit-scrollbar{
      display: none;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen w-100 overflow-hidden">
  <div class="flex flex-row w-100">
    <!-- SIDEBAR -->
    <div class="w-2/12 bg-white shadow-lg min-h-screen">
      <div class="flex flex-row items-center mb-5 m-10">
        <i class="fa-solid fa-comments text-indigo-500"></i>
        <h1 class="font-extrabold text-indigo-500 pb-1 ml-2">chatbox</h1>
      </div>
      <h2 class="font-semibold text-lg m-10">Welcome, <?=$getName['name']?></h2>
      <div>
        <input type="button" value="Chat" onclick="location.href='home.php'" class="font-bold text-indigo-500 hover:bg-indigo-100 px-10 py-4 w-full text-left">
      </div>
      <div>
        <input type="button" value="Add Friend" onclick="location.href='addFriend.php'" class="font-bold text-indigo-500 hover:bg-indigo-100 px-10 py-4 w-full text-left">
      </div>
      <form action="controller.php" method="post">
        <input type="submit" value="Logout" name="logout" class="font-bold text-indigo-500 hover:bg-indigo-100 px-10 py-4 w-full text-left">
      </form>
    </div>
    <div class="w-4/12 p-10 min-h-screen">
      <h2 class="text-3xl font-bold">Chat</h2>
      <div class="scrollable-list bg-white py-2 rounded-lg my-5 border border-gray-200 flex flex-col divide-y divide-slate-200">
        <?php foreach($friends as $i) { ?>
          <button onclick="open_chat(this)"  value="<?=$i['id']?>" class="bg-white hover:bg-indigo-100 px-5 py-4 w-full items-center flex">
            <img src="<?=$i['pfp']?>" alt="" class="rounded-full  w-[70px] h-[70px]">
            <div class="px-5 flex items-center">
              <h2 class="text-lg font-medium"><?=$i['name']?></h2>
            </div>
          </button>
        <?php } ?>
      </div>
    </div>
    <div class="w-6/12 bg-white min-h-screen flex flex-col justify-between p-5">
      <div id="chats">
        <!-- <div class="bg-gray-100 px-5 py-2 w-full flex flex-row rounded-lg mb-4">
          <img src="https://i.pinimg.com/originals/84/72/d7/8472d7719a92a1994a59d0b2ec4870a2.jpg" alt="" class="rounded-full  w-[70px]">
          <div class="px-5 flex items-center">
            <h2 class="text-lg font-medium">Arima</h2>
          </div>
        </div>
        <div class="flex w-full h-full flex-col scrollable-chat" style="overflow-y: auto; max-height: 20vh;">
          <div class="justify-start w-3/6 flex mb-3">
            <p class="text-sm  bg-indigo-100 rounded-r-xl rounded-bl-xl p-3"></p>
          </div>
          <div class="justify-end flex mb-3">
            <div class="max-w-[50%]">
              <p class="text-sm bg-indigo-500 text-white rounded-l-xl rounded-br-xl p-3 w-auto"></p>
            </div>
          </div>
        </div> -->
      </div>
      <div class="flex flex-row my-2">
        <input type="text" name="content" id="content" class="w-full px-8 py-3 rounded-l-lg font-medium bg-white border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white" placeholder="Type a message">
        <button onclick="send_chat()" type="submit" name="send" class=" font-semibold bg-indigo-500 text-gray-100 w-25 py-3 px-5 rounded-r-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4">Send <span><i class="fa-solid fa-paper-plane fa-sm ml-2"></i></span></button>
      </div>
      <!-- <?php if($_SESSION['target'] != "") { ?>
      <?php } ?> -->
    </div>
  </div>
</body>
<script>
  window.addEventListener('load', function() {
    function scrollToBottom() {
      var chatContainer = document.querySelector('.scrollable-chat');
      chatContainer.scrollTop = chatContainer.scrollHeight;
  
    }
    scrollToBottom();
  });
  // setInterval(scrollToBottom, 1000)
  setInterval(load_chat, 1000)
  

  function load_chat() {
    // console.log("masuk")
    $.ajax({
      url: 'user_chat.php',
      type: 'GET',
      success: function(data) {
        $('#chats').html(data)
      }
    })
  }

  function open_chat(obj) {
    var id = $(obj).attr("value");
    // console.log(id);
    $.ajax({
      url: 'user_open.php',
      type: 'GET',
      data: {
        id: id
      },
      success: function() {
        load_chat();
      }
    })
  }

  function send_chat(obj) {
    var content = $('#content').val();
    // var id = $(obj).attr("value");
    // console.log("masuk ges")
    $.ajax({
      url: 'user_send.php',
      type: 'POST',
      data: {
        content: content
      },
      success: function() {
        $('#content').val("");
        load_chat();
      }
    })
  }
</script>
</html>