<?
$tipo = $_GET['tipo']; //Recibidas Enviadas;
?>
<table class="table table-striped table-advance table-hover">
    <thead>
        <tr>
            <th colspan="3">

            </th>
            <th class="pagination-control" colspan="3">
                <div class="btn-group input-actions">
                    <a class="btn btn-sm blue btn-outline dropdown-toggle sbold" href="javascript:;" data-toggle="dropdown"> Filtrar
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-pencil"></i> Ver Pendientes </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-ban"></i> Ver Completadas </a>
                        </li>
                    </ul>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr class="unread" data-messageid="1">
            <td class="inbox-small-cells">
            </td>
            <td class="inbox-small-cells">
                <i class="fa fa-star"></i>
            </td>
            <td class="view-message hidden-xs"> Oscar Vivanco</td>
            <td class="view-message "> Licencia de construcción de Bosques de Lago</td>
            <td class="view-message inbox-small-cells">
                 <span class="badge badge-danger">ALTA</span>
            </td>
            <td class="view-message text-right"> 16:30 PM </td>
        </tr>

        <tr data-messageid="3">
            <td class="inbox-small-cells">
            </td>
            <td class="inbox-small-cells">
            </td>
            <td class="view-message hidden-xs"> Daniel Bass </td>
            <td class="view-message"> Pagar la Luz </td>
			<td class="view-message inbox-small-cells">
				<span class="badge badge-success">BAJA</span>
			</td>
            <td class="view-message text-right"> Octubre 16 </td>
        </tr>

        <tr data-messageid="3">
            <td class="inbox-small-cells">

            </td>
            <td class="inbox-small-cells">
            </td>
            <td class="view-message hidden-xs"> Luis Matos </td>
            <td class="view-message"> Agendar cita con compradores </td>
			<td class="view-message inbox-small-cells">
				<span class="badge badge-warning">MEDIA</span>
			</td>
            <td class="view-message text-right"> Octubre 19 </td>
        </tr>
 
    </tbody>
</table>