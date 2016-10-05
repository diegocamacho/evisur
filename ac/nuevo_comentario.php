<?
include("../includes/session.php");
include("../includes/db.php");
date_default_timezone_set ("America/Cancun");

extract($_POST);

if(!mensaje) exit("Escriba un comentario.");
if(!$id_tarea) exit("No ID");

$mensaje = str_replace("\n", "<br/><br/>", $mensaje);

$hoy = date('Y-m-d H:i:s');
//Updateamos el estado

$sql = "SELECT*FROM tareas WHERE id_tarea = $id_tarea";
$q = mysql_query($sql);
$tarea = mysql_fetch_object($q);

if($s_id_usuario!=$tarea->id_destino):
	$q = mysql_query("UPDATE tareas SET leido = 0 WHERE id_tarea = $id_tarea");
endif;

$sql = "INSERT INTO comentarios (id_tarea,id_usuario,fecha_hora,comentario)VALUES('$id_tarea','$s_id_usuario','$hoy','$mensaje')";
$q=mysql_query($sql) or die(mysql_error());

$id_comentario = mysql_insert_id();
if($q):
	echo "1";
		if($archivos):
			foreach($archivos as $val => $arch):
				$sq="INSERT INTO adjuntos (id_tarea,id_comentario,archivo)VALUES('$id_tarea','$id_comentario','$arch')";
				$q=mysql_query($sq);
			endforeach;
		endif;
	
else:
	echo "Ocurrió un error al guardar comentario.";
endif;

