<?php require_once "vistas/parte_superior.php" ?>

<!--INICIO del cont principal-->
<div class="container">
    <h1>Administrar Personas</h1>



    <?php
    include_once '../../bd/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $consulta = "SELECT * FROM persona where activo=0";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);   

    ?>


    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <button id="btnNuevo" type="button" class="btn btn-success" data-toggle="modal">Nuevo</button>
            </div>


        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaPersonas" class="table table-striped table-bordered table-condensed"
                        style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>DNI</th>
                                <th>DOMINIO</th>
                                <th>MARCA</th>
                                <th>MODELO</th>



                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $dat) {
                            ?>
                            <tr>
                                <td><?php echo $dat['id'] ?></td>
                                <td><?php echo $dat['nombre'] ?></td>
                                <td><?php echo $dat['apellido'] ?></td>
                                <td><?php echo $dat['dni'] ?></td>
                                <td><?php echo $dat['dominio'] ?></td>
                                <td><?php echo $dat['marca'] ?></td>
                                <td><?php echo $dat['modelo'] ?></td>


                                <td></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Modal para CRUD-->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formPersonas">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="col-form-label">Apellido:</label>
                            <input type="text" class="form-control" id="apellido">
                        </div>
                        <div class="form-group">
                            <label for="dni" class="col-form-label">DNI:</label>
                            <input type="text" class="form-control" id="dni">
                        </div>
                        <div class="modal-header">
                            <h5 class="" id="">Datos de Vehículo</h5>
                        </div>
                        <div class="form-group">
                            <label for="dominio" class="col-form-label">Dominio:</label>
                            <input type="text" class="form-control" id="dominio">
                        </div>
                        <div class="form-group">
                            <label for="marca" class="col-form-label">Marca:</label>
                            <input type="text" class="form-control" id="marca">
                        </div>
                        <div class="form-group">
                            <label for="modelo" class="col-form-label">Modelo:</label>
                            <input type="text" class="form-control" id="modelo">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal para QR-->
    <div class="modal fade" id="modalQR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formQR">
                    <div class="modal-body" id="imprimir">
                        <div>
                            <img class="" style=" height: 220px;" src="img/images.jpg">
                        </div>
                        <div class="row">

                            <div class='result col-md-8' style="text-align:center; ">

                            </div>
                            <div class='col-md-2' style="background-color: #00FF93;">
                                <div style="text-align:center; ">
                                    <h1 style="color: #000;font-family: fantasy;size: 50px;font-size: 60px;">2</h1>
                                </div>
                                <div style="text-align:center; ">
                                    <h1 style="color: #000;font-family: fantasy;size: 50px;font-size: 60px;">0</h1>

                                </div>
                                <div style="text-align:center; ">
                                    <h1 style="color: #000;font-family: fantasy;size: 50px;font-size: 60px;">2</h1>

                                </div>
                                <div style="text-align:center; ">
                        <h1 style=" color: #000;font-family: fantasy;size: 50px;font-size: 60px;">1</h1>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-md-8' >
                                <div style="text-align:center; ">
                                    
                                        <h1 style="color: #000;font-family: fantasy;size: 50px;font-size: 60px;">ID:
                                            <?php echo $dat['id'] ?></h1>
                                    
                                </div>
                            </div>
                            <div class='col-md-2' style="background-color: #00FF93;">

                                        
                                    </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                    <a href="generarqr.php?una="<?php echo $dat['id']; ?>>Descargar </a>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
                
            </div>
        </div>


    </div>


</div>



<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>