<?php
  // require_once 'controller.php';

  // if (isset($_SESSION['invalid'])) {
  //   echo ("<script>alert('". $_SESSION['invalid'] ."')</script>");
  //   session_destroy();
  // } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/fcd689d6ac.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen w-100">
  <div class="flex justify-center place-items-center w-100 min-h-screen">
    <div class="bg-white lg:w-1/4 sm:w-3/5 p-[4rem]  shadow sm:rounded-lg">
      <form action="controller.php" method="post" enctype="multipart/form-data">
        <div class="flex flex-row justify-center items-center">
          <i class="fa-solid fa-comments text-indigo-500"></i>
          <h1 class="font-extrabold text-indigo-500 pb-1 ml-2">chatbox</h1>
        </div>
        <div>
          <h2 class="text-3xl font-bold text-black text-center my-8">Register</h2>
        </div>
        <div class="">
          <input type="text" name="username" class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white" placeholder="Username" required>
        </div>
        <div class="mt-5">
          <input type="text" name="name" class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white" placeholder="Name" required>
        </div>
        <div class="mt-5">
          <input type="text" name="password" class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white" placeholder="Password" required>
        </div>
        <div class="mt-5">
          <input type="file" name="pict" class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white" placeholder="Profile Picture" required>
        </div>
        <div class="text-center flex flex-row">
          <button type="submit" name="register" class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none mr-4">Register</button>
          <input type="button" value="Login" onclick="location.href='index.php'" class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
        </div>
      </form>
    </div>
  </div>
</body>
</html>