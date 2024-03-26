<?php

namespace Models;

use Database\DatabaseConnect;

class User implements BaseModel
{
    private int $id;
    private int $roleId;
    private string $fullname;
    private string $email;
    private string $password;
    private string $username;
    public $db;

    public function __construct(int $roleId, string $fullname, string $email, string $password, string $username)
    {
        $this->roleId = $roleId;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->db = new DatabaseConnect;
        $this->id = $this->db->insert("users", ["role_id" => $roleId, "fullname" => $fullname, "email" => $email,  "username" => $username, "password" => $password]);
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
        return $this->db->select("users", $conditions, $columns, $joinType, $joinTable, $joinColumn, $limit, $orderBy, $order);
    }

    public function update(array $data = [], array $conditions = []): int
    {
        return $this->db->update("users", $data, $conditions);
    }
    public function delete(array $conditions = []): int
    {
        return $this->db->delete("users", $conditions);
    }
    public function all(): array
    {
        return $this->db->select("users");
    }
}
