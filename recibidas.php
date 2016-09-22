<?

$f = $_GET['f'];

$revision_sql1 = 0;
$revision_sql2 = 0;
$mostrar_li = 'none';

switch($f):
	case 'revision':
		$revision_sql2 = 1;
		$sub = 'Tareas en espera de revisión.';
		$add = 'en Revisión';
		$mostrar_li = 'inline';
	break;
	case 'completadas':
		$revision_sql1 = 1;
		$revision_sql2 = 1;
		$add = ' Completadas';
		$sub = 'Tareas terminadas con éxito.';
		$mostrar_li = 'inline';
	break;
	default:	
		$sub = 'Tareas pendientes por hacer.';
endswitch;

$sql = "SELECT tareas.*, usuarios.nombre FROM tareas JOIN usuarios ON tareas.id_remite = usuarios.id_usuario WHERE id_destino = $s_id_usuario AND tareas.activo = 1 AND terminado_creador = $revision_sql1 AND terminado_destino = $revision_sql2 ORDER BY leido ASC, fecha_limite ASC";
$q = mysql_query($sql);


$tareas = array();

while($datos = mysql_fetch_object($q)):
	$tareas[] = $datos;

endwhile; 
?>

<div class="col-md-9"> 
	<div class="inbox-body">
		<div class="row">
			<div class="col-md-8">
				<div class="inbox-header">
					<h1 class="pull-left">Recibidas <?= $add ?></h1>
				</div>
			</div>
			<div class="col-md-4" style="margin-top: 13px; text-align: right">
				<small style="font-weight: 100;font-size: 14px;color:gray"><?= $sub ?></small>
			</div>
		</div>

	    <div class="inbox-content">
		    
			<table class="table table-striped table-advance table-hover">
			    <thead>
			        <tr>
			            <th colspan="3">
			
			            </th>
			            <th class="pagination-control" colspan="3">
			                <div class="btn-group input-actions">
			                    <a class="btn btn-sm blue btn-outline dropdown-toggle sbold" href="javascript:;" data-toggle="dropdown"> Ver
			                        <i class="fa fa-angle-down"></i>
			                    </a>
			                    <ul class="dropdown-menu">
			                        <li style="display: <?= $mostrar_li ?>">
			                            <a href="?Modulo=Tareas">
			                                <i class="fa fa-hourglass-half"></i> Ver Pendientes </a>
			                        </li>
			                        <li>
			                            <a href="?Modulo=Tareas&f=revision">
			                                <i class="fa fa-search"></i> Ver en Revisión </a>
			                        </li>
			                        
			                        <li>
			                            <a href="?Modulo=Tareas&f=completadas">
			                                <i class="fa fa-check"></i> Ver Completadas </a>
			                        </li>

			                    </ul>
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
			
			        <tr class="<?= $l ?>" data-messageid="1">
			            <td class="inbox-small-cells">
			            </td>
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
		    
	    </div>
	</div>
</div>
