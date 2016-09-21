<?
//Utilerias
date_default_timezone_set ("America/Bogota");
$fechahora=date("Y-m-d H:i:s");
$fecha_actual=date("Y-m-d");
//Valida cadena de fecha
function validaStrFecha($fecha,$ano=false){
	if(!$ano){
		if( (is_numeric($fecha)) && (strlen((string)$fecha)==2) ){
			return true;
		}else{
			return false;
		}
	}else{
		if( (is_numeric($fecha)) && (strlen((string)$fecha)==4) ){
			return true;
		}else{
			return false;
		}
	}
}
//Encripta contrase–a
function contrasena($contrasena){
	return md5($contrasena);
}
//Valida c—digo postal
function validarCP($cp){
	if( (is_numeric($cp)) && (strlen($cp)==5) ){
		return true;
	}else{
		return false;
	}
}
//Valida teléfono
function validarTelefono($telefono){
	if( (is_numeric($telefono)) && (strlen($telefono)==10) ){
		return true;
	}else{
		return false;
	}
}
//Validar email
function validarEmail($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}
//Formatear cadenas
function limpiaStr($v,$base=false,$m=false){
 if($m){
 	$v =  mb_convert_case($v, MB_CASE_UPPER, "UTF-8");
 }else{
	$v =  mb_convert_case($v, MB_CASE_TITLE, "UTF-8"); 
 }
 if($base){
	 $v = mysql_real_escape_string(strip_tags($v));
 }
 return  $v;
}
//Funcion para escapar
function escapar($cadena,$numerico=false){
	if($numerico){
		if(is_numeric($cadena)){
			return mysql_real_escape_string($cadena);
		}else{
			return false;
		}
	}else{
		return mysql_real_escape_string(strip_tags($cadena));
	}
}
//Fecha para base de datos
function fechaBase($fecha){ 
	list($mes,$dia,$anio)=explode("/",$fecha); 

	$dia=(string)(int)$dia;
	return $anio."-".$mes."-".$dia;
}
//Para mostrar fecha
function fechaSinHora($fecha){
	return $fecha=substr($fecha,0,11);
}
//Fecha sin hora
function fechaLetra($fecha){
    
	list($anio,$mes,$dia)=explode("-",$fecha); 
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;
	
	}
	$dia=(string)(int)$dia;
	return $dia." ".$mest." ".$anio;
}

function fechaLetraAlt($fecha){
    
	list($anio,$mes,$dia)=explode("-",$fecha); 
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;
	
	}
	$dia=(string)(int)$dia;
	return $dia." ".$mest;
}

function fechaLetraDos($fecha){
    
	list($anio,$mes,$dia)=explode("-",$fecha); 
	switch($mes){
	case 1:
	$mest="ENE";
	break;
	case 2:
	$mest="FEB";
	break;
	case 3:
	$mest="MAR";
	break;
	case 4:
	$mest="ABR";
	break;
	case 5:
	$mest="MAY";
	break;
	case 6:
	$mest="JUN";
	break;
	case 7:
	$mest="JUL";
	break;
	case 8:
	$mest="AGO";
	break;
	case 9:
	$mest="SEP";
	break;
	case 10:
	$mest="OCT";
	break;
	case 11:
	$mest="NOV";
	break;
	case 12:
	$mest="DIC";
	break;
	
	}
	$dia=$dia;
	return $dia."/".$mest."/".$anio;
}



//Obtener el mes
function soloMesNumero($fecha){
    
	$x=explode("-",$fecha);
	return $x[1];
}
function soloMes($mes){
    
	switch($mes){
	case 1:
	$mest="Enero";
	break;
	case 2:
	$mest="Febrero";
	break;
	case 3:
	$mest="Marzo";
	break;
	case 4:
	$mest="Abril";
	break;
	case 5:
	$mest="Mayo";
	break;
	case 6:
	$mest="Junio";
	break;
	case 7:
	$mest="Julio";
	break;
	case 8:
	$mest="Agosto";
	break;
	case 9:
	$mest="Septiembre";
	break;
	case 10:
	$mest="Octubre";
	break;
	case 11:
	$mest="Noviembre";
	break;
	case 12:
	$mest="Diciembre";
	break;
	
	}
	return $mest;
}
function fnum($num,$sinDecimales = false, $sinNumberFormat = false){

//SinDecimales = TRUE: envias: 1500.1234 devuelve: 1,500
//SinNumberFormat = TRUE: envias 1500.1234 devuelve 1500.12
//SinNumberFormat = TRUE && SinDecimales = TRUE: envias: 1500.1234 devuelve 1500

	if(is_numeric($num)){
		$roto = explode('.',$num);
		if($roto[1]){
			$dec = substr($roto[1],0,2);
		}else{
			$dec = "00";
		}

		if(is_numeric($roto[0])){
			if($sinDecimales){
				if($sinNumberFormat){
					return $roto[0];
				}else{
					return number_format($roto[0]);
				}
			}else{
				if($sinNumberFormat){
					return $roto[0].'.'.$dec;
				}else{
					return number_format($roto[0]).'.'.$dec;
				}
			}
		}else{
			if($sinDecimales){
				return '0';
			}else{
				return '0.'.$dec;
			}
		}
	}else{
		if($sinDecimales){
			return '0';
		}else{
			return '0.00';
		}
	}

}
function tipo_usuario($id_tipo_usuario){
	$sql="SELECT tipo FROM tipo_usuario WHERE id_tipo_usuario=$id_tipo_usuario";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);
	$tipo=$ft['tipo'];
	return $tipo;
}

