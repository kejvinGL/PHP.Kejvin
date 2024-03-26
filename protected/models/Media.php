<?php

namespace Models;

use Database\DatabaseConnect;

class User implements BaseModel
{
    private string $path;
    private string $hashName;
    private string $originalName;
    private string $extension;
    private string $size;
    private string $type;
    private int $user_id;
    public $db;

    public function __construct(string $path, string $hashName, string $originalName, string $extension, string $size, string $type, int $user_id)
    {
        $this->path = $path;
        $this->hashName = $hashName;
        $this->originalName = $originalName;
        $this->extension = $extension;
        $this->size = $size;
        $this->type = $type;
        $this->user_id = $user_id;
        $this->db = new DatabaseConnect;
        $this->id = $this->db->insert("media", ["path" => $path, "hashName" => $hashName, "originalName" => $originalName, "extension" => $extension, "size" => $size, "type" => $type, "user_id" => $user_id]);
    }

    public function select(
        array $conditions = [],
        ?array $columns = ["*"],
        ?string $joinType = "",
        ?string $joinTable = "",
        ?array $joinColumn = [],
        int $limit = 0,
        string $orderBy = "",
        string $order = "",
    ): array {
        return $this->db->select("media", $conditions, $columns, $joinType, $joinTable, $joinColumn, $limit, $orderBy, $order);
    }

    public function update(array $data = [], array $conditions = []): int
    {
        return $this->db->update("media", $data, $conditions);
    }
    public function delete(array $conditions = []): int
    {
        return $this->db->delete("media", $conditions);
    }
    public function all(): array
    {
        return $this->db->select("media");
    }
}
