<?php

require '../conexion.php';

session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];


$query = "SELECT COUNT(*) as contar from empleados where usuario = '$usuario' and clave = '$clave' ";
$consulta = mysqli_query($con, $query);
$array = mysqli_fetch_array($consulta);

if($array['contar']>0){
    $_SESSION['username'] = $usuario;
    header("location: ../clientes.php");
    }else{
        echo "Datos por la banana";
        header("location: ../index.php");
    }

?>