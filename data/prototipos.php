<?

include("../includes/db.php");
include("../includes/funciones.php");

if(!$_GET['id_prototipo']){ exit("Error de ID");}

$id_prototipo=escapar($_GET['id_prototipo'],1);

$sql="SELECT * FROM prototipos WHERE id_prototipo=$id_prototipo";
$query=mysql_query($sql);
$ft=mysql_fetch_assoc($query);
if($query){
	echo $ft['prototipo'];
}else{
	echo "error";
}
?>