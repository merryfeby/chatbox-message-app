<?php
  session_start();
  require_once 'connection.php';

  $id_1 = $_GET['id'];

  $stmt = $pdo->prepare("SELECT id FROM users where username = ?");
  $stmt->execute([$_SESSION['username']]);
  $id_2 = $stmt->fetchColumn();

  $stmt = $pdo->prepare("DELETE FROM friendships WHERE user_id_1 = ? AND user_id_2 = ?");
  $stmt->execute([$id_1, $id_2]);
?>