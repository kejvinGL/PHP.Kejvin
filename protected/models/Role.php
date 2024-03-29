<?php

namespace Models;

class Role extends Model implements BaseModel
{
    protected static string $table = "roles";
    protected static array $fields = ["role"];
}
