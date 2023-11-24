<?php


class Dbase
{

    private $conn;

    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $connect = "mysql:host=$db_host;dbname=$db_name";
        $this->conn = new PDO($connect, $db_user, $db_pass);
    }

    public function insert(string $table, array $data)
    {
        $sql = "INSERT INTO $table SET ";
        $values = [];
        foreach ($data as $key => $value) {
            $sql .= "$key = ?,";
            $values[] = $value;
        }
        $sql = substr($sql, 0, -1);
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([...$values]);
    }
    public function delete(string $table, int $id)
    {
        $sql = "DELETE FROM $table WHERE id=$id";
        $this->conn->exec($sql);
    }
    public function selectAll(string $table)
    {
        $sql = "SELECT * FROM $table ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function selectOne(string $table, string $key, $value, $orderBy)
    {
        $sql = "SELECT * FROM $table WHERE $key = ?  ORDER BY $orderBy ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }
    public function update(string $table, array $data, int $id)
    {

        $sql = "UPDATE $table SET ";

        $values = [];
        foreach ($data as $key => $value) {
            $values[] = "$key = '$value'";
        }

        $sql .= implode(', ', $values);
        $sql .= " WHERE id = $id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }
    public  function search($table, $searchKeyWord)
    {
        $sql = "SELECT * FROM $table WHERE name LIKE '%$searchKeyWord%'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function searchByTypeCheet(string $table, string $key, $searchTypeCheet)
    {
        $sql = "SELECT * FROM $table WHERE $key LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["%$searchTypeCheet%"]);
        return $stmt->fetchAll();
    }
}

$DB = new Dbase("localhost", "root", "", "my_work");
