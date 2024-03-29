<?php

namespace Models;


class Media extends Model implements BaseModel
{
    protected static string $table = "media";
    protected static array $fields = ['path', 'hash_name', 'original_name', 'extension', 'size', 'type', 'user_id'];
}
