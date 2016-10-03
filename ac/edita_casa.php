<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);
//print_r($_POST);
//exit();
//Validamos datos completos
if(!$id_casa) exit("No llego el identificador.");
if($id_prototipo==0) exit("Seleccione un prototipo de casa.");
if($id_proyecto==0) exit("Seleccione un proyecto.");
if(!$manzana) exit("Debe escribir la manzana de la casa.");
if(!$lote) exit("Debe escribir el lote de la casa.");
if(!$calle) exit("Debe escribir la calle de la dasa.");
if(!$numero) exit("Debe escribir el número de la casa.");

//Limpiamos variables
$manzana=limpiaStr($manzana,1,1);
$lote=limpiaStr($lote,1,1);
$calle=limpiaStr($calle,1,1);
$numero=limpiaStr($numero,1,1);

//Insertamos datos
$sql="UPDATE casas SET id_prototipo='$id_prototipo', id_proyecto='$id_proyecto', manzana='$manzana', lote='$lote', calle='$calle', numero='$numero' WHERE id_casa='$id_casa'";
$q=mysql_query($sql);
if($q){
	echo "1";
}else{
	echo "Ocurrió un error, intente más tarde.";
}
