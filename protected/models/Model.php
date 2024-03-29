<?php

namespace Models;

use Core\DatabaseConnect;
class Model implements BaseModel
{
    protected static string $table = "";
    protected static array $fields = ["ID", "created_at", "updated_at"];

    public static function insert(array $data = []): int
    {
        return DatabaseConnect::insert(static::$table, array_only($data, static::$fields));
    }


    public static function select(
        array $conditions = [],
        ?string $joinType = "",
        ?string $joinTable = "",
        ?array $joinColumn = [],
        int $limit = 0,
        string $orderBy = "",
        string $order = "",
    ): array {
        return DatabaseConnect::select(static::$table, array_only($conditions, array_merge(self::$fields, static::$fields)), $joinType, $joinTable, $joinColumn, $limit, $orderBy, $order);
    }


    public static function update(array $data = [], array $conditions = []): bool
    {
        return DatabaseConnect::update(static::$table, $data,  array_only($conditions, array_merge(self::$fields, static::$fields)));
    }


    public static function delete(array $conditions = []): bool
    {
        return DatabaseConnect::delete(static::$table, array_only($conditions, array_merge(self::$fields, static::$fields)));
    }


    public static function all(): array
    {
        return DatabaseConnect::all(static::$table);
    }
    public static function query(string $sql = "", array $bindings = []): array
    {
        return DatabaseConnect::query($sql, $bindings);
    }
}
