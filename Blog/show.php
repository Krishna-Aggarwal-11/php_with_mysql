<?php require "includes/header.php"; ?>

<?php require "config.php"; ?>


<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $onePost = $conn->query("SELECT * FROM posts WHERE id = $id");
    $onePost->execute();

    $post = $onePost->fetch(PDO::FETCH_OBJ);
}

$comments  = $conn->query("SELECT * FROM comments WHERE post_id = $id");
$comments->execute();
$comment = $comments->fetchAll(PDO::FETCH_OBJ);

if (isset($_SESSION['user_id'])) {
    $ratings  = $conn->query("SELECT * FROM ratings WHERE post_id = $id AND user_id = '$_SESSION[user_id]'");
    $ratings->execute();
    $rating = $ratings->fetch(PDO::FETCH_OBJ);
}
?>


<div class="row">
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo $post->title; ?></h5>
            <p class="card-text"><?php echo $post->body; ?></p>
            <form id="form-data" method="POST">

                <div class="my-rating"></div>
                <input id="rating" type="hidden" name="rating" value="">
                <input id="post_id" type="hidden" name="post_id" value="<?php echo $post->id; ?>">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <input id="user_id" type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>


<div class="row">
    <form method="POST" id="comment-form">
        <?php if (isset($_SESSION['username'])) : ?>
            <div class="form-floating">
                <input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="username">
            </div>
        <?php endif; ?>
        <div class="form-floating">
            <input name="post_id" type="hidden" value="<?php echo $post->id; ?>" class="form-control" id="post_id">
        </div>


        <div class="form-floating mt-4">
            <textarea rows="9" name="comment" class="form-control" placeholder="comment" id="comment">

      </textarea>
            <label for="floatingInput">Comment </label>
        </div>



        <button name="submit" id="submit" class="w-100 btn mt-4 btn-lg btn-primary" type="submit">Create Comment</button>
        <div id="msg" class="nothing"></div>
        <div id="delete-msg" class="nothing"></div>


    </form>

</div>

<div class="row">
    <?php foreach ($comment as $singlecomment) : ?>
        <div class="card my-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo $singlecomment->username; ?></h5>
                <p class="card-text"><?php echo $singlecomment->comment; ?></p>
                <?php if (isset($_SESSION['username']) && $singlecomment->username == $_SESSION['username']) : ?>
                    <button id="delete-btn" class="btn btn-danger mt-3" value="<?php echo $singlecomment->id; ?>">Delete</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>



<?php require "includes/footer.php"; ?>

