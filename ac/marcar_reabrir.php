<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_GET);
//print_r($_POST);
//Validamos datos completos
//if(!$tipo) exit("No llego el identificador de la operación");
if(!$id_tarea) exit("No ID Task");

$sql = "SELECT*FROM tareas WHERE id_tarea = $id_tarea";
$q = mysql_query($sql);
$tarea = mysql_fetch_object($q);

if($s_id_usuario!=$tarea->id_remite) exit('Debes ser el remitente para finalizar la tarea'); 

$hoy_fecha_hora = date('Y-m-d H:i:s');
//Updateamos el estado
$sql="UPDATE tareas SET terminado_destino = 0, terminado_creador = 0, fecha_hora_terminado = '' WHERE id_tarea=$id_tarea";
$q=mysql_query($sql);
if($q){
	echo "1";
	
	$mensaje_bot = mayus($s_nombre).' reabrió esta tarea.';
	$sql = "INSERT INTO comentarios (id_tarea,fecha_hora,comentario)VALUES('$id_tarea','$hoy_fecha_hora','$mensaje_bot')";
	$q = mysql_query($sql);
	
}else{
	echo "Ocurrió un error al actualizar.";
}

