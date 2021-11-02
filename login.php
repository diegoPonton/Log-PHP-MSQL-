<?php

  session_start();


  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /PHP-LOGIN/IoT.php");
    } else {
      $message = 'Sorry, those credentials do not match';
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <title>LOGIN</title>
</head>
<body>
    <?php require 'partials/header.php' ?>
    
    
    <h1>LOGIN</h1>
    <span>or <a href="singup.php">SingUp</a></span>
    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
    
    <form action="login.php" method="post">

        <input type="text" name="email" placeholder="Enter your email">
        <input type="text" name="password" placeholder="Enter your password">
        <input type="submit" value="send">
    </form>
</body>
<style>
    header {    
        border-bottom: 2px solid #eee;
        padding: 20px 0;
        margin-bottom: 10px;
        width: 100%;
        text-align: center;
    }

    header a {
        text-decoration: none;
        color: #333;
    }
</style>

</html>

