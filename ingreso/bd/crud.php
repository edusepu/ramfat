<?php
session_start();
if($_SESSION["s_usuario"] === null){
    header("Location: login.php");
}
$idUsuario=$_SESSION["idUsuario"];

include_once '../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$idPersona = (isset($_POST['idPersona'])) ? $_POST['idPersona'] : '';
$puesto = (isset($_POST['puesto'])) ? $_POST['puesto'] : '';
date_default_timezone_set('America/Argentina/Buenos_Aires');
$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];
$mesConCeros = str_pad($month, 2, "0", STR_PAD_LEFT);
$diaConCeros = str_pad($date, 2, "0", STR_PAD_LEFT);
$horaConCeros = str_pad($hour, 2, "0", STR_PAD_LEFT);
$minutosConCeros = str_pad($min, 2, "0", STR_PAD_LEFT);
$segundosConCeros = str_pad($sec, 2, "0", STR_PAD_LEFT);
$current_date = "$year-$mesConCeros-$diaConCeros $horaConCeros:$minutosConCeros:$segundosConCeros";
$fechaHoy="$year-$mesConCeros-$diaConCeros";
$estado=0;
$consulta = "select estado from registro where idPersona='" . $idPersona . "' and horario LIKE '$fechaHoy%' order by id desc limit 1";
            
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataPuesto = $resultado->fetch(PDO::FETCH_ASSOC);
if  (isset($dataPuesto['estado'])){
if($dataPuesto['estado']==0){
    $estado=1;
} 
}

switch ($opcion) {
    case 1: //registro
        $consulta = "select id from persona where id='" . $idPersona . "'";            
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $dataP = $resultado->fetch(PDO::FETCH_ASSOC);
        if  (isset($dataP['id'])){
            $consulta = "INSERT INTO registro (idPersona, horario, puesto, usuario, estado) VALUES('$idPersona','$current_date','$puesto','$idUsuario','$estado')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        
            }
$consulta = "SELECT id, nombre, apellido, dni, dominio, marca, modelo, $estado as estado FROM persona where id='$idPersona'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        break;
    
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
