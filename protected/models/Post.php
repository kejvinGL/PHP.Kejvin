<?php

namespace Models;

use Database\DatabaseConnect;

class Post implements BaseModel
{
    private int $id;
    private int $user_id;
    private string $title;
    private string $body;
    public $db;

    public function __construct(int $user_id, string $title, string $body)
    {
        $this->user_id = $user_id;
        $this->title = $title;
        $this->body = $body;
        $this->db = new DatabaseConnect;
        $this->id = $this->db->insert("posts", ["user_id" => $user_id, "title" => $title, "body" => $body]);
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
        return $this->db->select("posts", $conditions, $columns, $joinType, $joinTable, $joinColumn, $limit, $orderBy, $order);
    }

    public function update(array $data = [], array $conditions = []): int
    {
        return $this->db->update("posts", $data, $conditions);
    }
    public function delete(array $conditions = []): int
    {
        return $this->db->delete("posts", $conditions);
    }
    public function all(): array
    {
        return $this->db->select("posts");
    }
}
