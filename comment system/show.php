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
?>

<div class="row">

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo $post->title; ?></h5>
            <p class="card-text"><?php echo $post->body; ?></p>

        </div>
    </div>
</div>


<div class="row">
  <form method="POST" id="comment-form" >
    <div class="form-floating">
      <input name="username" type="hidden" value="<?php echo $_SESSION['username']; ?>" class="form-control" id="username" >
    </div>
    <div class="form-floating">
      <input name="post_id" type="hidden" value="<?php echo $post->id; ?>" class="form-control" id="post_id" >
    </div>
    

    <div class="form-floating mt-4">
      <textarea rows="9" name="comment" class="form-control" placeholder="comment"
      id="comment">
      
      </textarea>
      <label for="floatingInput">Comment </label>
    </div>

    

    <button name="submit" id="submit" class="w-100 btn mt-4 btn-lg btn-primary" type="submit">Create Comment</button>
    <div id="msg" class="nothing"></div>
    

  </form>
  
</div>

<div class="row">
    <?php foreach ($comment as $singlecomment) : ?>
    <div class="card my-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo $singlecomment->username; ?></h5>
            <p class="card-text"><?php echo $singlecomment->comment; ?></p>

        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require "includes/footer.php"; ?>

<script>
    $(document).ready(function(){
        $(document).on('submit', function(e){
            e.preventDefault();
            var formdata = $('#comment-form').serialize()+"&submit=submit";

            $.ajax({
                type: 'POST',
                url: 'insert-comment.php',
                data: formdata,
                success: function(){
                    // alert("success");
                    $('#comment').text(null);
                    $('#username').text(null);
                    $('#post_id').text(null);

                    $("#msg").html("Added Successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();    
                }
            });
        });

        function fetch(){
            setInterval(function(){
                $("body").load("show.php?id=<?php echo $_GET['id']; ?>");
            },4000)
        }
    });
</script>