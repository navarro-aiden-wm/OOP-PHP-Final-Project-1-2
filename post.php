<head>
    <title>My Blog - Make Post</title>
</head>

<body>
<link href="styles.css" rel="stylesheet">
<h1 align="center">Add Post</h1>

<div id="content">
    <a href="index1.php"><p align="center">Posts</p></a>
    <?php
    /**
     * Created by PhpStorm.
     * User: session2
     * Date: 9/28/16
     * Time: 4:17 PM
     */
    require 'databases.php';
    require 'Tags.php';


    $database = new BlogPost([$inId = null], [$inTitle = null], [$inPost = null], [$inAuthorId = null], [$inDatePosted = null]);

    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


    if (@$post['update']) {
        $id = $post['id'];
        $title = $post['title'];
        $body = $post['body'];


        $database->query('UPDATE blog_post SET title = :title, body = :body WHERE id = :id');
        $database->bind(':title', $title);
        $database->bind(':body', $body);
        $database->bind(':id', $id);
        $database->execute();
    }

    if (@$post['submit']) {
        $title = $post['title'];
        $body = $post['body'];
        $authorId = $post['author'];
        $datePosted = $post['date'];
        $name = $post['name'];

        $database->query('INSERT INTO tags (name) VALUE (:name)');
        $database->bind(':name', $name);
        $database->query('INSERT INTO blog_post (title, body, author_id, date_posted) VALUES(:title, :body, :authorId, :datePosted)');
        $database->bind(':title', $title);
        $database->bind(':body', $body);
        $database->bind(':authorId', $authorId);
        $database->bind(':datePosted', $datePosted);
        $database->execute();
        if ($database->lastInsertId()) {
            echo '<p>Post Added!</p>';
        }
    }

    ?>
    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">

        <label>Author</label><br/>
        <input type="text" name="author" placeholder="Author..."/><br/><br/>

        <label>Title</label><br/>
        <input type="text" name="title" placeholder="Add a Title..."/><br/><br/>

        <label>Date</label><br/>
        <input type="date" name="date" placeholder="date..."/><br/><br/>

        <label>Tags</label><br/>
        <input type="text" name="name" placeholder="tags..."/><br/><br/>

        <label>Body</label><br/>
        <textarea name="body"></textarea><br/><br/>
        <input type="submit" name="submit" value="Submit"/>

    </form>
</div>
</body>