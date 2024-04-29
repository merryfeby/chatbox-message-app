<?php
  session_start();
  require_once 'connection.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
      $name = $_POST['name'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $pict = $_FILES;

      $stmt = $pdo->prepare("select * from users where username = ? and password = ?");
      $stmt->execute([$username, $password]);
      $check = $stmt->fetch();

      $type = pathinfo($pict['pict']['name'], PATHINFO_EXTENSION);
      $size = $pict["pict"]["size"];

      if ($check) {
        echo "<script>
          alert('User sudah ada!')
          window.location.replace('register.php');
          </script>";
      } else if ($type != "png" && $type != "jpg" && $type != "jpeg") {
        echo "<script>
          alert('Tipe file tidak sesuai!')
          window.location.replace('register.php');
          </script>";
      } else if ($size > 1000000) {
        echo "<script>
          alert('File Terlalu Besar (lebih dari 1MB)!')
          window.location.replace('register.php');
          </script>";
      } else {
        if ($pict['pict']['error'] === UPLOAD_ERR_OK) {
          $target_dir =  "user/";
          $target_file =  $target_dir . $username . "/";

          if(!file_exists($target_file)) {
            mkdir($target_file, 0777, true );
          }
        }

        $stmt = $pdo->prepare("insert into users (name, username, password) values (?,?,?)");
        $stmt->execute([$name, $username, $password]);

        $target_file = $target_dir . $username . "/";
        if (!file_exists($target_file)) {
          mkdir($target_file, 0777, true);
        }

        $id = $pdo->lastInsertId();
        $target_file = $target_file . $id . "." . $type;

        if (move_uploaded_file($pict['pict']['tmp_name'], $target_file)) {
          $stmt = $pdo->prepare("update users set pfp = ? where id = ?");
          $stmt->execute([$target_file, $id]);
        }
        header("Location: index.php");
      }
    }
    if (isset($_POST['login'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $stmt = $pdo->prepare("select * from users where username = ? and password = ?");
      $stmt->execute([$username, $password]);
      $check = $stmt->fetch();

      if ($check) {
        $_SESSION['username'] = $username;
        header('Location: home.php');
      } else {
        echo "<script>
        alert('Username tidak ditemukan!')
        window.location.replace('index.php');
        </script>";
      }

    }

    if (isset($_POST['logout'])) {
      session_destroy();
      header('Location: index.php');
      exit;
    }

    if (isset($_POST['add_friend'])) {
      $id = $_POST['add_friend'];

      $stmt = $pdo->prepare("select id from users where username = ?");
      $stmt->execute([$_SESSION['username']]);
      $idUser = $stmt->fetchColumn();

      $stmt = $pdo->prepare("insert into friendships (user_id_1, user_id_2, status) values (?,?,?)");
      $stmt->execute([$idUser, $id, 'pending']);

      header('Location: addFriend.php');
    }
  }
?>