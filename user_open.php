<?php
  session_start();
  require_once 'connection.php';

  $id = $_GET['id'];

  $_SESSION['target'] = $id;
?>