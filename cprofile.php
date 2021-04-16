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
<!--


-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de Cliente</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("cnav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del Cliente &raquo; Perfil</h2>
			<hr />
			
			<?php
			// escaping, additionally removing everything that could be (html/javascript-) code
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			
			$sql = mysqli_query($con, "SELECT * FROM clientes WHERE codigo='$nik'");
			if(mysqli_num_rows($sql) == 0){
				header("Location: clientes.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			
			if(isset($_GET['aksi']) == 'delete'){
				$delete = mysqli_query($con, "DELETE FROM clientes WHERE codigo='$nik'");
				if($delete){
					echo '<div class="alert alert-danger alert-dismissable">><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Datos borrados exitosamente.</div>';
				}else{
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>No se pudieron borrar los datos.</div>';
				}
			}
			?>
			
			<table class="table table-striped table-condensed">
				<tr>
					<th></th>
					
					<style type="text/css">
  					.img {
						max-width: 80%;
					  }
					</style>

					<td>
					<?php 
					echo' <img class="img" src="data:image/jpeg;base64,'.base64_encode ($row["fotoContador"]).'" alt="Contador"/>';
					 ?>
					</td>

				</tr>
				<tr>
					<th width="20%">Código</th>
					<td><?php echo $row['codigo']; ?></td>
				</tr>
				<tr>
					<th>Nombre del Cliente</th>
					<td><?php echo $row['nombres']; ?></td>
				</tr>
				<tr>
					<th>Fecha de Activación</th>
					<td><?php echo $row['lugar_nacimiento'].', '.$row['fecha_nacimiento']; ?></td>
				</tr>
				<tr>
					<th>Dirección</th>
					<td><?php echo $row['direccion']; ?></td>
				</tr>
				<tr>
					<th>Teléfono</th>
					<td><?php echo $row['telefono']; ?></td>
				</tr>
				<tr>
					<th>Nº Contador</th>
					<td><?php echo $row['puesto']; ?></td>
				</tr>
				<tr>
					<th>Estado</th>
					<td>
						<?php 
							if ($row['estado']==1) {
								echo "Inactivo";
							} else if ($row['estado']==2){
								echo "Activo";
							} else if ($row['estado']==3){
								echo "Cancelado";
							}
						?>
					</td>
				</tr>
				
			</table>
			
			<a href="clientes.php" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Regresar</a>
			<a href="cedit.php?nik=<?php echo $row['codigo']; ?>" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar datos</a>
			<a href="cprofile.php?aksi=delete&nik=<?php echo $row['codigo']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Esta seguro de borrar los datos <?php echo $row['nombres']; ?>')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</a>
		</div>
	</div>
	<center>
	<?php
		echo "<h3> $usuario </h3>";
	}
	?>

<p>&copy; Sistema Web Electrika <?php echo date("Y") ;?></p
</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>