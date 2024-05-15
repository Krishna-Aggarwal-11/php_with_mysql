<?php 

include 'config.php' ;
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $select = $conn->query("SELECT * FROM posts WHERE title LIKE '%{$search}%' OR body LIKE '%{$search}%'");

    $select->execute();
    $result = $select->fetchAll(PDO::FETCH_OBJ);

    
}
?>

<?php foreach($result as $row): ?>
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            <h5 class="card-title"><?php  echo $row->title ; ?></h5>
            <p class="card-text"><?php echo substr($row->body,0,85)."..." ; ?></p>
            <a href="show.php?id=<?php  echo $row->id ; ?>" class="btn btn-primary">Show more</a>
        </div>
    </div>
    <br>
<?php endforeach; ?>
