<?php
  session_start();
  require_once 'connection.php';

  $id_1 = $_GET['id'];

  $stmt = $pdo->prepare("SELECT id FROM users where username = ?");
  $stmt->execute([$_SESSION['username']]);
  $id_2 = $stmt->fetchColumn();


  //Update & Insert
  $stmt = $pdo->prepare("UPDATE friendships
  SET STATUS = 'accepted'
  WHERE user_id_1 = ? AND user_id_2 = ?");
  $stmt->execute([$id_1, $id_2]);

  //Check
  $stmt = $pdo->prepare("SELECT * FROM friendships WHERE user_id_1 = ? AND user_id_2 = ?");
  $stmt->execute([$id_2, $id_1]);
  $check = $stmt->fetch();

  if (!$check) {
    $stmt = $pdo->prepare("INSERT INTO friendships (user_id_1, user_id_2, STATUS) VALUES (?,?,'accepted')");
    $stmt->execute([$id_2, $id_1]);
  } else {
    $stmt = $pdo->prepare("UPDATE friendships set status = 'accepted' where user_id_1 = ? AND user_id_2 = ?");
    $stmt->execute([$id_2, $id_1]);
  }
?>