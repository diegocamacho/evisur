<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);
//print_r($_POST);

//Validamos datos completos
if(!$producto) exit("Debe escribir un nombre para el producto.");
if(!$id_producto_categoria) exit("Seleccione una categoria para el producto.");
if($id_producto_categoria==0) exit("Seleccione una categoria para el producto.");

//Formateamos y validamos los valores
$id_producto_categoria=limpiaStr($id_producto_categoria,1);
$producto=limpiaStr($producto,1,1);

//Insertamos datos
$sql="INSERT INTO productos (id_producto_categoria,producto,foto) VALUES ('$id_producto_categoria','$producto','$foto_final')";
$q=mysql_query($sql);
if($q){
	echo "1";
}else{
	echo "Ocurrió un error, intente más tarde.";
}
