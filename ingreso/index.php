<?php
session_start();
//var_dump($_SESSION);
if($_SESSION["s_usuario"] === null){
    header("Location: login.php");
}

$_SESSION["puesto"]=(isset($_POST['puesto'])) ? $_POST['puesto'] : $_SESSION["puesto"];

$puesto=$_SESSION["puesto"];
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


$current_date = "$year/$mesConCeros/$diaConCeros $horaConCeros:$minutosConCeros:$segundosConCeros";
//$current_date = "$year/$month/$date $hour:$min:$sec";
$fechaactual = "$date/$month/$year";
$hora = "$hour:$min:$sec";

$fechaHoy = substr($current_date, 0, 10);

include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$consulta = "select * from puestos where id='" . $puesto . "'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataPuesto = $resultado->fetch(PDO::FETCH_ASSOC);

$consulta = "select id, idPersona, horario, puesto, estado,(select nombre from persona where id=idPersona)as nombre,(select apellido from persona where id=idPersona)as apellido FROM registro where puesto='" . $puesto . "' and horario  LIKE '$fechaHoy%'";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataRegistro = $resultado->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>RAMFAT</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
          type="text/css"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet"/>
</head>

<body id="page-top">
<!-- Navigation-->

<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">

    <div class="container">
        <a class="navbar-brand" href="#page-top"></a>
        <div style="text-align: left;" class="navbar-brand">
            <?php
            echo "<img width='10%' src='imagenes/barrera.png' alt='' />";
            echo "        <label>" . $dataPuesto['descripcion'] . "</label>";



            ?></div>
        <div class="col-md-2"></div>
        <div class="navbar-brand" style="text-align: right; font-size: medium" ><?php 
        if($_SESSION["rol"]==1){
            echo "<br>Administrador: ".$_SESSION['nombre']."<br><a href='bd/logout.php'>Cerrar Sesión</a><br><a href='admin'>Ingreso Administrador</a> <br><a href='../'>Volver</a></div>";
        }
        if($_SESSION["rol"]==2){
            echo "<br>Operador: ".$_SESSION['nombre']."<br><a href='bd/logout.php'>Cerrar Sesión</a> <br><a href='../'>Volver</a></div>";
        }
        
        if($_SESSION["rol"]==3){
            echo "<br>Supervisor: ".$_SESSION['nombre']."<br><a href='bd/logout.php'>Cerrar Sesión</a><br><a href='../supervisor'>Ingreso Supervisor</a> <br><a href='../'>Volver</a></div>";
        }
        
        ?>

        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">

   <!--<ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Portfolio</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
                <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
            </ul>-->
        </div>
    </div>



</nav>



<!-- Masthead-->
<div class="masthead text-white text-center" style="background-color: cadetblue">
    <div class="container d-flex align-items-center flex-column">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                <!--<img style="height: 150px;" alt="Sin Foto"
                         src="https://www.crecepersonas.es/templates/yootheme/cache/employee-bcd31bcd.png"
                         class="rounded"/> -->
                    <div class="list-group" STYLE="TEXT-ALIGN: LEFT">
                        <a href="#" class="list-group-item list-group-item-action active">DATOS PERSONALES</a>
                        <div class="form-group">
                            <label class="control-label col-xs-6" for="code-scan">Scanned code</label>
                            <div class="col-xs-6">
                                <input class="form-control" id="code-scan" type="text"/>

                            </div>
                        </div>
                        <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                Identificación:
                            </h5>
                            <label id="id">
                            </label>
                        </div>
                        <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                NOMBRE Y APELLIDO:
                            </h5>
                            <label id="nom">
                            </label>
                        </div>
                        <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                DNI:
                            </h5>
                            <label id="dni"></label>
                            <?php echo "<input type='hidden' id='puesto' name='puesto' value='" . $dataPuesto['id'] . "'>"; ?>


                        </div>
                        <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                DOMINIO:
                            </h5>
                            <label id="dominio">
                            </label>
                        </div>
                        <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                MARCA:
                            </h5>
                            <label id="marca">
                            </label>
                        </div>
                        <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                MODELO:
                            </h5>
                            <label id="modelo">
                            </label>
                        </div>
                        <!--   <div class="list-group-item">
                            <h5 class="list-group-item-heading">
                                PATENTE VEHICULO:
                            </h5>
                        </div>-->
                    </div>

                </div>
                <div class="col-md-6">
                <div class="navbar-brand" style="text-align: center; font-size: xl" >
                <?php
                echo "Fecha : ".$fechaactual;
                
                ?></div>
                    <table id="tablaPersonas" class="table table-sm">
                        <thead>
                        <tr class="table-success">
                            <th>
                                ID
                            </th>
                            <th>
                                NOMBRE Y APELLIDO
                            </th>
                            <th>
                                Horario
                            </th>
                            <th>
                                Estado
                            </th>
                        </tr>
                        </thead>
                        <tbody class='table-success'>

                        <?php
                        foreach ($dataRegistro as $key => $value) {
                            echo "<tr class='table-success'>";
                            echo "<td>" . $value['idPersona'] . "</td>";
                            echo "<td>" . $value['nombre'] . " " . $value['apellido'] . "</td>";
                            echo "<td>" . substr($value['horario'], 10) . "</td>";
                            if($value['estado']==0){
                                $estado="Entrada";
                            }else{
                                $estado="Salida";
                            }
                            echo "<td>" . $estado . "</td>";
                            echo "</tr>";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Footer-->
<footer class="footer text-center">
    <div class="container">
        <div class="row">
            <!-- Footer Location-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <!-- <h4 class="text-uppercase mb-4">Location</h4>
                 <p class="lead mb-0">
                     2215 John Daniel Drive
                     <br />
                     Clark, MO 65243
                 </p>-->
            </div>
            <!-- Footer Social Icons-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <!-- <h4 class="text-uppercase mb-4">Around the Web</h4>
                 <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                 <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                 <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                 <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
             -->
            </div>
            <!-- Footer About Text-->
            <div class="col-lg-4">
                <!-- <h4 class="text-uppercase mb-4">About Freelancer</h4>
                 <p class="lead mb-0">
                     Freelance is a free to use, MIT licensed Bootstrap theme created by
                     <a href="http://startbootstrap.com">Start Bootstrap</a>
                     .
                 </p>-->
            </div>
        </div>
    </div>
</footer>
<!-- Copyright Section-->
<div class="copyright py-4 text-center text-white">
    <div class="container"><small>Copyright &copy; 2021</small></div>
   
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS
<script src="js/scripts.js"></script>-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               SB Forms JS                               * *-->
<!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>


<script type='text/javascript' src='jquery-1.6.4.js'></script>
<script src="jquery.min.js"></script>
<script src="jquery-code-scanner.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(function () {
        $('#code-scan').codeScanner();
    });
</script>
<!-- datatables JS -->
<script type="text/javascript" src="vendor/datatables/datatables.min.js"></script>
<!-- código propio JS -->
<script>

</script>
<!-- datatables JS -->
<script type="text/javascript" src="vendor/datatables/datatables.min.js"></script>
<!-- código propio JS -->
<script type="text/javascript" src="main.js"></script>
</body>
</html>