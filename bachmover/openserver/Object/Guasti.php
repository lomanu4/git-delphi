<?php
/**
*contains properties and methods for "product" database queries.
 */

class Product
{

    //Db connection and table
    private $conn;
    private $table_name = 'Guasti';

    //Object properties
    public $id;
    public $Componente;
    public $DTR;
    public $Treno;
    public $DataGuasto;
    public $Veicolo;
    public $Inprova;
	public $Seriale;
	public $OdlSO;
	public $Comment;
	public $Spidito;
	public $Operatore;
    public $Riparare;
    
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
			
               Componente=:Componente,DTR=:DTR,Treno=:Treno,DataGuasto=:DataGuasto, Veicolo=:Veicolo,Inprova=:Inprova,Seriale=:Seriale,OdlSO=:OdlSO,Comment=:Comment,Spidito=:Spidito,Operatore=:Operatore,Riparare=:Riparare";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
	$this->Componente=htmlspecialchars(strip_tags($this->Componente));
	$this->DTR=htmlspecialchars(strip_tags($this->DTR));
	$this->Treno=htmlspecialchars(strip_tags($this->Treno));
    $this->DataGuasto=htmlspecialchars(strip_tags($this->DataGuasto));
    $this->Veicolo=htmlspecialchars(strip_tags($this->Veicolo));
    $this->Inprova=htmlspecialchars(strip_tags($this->Inprova));
    $this->Seriale=htmlspecialchars(strip_tags($this->Seriale));
	$this->OdlSO=htmlspecialchars(strip_tags($this->OdlSO));
	$this->Comment=htmlspecialchars(strip_tags($this->Comment));
	$this->Spidito=htmlspecialchars(strip_tags($this->Spidito));
	$this->Operatore=htmlspecialchars(strip_tags($this->Operatore));
	$this->Riparare=htmlspecialchars(strip_tags($this->Riparare));
 
    // bind values
	 $stmt->bindParam(":Componente", $this->Componente);
    
	$stmt->bindParam(":DTR", $this->DTR);
	$stmt->bindParam(":Treno", $this->Treno);
    $stmt->bindParam(":DataGuasto", $this->DataGuasto);
    $stmt->bindParam(":Veicolo", $this->Veicolo);
    $stmt->bindParam(":Inprova", $this->Inprova);
	$stmt->bindParam(":Seriale", $this->Seriale);
	$stmt->bindParam(":OdlSO", $this->OdlSO);
	$stmt->bindParam(":Comment", $this->Comment);
	$stmt->bindParam(":Spidito", $this->Spidito);
    $stmt->bindParam(":Operatore", $this->Operatore);
     $stmt->bindParam(":Riparare", $this->Riparare);
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
                    Componente , id, DTR, Riparare, DataGuasto,Treno,Veicolo, Inprova,Seriale,OdlSO,Comment,Spidito,Operatore
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
    $this->Componente = $row['Componente'];
    $this->DTR = $row['DTR'];
    $this->Treno = $row['Treno'];
    $this->DataGuasto = $row['DataGuasto'];
    $this->Veicolo = $row['Veicolo'];
	$this->Inprova = $row['Inprova'];
	$this->Seriale = $row['Seriale'];
    $this->OdlSO = $row['OdlSO'];	
    $this->Comment = $row['Comment'];	
    $this->Spidito = $row['Spidito'];	
    $this->Operatore = $row['Operatore'];
    $this->Riparare = $row['Riparare'];
}


    //update product
    function update(){

        //update query
        $query = "UPDATE
                    " . $this->table_name. "
                    SET
                       Componente=:Componente,Riparare=:Riparare,DTR=:DTR,Treno=:Treno, DataGuasto=:DataGuasto, Veicolo=:Veicolo,Inprova=:Inprova,Seriale=:Seriale,OdlSO=:OdlSO,Comment=:Comment,Spidito=:Spidito,Operatore=:Operatore
                    WHERE
                        id=:id";

        //prepare
        $stmt = $this->conn->prepare($query);

        //sanitize
   
    $this->Componente=htmlspecialchars(strip_tags($this->Componente));
	$this->DTR=htmlspecialchars(strip_tags($this->DTR));
	$this->Treno=htmlspecialchars(strip_tags($this->Treno));
    $this->DataGuasto=htmlspecialchars(strip_tags($this->DataGuasto));
    $this->Veicolo=htmlspecialchars(strip_tags($this->Veicolo));
    $this->Inprova=htmlspecialchars(strip_tags($this->Inprova));
    $this->Seriale=htmlspecialchars(strip_tags($this->Seriale));
	$this->OdlSO=htmlspecialchars(strip_tags($this->OdlSO));
	$this->Comment=htmlspecialchars(strip_tags($this->Comment));
	$this->Spidito=htmlspecialchars(strip_tags($this->Spidito));
	$this->Operatore=htmlspecialchars(strip_tags($this->Operatore));
	$this->Riparare=htmlspecialchars(strip_tags($this->Riparare));

        //bind new values
     
    $stmt->bindParam(":Componente", $this->Componente);
	$stmt->bindParam(":DTR", $this->DTR);
	$stmt->bindParam(":Treno", $this->Treno);
    $stmt->bindParam(":DataGuasto", $this->DataGuasto);
    $stmt->bindParam(":Veicolo", $this->Veicolo);
    $stmt->bindParam(":Inprova", $this->Inprova);
	$stmt->bindParam(":Seriale", $this->Seriale);
	$stmt->bindParam(":OdlSO", $this->OdlSO);
	$stmt->bindParam(":Comment", $this->Comment);
	$stmt->bindParam(":Spidito", $this->Spidito);
    $stmt->bindParam(":Operatore", $this->Operatore);
     $stmt->bindParam(":Riparare", $this->Riparare);
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
