<?

$f = $_GET['f'];

$revision_sql1 = 0;
$revision_sql2 = 0;
$mostrar_li = 'inline';

$hover = "background:#3598dc;color:white";

$sql = "SELECT*FROM tareas WHERE id_remite = '$s_id_usuario' AND terminado_creador = 0 AND terminado_destino = 0 AND activo = 1";
$q = mysql_query($sql);
$pendientes = mysql_num_rows($q);

$sql = "SELECT*FROM tareas WHERE id_remite = '$s_id_usuario' AND terminado_creador = 0 AND terminado_destino = 1 AND activo = 1";
$q = mysql_query($sql);
$revision = mysql_num_rows($q);

$cuantas_pendientes = $pendientes;
$cuantas_revision = $revision;

switch($f):
	case 'revision':
		$revision_sql2 = 1;
		$sub = 'Tareas en espera de mi revisión.';
		$add = 'en Revisión';
		$mostrar_li = 'inline';
		$revision_activo = $hover;
	break;
	case 'completadas':
		$revision_sql1 = 1;
		$revision_sql2 = 1;
		$add = ' Completadas';
		$sub = 'Tareas terminadas con éxito.';
		$mostrar_li = 'inline';
		$completadas_activo = $hover;
	break;
	default:	
		$sub = 'Tareas pendientes.';
		$pendientes_activo = $hover;
endswitch;

$sql = "SELECT tareas.*, usuarios.nombre FROM tareas JOIN usuarios ON tareas.id_destino = usuarios.id_usuario WHERE id_remite = $s_id_usuario AND tareas.activo = 1 AND terminado_creador = $revision_sql1 AND terminado_destino = $revision_sql2 ORDER BY leido ASC, fecha_limite ASC";
$q = mysql_query($sql);


$tareas = array();

while($datos = mysql_fetch_object($q)):
	$tareas[] = $datos;

endwhile; 

$hay_tareas = count($tareas);
?>

<div class="col-md-9"> 
	<div class="inbox-body">
		<div class="row">
			<div class="col-md-8">
				<div class="inbox-header">
					<h1 class="pull-left">Enviadas <?= $add ?></h1>
				</div>
			</div>
			<div class="col-md-4" style="margin-top: 13px; text-align: right">
				<small id="subtitulo" style="font-weight: 100;font-size: 14px;color:gray"><?= $sub ?></small>
			</div>
		</div>

	    <div class="inbox-content">
		    
			<table class="table table-striped table-advance table-hover">
			    <thead>
			        <tr>
			            <th class="pagination-control" colspan="5">
			                <div class="btn-group input-actions">
			                    <a class="btn btn-sm blue btn-outline sbold"  style="display: <?= $mostrar_li ?>; <?=$pendientes_activo?>" href="?Modulo=Tareas&tipo=enviadas"> 
			                                <i class="fa fa-hourglass-half"></i> Pendientes (<?= $cuantas_pendientes ?>) </a>
			                    </a>

			                    <a class="btn btn-sm blue btn-outline sbold" style="<?=$revision_activo?>" href="?Modulo=Tareas&tipo=enviadas&f=revision"> 
			                                <i class="fa fa-search"></i> En Revisión (<?= $cuantas_revision ?>) </a>
			                    </a>
			                    
			                    <a class="btn btn-sm blue btn-outline sbold" style="<?=$completadas_activo?>" href="?Modulo=Tareas&tipo=enviadas&f=completadas"> 
			                                <i class="fa fa-check"></i> Completadas </a>
			                    </a>

			                </div>
			            </th>
			        </tr>
			    </thead>
			    <tbody>
				    
				    
			<? foreach($tareas as $tarea): 
			
				if($tarea->leido == '0'): $l = 'unread'; $estrella = '<i class="fa fa-star"></i>'; else: $l = ''; $estrella = ''; endif;

				$fecha = $tarea->fecha_limite;
			
				if($fecha==date('Y-m-d')):
					$mostrar_fecha = 'Hoy';
				else:
					$mostrar_fecha = fechaLetraAlt($fecha);
				endif;
									
				switch($tarea->prioridad):
				case '1':
					$prioridad = 'BAJA';
					$class = 'success';
				break;
				case '2':
					$prioridad = 'MEDIA';
					$class = 'warning';
				break;
				case '3':
					$prioridad = 'ALTA';
					$class = 'danger';
				break;
				endswitch; 
				

			?>
			        <tr onclick="window.location = '?Modulo=Tareas&tarea=<?= $tarea->id_tarea ?>'" class="<?= $l ?>">

			            <td class="inbox-small-cells">
			                <?= $estrella ?>
			            </td>
			            <td class="view-message hidden-xs"> 
				            <?= mayus($tarea->nombre) ?>
						</td>
			            <td class="view-message "> 
				            <?= $tarea->asunto ?>
			            </td>
			            <td class="view-message inbox-small-cells">
			                 <span class="badge badge-<?= $class ?>">
			                 	<?= $prioridad ?>
			                 </span>
			            </td>
			            <td class="view-message text-right"> 
				            <?= $mostrar_fecha ?> 
				        </td>

			        </tr>
			
			
			<? endforeach; ?>
			         
			    </tbody>
			</table>
			<? if(!$hay_tareas): ?>
		    			         <center><h4><p>No hay tareas.</p></h4></center>
			<? endif; ?>
	    </div>
	</div>
</div>
