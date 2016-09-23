<?
include("../includes/session.php");
include("../includes/db.php");

extract($_GET);
//print_r($_POST);
//Validamos datos completos
//if(!$tipo) exit("No llego el identificador de la operación");
if(!$id_tarea) exit("No ID Task");

$hoy = date('Y-m-d H:i:s');
//Updateamos el estado
$sql="UPDATE tareas SET terminado_destino=1, fecha_hora_terminado = '$hoy' WHERE id_tarea=$id_tarea";
$q=mysql_query($sql);
if($q){
	echo "1";
}else{
	echo "Ocurrió un error al actualizar";
}

