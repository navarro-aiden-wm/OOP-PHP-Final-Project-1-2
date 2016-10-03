<head>
    <title>My Blog - Posts</title>
</head>

<body>
<link href="styles.css" rel="stylesheet">

<h1 align="center">My Simple Blog</h1>

<div id="content">
    <?php
    /**
     * Created by PhpStorm.
     * User: session2
     * Date: 9/27/16
     * Time: 5:08 PM
     */

    require 'databases.php';
    require 'Tags.php';
    $database = new BlogPost([$inId = null], [$inTitle = null], [$inPost = null], [$inAuthorId = null], [$inDatePosted = null]);
    $database->query('SELECT * FROM blog_post');
    $database->execute();
    $rows = $database->resultset();

    if (@$_POST['delete']) {
        $delete_id = $_POST['delete_id'];
        $database->query('DELETE FROM blog_post WHERE id = :id');
        $database->bind(':id', $delete_id);
        $database->execute();
    }


    ?>

    <h1 align="center">Posts</h1>
    <a href="post.php"><p align="center">Create Post</p></a>
    <div id="post">
        <?php foreach ($rows as $row) :

            $database->query('SELECT name FROM tags LEFT JOIN (blog_post_tags) ON (tags.id = blog_post_tags.tag_id) WHERE blog_post_tags.blog_post_id = :inId');
            $database->bind(':inId', $row['id']);
            $tagName = $database->resultset();
            ?>
            <h2><?php echo $row['title']; ?></h2>
            <p style="font-size: large;"><?php echo $row['body']; ?></p>
            <br/>
            <div id="info">
                <p style="font-family: 'American Typewriter'">Posted By: <?php echo $row['author_id']; ?> Posted
                    On: <?php echo $row['date_posted']; ?> Tags: <?php echo $row['tags']; ?> , etc...</p>
            </div>
            <div id="delete">
                <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="delete" value="Delete"/>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>