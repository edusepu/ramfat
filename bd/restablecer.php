<?php
session_start();
//var_dump($_SESSION);exit;
if ($_SESSION["s_usuario"] === null) {
    header("Location: login.php");
}


include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();
$consulta = "select * from puestos";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$dataRegistro = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>RAMFAT</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../ingreso/assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../ingreso/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/form-register.css">
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">Control de Ingreso/Egreso</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="col-md-3"></div>
            <div class="navbar-brand" style="text-align: right; font-size: medium">
                <?php

                if ($_SESSION["rol"] == 1) {
                    echo "<br>Administrador: " . $_SESSION['nombre'] . "<br><a href='../bd/restablecer.php'>Cambiar Contraseña</a><br><a href='../bd/logout.php'>Cerrar Sesión</a><br><a href='ingreso/admin'>Ingreso Administrador</a></div>";
                }
                if ($_SESSION["rol"] == 2) {
                    echo "<br>Operador: " . $_SESSION['nombre'] . "<br><a href='../bd/restablecer.php'>Cambiar Contraseña</a><br><a href='../bd/logout.php'>Cerrar Sesión</a></div>";
                }

                if ($_SESSION["rol"] == 3) {
                    echo "<br>Supervisor: " . $_SESSION['nombre'] . "<br><a href='../bd/restablecer.php'>Cambiar Contraseña</a><br><a href='../bd/logout.php'>Cerrar Sesión</a><br><a href='supervisor'>Ingreso Supervisor</a></div>";
                }

                ?>
                <div class="collapse navbar-collapse" id="navbarResponsive">

                </div>
            </div>
    </nav>
    <!-- Masthead-->
    <div class="masthead text-white text-center" style="background-color: cadetblue">
        <div class="container d-flex align-items-center flex-column">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-8">
                        <div class="list-group" STYLE="TEXT-ALIGN: center   ">
                            <div class='list-group-item'>

                                <form class="login-form validate-form" id="restablecer" method="post" action="#">

                                    <div class="form-register-with-email">

                                        <div class="form-white-background">

                                            <div class="form-title-row">
                                                <h1>Cambiar Contraseña</h1>
                                                <h5>Usuario: <?php echo $_SESSION['s_usuario']." (".$_SESSION['nombre'].")";?></h5>
                                            </div>
                                            <div class="form-row oculto">
                                                <label>
                                                    <span>Usuario</span>
                                                    <input type="text" id="usuario" name="usuario" value="<?php echo $_SESSION["s_usuario"];?>" disabled>
                                                </label>
                                            </div>
                                          
                                            <div class="form-row">
                                                <label>
                                                    <span>Contraseña Actual</span>
                                                    <input type="password" id="actual" name="actual" required>
                                                </label>
                                            </div>
                                            <div class="form-row">
                                                <label>
                                                    <span>Nueva Contraseña</span>
                                                    <input type="password" id="nueva" name="nueva" required>
                                                </label>
                                            </div>

                                            <div class="form-row">
                                                <label>
                                                    <span>Repetir Nueva Contraseña</span>
                                                    <input type="password" id="repetir" name="repetir" required>
                                                </label>
                                            </div>
                                         

                                            <div class="form-row">
                                                <button type="submit">Cambiar</button>
                                            </div>

                                        </div>

                                    </div>



                                </form>
                            </div>



                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer-->
    <footer>
        <div class="copyright py-4 text-center text-white">
            <div class="container"><small>Copyright &copy; 2021</small></div>
        </div>
    </footer>
    <script src="../ingreso/admin/jquery/jquery-3.3.1.min.js"></script>
     <script src="../ingreso/vendor/bootstrap/js/bootstrap.min.js"></script>
     <script src="../ingreso/admin/js/popper.min.js"></script>
        
     <script src="../ingreso/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="../js/codigo.js"></script>

</body>

</html>