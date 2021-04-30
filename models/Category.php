<?php

class Category
{
    private $conn;
    private $table = 'categories';

    public $id;
    public $name;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Categories
    public function read()
    {
        //Create query
        $query = "SELECT 
                    c.id,
                    c.name as category_name,
                    c.created_at
                  FROM
                    {$this->table} c 
                  ORDER BY
                  c.created_at DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Get single Category
    public function read_single()
    {
        $query = "SELECT 
                   c.id,
                   c.name,
                   c.created_at
                  FROM
                    {$this->table} c 
                  WHERE 
                    c.id = ?
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id         = $row['id'];
        $this->name       = $row['name'];
        $this->created_at = $row['created_at'];
    }

    //Create Category
    public function create()
    {
        //Create query
        $query = "INSERT INTO 
                    {$this->table} 
                  SET    
                    name = :name";

        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));

        //Bind data
        $stmt->bindParam(':name', $this->name);

        //Execute query
        if ($stmt->execute()) {
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update Category
    public function update()
    {
        //Create query
        $query = "UPDATE {$this->table} 
                  SET
                    name = :name
                  WHERE
                    id =:id";

        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id   = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if ($stmt->execute()) {
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Delete Category
    public function delete()
    {
        //Create query
        $query = "DELETE FROM {$this->table} WHERE id =:id";
        $stmt  = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        //Execute query
        if ($stmt->execute()) {
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}