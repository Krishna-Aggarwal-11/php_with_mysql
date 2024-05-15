</div>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="" crossorigin=""></script>
<script src="rating-plugin/dist/jquery.star-rating-svg.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js
"></script>
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
                            if (isset($rating->rating) && isset($rating->user_id) && $rating->user_id == $_SESSION['user_id']) {
                                echo $rating->rating;
                            } else {
                                echo 0;
                            }
                            ?>,
            callback: function(currentRating, $el) {
                $("#rating").val(currentRating);

                $(".my-rating").click(function(e) {
                    e.preventDefault();

                    var $formdata = $('#form-data').serialize() + "&insert=insert";

                    $.ajax({
                        type: 'POST',
                        url: 'insert-rating.php',
                        data: $formdata,
                        success: function() {
                            //   alert("success");
                        }
                    })
                })
            }

        });

        $("#search_data").keyup(function() {
            var search = $(this).val();
            if (search != '') {
                $.ajax({
                    url: "search.php",
                    type: "POST",
                    data: {
                        search: search
                    },
                    success : function(data) {
                        $("#search-data").html(data);
                    }
                })
            }else{
                $("#search-data").css("display", "none");
            }
            })
    });
</script>
</body>
</html>