<?

include("../includes/db.php");
include("../includes/funciones.php");

if(!$_GET['id_casa']){ exit("Error de ID");}

$id_casa=escapar($_GET['id_casa'],1);

$sql="SELECT * FROM casas WHERE id_casa=$id_casa";
$query=mysql_query($sql);
$ft=mysql_fetch_assoc($query);
if($query){
	echo $ft['id_prototipo']."|".$ft['id_proyecto']."|".$ft['manzana']."|".$ft['lote']."|".$ft['calle']."|".$ft['numero'];
}else{
	echo "error";
}
?>