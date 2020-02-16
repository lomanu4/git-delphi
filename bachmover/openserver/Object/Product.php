<?php
/**
*contains properties and methods for "product" database queries.
 */

class Product
{

    //Db connection and table
    private $conn;
    private $table_name = 'material';

    //Object properties
    public $id;
    public $Materiale;
    public $Descripzione;
    public $Quantita;
    public $Treno;
    public $Discorta;
    public $Commento;
	public $Creatoda;
    public $Ordinato;
    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }

	// SYNC product   INSERT INTO ... ON DUPLICATE KEY UPDATE ... SET
  function synch(){
     // query to insert record
     $query = "INSERT INTO
                " . $this->table_name .
				"  (Materiale=:Materiale, Descripzione=:Descripzione,
				Quantita=:Quantita, Treno=:Treno, Discorta=:Discorta,
				Commento=:Commento, Creatoda=:Creatoda,Ordinato=:Ordinato) 
				 on dublicate key update  
				(Materiale=:Materiale, Descripzione=:Descripzione, 
				Quantita=:Quantita, Treno=:Treno, Discorta=:Discorta,
				Commento=:Commento, Creatoda=:Creatoda,Ordinato=:Ordinato)";							
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));
		$this->Materiale=htmlspecialchars(strip_tags($this->Materiale));
		$this->Descripzione=htmlspecialchars(strip_tags($this->Descripzione));
		$this->Quantita=htmlspecialchars(strip_tags($this->Quantita));
		$this->Discorta=htmlspecialchars(strip_tags($this->Discorta));
		$this->Commento=htmlspecialchars(strip_tags($this->Commento));
		 $this->Treno=htmlspecialchars(strip_tags($this->Treno));
		$this->Creatoda=htmlspecialchars(strip_tags($this->Creatoda));
		$this->Ordinato=htmlspecialchars(strip_tags($this->Ordinato));
		// bind values
		$stmt->bindParam(":Materiale", $this->Materiale);
		$stmt->bindParam(":Descripzione", $this->Descripzione);
		$stmt->bindParam(":Quantita", $this->Quantita);
		$stmt->bindParam(":Treno", $this->Treno);
		$stmt->bindParam(":Discorta", $this->Discorta);
		$stmt->bindParam(":Commento", $this->Commento);
		$stmt->bindParam(":Creatoda", $this->Creatoda);
		$stmt->bindParam(":Ordinato", $this->Ordinato);
		 $stmt->bindParam(':id', $this->id);
		// execute query
		if($stmt->execute()){
			return true;
    }
 
    return false;
     
  }
  
      function create(){
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            set
                Materiale=:Materiale, Descripzione=:Descripzione, Quantita=:Quantita, Treno=:Treno, Discorta=:Discorta, Commento=:Commento, Creatoda=:Creatoda,Ordinato=:Ordinato";
 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->Materiale=htmlspecialchars(strip_tags($this->Materiale));
		$this->Descripzione=htmlspecialchars(strip_tags($this->Descripzione));
		$this->Quantita=htmlspecialchars(strip_tags($this->Quantita));
		$this->Discorta=htmlspecialchars(strip_tags($this->Discorta));
		$this->Commento=htmlspecialchars(strip_tags($this->Commento));
		 $this->Treno=htmlspecialchars(strip_tags($this->Treno));
		$this->Creatoda=htmlspecialchars(strip_tags($this->Creatoda));
		$this->Ordinato=htmlspecialchars(strip_tags($this->Ordinato));
		// bind values
		$stmt->bindParam(":Materiale", $this->Materiale);
		$stmt->bindParam(":Descripzione", $this->Descripzione);
		$stmt->bindParam(":Quantita", $this->Quantita);
		$stmt->bindParam(":Treno", $this->Treno);
		$stmt->bindParam(":Discorta", $this->Discorta);
		$stmt->bindParam(":Commento", $this->Commento);
		$stmt->bindParam(":Creatoda", $this->Creatoda);
		$stmt->bindParam(":Ordinato", $this->Ordinato);
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
                    Materiale , id, Descripzione, Quantita,Treno,Discorta, Discorta,Data,Creatoda,Ordinato
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
                        Materiale=:Materiale,
                        Descripzione=:Descripzione,
                        Quantita=:Quantita,
                        Treno=:Treno,
						Discorta=:Discorta,
						Commento=:Commento,
						Creatoda=:Creatoda,
						Ordinato=:Ordinato
                    WHERE
                        id=:id";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->Materiale=htmlspecialchars(strip_tags($this->Materiale));
    $this->Descripzione=htmlspecialchars(strip_tags($this->Descripzione));
    $this->Quantita=htmlspecialchars(strip_tags($this->Quantita));
    $this->Treno=htmlspecialchars(strip_tags($this->Treno));
    $this->Discorta=htmlspecialchars(strip_tags($this->Discorta));
	$this->Commento=htmlspecialchars(strip_tags($this->Commento));
	$this->Creatoda=htmlspecialchars(strip_tags($this->Creatoda));
	$this->Ordinato=htmlspecialchars(strip_tags($this->Ordinato));
        $this->id=htmlspecialchars(strip_tags($this->id));

        //bind new values
        $stmt->bindParam(":Materiale", $this->Materiale);
    $stmt->bindParam(":Descripzione", $this->Descripzione);
    $stmt->bindParam(":Quantita", $this->Quantita);
    $stmt->bindParam(":Treno", $this->Treno);
    $stmt->bindParam(":Discorta", $this->Discorta);
	$stmt->bindParam(":Commento", $this->Commento);
	$stmt->bindParam(":Creatoda", $this->Creatoda);
	$stmt->bindParam(":Ordinato", $this->Ordinato);
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
