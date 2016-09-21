<?

include("../includes/db.php");
include("../includes/funciones.php");

if(!$_GET['id_proyecto']){ exit("Error de ID");}

$id_proyecto=escapar($_GET['id_proyecto'],1);

$sql="SELECT * FROM proyectos WHERE id_proyecto=$id_proyecto";
$query=mysql_query($sql);
$ft=mysql_fetch_assoc($query);
if($query){
	echo $ft['proyecto'];
}else{
	echo "error";
}
?>