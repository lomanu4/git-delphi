<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config.php';
include_once '../object/Product.php';


$database = new Database();
$db=$database->getConnection();

$product = new Product($db);

//Get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->Materiale) &&
    !empty($data->Descripzione) &&
    !empty($data->Quantita) &&
	 !empty($data->Treno) &&
	  !empty($data->Discorta) &&
	   !empty($data->Commento) &&
    !empty($data->Creatoda)
)

//set product values
$product->Materiale = $data->Materiale;
$product->Descripzione = $data->Descripzione;
$product->Quantita   = $data->Quantita;
$product->Treno   = $data->Treno;
$product->Discorta= $data->Discorta;
$product->Commento          = $data->Commento;
$product->Creatoda          = $data->Creatoda;
//$product->created       = date('Y-m-d H:i:s');

//Create product
if($product->synch()){
	
	// set response code - 201 created
        http_response_code(201);
 //  echo '{';
    //    echo '"message": "Product was created."';
	 echo json_encode(array("message" => "Product was created."));
  //  echo '}';
}else{
// set response code - 503 service unavailable
        http_response_code(503);
// tell the user
        echo json_encode(array("message" => "Unable to create product."));
   // echo '{';
  
 // echo '"message": "Unable to create product."';
   // echo '}';
}
	

function create(){

    //query insert
    $query = "INSERT INTO
              ". $this->table_name ."
              SET
                Materiale=:Materiale,Descripzione=:Descripzione,Quantita=:Quantita, Treno=:Treno, Discorta=:Discorta,Commento=:Commento,Creatoda=:Creatoda";

    //Prepare
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->Materiale=htmlspecialchars(strip_tags($this->Materiale));
	 $this->Descripzione=htmlspecialchars(strip_tags($this->Descripzione));
	  $this->Quantita=htmlspecialchars(strip_tags($this->Quantita));
	   $this->Treno=htmlspecialchars(strip_tags($this->Treno));
    $this->Discorta=htmlspecialchars(strip_tags($this->Discorta));
    $this->Commento=htmlspecialchars(strip_tags($this->Commento));
    $this->Creatoda=htmlspecialchars(strip_tags($this->Creatoda));
    

    //Bind values
    $stmt->bindParam(":Materiale", $this->Materiale);
	$stmt->bindParam(":Descripzione", $this->Descripzione);
	$stmt->bindParam(":Quantita", $this->Quantita);
	$stmt->bindParam(":Treno", $this->Treno);
    $stmt->bindParam(":Discorta", $this->Discorta);
    $stmt->bindParam(":Commento", $this->Commento);
    $stmt->bindParam(":Creatoda", $this->Creatoda);
   

    //execute
    if($stmt->execute()){
        return true;
    }
    return false;
}
?>