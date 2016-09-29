<?
include("../includes/session.php");
include("../includes/db.php");

extract($_POST);
//print_r($_POST);
//Validamos datos completos
//if(!$tipo) exit("No llego el identificador de la operación");
if(!$id_producto_categoria) exit("No llego el identificador del usuario");

//Updateamos el estado
$sql="UPDATE productos_categorias SET activo='$tipo' WHERE id_producto_categoria=$id_producto_categoria";
$q=mysql_query($sql);
if($q){
	echo "1";
}else{
	echo "Ocurrió un error al actualizar el usuario";
}
?>