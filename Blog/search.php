<?php 

include 'config.php' ;
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $select = $conn->query("SELECT * FROM posts WHERE title LIKE '%{$search}%' OR body LIKE '%{$search}%'");

    $select->execute();
    $result = $select->fetchAll(PDO::FETCH_OBJ);

    foreach ($result as $post) {
        echo $post->title;
        echo $post->body;
    }
}
