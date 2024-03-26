<?php

namespace Database;

class DatabaseConnect
{
    private $db_username = "root";
    private $db_password = "";
    private $dsn = 'mysql:host=localhost;dbname=loginpage;charset=utf8mb4';
    public $pdo;
    public function __construct()
    {
        try {
            $this->pdo = new \PDO($this->dsn, $this->db_username, $this->db_password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException("Database connection failed: " . $e->getMessage());
        }
    }


    /**
     * Selects records from a database table based on the specified conditions.
     *
     * @param string $table The name of the table to select from.
     * @param array $conditions An associative array of conditions to filter the records (optional).
     * @param array $columns An array of columns to select (optional, default is ["*"]).
     * @param int $limit The maximum number of records to return (optional, default is 0 for no limit).
     * @param string $orderBy The column to order the results by (optional).
     * @param string $order The order in which to sort the results (optional, default).
     * @return array An array of selected records.
     */
    public function select(
        string $table,
        array $conditions = [],
        ?array $columns = ["*"],
        ?string $joinType = "",
        ?string $joinTable = "",
        ?array $joinColumn = [],
        int $limit = 0,
        string $orderBy = "",
        string $order = "",
    ): array {
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        if (!empty($joinType)) {
            $joins = [];
            foreach ($joinColumn as $column) {
                array_push($joins, $table . "." . $column . " = " . $joinTable . "." . $column);
            }
            $sql .= $joinType  . " $joinTable ON " . implode(" AND ", $joins);
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" = ? AND ", array_keys($conditions)) . " = ?";
        }
        if (!empty($orderBy)) {
            $sql .= " ORDER BY " . $orderBy . " " . $order;
        }
        if ($limit > 0) {
            $sql .= " LIMIT " . $limit;
        }
        $stmt = $this->pdo->prepare($sql);
        // dd($stmt);
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }


    /**
     * Inserts a new record into the specified table.
     *
     * @param string $table The name of the table to insert into.
     * @param array $data The data to insert.
     * @return int The ID of the inserted record.
     */
    public function insert(string $table, array $data): int
    {
        $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($data)) . ") VALUES (" . implode(", ", array_fill(0, count($data), "?")) . ")";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }


    /**
     * Updates records in the specified table based on the given conditions.
     *
     * @param string $table The name of the table to update.
     * @param array $data The data to update.
     * @param array $conditions The conditions to apply to the update.
     * @return int The number of affected rows.
     */
    public function update(string $table, array $data, array $conditions): int
    {
        $sql = "UPDATE " . $table . " SET " . implode(" = ?, ", array_keys($data)) . " = ?";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" = ?, ", array_keys($conditions)) . " = ?";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge(array_values($data), array_values($conditions)));
        return $stmt->rowCount();
    }


    /**
     * Deletes records from the specified table based on the given conditions.
     *
     * @param string $table The name of the table to delete from.
     * @param array $conditions The conditions to apply to the delete.
     * @return int The number of affected rows.
     */
    public function delete(string $table, array $conditions): int
    {
        $sql = "DELETE FROM " . $table . " WHERE " .
            implode(" = ?, ", array_keys($conditions)) . " = ?";
        $stmt = $this->pdo->prepare($sql);
        // dd($sql);
        $stmt->execute(array_values($conditions));
        return $stmt->rowCount();
    }


    /**
     * Executes a custom SQL query with optional bindings.
     *
     * @param string $sql The SQL query to execute.
     * @param array $bindings The parameter bindings for the query (default: []).
     * @return array An array of query results.
     */
    public function query(string $sql, array $bindings = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->fetchAll();
    }
}
