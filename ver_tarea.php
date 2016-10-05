<?php  
	
extract($_GET); 
$id_tarea = $tarea;
$hoy_fecha_hora = date('Y-m-d H:i:s');
$sql = "
SELECT tareas.*,proyectos.proyecto 
FROM tareas 
LEFT JOIN proyectos ON proyectos.id_proyecto = tareas.id_proyecto
WHERE tareas.id_tarea = $tarea AND (id_remite = $s_id_usuario OR id_destino = $s_id_usuario)";

$q = mysql_query($sql);
$tarea = mysql_fetch_object($q);

$t_creador = 		$tarea->terminado_creador;
$t_destino = 		$tarea->terminado_destino;
$fecha_limite = 	$tarea->fecha_limite;
$fecha_finalizada = $tarea->fecha_hora_terminado;
$fecha_c = 			$tarea->fecha_hora_creacion;

$destino_completada = 'none';
$remite_finaliza = 'none';
$remite_reabrir = 'none';
						

$sql = "SELECT*FROM usuarios WHERE id_usuario = {$tarea->id_remite}"; 
$q = mysql_query($sql);
$remitente = mysql_fetch_object($q);

$sql = "SELECT*FROM usuarios WHERE id_usuario = {$tarea->id_destino}"; 
$q = mysql_query($sql);
$destino = mysql_fetch_object($q);

if($s_id_usuario==$tarea->id_remite):	
	$soyremite = 1;
	$soydestino = 0;
else:
	$soyremite = 0;
	$soydestino = 1;
endif;


if($soyremite):

	if( ($t_creador==0) && ($t_destino==1) ):
		$remite_finaliza 	= 'inline';
		$remite_reabrir		= 'inline';
	endif;

	$por_para = 'Para';
	$nombre_aqui = mayus($destino->nombre);
	$foto_remite_destino = $destino->foto;

endif;

if($soydestino):
	
	if(	($t_creador==0) && ($t_destino==0) ):
		$destino_completada = 'inline';
	endif;
	
	if($tarea->leido==0):

		$sql = "UPDATE tareas SET leido = 1 WHERE id_tarea = $id_tarea";
		$q = mysql_query($sql);
		
		$mensaje_bot = mayus($destino->nombre).' ha leído esta tarea.';
		$sql = "INSERT INTO comentarios (id_tarea,fecha_hora,comentario)VALUES('$id_tarea','$hoy_fecha_hora','$mensaje_bot')";
		$q = mysql_query($sql);

	endif;
	
	$por_para = 'Por';
	$nombre_aqui = mayus($remitente->nombre);
	$foto_remite_destino = $remitente->foto;

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


$fecha_c = explode(' ', $fecha_c);

$hora = substr($fecha_c[1],0,5);
$f_ex = explode('-', $fecha_c[0]);

$dia = $f_ex[2];
$mes = soloMes($f_ex[1]);
$anio = $f_ex[0];

$string_fecha = "$dia de $mes de $anio";

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

	if($dias_restantes>0):
		$es_negativo = 1;
	endif;
	
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
	
	if($es_negativo):
		$color = 'danger';
	endif;
	
	$f_lim = explode('-', $tarea->fecha_limite);
	$dia_lim = $f_lim[2];
	$mes_lim = soloMes($f_lim[1]);
	$anio_lim = $f_lim[0];
	
	$hoy = date('Y-m-d');
	$fecha_limite = $tarea->fecha_limite;
	
	if(strtotime($hoy)<strtotime($fecha_limite)):
		
		if($dias_restantes==1):
			$en = "Mañana";
		else:
			$en = "en $dias_restantes días";
		endif;
				
	elseif(date('Y-m-d')==$tarea->fecha_limite):
		$en = "Hoy";			
	else:
		if($dias_restantes==1):
			$en = "Venció Ayer";
		else:
			$en = "Venció hace $dias_restantes días";
		endif;
	endif;
	
	$msg = "Fecha de Entrega: $dia_lim de $mes_lim de $anio_lim ($en)";
	
endif;

########### TERMINA A LA VERGA COMPA. ###########

$sql = "SELECT*FROM adjuntos WHERE id_tarea = $id_tarea AND id_comentario = 0";
$q = mysql_query($sql);
$adjuntos = array();

while($archivo = mysql_fetch_object($q)):
	$adjuntos[] = $archivo;
endwhile;

$hay_adjuntos = count($adjuntos);

