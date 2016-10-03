<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);

//Validamos datos completos
if(!$id_producto) exit("Error al identificar el usuario.");
if(!$producto) exit("Debe escribir un nombre para el producto.");
if($id_producto_categoria<=0) exit("Debe seleccionar una categoria para el producto.");
//if(!$usuario) exit("Debe escribir un usuario.");
//if(!$password) exit("Debe escribir una contraseña.");


$producto=limpiaStr($producto,1,1);
$id_producto=escapar($id_producto,1);
$id_producto_categoria=escapar($id_producto_categoria,1);


$sql="UPDATE productos SET id_producto_categoria='$id_producto_categoria', producto='$producto', foto='$foto_final' WHERE id_producto=$id_producto";
$q=mysql_query($sql);
if($q){
	echo "1";
}else{
	echo "Ocurrió un error, intente más tarde.";
}
?>