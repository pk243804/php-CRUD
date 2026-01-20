<?php 
session_start();
require_once 'conn.php';
if (isset($_POST['login'])){
  
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $password = mysqli_real_escape_string($conn,$_POST['password']);

  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $exe = $conn->query($sql);

  if ($exe->num_rows > 0) {
    
    $_SESSION['user_data'] = $exe->fetch_object();
    header("refresh:1, url=index.php");

  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Login</title>
  </head>

  <body>

    <!-- Nav bar -->

    <nav class="navbar navbar-light bg-warning">
  <a class="navbar-brand"><b>Login System</b></a>
  <form class="form-inline">
    <a href="registration.php" class="btn btn-success">Registration</a>
  </form>
</nav>
        <!-- Login bar -->
<div class="album py-5 mx-auto bg-light" style="height: 100vh;">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="card border-dark" style="max-width: 40rem; padding: 2%;">
	<h3>Login</h3><hr>
  <!-- php code-->
<div class="card-body">
  <?php 
  if (isset($_SESSION['user_data'])) {
echo "<div class = 'alert alert-success' role = 'alert'> Welcome ". $_SESSION['user_data']->fname ."</div>";
} elseif(isset($exe) && $exe->num_rows < 1) {
echo "<div class = 'alert alert-danger' role = 'alert'> Email or password invalid </div>";
}
  ?>
  <form method="post">
    <div class="mb-3">
      <label for="validationDefault01">Email</label>
      <input type="email" name="email" class="form-control" id="validationDefault01" required="">
    </div>

  <div class="mb-3">
      <label for="validationDefault03">Password</label>
      <input type="password" name="password" class="form-control" id="validationDefault03" required="">
    </div>

    <div class="mb-3">  
  <button class="btn btn-primary" name="login" type="submit">Login</button>
</div>
</form>
</div></div>
</div></div>

<script src="js/bootstrap.min.js"></script>
</body>

</html>
