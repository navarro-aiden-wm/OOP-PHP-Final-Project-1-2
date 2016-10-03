<?php
/**
 * Created by PhpStorm.
 * User: session2
 * Date: 9/30/16
 * Time: 5:18 PM
 */

require_once('databases.php');

class Tags extends BlogPost
{
    public function resultset()
    {
        $posts = parent::resultset();

        if (is_array($posts) && count($posts)) {
            foreach ($posts as $post) {
                $tags = [];

                $sql = 'SELECT tag_id FROM blog_post_tags bpt LEFT JOIN tags t ON bpt.tag_id = t.id WHERE bpt.blog_post_id = :blogid';

                parent::query($sql);
                parent::bind(':blogid', $post['id']);
                $blogTags = parent::resultset();

                foreach ($blogTags as $btag) {
                    array_push($tags, $btag['name']);
                }

                $post['tags'] = implode(', ', $tags);
            }

            return $posts;
        } else {
            return [];
        }
    }
}