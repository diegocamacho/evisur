<?
include("../includes/session.php");
include("../includes/db.php");

extract($_POST);

if(!mensaje) exit("Escriba un comentario.");
if(!$id_tarea) exit("No ID");

$hoy = date('Y-m-d H:i:s');
//Updateamos el estado
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
