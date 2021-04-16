<?php
include("conexion.php");
session_start();
	$usuario = $_SESSION['username'];
	
		if (!isset($usuario)){
			header("location: login.php");
		}else{

?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de Lectura Abonados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<style>
		.content {
			margin-top: 80px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('cnav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Lista de Abonados</h2>
			<hr />

			<?php
			if(isset($_GET['aksi']) == 'delete'){
				// escaping, additionally removing everything that could be (html/javascript-) code
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				$cek = mysqli_query($con, "SELECT * FROM lectura WHERE codigo='$nik'");
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}else{
					$delete = mysqli_query($con, "DELETE FROM lectura WHERE codigo='$nik'");
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<!-- <form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtros de datos de clientes</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Activo</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Inactivo</option>
                        <option value="3" <?php if($filter == 'Outsourcing'){ echo 'selected'; } ?>>Cancelado</option>
					</select>
				</div>
			</form> -->

			<form class="form-inline" method="get">
				<div class="form-group">
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Facturas</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="0" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>></option>
						<option value="1" <?php if($filter == 'Tetap'){ echo 'selected'; } ?>>Pendiente</option>
						<option value="2" <?php if($filter == 'Kontrak'){ echo 'selected'; } ?>>Pagado</option>
                      
					</select>
				</div>
			</form>

			<br />
			<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Lectura</th>
                    <th>No</th>
					<th>Código</th>
					<th>Nombre</th>
                    <th>Nº Contador</th>
                    <th>Fec. Lectura</th>
					<!-- <th>Teléfono</th> -->
					<th>Lectura</th>
				<!--	<th>Imagen</th> -->
					<th>Estado</th>
				    <th>Acciones</th>
				</tr>
				<?php
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM lectura WHERE estado='$filter' ORDER BY codigo ASC");
				}else{
					$sql = mysqli_query($con, "SELECT * FROM lectura ORDER BY codigo ASC");
				}
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					$no = 1;
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>
							<a href="lectura.php?nik='.$row['codigo'].'" title="Lectura de Contador" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span></a>
							</td>
							<td>'.$no.'</td>
							<td>'.$row['codigo'].'</td>
							<td><a href="cprofile.php?nik='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
                            <td>'.$row['puesto'].'</td>
                            <td>'.$row['fecha_nacimiento'].'</td>
					
                            <td>'.$row['direccion'].'</td>

							
							
							

							<td>';
							if($row['estado'] == '1'){
								echo '<span class="label label-warning">Pendiente</span>';
							}
                            else if ($row['estado'] == '2' ){
								echo '<span class="label label-success">Pagado</span>';
							}
                            else if ($row['estado'] == '3' ){
								echo '<span class="label label-warning">Cancelado</span>';
							}
						echo '
							</td>
							
							

							
							<td>

								<a href="cedit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="clientes.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
						$no++;
					}
				}

				?>
			</table>
			</div>
		</div>
	</div><center>

	<?php
		echo "<h3> $usuario </h3>";
	}
	?>

	<p>&copy; Sistemas Web <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
