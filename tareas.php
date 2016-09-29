<?
$tipo = $_GET['tipo'];
$tarea = $_GET['tarea'];

switch($tipo):
	case 'enviadas';
		$incluir = 'enviadas.php';
		$activoEnviadas = 'active';
	break;
	case 'nueva';
		$incluir = 'nueva_tarea.php';
	break;
	case 'recibidas';
	default:
		$incluir = 'recibidas.php';
		$activoRecibidas = 'active';
		
endswitch;

if(is_numeric($tarea)) $incluir = 'ver_tarea.php';

$sql = "SELECT COUNT(*) as cuantos FROM tareas WHERE id_destino = $s_id_usuario AND activo = 1 AND terminado_creador = 0 AND terminado_destino = 0";
$q = mysql_query($sql);
$arr = mysql_fetch_assoc($q);
$rec = $arr['cuantos'];

$sql = "SELECT COUNT(*) as cuantos FROM tareas WHERE id_remite = $s_id_usuario AND activo = 1 AND terminado_creador = 0 AND terminado_destino = 0";
$q = mysql_query($sql);
$arr = mysql_fetch_assoc($q);
$env = $arr['cuantos'];

$sql = "SELECT*FROM usuarios WHERE activo = 1 ORDER BY ultimo_acceso DESC";
$q = mysql_query($sql);

$usuario = array();

while($datos = mysql_fetch_object($q)):
	$usuario[] = $datos;
endwhile;


?>
<div class="container">
	
                                    <div class="page-content-inner">
                                        <div class="inbox">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="inbox-sidebar">
                                                        <a href="javascript:;" data-title="Nueva Tarea" class="btn red  btn-block componer">
                                                            <i class="fa fa-edit"></i> Nueva Tarea </a>
                                                        <ul class="inbox-nav">
                                                            <li class="<?= $activoRecibidas ?>">
                                                                <a href="?Modulo=Tareas" data-type="inbox" data-title="Recibidas"> Recibidas
                                                                    <span class="badge badge-danger"><?= $rec ?></span>
                                                                </a>
                                                            </li>
                                                            
                                                            
                                                            <li class="<?= $activoEnviadas ?>">
                                                                <a href="?Modulo=Tareas&tipo=enviadas" data-type="draft" data-title="Enviadas"> Enviadas
                                                                    <span class="badge badge-warning"><?= $env ?></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <ul class="inbox-contacts">
                                                            <li class="divider"></li>

<p>
<div class="text-center"><span class="item-label" style="color:#545454 !important;">Último Acceso</span></div>
</p>

<? foreach($usuario as $user): 
	
		$foto = ($user->foto) ? $user->foto : 'display.jpeg';
		$st = ($user->id_usuario==$s_id_usuario) ? 'style="display:none"' : '';

?>
                                                            <li <?= $st ?>>
                                                                <a href="javascript:;" class="componer_sidebar" id_usuario="<?= $user->id_usuario ?>">
                                                                    <span class="contact-name">
                                                                    	<?= mayus($user->nombre) ?>
                                                                    </span>
                                                                    <span class="badge badge-info">
                                                                    <?=dias_restantes_formato(fechaSinHora($user->ultimo_acceso))?>
                                                                    </span>
                                                                </a>
                                                                
                                                            </li>                                                            
<? endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
												<? include($incluir); ?>
                                            </div>
                                        </div>
                                    </div>
</div>                                  