$sql = "SELECT comentarios.*, usuarios.nombre,usuarios.foto FROM comentarios LEFT JOIN usuarios ON usuarios.id_usuario = comentarios.id_usuario WHERE id_tarea = $id_tarea ORDER BY fecha_hora ASC";
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
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: 'upload.php',
            autoUpload: true
        });
        
        $('#fileupload').bind('fileuploadprogressall', function (e, data) {
        	$('#enviar_comentario').hide();
        });

        $('#fileupload').bind('fileuploaddone', function (e, data) {
	       	$('#enviar_comentario').show();
        });
        
        

	$('#enviar_comentario').click(function() {
		
		var comentario =  $.trim($('#mensaje').val());

		if(!comentario){
			return false;
		}
		
		App.blockUI({
	            message: 'Enviando comentario...'
	    });
		
		var datos = $('#fileupload').serialize();
		$.post('ac/nuevo_comentario.php',datos+'&id_tarea=<?= $id_tarea ?>',function(data) {
			if(data==1){
				window.location.reload();
			}else{
				App.UnblockUI();
				alert(data);
			}
		});
	});

	$('#destino_completada').click(function() {
		
		App.blockUI({
	            message: 'Enviando a Revisión...'
	    });
	    
		$.get('ac/marcar_completada.php','id_tarea=<?=$id_tarea?>',function(data) {
			if(data==1){
				window.location.reload();
			}else{
				App.UnblockUI();
				alert(data);
			}
		});	
	});
	
	$('#remite_termina').click(function() {
		
		App.blockUI({
	            message: 'Cerrando Tarea...'
	    });
	    
		$.get('ac/marcar_finalizada.php','id_tarea=<?=$id_tarea?>',function(data) {
			if(data==1){
				window.location.reload();
			}else{
				App.UnblockUI();
				alert(data);
			}
		});	
	});
	
	$('#remite_reabre').click(function() {
		
		App.blockUI({
	            message: 'Reabriendo Tarea...'
	    });
	    
		$.get('ac/marcar_reabrir.php','id_tarea=<?=$id_tarea?>',function(data) {
			if(data==1){
				window.location.reload();
			}else{
				App.UnblockUI();
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
			            <img height="30" src="files/<?= $foto_remite_destino ?>" class="inbox-author">
			            <?=$por_para?> <span class="sbold"><?= $nombre_aqui ?> </span> · 
			            <span class="sbold"><?= $string_fecha ?></span> a las <?= $hora ?>
			        </div>
			    </div>
			</div>
	
			<div class="inbox-view">
				<div class="alert alert-<?= $color ?>">
					<?= $msg ?>
				</div>                                                            
			    <p style="font-size: 16px;"><?= $tarea->descripcion ?> 
			    </p>
			    			
			</div>
			
			<div class="" style="display:flex;margin:0px;padding:0px">
				
				<div class="pull-right" style="display: <?= $destino_completada ?>">
					<br/><a role="button" id="destino_completada" class="btn blue acccion"><i class="fa fa-check-square-o"></i> Enviar a Revisión</a>
				</div>
				<div class="pull-right" style="display: <?= $remite_finaliza ?>">
					<p><br/><a role="button" id="remite_termina"  class="btn green acccion"><i class="fa fa-check"></i> Tarea Completada</a></p>
				</div>&nbsp;&nbsp;&nbsp;&nbsp;
				
				<div class="pull-right" style="display: <?= $remite_reabrir ?>">
					<p><br/><a role="button" id="remite_reabre" class="btn red acccion"><i class="fa fa-times"></i>  Reabrir Tarea</a></p>
				</div>
				
			</div>
						
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
			$badge = '<span class="badge badge-empty badge-danger"></span></span>';
			$foto = 'bot_icon.png';
		else:
			$nombre = $comentario->nombre;
			$badge = '<span class="badge badge-empty badge-success"></span>';

				if($comentario->foto):	
					$foto = $comentario->foto;
				else:
					$foto = 'display.jpeg';		
				endif;
		endif;
				
		$sql = "SELECT*FROM adjuntos WHERE id_comentario = ".$comentario->id_comentario;
		$q = mysql_query($sql);
		$adjuntos_comentario = array();

		while($datos = mysql_fetch_object($q)):
			$adjuntos_comentario[] = $datos;
		endwhile;
		
		$hay_adjuntos_com = count($adjuntos_comentario);

?>

				            
			                <div class="item">
			                    <div class="item-head">
			                        <div class="item-details">
			                            <img class="item-pic rounded" src="files/<?= $foto ?>">
			                            <span class="item-name primary-link"><?= mayus($nombre) ?></span>
			                            <span class="item-label"><?= $fechaHoraComentario($comentario->fecha_hora) ?></span>
			                        </div>
			                        <span class="item-status">
			                            <?= $badge ?>
			                        </span>
			                    </div>
			                    <div class="item-body" style="margin-left: 50px"> <?= $comentario->comentario ?> 
								
<?
		if($hay_adjuntos_com):	
?>
							<br><br>
<?
			foreach($adjuntos_comentario as $adjunto_com):	
?>
							<a href="files/<?= $adjunto_com->archivo ?>" target="_blank">
							<?= $adjunto_com->archivo ?>
							</a><br/>
<? 
			endforeach;
		endif; ?>

							
			                    </div>
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
	
<form class="inbox-compose form-horizontal" id="fileupload" action="#" method="POST" enctype="multipart/form-data" style="border:0px">


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
					
    <div class="inbox-compose-attachment">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <span class="btn green btn-outline fileinput-button">
            <i class="fa fa-plus"></i>
            <span> Agregar archivos... </span>
            <input type="file" name="files[]" multiple> </span>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped margin-top-10">
            <tbody class="files"> </tbody>
        </table>
    </div>

					
					
				</div>
			</div>
			
<!-- Comienza Adjuntos--><!-- Comienza Adjuntos--><!-- Comienza Adjuntos--><!-- Comienza Adjuntos-->
<!-- Comienza Adjuntos--><!-- Comienza Adjuntos--><!-- Comienza Adjuntos--><!-- Comienza Adjuntos-->

    
    <!-- The blueimp Gallery widget -->
	<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
	    <div class="slides"> </div>
	    <h3 class="title"></h3>
	    <a class="prev"> ‹ </a>
	    <a class="next"> › </a>
	    <a class="close white"> </a>
	    <a class="play-pause"> </a>
	    <ol class="indicator"> </ol>
	</div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <script id="template-upload" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
    	<tr class="template-upload fade">
		    <td width="100">
		        <span class="preview"></span>
		    </td>
		    <td align="left" valign="top">
		        {%=file.name%}
		        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
		            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
		        </div>
		        <strong class="error text-danger label label-danger"></strong>
		        
		    </td>
		    <td width="150">
		        <p class="size">Processing...</p>
		    </td>
		    <td align="right" width="100"> {% if (!i && !o.options.autoUpload) { %}
		        <button class="btn blue start" disabled>
		            <i class="fa fa-upload"></i>
		            <span>Subir</span>
		        </button> {% } %} {% if (!i) { %}
		        <button class="btn red cancel">
		            <i class="fa fa-ban"></i>
		            <span>Cancelar</span>
		        </button> {% } %} </td>
		</tr> {% } %} </script>
        <!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl"> {% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade">
		        <td width="100">
			        <input type="hidden" name="archivos[]" value="{%=file.name%}" />
		            <span class="preview"> {% if (file.thumbnailUrl) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery>
		                    <img src="{%=file.thumbnailUrl%}">
		                </a> {% } %} </span>
		        </td>
		        <td align="left" valign="top">
		             {% if (file.url) { %}
		                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl? 'data-gallery': ''%}>{%=file.name%}</a> {% } else { %}
		                <span>{%=file.name%}</span> {% } %}  {% if (file.error) { %}
		            <div>
		                <span class="label label-danger">Error</span> {%=file.error%}</div> {% } %} </td>
		        <td width="150">
		            <span class="size" style="margin-top: 0px;">{%=o.formatFileSize(file.size)%}</span>
		        </td>
		        <td width="100" align="right"> {% if (file.deleteUrl) { %}
		            <button class="btn red delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}" {% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'
		                {% } %}>
		                <i class="fa fa-trash-o"></i>
		                <span>Borrar</span>
		            </button>
		            {% } else { %}
		            <button class="btn yellow cancel btn-sm">
		                <i class="fa fa-ban"></i>
		                <span>Cancelar</span>
		            </button> {% } %} </td>
		    </tr> {% } %} </script>

</form>

<!-- Termina Adjuntos --><!-- Termina Adjuntos --><!-- Termina Adjuntos --><!-- Termina Adjuntos -->
<!-- Termina Adjuntos --><!-- Termina Adjuntos --><!-- Termina Adjuntos --><!-- Termina Adjuntos -->
                                                
<!-- Termina inbox body y col-md-9 -->		
		</div>
	</div>
</div>
