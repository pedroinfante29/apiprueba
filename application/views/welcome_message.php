<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap.min.css">
<hr>
<section class="content" style="padding-left: 3%;">
	<div class="row">
		<div class="col-md-11">
			<table id="example" class="table table-striped table-bordered">
				<thead>
				<tr>
					<th>nombre</th>
					<th>apellidos</th>
					<th>telefono</th>
					<th>email</th>
					<th>pais</th>
					<th>ciudad</th>
					<th>fechaviaje</th>
					<th>acciones</th>
				</tr>
				</thead>
				<tbody>
				<?php
					if(isset($datos)){
					foreach ($datos as $reporte)
					{
						echo "
                          <tr>				
							<td>".$reporte['nombre']."</td>
							<td>".$reporte['apellidos']."</td>
							<td>".$reporte['telefono']."</td>
							<td>".$reporte['email']."</td>
							<td>".$reporte['pais']."</td>
							<td>".$reporte['ciudad']."</td>
							<td>".$reporte['fechaviaje']."</td>
							<td><a href='../welcome/deleteclientWeb?email=".$reporte['email']."' class='btn btn-success btn-danger'>Eliminar</a></td>
						</tr>
                      ";
					}
				}
				?>
				</tbody>
				<tfoot>
				<tr>
					<th>nombre</th>
					<th>apellidos</th>
					<th>telefono</th>
					<th>email</th>
					<th>pais</th>
					<th>ciudad</th>
					<th>fechaviaje</th>
					<th>acciones</th>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
</section>
</aside>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
<script>
	$(document).ready(function() {
		var table = $('#example').DataTable( {
			lengthChange: false,
			buttons: [ 'copy', 'excel', 'pdf', 'csv', 'colvis']
		} );

		table.buttons().container()
			.appendTo( '#example_wrapper .col-sm-6:eq(0)' );
	} );
</script>

