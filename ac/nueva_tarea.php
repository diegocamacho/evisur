<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);

//Validamos datos completos
//if(!$nombre) exit("Debe escribir un nombre para el proyecto.");
/*asunto
descripcion
prioridad
id_destino
mensaje
$nombre=limpiaStr($nombre,1,1);*/



	//Insertamos datos
	$sql="INSERT INTO tareas (id_remite,id_destino,id_proyecto,fecha_hora_creacion,fecha_limite,asunto,descripcion,prioridad,activo) VALUES ('$s_id_usuario','$id_destino','$id_proyecto','$fechahora','$fecha_limite','$asunto','$mensaje','$prioridad','1')";
	$q=mysql_query($sql);
	if($q){
		echo "1";
	}else{
		echo "Ocurrió un error, intente más tarde.";
	}
