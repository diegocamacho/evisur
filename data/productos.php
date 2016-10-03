<?
include("../includes/db.php");
include("../includes/funciones.php");

if(!$_GET['id_producto']){ exit("Error de ID");}

$id_producto=escapar($_GET['id_producto'],1);

$sql="SELECT * FROM productos WHERE id_producto=$id_producto";
$query=mysql_query($sql);
$ft=mysql_fetch_assoc($query);
if($query){
	echo $ft['id_producto_categoria']."|".$ft['producto']."|".$ft['foto'];
}else{
	echo "error";
}
?>