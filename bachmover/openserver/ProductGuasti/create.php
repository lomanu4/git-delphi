<?php /** @noinspection PhpUndefinedFieldInspection */

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config.php';
include_once '../Object/Guasti.php';


$database = new Database();
$db=$database->getConnection();

$product = new Product($db);

//Get post data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->Componente) &&
    !empty($data->DTR) &&
    !empty($data->Treno) &&
	 !empty($data->DataGuasto) &&
	  !empty($data->Veicolo) &&
	   !empty($data->Inprova) &&
    !empty($data->Seriale) &&
	!empty($data->OdlSO) &&
	!empty($data->Comment) &&
	!empty($data->Spidito) &&
	!empty($data->Operatore) &&
	!empty($data->Riparare) 
)

//set product values
$product->Componente = $data->Componente;
$product->DTR =  $data->DTR;
$product->Treno   = $data->Treno;
$product->DataGuasto   = $data->DataGuasto;
$product->Veicolo= $data->Veicolo;
$product->Inprova          = $data->Inprova;
$product->Seriale          = $data->Seriale;
$product->OdlSO          = $data->OdlSO;
$product->Comment          = $data->Comment;
$product->Spidito          = $data->Spidito;
$product->Operatore          = $data->Operatore;
$product->Riparare          = $data->Riparare;

//$product->created       = date('Y-m-d H:i:s');

//Create product
if($product->create()){
	
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
                Componente=:Componente,DTR=:DTR,Treno=:Treno,DataGuasto=:DataGuasto, Veicolo=:Veicolo,Inprova=:Inprova,Seriale=:Seriale,OdlSO=:OdlSO,Comment=:Comment,Spidito=:Spidito,Operatore=:Operatore,Riparare=:Riparare";

    //Prepare
    /** @var TYPE_NAME $this */
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
    

    //Bind values
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

    //execute
    if($stmt->execute()){
        return true;
    }
    return false;
}
?>