function dameLugar($id){
	$sql="SELECT locacion_display FROM locaciones_detalle WHERE id_locacion_detalle=$id";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);
	$nombre=$ft['locacion_display'];
	return $nombre;
}

function acentos($cadena){
    $originales =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    return utf8_encode($cadena);
}

function obtenerDeuda($id_cliente){
	
	global $conexion;
	
	$sql = "SELECT SUM(monto) FROM abonos WHERE id_cliente = '$id_cliente'";
	$q = mysql_query($sql);
	$abonos = mysql_result($q, 0);
	
	$sql ="SELECT * FROM creditos WHERE id_cliente = '$id_cliente'";
	$q = mysql_query($sql);
	
	while($ft = mysql_fetch_assoc($q)){
		
		$id_venta = $ft['id_venta'];
		
		$sql ="SELECT * FROM venta_detalle WHERE id_venta = $id_venta";
		$qq = mysql_query($sql);
		
		while($fx = mysql_fetch_assoc($qq)){

			$cantidad = $fx['cantidad'];
			$precio_venta = $fx['precio_venta'];
			$adeuda+= $cantidad*$precio_venta;
					
		}		
	}
	
	$debe = $adeuda-$abonos;
	
	if($debe==0){
		return  "0.00";
	}else{
		return $debe;
	}
		
}


function devuelveFechaHora($fecha_hora){
	
	
$data = explode(' ', $fecha_hora);

return fechaLetraDos($data[0]).' · '.substr($data[1], 0,5);

	
	
}

function dameVendedor($id) {
	$sql="SELECT nombre FROM usuarios WHERE id_usuario=$id";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);
	return $ft['nombre'];
}
function torzon($titulo,$mensaje){
	
	$correo = "hola@epicmedia.pro";
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=utf8\r\n"; 
	$headers .= "From: Epicmedia Robot <robot@epicmedia.pro>\r\n";
	
	$bool = mail($correo,$titulo,$mensaje,$headers);
	if($bool){
		return true;
	}else{
	    return false;
	}
}
function torzon2($cliente){
	$mail = $cliente." acaba de pedir que le avisen cuando Adminus regrese.";
	$titulo = "Soporte Adminus";
	$correo = "diegocamacho2.0@gmail.com,adolfoflores@me.com";
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=utf8\r\n"; 
	$headers .= "From: Adminus Robot <robot@adminus.mx>\r\n";
	
	$bool = mail($correo,$titulo,$mail,$headers);
	if($bool){
		return true;
	}else{
	    return false;
	}
}
function dameTarifa($dias,$horas,$id_vehiculo) {
	$sql="SELECT * FROM vehiculos WHERE id_vehiculo=$id_vehiculo";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);

	
}

//Hora del dia en formato 24 hrs
function horaOficial($hora){
  $hora_oficial = date("H:i",strtotime($hora));
  return $hora_oficial;
}

//Hora del dia en formato 12 hrs
function horaInput($hora){
  $hora_oficial = date("h:i A",strtotime($hora));
  return $hora_oficial;
}

//Código de Reservación
function codigoReservacion(){ 
       $cadena="[^A-Z0-9]"; 
       return substr(eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())) . eregi_replace($cadena, "", md5(rand())), 0, 10); 
}


function damePrecioDia($id_vehiculo,$id_locacion){
	$sql="SELECT precio_dia FROM vehiculos_precios WHERE id_vehiculo=$id_vehiculo AND id_locacion=$id_locacion";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);
	$precio=$ft['precio_dia'];
	return $precio;
}

function damePrecioHora($id_vehiculo,$id_locacion){
	$sql="SELECT precio_hora FROM vehiculos_precios WHERE id_vehiculo=$id_vehiculo AND id_locacion=$id_locacion";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);
	$precio=$ft['precio_hora'];
	return $precio;
}

function dameVehiculo($id_vehiculo_detalle){
	$sql="SELECT vehiculo FROM vehiculos_detalle
	JOIN vehiculos ON vehiculos.id_vehiculo=vehiculos_detalle.id_vehiculo
	WHERE id_vehiculo_detalle=$id_vehiculo_detalle";
	$q=mysql_query($sql);
	$ft=mysql_fetch_assoc($q);
	return $ft['vehiculo'];
}

function damePorcentaje($cantidad,$porciento){
	return number_format($cantidad*$porciento/100 ,2);
}