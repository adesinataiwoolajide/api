<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "categories";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $created;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    public function readAll(){
        //select all data
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }

    // used by select drop-down list
    //http://localhost/api/category/read.php
    public function read(){
     
        //select all data
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function create(){
 
        // query to insert record
        // http://localhost/api/category/create.php
        try{
            $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " SET name=:name, description=:description, created=:created");
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->created=htmlspecialchars(strip_tags($this->created));
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":created", $this->created);
            if($stmt->execute()){
                return true;
            }else{
         
                return false;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // used when filling up the update category form
    //http://localhost/api/category/read_one.php?id=60
    function readOne(){
     
        $stmt = $this->conn->prepare( "SELECT * FROM " . $this->table_name . "  WHERE id = ? LIMIT 0,1" );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
        $this->description = $row['description'];
    }

    function update(){
        //http://localhost/api/category/update.php
        $stmt = $this->conn->prepare("UPDATE categories SET name=:name, description=:description WHERE id=:id");
        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->id=htmlspecialchars(strip_tags($this->id));
        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
       
    }
    function delete(){
        // http://localhost/api/product/delete.php
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = ?");
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }  
    }
    function search($keywords){
     
        $stmt=$this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE name LIKE ? OR description LIKE ? ORDER BY name ASC");
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        $arr = array(':keywords', $keywords);
        // execute query
        if($stmt->execute($arr)){
            return $stmt;
        }else{
            return false;
        } 
        
    }

        
}
?>