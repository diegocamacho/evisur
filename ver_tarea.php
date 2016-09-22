<? 
extract($_GET);

$id_tarea = $tarea;
$sql = "
SELECT tareas.*,proyectos.proyecto 
FROM tareas 
LEFT JOIN proyectos ON proyectos.id_proyecto = tareas.id_proyecto
WHERE tareas.id_tarea = $tarea AND (id_remite = $s_id_usuario OR id_destino = $s_id_usuario)
";

$q = mysql_query($sql);
$tarea = mysql_fetch_object($q);

if($s_id_usuario==$tarea->id_remite):
	$soyremite = 1;
	$soydestino = 0;
else:
	$soyremite = 0;
	$soydestino = 1;
endif;

if($tarea->proyecto): 
	$proyecto = '['.$tarea->proyecto.']'; 
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

$fecha_c = $tarea->fecha_hora_creacion;
$fecha_c = explode(' ', $fecha_c);

$hora = substr($fecha_c[1],0,5);
$f_ex = explode('-', $fecha_c[0]);


$dia = $f_ex[2];
$mes = soloMes($f_ex[1]);
$anio = $f_ex[0];

$string_fecha = "$dia de $mes de $anio";

$id_remite = $tarea->id_remite;

$sql = "SELECT*FROM usuarios WHERE id_usuario = $id_remite";
$q = mysql_query($sql);
$remitente = mysql_fetch_object($q);

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
		$dias_restantes = abs($dias_restantes);
		if($dias_restantes==1):
			$en = "Atraso de $dias_restantes día";
		else:
			$en = "Atraso de $dias_restantes días";
		endif;
	endif;
	
	$msg = "Fecha de Entrega: $dia_lim de $mes_lim de $anio_lim ($en)";
	
endif;


if($soyremite==1):

	$btn_compeltada = 'none';
	
endif;



function dias_restantes($fecha_final) {
	$fecha_actual = date("Y-m-d");
	$s = strtotime($fecha_final)-strtotime($fecha_actual);
	$d = intval($s/86400);
	$diferencia = $d;
	return $diferencia;
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
<div class="col-md-9"> 
	<div class="inbox-body">
		<div class="inbox-header inbox-view-header">
			<h1 class="pull-left">
				<?= $proyecto ?> <?= $tarea->asunto ?>
			<span class="badge badge-<?= $class ?>">
				<?= $prioridad ?>
			</span>
			</h1>
			<div class="pull-right">
	        	<!--
		        <a href="javascript:;" class="btn btn-icon-only dark btn-outline"><i class="fa fa-print"></i></a>
				-->
	    	</div>
		</div>


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
		
<script>

$(function() {

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
<!--
		<hr>
		
		<div class="inbox-attached">
		    <div class="margin-bottom-10">
		        <span class="item-body">Archivos adjuntos: </span>
		    </div>
		    <div>
				<strong>
					<a href="javascript:;">DOCUMENTO EN ZIP (1).docx</a><br/>
					<a href="javascript:;">Balanza VIVANCO.xlsx</a>
				</strong>
		    </div>
		</div>
		-->
<!-- empiezan comentarios -->

<hr>
<!--
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
			            
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/display.jpeg">
		                            <a href="" class="item-name primary-link">Evisur App</a>
		                            <span class="item-label">11 Oct 16 · 16:40</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-danger"></span></span>
		                    </div>
		                    <div class="item-body"> Tarea leída por Sharon Vivanco. </div>
		                </div>
		                
		                
			            
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/assets/pages/media/users/avatar6.jpg">
		                            <a href="" class="item-name primary-link">Sharon Vivanco</a>
		                            <span class="item-label">3 hrs ago</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-success"></span> </span>
		                    </div>
		                    <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </div>
		                </div>
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/assets/pages/media/users/avatar6.jpg">
		                            <a href="" class="item-name primary-link">Oscar Vivanco</a>
		                            <span class="item-label">5 hrs ago</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-warning"></span></span>
		                    </div>
		                    <div class="item-body"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat tincidunt ut laoreet. </div>
		                </div>
		
		                <div class="item">
		                    <div class="item-head">
		                        <div class="item-details">
		                            <img class="item-pic rounded" src="http://localhost/evisur/display.jpeg">
		                            <a href="" class="item-name primary-link">Evisur App</a>
		                            <span class="item-label">hace 10 minutos</span>
		                        </div>
		                        <span class="item-status">
		                            <span class="badge badge-empty badge-danger"></span></span>
		                    </div>
		                    <div class="item-body"> Tarea reabierta por Oscar Vivanco. </div>
		                </div>
		
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
				<textarea class="inbox-editor  form-control" name="mensaje" rows="6" placeholder="Escriba un comentario..."></textarea>
				<p><br/><a role="button" class="btn green"><i class="fa fa-check"></i>Enviar</a></p>
			</div>

	</div>
</div>
-->                                      
                                                
<!-- Termina inbox body y col-md-9 -->		
	</div>
</div>
