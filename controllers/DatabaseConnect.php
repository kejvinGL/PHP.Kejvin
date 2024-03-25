<?php

namespace Database;

class DatabaseConnect
{
    private $db_username = "root";
    private $db_password = "";
    private $dsn = 'mysql:host=localhost;dbname=loginpage;charset=utf8mb4';
    private $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new \PDO($this->dsn, $this->db_username, $this->db_password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException("Database connection failed: " . $e->getMessage());
        }
    }


    public function select(string $table, array $columns = ["*"], array $conditions = [], string $orderBy = "", int $limit = 0): array
    {
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_keys($conditions));
        }
        if (!empty($orderBy)) {
            $sql .= " ORDER BY " . $orderBy;
        }
        if ($limit > 0) {
            $sql .= " LIMIT " . $limit;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->fetchAll();
    }

    public function insert(string $table, array $data): int
    {
        $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($data)) . ") VALUES (" . implode(", ", array_fill(0, count($data), "?")) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update(string $table, array $data, array $conditions): int
    {
        $sql = "UPDATE " . $table . " SET " . implode(" = ?, ", array_keys($data)) . " = ?";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", array_keys($conditions));
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge(array_values($data), array_values($conditions)));
        return $stmt->rowCount();
    }

    public function delete(string $table, array $conditions): int
    {
        $sql = "DELETE FROM " . $table . " WHERE " . implode(" AND ", array_keys($conditions));
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($conditions);
        return $stmt->rowCount();
    }

    public function query(string $sql, array $bindings = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }
}
