<?php
  session_start();
  require_once 'connection.php';

  $username = $_POST['username'];
  $id = $_POST['id'];

  $stmt = $pdo->prepare("SELECT * FROM users u
  JOIN  friendships f ON u.id = f.user_id_2
  WHERE username = ? AND f.user_id_1 = ?");
  $stmt->execute([$username, $id]);
  $found = $stmt->fetch();

  if (!$found) {
    $stmt = $pdo->prepare("SELECT * FROM users
    WHERE username = ? ");
    $stmt->execute([$username]);
    $new = $stmt->fetch();

    if ($new)  {
      if ($new['username'] != $_SESSION['username']) {
        echo "<div class='bg-white p-5 rounded-lg my-5 border border-gray-200 flex'>";
          echo "<img src='". $new['pfp'] ."' alt='' class='rounded-full w-[70px] h-[70px]'>";
          echo "<div class='px-5'>";
            echo "<h2 class='text-lg font-medium'>" .$new['name']. "</h2>";
            echo "<form action='controller.php' method='post'>";
              echo "<button type='submit' value='". $new['id']."' name='add_friend' class='font-semibold text-xs px-6 bg-indigo-500 text-gray-100 w-full py-2 mt-2 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4'>Add</button>";
            echo "</form>";
          echo "</div>";
        echo "</div>";
      }
    }
  } else {
    echo "<div class='bg-white p-5 rounded-lg my-5 border border-gray-200 flex'>";
      echo "<img src='". $found['pfp'] ."' alt='' class='rounded-full w-[70px] h-[70px]'>";
      echo "<div class='px-5 justify-center flex flex-col'>";
        echo "<h2 class='text-lg font-medium'>".$found['name']."</h2>";
        echo "<h2 class='text-sm text-gray-500 font-normal'>".$found['status']."</h2>";
      echo "</div>";
    echo "</div>";
  }
?>