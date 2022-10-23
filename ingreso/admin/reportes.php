<?php require_once "vistas/parte_superior.php" ?>
    <!--INICIO del cont principal-->
<?php
$meses = [['id' => '01', 'nombre' => 'ENERO'], ['id' => '02', 'nombre' => 'FEBRERO'], ['id' => '03', 'nombre' => 'MARZO'], ['id' => '04', 'nombre' => 'ABRIL']
    , ['id' => '05', 'nombre' => 'MAYO'], ['id' => '06', 'nombre' => 'JUNIO'], ['id' => '07', 'nombre' => 'JULIO'], ['id' => '08', 'nombre' => 'AGOSTO']
    , ['id' => '09', 'nombre' => 'SEPTIEMBRE'], ['id' => '10', 'nombre' => 'OCTUBRE'], ['id' => '11', 'nombre' => 'NOVIEMBRE'], ['id' => '12', 'nombre' => 'DICIEMBRE']];
$anios = [['id' => '2022', 'nombre' => '2022'], ['id' => '2023', 'nombre' => '2023'], ['id' => '2024', 'nombre' => '2024'], ['id' => '2025', 'nombre' => '2025']];

$html = "";
$html2 = "";
$variable = date('m');
$variable2 = date('Y');

if (isset($_POST['mes'])) {
    $variable = $_POST['mes'];
    $variable2 = $_POST['anio'];
}
//echo $variable2;
?>
    <div class="container">
        <h1>Control de Ingreso</h1>
        <div class="form-row shadow-sm p-3 mb-5 bg-body rounded">
            <div class="col-12 d-inline">
                <form name="formMes" method="post" action="">
                    <label>
                        <span>Elegir MES</span>
                    </label>
                    <select class="select" id="mes" name="mes" onchange="this.form.submit()">
                        <?php
                        foreach ($meses as $region) {
                            $html .= "<option value=" . $region['id'];
                            if ($region['id'] == $variable) {
                                $html .= " selected";
                            }
                            $html .= ">" . $region['nombre'] . "</option>";
                        }
                        echo $html;
                        ?>
                    </select>
                    <label>
                        <span>Elegir AÑO</span>
                    </label>
                    <select class="select" id="anio" name="anio" onchange="this.form.submit()">
                        <?php
                        foreach ($anios as $region) {
                            $html2 .= "<option value=" . $region['id'];
                            if ($region['id'] == $variable2) {
                                $html2 .= " selected";
                            }
                            $html2 .= ">" . $region['nombre'] . "</option>";
                        }
                        echo $html2;
                        ?>

                    </select>
                </form>
            </div>


            <?php
            //echo $variable;
            include_once '../../bd/conexion.php';
            $objeto = new Conexion();
            $conexion = $objeto->Conectar();
            $consulta = "SELECT registro.id, idPersona, horario, (select descripcion from puestos where registro.puesto=puestos.id) as puesto, usuario,(select nombre from usuarios where id=registro.usuario) as usu, estado, p.nombre, p.apellido, p.dni, (SELECT CONCAT(marca,' ', modelo, ' ', dominio) from persona WHERE persona.id=registro.idPersona) AS dominio from registro JOIN persona as p ON p.id=registro.idPersona  where registro.id>275 
                 and horario LIKE '%" . $variable2 . "-" . $variable . "%' order by registro.id";

            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            //echo $consulta;
            ?>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="tablaReportes"
                                   class="table  table-sm table-striped table-bordered table-condensed"
                                   style="width:100%">
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
                                    if ($dat['estado'] == 0) {
                                        echo "<tr class='table-success'>";
                                    } else {
                                        echo "<tr class='table-danger'>";
                                    }
                                    ?>

                                    <td><?php echo $dat['idPersona'] ?></td>
                                    <td><?php echo $dat['nombre'] . " " . $dat['apellido'] ?></td>
                                    <td><?php echo $dat['dni'] ?></td>
                                    <td><?php echo $dat['dominio'] ?></td>

                                    <td><?php
                                        $date = date_create($dat['horario']);
                                        echo date_format($date, "d/m/Y H:i:s");
                                        //echo $date;
                                        ?></td>
                                    <td><?php if ($dat['estado'] == 0) {
                                            echo "ENTRADA";
                                        } else {
                                            echo "SALIDA";

                                        }

                                        ?></td>
                                    <td><?php echo $dat['puesto'] ?></td>
                                    <td><?php echo $dat['usu'] ?></td>
                                    <?php
                                    if ($dat['estado'] == 0) {
                                        echo "<td>ENTRADA</td>";
                                    } else {
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
    </div>
    <!--FIN del cont principal-->
<?php require_once "vistas/parte_inferior.php" ?>