<?
session_start();
require '../includes/db.php';
date_default_timezone_set ("America/Bogota");
$fecha_hora=date("Y-m-d H:i:s");



if(!$_POST['user']) exit("Debe escribir su usuario");
if(!$_POST['pass']) exit("Debe escribir su contraseña");

	if(isset ($_POST['user']) && ($_POST['pass']))
	{

		$usuario=mysql_real_escape_string($_POST['user']);
		$contrasena=mysql_real_escape_string($_POST['pass']);
		// Admin
 		$sql = "SELECT * FROM usuarios WHERE email='$usuario' AND pass='$contrasena' AND activo='1' LIMIT 1";
		$res = mysql_query($sql) or die ('Error en db');
		$num_result = mysql_num_rows($res);
		if($num_result != 0){
			while ($row=mysql_fetch_object($res))
				{
					$_SESSION['s_id'] = $row->id_usuario;
					$_SESSION['s_tipo'] = $row->id_tipo_usuario;
					$_SESSION['s_nombre'] = $row->nombre;
					$_SESSION['s_display'] = $row->foto;
				}
			if(mysql_query("UPDATE usuarios SET ultimo_acceso='$fecha_hora' WHERE id_usuario='".$_SESSION['s_id']."'")){
				echo "1";
			}
		}else{
			exit('Datos de acceso incorrectos, por favor intente nuevamente.');
		}

	}
?>