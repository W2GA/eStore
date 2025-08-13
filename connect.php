<?php 
$host="localhost";
$dbname="store";
$port = 4306;
$user = "root" ;
$pass = "" ; 
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8" // FOR Arabic
);
$dsn = "mysql:host=$host;port=$port;dbname=$dbname" ; 
//connectbd
try {
  $con = new PDO($dsn , $user , $pass , $option ); 
  $con->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
  // include 'functions.php';
}catch(PDOException $e){
  echo $e->getMessage() ;        
} 

##################################################################################################################
//read data

function showdata($requete){
  global $con;
  $stmt= $con->prepare("$requete ");
  $stmt->execute();
  $lignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // $a = $stmt->rowCount();
  return ["lignes"=>$lignes,"nmbreligne"=>$stmt->rowCount()];
}
##################################################################################################################
// add update delete data 
function adu($requete,$tab){
  global $con;
  $stmt= $con->prepare("$requete");
  $stmt->execute($tab);
  return $stmt->rowCount();
}



