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

$ratings  = $conn->query("SELECT * FROM ratings WHERE post_id = $id");
$ratings->execute();
$rating = $ratings->fetch(PDO::FETCH_OBJ);
?>

<div class="row">

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo $post->title; ?></h5>
            <p class="card-text"><?php echo $post->body; ?></p>
            <form id="form-data" method="POST">

                <div class="my-rating"></div>
                <input id="rating" type="hidden" name="rating" value="">
                <input id="psot_id" type="hidden" name="post_id" value="<?php echo $post->id; ?>">
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

<script>
    $(document).ready(function() {
        $(document).on('submit', function(e) {
            e.preventDefault();
            var formdata = $('#comment-form').serialize() + "&submit=submit";

            $.ajax({
                type: 'POST',
                url: 'insert-comment.php',
                data: formdata,
                success: function() {
                    // alert("success");
                    $('#comment').text(null);
                    $('#username').text(null);
                    $('#post_id').text(null);

                    $("#msg").html("Added Successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();
                }
            });
        });

        $(document).on('click', '#delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'delete-comment.php',
                data: {
                    delete: "delete",
                    id: id
                },
                success: function() {
                    // alert("success");


                    $("#delete-msg").html("Deleted Successfully").toggleClass("alert alert-success bg-success text-white mt-3");
                    fetch();
                }
            });
        });

        function fetch() {
            setInterval(function() {
                $("body").load("show.php?id=<?php echo $_GET['id']; ?>");
            }, 2000)
        }

        $(".my-rating").starRating({
            starSize: 25,
            initialRating: <?php 
                if (isset($rating->rating)) {
                    echo $rating->rating;
                }else{
                    echo 0;
                }
            ?>,
            callback: function(currentRating, $el) {
                $("#rating").val(currentRating);

                $(".my-rating").click(function(e) {
                  e.preventDefault();
                  
                  var $formdata = $('#form-data').serialize()+"&insert=insert";

                  $.ajax({
                    type: 'POST',
                    url: 'insert-rating.php',
                    data: $formdata,
                    success: function() {
                      alert("success");
                    }
                })
            })
        }

    });
    
    

    });
</script>