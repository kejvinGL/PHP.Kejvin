<?php

namespace Models;

use Database\DatabaseConnect;

class Role implements BaseModel
{
    private int $id;
    private string $role;
    public $db;

    public function __construct(string $role)
    {
        $this->role = $role;
        $this->db = new DatabaseConnect;
        $this->id = $this->db->insert("roles", ["role_id" => $role]);
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
        return $this->db->select("roles", $conditions, $columns, $joinType, $joinTable, $joinColumn, $limit, $orderBy, $order);
    }

    public function update(array $data = [], array $conditions = []): int
    {
        return $this->db->update("roles", $data, $conditions);
    }
    public function delete(array $conditions = []): int
    {
        return $this->db->delete("roles", $conditions);
    }
    public function all(): array
    {
        return $this->db->select("roles");
    }
}
