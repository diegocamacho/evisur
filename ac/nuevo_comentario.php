<?
include("../includes/session.php");
include("../includes/db.php");

extract($_POST);

if(!$comentario) exit("No Comment");
if(!$id_tarea) exit("No Comment");

$hoy = date('Y-m-d H:i:s');
//Updateamos el estado
$sql = "INSERT INTO comentarios (id_tarea,id_usuario,fecha_hora,comentario)VALUES('$id_tarea','$s_id_usuario','$hoy','$comentario')";
$q=mysql_query($sql) or die(mysql_error());

if($q):
	echo "1";
else:
	echo "Ocurrió un error al guardar comentario.";
endif;

