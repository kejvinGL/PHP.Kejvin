<?php

namespace Core;

use PDO;
use PDOException;
use Validation\Validator;

class DatabaseConnect
{


    /**
     * Selects records from a database table based on the specified conditions.
     *
     * @param string $table The name of the table to select from.
     * @param array $conditions An associative array of conditions to filter the records (optional).
     * @param string|null $joinType
     * @param string|null $joinTable
     * @param array|null $joinColumn
     * @param int $limit The maximum number of records to return (optional, default is 0 for no limit).
     * @param string $orderBy The column to order the results by (optional).
     * @param string $order The order in which to sort the results (optional, default).
     * @return array An array of selected records.
     */
    public static function select(
        string $table,
        array $conditions = [],
        ?string $joinType = "",
        ?string $joinTable = "",
        ?array $joinColumn = [],
        int $limit = 0,
        string $orderBy = "",
        string $order = "",
    ): array {
        $pdo = self::connect();
        $sql = "SELECT * FROM " . $table;
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
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }


    /**
     * Inserts a new record into the specified table.
     *
     * @param string $table The name of the table to insert into.
     * @param array $data The data to insert.
     * @return bool Returns TRUE when executed properly.
     */
    public static  function insert(string $table, array $data): bool
    {
        $pdo = self::connect();

        $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($data)) . ") VALUES (" . implode(", ", array_fill(0, count($data), "?")) . ")";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute(array_values($data));
    }


    /**
     * Updates records in the specified table based on the given conditions.
     *
     * @param string $table The name of the table to update.
     * @param array $data The data to update.
     * @param array $conditions The conditions to apply to the update.
     * @return bool Returns TRUE when executed properly.
     */
    public static function update(string $table, array $data, array $conditions): bool
    {
        $pdo = self::connect();

        $sql = "UPDATE " . $table . " SET " . implode(" = ?, ", array_keys($data)) . " = ?";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" = ? and ", array_keys($conditions)) . " = ?";
        }
        $stmt = $pdo->prepare($sql);

        return $stmt->execute(array_merge(array_values($data), array_values($conditions)));
    }


    /**
     * Deletes records from the specified table based on the given conditions.
     *
     * @param string $table The name of the table to delete from.
     * @param array $conditions The conditions to apply to the delete query.
     * @return bool Returns TRUE when executed properly
     */
    public static function delete(string $table, array $conditions): bool
    {
        $pdo = self::connect();
        $sql = "DELETE FROM " . $table . " WHERE " .
            implode(" = ?, ", array_keys($conditions)) . " = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(array_values($conditions));
    }


    /**
     * Executes a custom SQL query with optional bindings.
     *
     * @param string $sql The SQL query to execute.
     * @param array $bindings The parameter bindings for the query (default: []).
     * @return array An array of query results.
     */
    public static function query(string $sql, array $bindings = []): array
    {
        $pdo = self::connect();
        $stmt = $pdo->prepare($sql);
        //        dd($stmt);
        !empty($bindings) ?  $stmt->execute($bindings) : $stmt->execute();

        return $stmt->fetchAll();
    }


    public static function all(string $table): false|array
    {
        $pdo = self::connect();

        $sql = "SELECT * FROM $table";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function connect(): PDO
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=loginpage;charset=utf8mb4', "root");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            Validator::addErrors(["database" => ["An error occurred while connecting to Database"]]);
            header("Location: /login");
        }
    }
}
