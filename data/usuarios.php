<?

include("../includes/db.php");
include("../includes/funciones.php");

if(!$_GET['id_usuario']){ exit("Error de ID");}

$id_usuario=escapar($_GET['id_usuario'],1);

$sql="SELECT * FROM usuarios WHERE id_usuario=$id_usuario";
$query=mysql_query($sql);
$ft=mysql_fetch_assoc($query);
if($query){
	echo $ft['id_tipo_usuario']."|".$ft['nombre']."|".$ft['email']."|".$ft['celular'];
}else{
	echo "error";
}
?>