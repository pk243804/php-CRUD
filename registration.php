<?php 
session_start();
require_once 'conn.php';
if (isset($_POST['submit'])) {
  
  $path = 'uploads/';
  $extension = pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION);
  $file_name = $_POST['fname'].'_'.date('YmdHis').'.'.$extension;
  $profile = (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : null;

  $insert_data = [
'fname' => $_POST['fname'],
'lname' => $_POST['lname'],
'email' => $_POST['email'],
'password' => $_POST['password'],
'contact' => $_POST['contact'],
'gender' => $_POST['gender'],
'address' => $_POST['address'],
'state' => $_POST['state'],
'profile' => $profile,
'hobbies' => implode(',', $_POST['hobbies'])
  ];

 $cols = implode(',', array_keys($insert_data));
 $vals = implode("','", array_values($insert_data));
 $sql = "INSERT INTO users ($cols) VALUES ('$vals')";
 $exec = $conn->query($sql);

 if ($exec) {
  if (!is_null($profile)) {
   move_uploaded_file($_FILES['profile']['tmp_name'], $path.$file_name);
  } echo "<div class = 'alert alert-success' role = 'alert'> Data inserted </div>"; 
             } else {
   echo "<div class = 'alert alert-danger' role = 'alert'> Data not inserted </div>";
   header("refresh:3; url=registration.php");
  }
}
?>
<!--html code-->
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>Registration</title>
  </head>

  <body>

    <!-- Nav bar -->

    <nav class="navbar navbar-light bg-warning mb-4">
  <a class="navbar-brand"><b>Login System</b></a>
  <form class="form-inline">
    <a href="login.php" class="btn btn-success">Login</a>
  </form>
</nav>

          <!-- main form bar -->
<div class="container border border-dark">
	<h3>Registration</h3><hr>



<form method="post" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputFname4">Firstname</label>
      <input type="name" class="form-control" name="fname">
    </div>
    <div class="form-group col-md-6">
      <label for="inputLname4">Lastname</label>
      <input type="name" class="form-control" name="lname">
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name="password">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputContact4">Contact</label>
      <input type="number" class="form-control" name="contact">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Gender</label><br>
      <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" value="Male">
  <label class="form-check-label" for="inlineRadio1">Male</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" value="Female">
  <label class="form-check-label" for="inlineRadio2">Female</label>
</div>
</div></div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputAddress">Address</label>
      <input type="text" class="form-control" name="address">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control" name="state">
        <option selected>--select--</option>
        <option value="gj">Gujrat</option>
        <option value="dl">Delhi</option>
        <option value="sk">Sikkim</option>
        <option value="rj">Rajasthan</option>
      </select>
    </div>
  </div>

 <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputAddress">Profile</label>
      <input type="file" name="profile" class="form-control">
    </div>
  <div class="form-group col-md-6">
  	<label for="inputAddress">Hobbies</label><br>
    <div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="hobbies[]" value="Travelling">
  <label class="form-check-label" for="inlineCheckbox1">Travelling</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="hobbies[]" value="Music">
  <label class="form-check-label" for="inlineCheckbox2">Music</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="hobbies[]" value="Coding">
  <label class="form-check-label" for="inlineCheckbox2">Coding</label>
</div>
    </div>
  </div>
  <button type="submit" name = "submit" class="btn btn-primary">Registration</button>
</form> <br>
</div>


<script src="js/bootstrap.min.js"></script>
  </body>

</html>
