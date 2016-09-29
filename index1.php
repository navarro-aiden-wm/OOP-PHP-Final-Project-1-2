<?php
/**
 * Created by PhpStorm.
 * User: session2
 * Date: 9/27/16
 * Time: 5:08 PM
 */

require 'databases.php';
$database = new BlogPost([$inId = null],[$inTitle = null],[$inPost = null],[$inAuthorId = null],[$inDatePosted = null]);
$database->query('SELECT * FROM blog_post');
$database->execute();
$rows = $database->resultset();


if(@$_POST['delete']){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM blog_post WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();
}



?>

<h1>Posts</h1>
<div>
    <?php foreach($rows as $row) : ?>
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['body']; ?></p>
    <br />
    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
        <input type="submit" name="delete" value="Delete" />
    </form>
    </div>
<?php endforeach; ?>
</div>
