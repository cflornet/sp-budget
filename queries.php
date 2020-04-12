<?
require "connectDB.req.php";
// Exécuter une requête SELECT

$sql = "SELECT * from categories;";
$categs = $pdo -> query($sql);

echo "<h1>Catégories<h1><br>";
while ($categ = $categs -> fetch()) {
  echo $categ['category']."<br>";
}

//passage de paramètres par valeur
/*
$stmt = $pdo -> prepare("SELECT * FROM categories WHERE idCategory IN (?,?,?)");
$stmt->bindValue(1, 3, PDO::PARAM_INT);
$stmt->bindValue(2, 6, PDO::PARAM_INT);
$stmt->bindValue(3, 9, PDO::PARAM_INT);

if($stmt->execute()){
  echo "La requete SELECT a été executé. Ne fait rien, la seule table à modifer est Transactions.<br>";
   $stmt->debugDumpParams();} 
else{
echo "La requete n'a pas été executé";}
 */


date_default_timezone_set('Europe/Paris');
$dateOOP=new DateTime();
$today=$dateOOP->format('Y-m-d');

// passage de paramètres par reférence
$transac=array();
$transac[0]="222;$today;2;3";
$transac[1]="22.5;$today;2;1";
$transac[2]="333;$today;1;4";

echo "<pre>";
print_r($transac);
echo "</pre>";


$query = "INSERT INTO transactions (`transactionAmount`, `transactionDate`, `idCategory`, `idPayment`) VALUES (:transactionAmount, :transactionDate, :idCategory, :idPayment);";

$stmt=$pdo->prepare($query);

$stmt->bindParam(':transactionAmount',$transactionAmount,PDO::PARAM_INT);
$stmt->bindParam(':transactionDate',$transactionDate,PDO::PARAM_STR);
$stmt->bindParam(':idCategory',$idCategory,PDO::PARAM_INT);
$stmt->bindParam(':idPayment',$idPayment,PDO::PARAM_INT);


foreach($transac as $key=>$value){

  list($transactionAmount, $transactionDate, $idCategory, $idPayment)=explode(';',$value);

  if($stmt->execute()){
    echo "La requete a été executé<br>";
    $stmt->debugDumpParams();
    echo "<br>";
    $lastId = $pdo->lastInsertId();
    echo "lastId == ".$lastId."<br>";


  }else{
    echo "La requete n'a pas été executé";}
} // end foreach
?>
