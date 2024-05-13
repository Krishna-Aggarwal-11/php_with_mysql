<?php require "includes/header.php" ; ?>
<?php require "config.php" ; ?>

<?php 
    if (isset($_POST['submit'])) {
        if ($_POST['title'] == '' || $_POST['body'] == '') {
            echo '<p class="alert alert-danger">All fields are required</p>';
        }else{
            $title = $_POST['title'];
            $body = $_POST['body'];
            $username = $_SESSION['username'];
            $insert = $conn->prepare("INSERT INTO posts(title,body,username) VALUES(:title,:body,:username)");
            $insert->execute([
                ':title' => $title,
                ':body' => $body,
                ':username' => $username
            ]);
        }
    }


?>


<main class="form-signin w-50 m-auto">
  <form method="POST" action="create.php">
   
    <h1 class="h3 mt-5 fw-normal text-center">Create Post</h1>

    <div class="form-floating">
      <input name="title" type="text" class="form-control" id="floatingInput" placeholder="Title">
      <label for="floatingInput">Title </label>
    </div>
    

    <div class="form-floating mt-4">
      <textarea rows="9" name="body" class="form-control" placeholder="body">
      </textarea>
      <label for="floatingInput">Body </label>
    </div>

    

    <button name="submit" class="w-100 btn mt-4 btn-lg btn-primary" type="submit">Create Post</button>
    

  </form>
</main>













<?php require "includes/footer.php" ; ?>