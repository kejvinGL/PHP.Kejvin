<?php

namespace Models;

class Post extends Model implements BaseModel
{
    protected static string $table = "posts";
    protected static array $fields = ['title', 'body', 'user_id'];

    public static function recentPosts(): int
    {
        return count(Post::query("SELECT * FROM posts WHERE date_created >= DATE_SUB(NOW(), INTERVAL 1 DAY)"));
    }
}
