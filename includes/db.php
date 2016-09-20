<?php
//error_reporting(0);
$servidor="localhost";
$usuario="root";
$clave="root";
$base="evisur_app";
$conexion = @mysql_connect ($servidor,$usuario,$clave) or die ("Error en conexi&oacute;n.");
@mysql_select_db($base) or die ("No BD ");
?>