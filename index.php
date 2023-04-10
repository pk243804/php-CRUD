<?php 
session_start();
require_once 'conn.php';  
  
if (!isset($_SESSION['user_data'])) {
  header('location:login.php');
}
  $sql = "SELECT * FROM users";
  $exe = $conn->query($sql);
while ($data = $exe->fetch_object()) {
  $users[] = $data;
}
  

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
       .table th {
        text-align: center;
       }
    </style>
    <script src="bootstrap.bundle.js"></script>

    <title>Index</title>
  </head>

  <body>

    <!-- Nav bar -->

    <nav class="navbar navbar-light bg-warning">
  <a class="navbar-brand"><b>Login System</b></a>
  <form class="form-inline">
    <?php 
        if (isset($_SESSION['user_data'])) {
          echo "<a href='logout.php' class='btn btn-success'>Logout</a>";
        } else { 
           echo "<a href='login.php' class='btn btn-success'>Login</a>";
            header('location:login.php');
  }
  ?>
  </form>
</nav>
            <!-- List bar -->
<div class="album py-5 bg-light" style="height: 100vh;">
  <div class="row h-100 justify-content-center">
    <table class="table table-hover" style="max-width: 40rem;">
 
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Fname</th>
            <th scope="col">Lname</th>
            <th scope="col">Email</th>
            <th scope="col">Contact</th>
            <th scope="col">Gender</th>
            <th scope="col">Address</th>
            <th scope="col">State</th>
            <th scope="col">Profile</th>
            <th scope="col">Action</th>
          </tr>
      </thead>
      <tbody>
          <?php 
              $i = 1;
              foreach ($users as $user) {

          ?>
          <tr>
             <th scope="row"><?php echo $i; ?></th>
             <td><?php echo $user->fname; ?></td>
             <td><?php echo $user->lname; ?></td>
             <td><?php echo $user->email; ?></td>
             <td><?php echo $user->contact; ?></td>
             <td><?php echo $user->gender; ?></td>
             <td><?php echo $user->address; ?></td>
             <td><?php echo $user->state; ?></td>
             <td>
              <img src="<?php echo 'uploads/'.$user->profile ?>" alt="alt" height="80px" width="80px">
            </td>

             <td>
                 <a href="update.php?user=<?php echo $user->id; ?>" class="btn btn-warning">Edit</a>
                 <a href="indexx.php?user=<?php echo $user->id; ?>" class="btn btn-danger">Delete</a>
             </td>
          </tr>
        <?php 
            $i++;
              }  
        ?>
      </tbody>      
 </table>
  </div></div>

</body>
</html>