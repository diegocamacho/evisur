<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);

//Validamos datos completos
if(!$asunto) exit("Escriba el asunto de la tarea.");
if(!$prioridad) exit("Seleccione la prioridad de la tarea.");
if(!$id_destino) exit("Seleccione el usuario al que se le va asignar la tarea.");
//if(!$id_proyecto) exit("Seleccione el proyecto al que va afectar la tarea.");
if(!$fecha_limite) exit("Seleccione la fecha límite de entrega.");
if(!$mensaje) exit("Escriba la tarea a realizar.");

/*asunto
descripcion
prioridad
id_destino
mensaje
$nombre=limpiaStr($nombre,1,1);*/
$asunto=limpiaStr($asunto,1,1);
$mensaje=limpiaStr($mensaje,1,1);



	//Insertamos datos
	$sql="INSERT INTO tareas (id_remite,id_destino,id_proyecto,fecha_hora_creacion,fecha_limite,asunto,descripcion,prioridad,activo) VALUES ('$s_id_usuario','$id_destino','$id_proyecto','$fechahora','$fecha_limite','$asunto','$mensaje','$prioridad','1')";
	$q=mysql_query($sql);
	if($q){
		echo "1";
	}else{
		echo "Ocurrió un error, intente más tarde.";
	}
