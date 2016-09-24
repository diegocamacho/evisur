<?php  
	
extract($_GET); 
$id_tarea = $tarea;

$sql = "
SELECT tareas.*,proyectos.proyecto 
FROM tareas 
LEFT JOIN proyectos ON proyectos.id_proyecto = tareas.id_proyecto
WHERE tareas.id_tarea = $tarea AND (id_remite = $s_id_usuario OR id_destino = $s_id_usuario)";

$q = mysql_query($sql);
$tarea = mysql_fetch_object($q);


$sql = "SELECT*FROM usuarios WHERE id_usuario = {$tarea->id_remite}"; 
$q = mysql_query($sql);
$remitente = mysql_fetch_object($q);


if($s_id_usuario==$tarea->id_remite):	##olakase
	$soyremite = 1;
	$soydestino = 0;
else:
	$soyremite = 0;
	$soydestino = 1;
endif;


if($tarea->proyecto): 
	$proyecto = '['.$tarea->proyecto.']';  # Obtenemos nombre del proyecto
endif;

switch($tarea->prioridad):					# Obtenemos la prioridad
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

########### DE AQUI PA BAJO SE GENERA LA BARRA DE STATUS ###########

$fecha_c = $tarea->fecha_hora_creacion;
$fecha_c = explode(' ', $fecha_c);

$hora = substr($fecha_c[1],0,5);
$f_ex = explode('-', $fecha_c[0]);

$dia = $f_ex[2];
$mes = soloMes($f_ex[1]);
$anio = $f_ex[0];

$string_fecha = "$dia de $mes de $anio";

$t_creador = $tarea->terminado_creador;
$t_destino = $tarea->terminado_destino;
$fecha_limite = $tarea->fecha_limite;
$fecha_finalizada = $tarea->fecha_hora_terminado;


if($fecha_finalizada):

	$fecha_fin = explode(' ', $fecha_finalizada);
	$hora_fin = substr($fecha_fin[1],0,5);
	$f_fin = explode('-', $fecha_fin[0]);
	
	$dia_fin = $f_fin[2];
	$mes_fin = soloMes($f_fin[1]);
	$anio_fin = $f_fin[0];
		
	if( ($t_creador==1) && ($t_destino==1) ):

		$string_fecha_fin = "Tarea completada el $dia_fin de $mes_fin de $anio_fin a las $hora_fin";
		$color = 'success';
		$msg = $string_fecha_fin;
		$btn_compeltada = 'none';
	endif;

	if( ($t_creador==0) && ($t_destino==1) ):
		$string_fecha_fin = "Tarea enviada a revisión el $dia_fin de $mes_fin de $anio_fin a las $hora_fin";
		$color = 'success';
		$msg = $string_fecha_fin;
		$btn_compeltada = 'none';
	endif;

else:
	
	$dias_restantes = dias_restantes($tarea->fecha_limite);
	$dias_restantes = abs($dias_restantes);

	$btn_compeltada = 'inline';
	
	$dia_no = 'días';
	$color = 'danger';
	
	if($dias_restantes==1):
		$color = 'danger';
		$dia_no = 'día';
	elseif($dias_restantes==2):
		$color = 'warning';
	elseif($dias_restantes>2):
		$color = 'info';
	endif;
	
	$f_lim = explode('-', $tarea->fecha_limite);
	$dia_lim = $f_lim[2];
	$mes_lim = soloMes($f_lim[1]);
	$anio_lim = $f_lim[0];
	
	$hoy = date('Y-m-d');
	$fecha_limite = $tarea->fecha_limite;
	
	if(strtotime($hoy)<strtotime($fecha_limite)):
		$en = "en $dias_restantes $dia_no";
	elseif(date('Y-m-d')==$tarea->fecha_limite):
		$en = "Hoy";			
	else:
		if($dias_restantes==1):
			$en = "Atraso de $dias_restantes día";
		else:
			$en = "Atraso de $dias_restantes días";
		endif;
	endif;
	
	$msg = "Fecha de Entrega: $dia_lim de $mes_lim de $anio_lim ($en)";
	
endif;

########### TERMINA A LA VERGA COMPA. ###########


if($soyremite==1):

	$btn_compeltada = 'none';
	
endif;

$sql = "SELECT*FROM adjuntos WHERE id_tarea = $id_tarea AND id_comentario = 0";
$q = mysql_query($sql);
$adjuntos = array();

while($archivo = mysql_fetch_object($q)):
	$adjuntos[] = $archivo;
endwhile;

$hay_adjuntos = count($adjuntos);

$sql = "SELECT comentarios.*, usuarios.nombre FROM comentarios LEFT JOIN usuarios ON usuarios.id_usuario = comentarios.id_usuario WHERE id_tarea = $id_tarea ORDER BY fecha_hora ASC";
$q = mysql_query($sql);
$comentarios = array();

while($comment = mysql_fetch_object($q)):
	$comentarios[] = $comment;
endwhile;

$hay_comentarios = count($comentarios);

$fechaHoraComentario = function ($fecha_hora){
	
	$ar = explode(' ', $fecha_hora);
	
	$f = $ar[0]; $h = $ar[1];

	$fecha = fechaLetraAltAnio($f);
	$hora = horaInput($h);
	
	return ucwords(strtolower($fecha)).' · '.strtolower($hora);	

}

?>

<style>
.item-label{
color: #96a5aa !important;
font-size: 13px !important;
}
.item-body{
color: #666 !important;
}
</style>
<script>

