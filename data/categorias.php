<?

include("../includes/db.php");
include("../includes/funciones.php");

if(!$_GET['id']){ exit("Error de ID");}

$id_producto_categoria=escapar($_GET['id'],1);

$sql="SELECT * FROM productos_categorias WHERE id_producto_categoria=$id_producto_categoria";
$query=mysql_query($sql);
$ft=mysql_fetch_assoc($query);
if($query){
	echo $ft['categoria'];
}else{
	echo "error";
}
?>