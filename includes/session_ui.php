<? session_start();

$s_id_usuario=$_SESSION['s_id'];
$s_tipo=$_SESSION['s_tipo'];
$s_nombre=$_SESSION['s_nombre'];
$s_display=$_SESSION['s_display'];


if(!isset($_SESSION['s_id'])){
	header("Location: login.php");
}
?>