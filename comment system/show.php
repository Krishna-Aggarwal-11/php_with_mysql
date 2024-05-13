<?php require "includes/header.php"; ?>

<?php require "config.php"; ?>


<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $onePost = $conn->query("SELECT * FROM posts WHERE id = $id");
    $onePost->execute();

    $post = $onePost->fetch(PDO::FETCH_OBJ);
    
}
?>

<div class="row">

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo $post->title; ?></h5>
            <p class="card-text"><?php echo $post->body; ?></p>

        </div>
    </div>
</div>

<?php require "includes/footer.php"; ?>