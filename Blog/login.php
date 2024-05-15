<?php require "includes/header.php"; ?>

<?php require "config.php"; ?>

<?php

if (isset($_SESSION['username'])) {
  
  header("Location: index.php");
}


if (isset($_POST['submit'])) {

  if ($_POST["email"] == "" || $_POST["password"] == "") {
    echo "Please enter email and password";
  } else {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $login = $conn->query("SELECT * FROM `users` WHERE `email` = '$email'");

    $login->execute();

    $data = $login->fetch(PDO::FETCH_ASSOC);

    if ($login->rowCount() > 0) {

      if (password_verify($password, $data['password'])) {

        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['email'] = $data['email'];

        header("Location: index.php");
      } else {
        echo "Login failed";
      }
    }else {
      echo "Login failed";
    }
  }
}

?>



<main class="form-signin w-50 m-auto">
  <form method="POST" action="login.php">

    <h1 class="h3 mt-5 fw-normal text-center">Please sign in</h1>

    <div class="form-floating mt-3">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>

    <div class="form-floating  mt-3">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <button name="submit" class="w-100 btn btn-lg btn-primary mt-3" type="submit">Sign in</button>
    <h6 class="mt-3">Don't have an account <a href="register.php">Create your account</a></h6>
  </form>
</main>
<?php require "includes/footer.php"; ?>