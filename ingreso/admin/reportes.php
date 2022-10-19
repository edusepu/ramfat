<?php require_once "vistas/parte_superior.php" ?>
<!--INICIO del cont principal-->
<div class="container">
    <h1>Control de Ingreso</h1>
    <?php
    include_once '../../bd/conexion.php';
    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $consulta = "SELECT registro.id, idPersona, horario, (select descripcion from puestos where registro.puesto=puestos.id) as puesto, usuario,(select nombre from usuarios where id=registro.usuario) as usu, estado, p.nombre, p.apellido, p.dni, (SELECT CONCAT(marca,' ', modelo, ' ', dominio) from persona WHERE persona.id=registro.idPersona) AS dominio from registro JOIN persona as p ON p.id=registro.idPersona  where registro.id>275 order by registro.id";
    $resultado = $conexion->prepare($consulta);
    $resultado->execute();
    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);   

    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="tablaReportes" class="table  table-sm table-striped table-bordered table-condensed" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>Id Persona</th>
                                <th>Nombre</th>
                              
                                <th>DNI</th>
                                <th>Dominio</th>


                                <th>Horario</th>
                                <th>Estado</th>
                                <th>Puesto</th>

                                <th>Operador</th>
                                <th>Estado</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $dat) {
                            ?>
                            <?php 
                                    if($dat['estado']==0){
                                        echo "<tr class='table-success'>"; 
                                    }else{
                                        echo "<tr class='table-danger'>"; 
                                    }
                                     ?>
                                
                                    <td><?php echo $dat['idPersona'] ?></td>
                                    <td><?php echo $dat['nombre']." ".$dat['apellido'] ?></td>
                                    <td><?php echo $dat['dni'] ?></td>
                                    <td><?php echo $dat['dominio'] ?></td>

                                    <td><?php
                                            $date = date_create($dat['horario']);
                                            echo date_format($date,"d/m/Y H:i:s");
                                            //echo $date;
                                        ?></td>
                                    <td><?php if($dat['estado'] ==0){
                                            echo "ENTRADA";
                                        }else{
                                            echo "SALIDA";

                                        }

                                        ?></td>
                                    <td><?php echo $dat['puesto'] ?></td>
                                    <td><?php echo $dat['usu'] ?></td>
                                    <?php 
                                    if($dat['estado']==0){
                                        echo "<td>ENTRADA</td>"; 
                                    }else{
                                        echo "<td>SALIDA</td>"; 
                                    }
                                     ?>

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
</div>
<!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>