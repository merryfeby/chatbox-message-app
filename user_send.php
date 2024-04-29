<?php 
  session_start();
  require_once 'connection.php';

  $isi = $_POST['content'];

  $stmt = $pdo->prepare("SELECT id FROM users where username = ?");
  $stmt->execute([$_SESSION['username']]);
  $id_1 = $stmt->fetchColumn();

  $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, content, DATE) VALUES (?,?,?, NOW())");
  $stmt->execute([$id_1, $_SESSION['target'], $isi]);

?>