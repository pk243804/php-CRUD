<?php 
//session_start();
require_once 'conn.php';

if (isset($_GET['user'])) {
  $uid = mysqli_real_escape_string($conn, $_GET['user']);
  $select_user = "SELECT * FROM users WHERE id=$uid"; 
  $select_exec = $conn->query($select_user);
  $user_data = $select_exec->fetch_object();

} else {
  header('location:index.php');
}

if (isset($_POST['update'])) {
  
  $path = 'uploads/';
  $extension = pathinfo($_FILES['profile']['name'],PATHINFO_EXTENSION);
  $file_name = $_POST['fname'].'_'.date('YmdHis').'.'.$extension;
  $profile = (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : $user_data->profile;

  $update_data = [
'fname' => mysqli_real_escape_string($conn,$_POST['fname']),
'lname' => mysqli_real_escape_string($conn,$_POST['lname']),
'email' => mysqli_real_escape_string($conn,$_POST['email']),
'password' => mysqli_real_escape_string($conn,$_POST['password']),
'contact' => mysqli_real_escape_string($conn,$_POST['contact']),
'gender' => mysqli_real_escape_string($conn,$_POST['gender']),
'address' => mysqli_real_escape_string($conn,$_POST['address']),
'state' => mysqli_real_escape_string($conn,$_POST['state']),
'profile' => mysqli_real_escape_string($conn,$profile),
'hobbies' => mysqli_real_escape_string($conn,implode(',', $_POST['hobbies']))
  ];

 $sql = "UPDATE users SET ";
 foreach ($update_data as $key => $value) {
   $sql .= "$key = '$value',";
 }
 $sql = rtrim($sql, ',');
 $sql .= "WHERE id=".$uid;
 
 $exec = $conn->query($sql);
 if ($exec) {
  if (!is_null($profile)) {
   move_uploaded_file($_FILES['profile']['tmp_name'], $path.$file_name);
  }
   echo "Data updated";
   header("refresh:1; url:index.php");
 } else {
   echo "Something went Wrong";
     header("refresh:1; url:index.php");
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="bootstrap.bundle.js"></script>

    <title>Update</title>
  </head>

  <body>

    <!-- Nav bar -->

    <nav class="navbar navbar-light bg-warning mb-4">
  <a class="navbar-brand"><b>Login System</b></a>
  <form class="form-inline">
    <?php 
        if (isset($_SESSION['user_data'])) {
         echo '<a href="index.php" class="btn btn-success">Index</a>';
          echo '<a href="login.php" class="btn btn-success">Login</a>';
        }
    ?>
  </form>
</nav>

          <!-- main form bar -->
<div class="container border border-dark">
	<h3>Update user</h3><hr>
<form method="post" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputFname4">Firstname</label>
      <input type="name" class="form-control" name="fname" required="" value="<?php echo $user_data->fname; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputLname4">Lastname</label>
      <input type="name" class="form-control" name="lname" required="" value="<?php echo $user_data->lname; ?>">
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Email</label>
      <input type="email" class="form-control" name="email" required="" value="<?php echo $user_data->email; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" name="password"required="" value="<?php echo $user_data->password; ?>">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputContact4">Contact</label>
      <input type="number" class="form-control" name="contact" required="" value="<?php echo $user_data->contact; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Gender</label> <br>  
  <input type="radio" name="gender" value="Male" <?php if($user_data->gender == 'Male'){echo 'checked';} ?> >Male
  <input type="radio" name="gender" value="Female" <?php if($user_data->gender == 'Female'){echo 'checked';} ?> >Female
</div>
</div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputAddress">Address</label>
      <input type="text" class="form-control" name="address" required="" value="<?php echo $user_data->address; ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control" name="state">
        <option>--select--</option>
        <option value="gj" <?php if($user_data->state == 'gj'){echo 'selected';} ?> >Gujrat</option>
        <option value="dl" <?php if($user_data->state == 'dl'){echo 'selected';} ?> >Delhi</option>
        <option value="sk" <?php if($user_data->state == 'sk'){echo 'selected';} ?> >Sikkim</option>
        <option value="rj" <?php if($user_data->state == 'rj'){echo 'selected';} ?> >Rajasthan</option>
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
    <?php $hobbies_arr = explode(',', $user_data->hobbies); ?>
    <div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="hobbies[]"                                                            value="Travelling" <?php if(in_array('Travelling', $hobbies_arr)){echo 'checked';} ?> >
  <label class="form-check-label" for="inlineCheckbox1">Travelling</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="hobbies[]"                                                            value="Music" <?php if(in_array('Music', $hobbies_arr)){echo 'checked';} ?> >
  <label class="form-check-label" for="inlineCheckbox2">Music</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="hobbies[]"                                                               value="Coding" <?php if(in_array('Coding', $hobbies_arr)){echo 'checked';} ?> >
  <label class="form-check-label" for="inlineCheckbox2">Coding</label>
</div>
    </div>
  </div>
  <button type="submit" name = "update" class="btn btn-primary">Update</button>
</form> <br>
</div>

  </body>
</html>