$(function() {
/*
Para enviar el comentario.
	App.blockUI(
		{
            message: 'Cargando...'
        }
	);
*/

	$('#enviar_comentario').click(function() {
		
		var comentario =  $.trim($('#mensaje').val());

		if(!comentario){
			return false;
		}
		
		
		App.blockUI(
			{
	            message: 'Enviando comentario...'
	        }
		);
		

		
		$.post('ac/nuevo_comentario.php','comentario='+comentario+'&id_tarea=<?= $id_tarea ?>',function(data) {
		
			if(data==1){
				
				window.location.reload();
				
			}else{
				
				App.UnblockUI();
				alert(data);
				
			}
			
		
		});
		
		
	
	});

	$('#completada').click(function() {
		
		$.get('ac/marcar_completada.php','id_tarea=<?=$id_tarea?>',function(data) {

			if(data==1){
				window.location = 'index.php?Modulo=Tareas';
			}else{
				alert(data);
			}
			
		});
		
	
	});

});			
			
</script>


<div class="col-md-9"> 
	<div class="inbox-body">
		<div class="inbox-header inbox-view-header">
			<h1 class="pull-left">
				<?= $proyecto ?> <?= $tarea->asunto ?>
			
			</h1>
			<div class="pull-right">
	        	<span class="badge badge-<?= $class ?>">
				<?= $prioridad ?>
			</span>
	    	</div>
		</div>

		<div class="inbox-content">
	 <!-- empieza cont -->
	 
			<div class="inbox-view-info">
			    <div class="row">
			        <div class="col-md-12">
			            <img src="http://localhost/evisur/assets/pages/media/users/avatar6.jpg" class="inbox-author">
			            Por <span class="sbold"><?= mayus($remitente->nombre) ?> </span> · 
			            <span class="sbold"><?= $string_fecha ?></span> a las <?= $hora ?>
			        </div>
			    </div>
			</div>
	
			<div class="inbox-view">
				<div class="alert alert-<?= $color ?>">
					<?= $msg ?>
				</div>                                                            
			    <p style="font-size: 16px;line-height: 30px"><?= $tarea->descripcion ?> 
			    </p>
			</div>
			
			<p style="display:<?=$btn_compeltada?>"><br/><a role="button" id="completada" class="btn green"><i class="fa fa-check"></i>Marcar como Completada</a></p>
						
<?
if($hay_adjuntos):	
?>
			<hr>
			<div class="inbox-attached">
			    <div class="margin-bottom-10">
			        <span class="item-body">Archivos adjuntos: </span>
			    </div>
			    <div>
					<strong>
<?
	foreach($adjuntos as $adjunto):
?>
						<a href="files/<?= $adjunto->archivo ?>" target="_blank">
							<?= $adjunto->archivo ?>
							</a><br/>
<?
	endforeach;
?>
					</strong>
			    </div>
			</div>
<?
endif;	
?>	

	<!-- empiezan comentarios display.jpeg -->
	
			<hr>
	
			<div class="">
			    <div class="portlet-title">
			        <div class="caption caption-md">
			            <i class="icon-bar-chart font-dark hide"></i>
			            <span class="caption-subject font-green-steel bold uppercase">Comentarios</span>
			            <span class="caption-helper"></span>
			        </div>
			    </div>
			    <div class="portlet-body">
			        <div data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
			            <div class="general-item-list">


<?
if($hay_comentarios):	

	foreach($comentarios as $comentario):
		
		if($comentario->id_usuario==0):
			$nombre = 'Evisur App';
			$foto = 'display.jpeg';
			$badge = '<span class="badge badge-empty badge-danger"></span></span>';
		else:
			$nombre = $comentario->nombre;
			$badge = '<span class="badge badge-empty badge-success"></span>';
			$foto = 'assets/pages/media/users/avatar6.jpg';

		endif;
?>

				            
			                <div class="item">
			                    <div class="item-head">
			                        <div class="item-details">
			                            <img class="item-pic rounded" src="http://localhost/evisur/<?= $foto ?>">
			                            <span class="item-name primary-link"><?= mayus($nombre) ?></span>
			                            <span class="item-label"><?= $fechaHoraComentario($comentario->fecha_hora) ?></span>
			                        </div>
			                        <span class="item-status">
			                            <?= $badge ?>
			                        </span>
			                    </div>
			                    <div class="item-body" style="margin-left: 50px"> <?= $comentario->comentario ?> </div>
			                </div>

<?
	endforeach;

else:
?>	
	<br>No hay comentarios.	
<?
endif;	
?>


			            </div>
			        </div>
			    </div>
			</div>
	
			<div class="portlet light ">
				<div class="portlet-title">
					<div class="caption caption-md">
						<i class="icon-bar-chart font-dark hide"></i>
						<span class="caption-subject font-green-steel bold uppercase">Nuevo Comentario</span>
					</div>
				</div>
	        
				<div class="portlet-body">
					<div class="general-item-list">
						<textarea class="inbox-editor  form-control" name="mensaje" id="mensaje" rows="6" placeholder="Escriba un comentario..."></textarea>
						<p><br/><a role="button" class="btn green" id="enviar_comentario"><i class="fa fa-check"></i>Enviar</a></p>
					</div>
				</div>
			</div>
                                                
<!-- Termina inbox body y col-md-9 -->		
		</div>
	</div>
</div>
