<?php
session_start();
//$url=$_SERVER['HTTP_REFERER'];
//$_SESSION["url"]=$url;
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

//recepción de datos enviados mediante POST desde ajax
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$nueva = (isset($_POST['nueva'])) ? $_POST['nueva'] : '';
$repetir = (isset($_POST['repetir'])) ? $_POST['repetir'] : '';

$pass = $password;//md5($password); //encripto la clave enviada por el usuario para compararla con la clava encriptada y almacenada en la BD

$consulta = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$pass' ";

$resultado = $conexion->prepare($consulta);
$resultado->execute();

if($resultado->rowCount() >= 1){
    $consulta = "UPDATE usuarios SET password='$nueva' WHERE usuario='$usuario'";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


 
    $_SESSION["s_usuario"] = $usuario;
}else{
    $_SESSION["s_usuario"] = null;
    $data=null;
}


print json_encode($data);
$conexion=null;
