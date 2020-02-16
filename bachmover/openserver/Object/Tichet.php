<?php
/**
*contains properties and methods for "product" database queries.
 */

class Product
{

    //Db connection and table
    private $conn;
    private $table_name = 'Tichet';

    //Object properties
    public $id;
    public $Divisone;
    public $Email;
    public $Messaggio;
    public $Approvato;
    public $datareg;
    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }

// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            set
                Divisone=:Divisone, Email=:Email, Messaggio=:Messaggio, Approvato=:Approvato, datareg=:datareg";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Divisone=htmlspecialchars(strip_tags($this->Divisone));
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    $this->Messaggio=htmlspecialchars(strip_tags($this->Messaggio));
    $this->Approvato=htmlspecialchars(strip_tags($this->Approvato));
    $this->datareg=htmlspecialchars(strip_tags($this->datareg));
	
    // bind values
	
    $stmt->bindParam(":Divisone", $this->Divisone);
    $stmt->bindParam(":Email", $this->Email);
    $stmt->bindParam(":Messaggio", $this->Messaggio);
    $stmt->bindParam(":Approvato", $this->Approvato);
    $stmt->bindParam(":datareg", $this->datareg);
	
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

    //Read product
    function read(){

        //select all
        $query = "SELECT
                    Divisone , id, Email, Messaggio,Approvato,datareg
                  FROM
                  " . $this->table_name . " p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  ORDER BY id";

        //prepare
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;

    }


    //read single product
function readOne(){
 
    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->Materiale = $row['Materiale'];
    $this->Descripzione = $row['Descripzione'];
    $this->Quantita = $row['Quantita'];
    $this->Treno = $row['Treno'];
    $this->Discorta = $row['Discorta'];
	$this->Commento = $row['Commento'];
	$this->Creatoda = $row['Creatoda'];	
	$this->Ordinato = $row['Ordinato'];	
}


    //update product
    function update(){

        //update query
        $query = "UPDATE
                    " . $this->table_name. "
                    SET
                        Divisone=:Divisone,
                        Email=:Email,
                        Messaggio=:Messaggio,
                        Approvato=:Approvato,
						datareg=:datareg
                    WHERE
                        id=:id";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->Divisone=htmlspecialchars(strip_tags($this->Divisone));
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    $this->Messaggio=htmlspecialchars(strip_tags($this->Messaggio));
    $this->Approvato=htmlspecialchars(strip_tags($this->Approvato));
    $this->datareg=htmlspecialchars(strip_tags($this->datareg));
	
        $this->id=htmlspecialchars(strip_tags($this->id));

        //bind new values
        $stmt->bindParam(":Divisone", $this->Divisone);
    $stmt->bindParam(":Email", $this->Email);
    $stmt->bindParam(":Messaggio", $this->Messaggio);
    $stmt->bindParam(":Approvato", $this->Approvato);
    $stmt->bindParam(":datareg", $this->datareg);
	
        $stmt->bindParam(':id', $this->id);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //delete product
    function delete(){

        //delete query
        $query = " DELETE FROM " . $this->table_name . " WHERE id = ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        //bind id
        $stmt->bindParam(1, $this->id);

        //execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    //search products
    function search($keywords){

        //select all query
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                  FROM " . $this->table_name. " p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  WHERE
                    p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
                  ORDER BY
                    p.created DESC";

        //prepare
        $stmt =$this->conn->prepare($query);

        //sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        //bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);

        //execute
        $stmt->execute();

        return $stmt;
    }

    //read products with pagination
    public function readPaging($from_record_num, $records_per_page){

        //select
        $query = "SELECT
                    c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                  FROM " . $this->table_name . " p
                  LEFT JOIN
                    categories c ON p.category_id = c.id
                  ORDER BY p.created DESC
                  LIMIT ?, ?";

        //prepare
        $stmt = $this->conn->prepare($query);

        //bind
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        //execute
        $stmt->execute();

        //return values from db
        return $stmt;
    }


    //paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];

    }
}
