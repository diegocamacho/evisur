<? session_start();

$s_id_usuario=$_SESSION['s_id'];
$s_tipo=$_SESSION['s_id_tipo_usuario'];
$s_nombre=$_SESSION['s_nombre'];
$s_id_empresa=$_SESSION['s_id_empresa'];
$s_rfc=$_SESSION['s_rfc'];
$s_razon_social=$_SESSION['s_razon_social'];
$s_mes_ingreso = $_SESSION['mes_ingreso'];
$s_mensual_bimestral = $_SESSION['mensual_bimestral'];
$s_mes_actual = $_SESSION['mes_actual'];
$s_mes_select = $_SESSION['mes_select'];
$s_vip = $_SESSION['vip'];

if(!isset($_SESSION['s_id'])){
	header("Location: login.php");
}
?>