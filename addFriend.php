<?php
  require_once 'controller.php';

  if(isset($_SESSION['username'])) {
    $stmt = $pdo->prepare("select id, name from users where username = ?");
    $stmt->execute([$_SESSION['username']]);
    $getName = $stmt->fetch();
  }

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
    .scrollable {
      overflow-y: auto;
      max-height: 100vh;
      
    }
    .scrollable::-webkit-scrollbar{
      display: none;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen w-100 overflow-hidden" >
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
    <!-- ADD FRIEND -->
    <div class="w-5/12 p-10 min-h-screen">
      <h2 class="text-3xl font-bold">Add Friend</h2>
      <div class="mt-5">
        <!-- <form action="" method="post"> -->
          <div class="flex flex-row">
            <input type="hidden" id="id" value="<?=$getName['id']?>">
            <input type="text" name="username" id="username" class="w-full px-8 py-3 rounded-l-lg font-medium bg-white border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white" placeholder="Username">
            <button onclick="search_user()" type="submit" name="search" class=" font-semibold bg-indigo-500 text-gray-100 w-20 py-3 px-5 rounded-r-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4">Search</button>
          </div>
          <div id="list_user">
          </div>
          <!-- <div class="bg-white p-5 rounded-lg my-5 border border-gray-200 flex">
            <img src="https://i.pinimg.com/originals/84/72/d7/8472d7719a92a1994a59d0b2ec4870a2.jpg" alt="" class="rounded-full w-[70px]">
            <div class="px-5">
              <h2 class="text-lg font-medium">Arima</h2>
              <form action="controller.php" method="post">
                <button type="submit" name="add_friend" class=" font-semibold text-xs px-6 bg-indigo-500 text-gray-100 w-full py-2 mt-2 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4">Add</button>
              </form>
            </div>
          </div> -->
          <!-- <div class="bg-white p-5 rounded-lg my-5 border border-gray-200 flex">
            <img src="https://i.pinimg.com/originals/84/72/d7/8472d7719a92a1994a59d0b2ec4870a2.jpg" alt="" class="rounded-full w-[70px]">
            <div class="px-5 justify-center flex flex-col">
              <h2 class="text-lg font-medium">Arima</h2>
              <h2 class="text-sm text-gray-500 font-normal">pending</h2>
            </div>
          </div> -->
        <!-- </form> -->
      </div>
    </div>
    <!-- FRIEND REQUEST -->
    <div class="w-5/12 p-10 min-h-screen">
      <div class="scrollable">
        <h2 class="text-3xl font-bold">Friend Request</h2>
        <div id="list_pending">

        </div>
        <!-- <div class="bg-white p-5 rounded-lg my-5 border border-gray-200 flex flex-row">
          <img src="https://i.pinimg.com/originals/84/72/d7/8472d7719a92a1994a59d0b2ec4870a2.jpg" alt="" class="rounded-full w-[70px]">
          <div class="px-5">
            <h2 class="text-lg font-medium">Arima</h2>
            <div class="flex flex-row">
              <button onclick="acc_friend(this)" type="submit" class=" font-semibold text-xs px-6 bg-emerald-500 text-gray-100 w-full py-2 mt-2 rounded-lg hover:bg-emerald-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4">Accept</button>
              <button onclick="decline_friend(this)" type="submit" class=" font-semibold text-xs px-6 bg-rose-500 text-gray-100 w-full py-2 mt-2 rounded-lg hover:bg-rose-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4">Decline</button>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>

</body>
<script>
  setInterval(display_pending, 1000)

  function display_pending() {
    $.ajax({
      url: 'user_pending.php',
      type: 'GET',
      success: function(data){
        $('#list_pending').html(data)
      }
    })
  }

  function search_user() {
    var username = $('#username').val();
    var id = $('#id').val();
    console.log(id)
    $.ajax({
      url: 'search_user.php',
      type: 'POST',
      data: {
        username: username,
        id: id
      },
      success: function(data) {
        // $('#username').val("")
        $('#list_user').html(data);
      }
    })
  }

  function acc_friend(obj) {
    var id = $(obj).attr("value");
    $.ajax({
      url: 'user_acc.php',
      type: 'GET',
      data: {
        id: id
      },
      success: function() {
        display_pending();
      }
    })
  }
  
  function decline_friend(obj) {
    var id = $(obj).attr("value");
    $.ajax({
      url: 'user_decline.php',
      type: 'GET',
      data: {
        id: id
      },
      success: function() {
        display_pending();
      }
    })
  }
</script>
</html>