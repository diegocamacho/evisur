<?
include("../includes/session.php");
include("../includes/db.php");
include("../includes/funciones.php");

extract($_POST);
//print_r($_POST);
if(!$id_prototipo) exit("No se encontro el prototipo.");

foreach($cantidad as $id => $val):

	$sq="SELECT * FROM prototipos_mano_obra WHERE id_prototipo=$id_prototipo AND id_producto_mo=$id ";
	$q=mysql_query($sq);
	$valida=mysql_num_rows($q);
	
	if($activo[$id]=='on'):
	
		$cant = $val;
		$pre  = $precio[$id];
		
		if(!$cant) exit("Falto una cantidad.");
		if(!$pre) exit("Falto un precio.");

		if($valida>0):
			//Updateamos
			$sql="UPDATE prototipos_mano_obra SET cantidad='$cant', precio_unitario='$pre' WHERE id_prototipo=$id_prototipo AND id_producto_mo=$id";
			$q=mysql_query($sql);
		else:
			//Insertamos
			$sql="INSERT INTO prototipos_mano_obra (id_prototipo,id_producto_mo,cantidad,precio_unitario)VALUES('$id_prototipo','$id','$cant','$pre')";
			$q=mysql_query($sql);
		endif;
	else:
		if($valida):
			$sql="DELETE FROM prototipos_mano_obra WHERE id_prototipo=$id_prototipo AND id_producto_mo=$id";
			$q=mysql_query($sql);
		endif;
	endif;

endforeach;

echo "1";