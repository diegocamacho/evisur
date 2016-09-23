<?
//Utilerias
date_default_timezone_set ("America/Bogota");
$fechahora=date("Y-m-d H:i:s");
$fecha_actual=date("Y-m-d");
//Valida cadena de fecha

function mb_ucfirst($string, $encoding = 'UTF-8'){
	$string = mb_strtolower($string, $encoding);
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

function mayus($string){
	
	return ucwords( mb_strtolower($string,'UTF-8') );
	
}

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

function acentos($cadena){
    $originales =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'AAAAAAACEEEEIIIIDNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    return utf8_encode($cadena);
}


function devuelveFechaHora($fecha_hora){
	
	
$data = explode(' ', $fecha_hora);

return fechaLetraDos($data[0]).' · '.substr($data[1], 0,5);

	
	
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

function damePorcentaje($cantidad,$porciento){
	return number_format($cantidad*$porciento/100 ,2);
}

function dias_restantes($fecha_final) {
	$fecha_actual = date("Y-m-d");
	$s = strtotime($fecha_actual)-strtotime($fecha_final);
	$d = intval($s/86400);
	$diferencia=$d;
	return $diferencia;
}

function dias_restantes_formato($fecha_final) {
	if(!$fecha_final){ return "N/A"; }
	$fecha_actual = date("Y-m-d");
	$s = strtotime($fecha_actual)-strtotime($fecha_final);
	$d = intval($s/86400);
	if($d==0){
		$diferencia="Hoy";
	}elseif($d==1){
		$diferencia="Ayer";
	}else{
		$diferencia=$d." días";
	}
	return $diferencia;
}