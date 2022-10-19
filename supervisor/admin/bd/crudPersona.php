<?php

include_once '../../../bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
// Recepción de los datos enviados mediante POST desde el JS   

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$apellido = (isset($_POST['apellido'])) ? $_POST['apellido'] : '';
$dni = (isset($_POST['dni'])) ? $_POST['dni'] : '';
$dominio = (isset($_POST['dominio'])) ? $_POST['dominio'] : '';
$marca = (isset($_POST['marca'])) ? $_POST['marca'] : '';
$modelo = (isset($_POST['modelo'])) ? $_POST['modelo'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';


switch ($opcion) {
    case 1: //alta
        $consulta = "SELECT * FROM persona";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $dat) {
            //echo "id:".$dat['id'];
            // echo "<br>";
            // $long =strlen($dat['id']);
            $ultimoId = $dat['id'];
        }
        //echo "<br>";
       // echo "ultimo id : " . $ultimoId;
       // echo "<br>";
        $nuevoId = $ultimoId + 1;
        $numeroConCeros = str_pad($nuevoId, 6, "0", STR_PAD_LEFT);

        $consulta = "INSERT INTO persona (id, nombre, apellido, dni, dominio, marca, modelo) VALUES('$numeroConCeros', '$nombre', '$apellido', '$dni', '$dominio', '$marca', '$modelo') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT id, nombre, apellido, dni, dominio, marca, modelo FROM persona ORDER BY id DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2: //modificación
        //exit;
        $numeroConCeros = str_pad($id, 6, "0", STR_PAD_LEFT);
        $consulta = "UPDATE persona SET nombre='$nombre', apellido='$apellido', dni='$dni', dominio='$dominio', marca='$marca', modelo='$modelo' WHERE id='$numeroConCeros' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $consulta = "SELECT id, nombre, apellido, dni, dominio, marca, modelo FROM persona WHERE id='$numeroConCeros' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3: //baja
        $consulta = "UPDATE persona SET activo=1 WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $consulta = "SELECT id, nombre, apellido, dni FROM persona WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
