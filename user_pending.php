<?php
  session_start();
  require_once 'connection.php';

  $stmt = $pdo->prepare("SELECT id FROM users where username = ?");
  $stmt->execute([$_SESSION['username']]);
  $id = $stmt->fetchColumn();

  $stmt = $pdo->prepare("SELECT * FROM users u
  JOIN  friendships f ON u.id = f.user_id_1
  WHERE user_id_2 = ? AND STATUS = 'pending'");
  $stmt->execute([$id]);
  $users_pending = $stmt->fetchAll();

  foreach($users_pending as $i) {
    echo "<div class='bg-white p-5 rounded-lg my-5 border border-gray-200 flex flex-row'>";
      echo "<img src='". $i['pfp'] ."' alt='' class='rounded-full w-[70px]'>";
      echo "<div class='px-5'>";
        echo "<h2 class='text-lg font-medium'>".$i['name']."</h2>";
        echo "<div class='flex flex-row'>";
          echo "<button onclick='acc_friend(this)' type='submit' value='". $i['id'] ."' class='font-semibold text-xs px-6 bg-emerald-500 text-gray-100 w-full py-2 mt-2 rounded-lg hover:bg-emerald-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4'>Accept</button>";
          echo "<button onclick='decline_friend(this)' type='submit' value='". $i['id'] ."' class='font-semibold text-xs px-6 bg-rose-500 text-gray-100 w-full py-2 mt-2 rounded-lg hover:bg-rose-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4'>Decline</button>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
  }
?>