<?php

namespace Models;

interface BaseModel
{
    public static function insert(): int;
    public static function select(): array;
    public static function update(): bool;
    public static function delete(): bool;
    public static function all(): array;
}
