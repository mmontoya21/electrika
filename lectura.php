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
Project      : Datos de Clientes con PHP, MySQLi y Bootstrap CRUD  (Create, read, Update, Delete) 

-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de Lecturas Abonados</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	</head>

<style>
	.imagenb {
	background-image: url('image/contador.jpg');
  	background-repeat: no-repeat;
	background-size: 100%;
	
	}

	/* .form-horizontal{
		-webkit-filter: contrast(100%);
    filter: contrast(100%);
	} */
</style>


<body >



	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("nav.php");?>
	</nav>
	<div class="container imagenb">
		<div class="content">
			


			<h2>Abonados &raquo; Lectura de Contador</h2>
			<hr />
			
			<?php
			// Base de datos a consultar
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($con, "SELECT * FROM lectura WHERE codigo='$nik'");
			$row2 = mysqli_fetch_assoc($sql);

			// Base de Datos Principal y para guardar
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			$sql = mysqli_query($con, "SELECT * FROM clientes WHERE codigo='$nik'");
			
			if(mysqli_num_rows($sql) == 0){
				header("Location: clientes.php");
			}else{
				$row = mysqli_fetch_assoc($sql);
			}
			
			if(isset($_POST['add'])){
				$codigo		     = mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));//Escanpando caracteres 
				$nombres		     = mysqli_real_escape_string($con,(strip_tags($_POST["nombres"],ENT_QUOTES)));//Escanpando caracteres 
				$fecha_nacimiento	 = mysqli_real_escape_string($con,(strip_tags($_POST["fecha_nacimiento"],ENT_QUOTES)));
				$direccion	     = mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 
				$puesto		 = mysqli_real_escape_string($con,(strip_tags($_POST["puesto"],ENT_QUOTES)));//Escanpando caracteres 
				$estado		 = mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres 
				
				$codigo = $codigo + rand();
				
				/*/ GUARDAR EN LECTURA COMO NUEVA LECTURA DEL MES **/
				$cek = mysqli_query($con, "SELECT * FROM lectura WHERE codigo='$codigo'");
				$fotoLectura			 = addslashes(file_get_contents($_FILES["fotoLectura"]["tmp_name"]));
				if(mysqli_num_rows($cek) == 0){
						$insert = mysqli_query($con, "INSERT INTO lectura (codigo, nombres, fecha_nacimiento, direccion, puesto, estado, fotoLectura)
														 	      VALUES('$codigo', '$nombres', '$fecha_nacimiento',' $direccion', '$puesto', '$estado', '$fotoLectura')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
					 
				}else{
					// echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. código exite!</div>';
					$insert = mysqli_query($con, "INSERT INTO lectura (codigo, nombres, fecha_nacimiento, direccion, puesto, estado, fotoLectura)
															VALUES('$codigo','$nombres','$fecha_nacimiento', $direccion', '$puesto', '$estado'. '$fotoLectura')") or die(mysqli_error());
						if($insert){
							echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bien hecho! Los datos han sido guardados con éxito.</div>';
						}else{
							echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error. No se pudo guardar los datos !</div>';
						}
				}
			}
			
			// if(isset($_GET['pesan']) == 'sukses'){
			// 	echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			// }
			?>
			
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				
				<!-- <div class="form-group">
					<label class="col-sm-3 control-label">Nombre</label>
					<div class="col-sm-2">
						<input type="text" name="nombres1" value="<?php echo $row2 ['nombres']; ?>" class="form-control" placeholder="Nombres" readonly=»readonly»>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Código</label>
					<div class="col-sm-2">
						<input type="text" name="codigo1" value="<?php echo $row2 ['codigo']; ?>" class="form-control" placeholder="NIK" readonly=»readonly»>
					</div>
				</div> -->
				
				<div class="form-group">
					<label class="col-sm-3 control-label">Código</label>
					<div class="col-sm-2">
						<input type="text" name="codigo" value="<?php echo $row ['codigo']; ?>" class="form-control" placeholder="NIK" readonly=»readonly»>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Nombres</label>
					<div class="col-sm-4">
						<input type="text" name="nombres" value="<?php echo $row ['nombres']; ?>" class="form-control" placeholder="Nombres" readonly=»readonly»>
					</div>
				</div>
							
				<div class="form-group">
					<label class="col-sm-3 control-label">Nº Contador</label>
					<div class="col-sm-3">
						
						<input type="text" name="puesto" value="<?php echo $row ['puesto']; ?>" class="form-control" placeholder="Nº Contador" readonly=»readonly»>
					</div>
					</div>

				<div class="form-group">
					<label class="col-sm-3 control-label">Fecha de Lectura</label>
					<div class="col-sm-4">
						<input type="text" name="fecha_nacimiento" value="<?php echo $row ['fecha_nacimiento']; ?>" class="input-group date form-control" date="" data-date-format="yyyy-mm-dd" placeholder="0000-00-00" required>
					</div>
				</div>

				
				<!-- <div class="form-group">
					<label class="col-sm-3 control-label">Nº Contador</label>
					<div class="col-sm-3">
						
						<input type="text" name="puesto" value="<?php echo $row ['puesto']; ?>" class="form-control" placeholder="Puesto" required readonly=»readonly»>
					</div>
                </div> -->

				<div class="form-group">
					<label class="col-sm-3 control-label">Lectura</label>
					<div class="col-sm-3">
						<textarea name="direccion" class="form-control" placeholder="Lectura del mes"><?php echo $row ['direccion']; ?></textarea>
					</div>
				</div>

				<!-- Imagen -->
				<!-- <div class="form-group">
					<label class="col-sm-3 control-label">Lectura</label>
					<div class="col-sm-3">
						<input type="text" name="estado" class="form-control" placeholder="Lectura del mes" required>
					</div>
				</div> -->
				<!-- Imagen -->

				<div class="form-group">
					<label class="col-sm-3 control-label">Estado del Servicio</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<!-- <option value=""> ----- </option> -->
                           <option value="1">Pendiente</option>
							<option value="2">Pagado</option>
						</select>
					</div>
				</div>


				<!-- Imagen -->
				<div class="form-group">
					<label class="col-sm-3 control-label">Imagen Contador</label>
					<div class="col-sm-3" >
				
						<input type="file" name="fotoLectura" accept="image/*" required >
				
					</div>
				</div>
				<!-- Imagen -->


				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<input type="submit" name="add" class="btn btn-sm btn-primary" value="Guardar datos">
						<a href="clientes.php" class="btn btn-sm btn-danger">Cancelar</a>
						<a href="clectura.php" class="btn btn-sm btn-warning">Ver Lecturas</a>
					</div>
				</div>
			</form>
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
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>
</body>
</html>