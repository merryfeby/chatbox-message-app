<?php
  session_start();
  require_once 'connection.php';

  $stmt = $pdo->prepare("SELECT id FROM users where username = ?");
  $stmt->execute([$_SESSION['username']]);
  $id_1 = $stmt->fetchColumn();

  
  if ($_SESSION['target'] != "") {
    $stmt = $pdo->prepare("select * from users where id = ?");
    $stmt->execute([$_SESSION['target']]);
    $id_2 = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM messages 
    WHERE sender_id = ? AND receiver_id = ? OR sender_id = ? AND receiver_id = ?
    ORDER BY DATE;");
    $stmt->execute([$id_1, $id_2['id'], $id_2['id'], $id_1]);
    $chats = $stmt->fetchAll();

    echo "<div class='bg-gray-100 px-5 py-2 w-full flex flex-row rounded-lg mb-4'>";
    echo "  <img src='". $id_2['pfp'] ."' alt='' class='rounded-full  w-[70px] h-[70px]'>";
    echo "  <div class='px-5 flex items-center'>";
    echo "    <h2 class='text-lg font-medium'>". $id_2['name'] ."</h2>";
    echo "  </div>";
    echo "</div>";
    echo "<div class='flex w-full h-full flex-col scrollable-chat' >";
    foreach($chats as $chat) {
      if($chat['sender_id'] == $id_1) {
        echo "  <div class='justify-end flex mb-3'>";
        echo "    <div class='max-w-[50%]'>";
        echo "      <p class='text-sm bg-indigo-500 text-white rounded-l-xl rounded-br-xl p-3 w-auto'>". $chat['content'] ."</p>";
        echo "    </div>";
        echo "  </div>";
      } else {
        echo "  <div class='justify-start w-3/6 flex mb-3'>";
        echo "    <p class='text-sm  bg-indigo-100 rounded-r-xl rounded-bl-xl p-3'>". $chat['content'] ."</p>";
        echo "  </div>";
      }
    }
    echo "</div>"; // Tag penutup div scrollable-chat
    echo "<script>";
    echo "  function scrollToBottom() {";
    echo "    var chatContainer = document.querySelector('.scrollable-chat');";
    echo "    chatContainer.scrollTop = chatContainer.scrollHeight;";
    echo "  }";
    echo "  scrollToBottom();";
    echo "</script>";

  } else {
    echo "Empty";
  }
?>
