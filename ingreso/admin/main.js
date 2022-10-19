$(document).ready(function () {
    $.fn.dataTable.ext.buttons.nuevo = {
        className: 'dt-button buttons-pdf buttons-html5',

        action: function ( e, dt, node, config ) {
            //alert( this.text() );
            $("#formPersonas").trigger("reset");
            $(".modal-header").css("background-color", "#1cc88a");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Nuevo Efecto");
            $("#modalCRUD").modal("show");
            id = null;
            opcion = 1; //alta
        }
    };
    $.fn.dataTable.ext.buttons.qr = {
        className: 'dt-button buttons-pdf buttons-html5',

        action: function ( e, dt, node, config ) {
            $("#formQR").trigger("reset");
            $(".modal-header").css("background-color", "#1cc88a");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Imprimir Obleas QR");
            $("#modalQR").modal("show");
        }
    };
    tablaPersonas = $("#tablaPersonas").DataTable({
"sort": false,
        "dom": '<"dt-buttons"Bf><"clear">lirtp',
        "buttons": [
            {
                extend: 'pdfHtml5',
                text: '<button class="btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>',
                download: 'open',
                //className: '',
                //messageTop: ' ',
                title:'Registo de Inasgresos MES DE AGOSTO 2022',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7],
                    //  columns: ':visible',
                    search: 'applied'
                },
                customize:function(doc) {

                    doc.content.splice(0,1);
                    var now = new Date();
                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                    doc.pageMargins = [20,60,20,40];
                    doc.defaultStyle.fontSize = 9;
                    doc.styles.tableHeader.fontSize = 10;

                    doc['header']=(function() {
                        return {
                            columns: [
                                {
                                    //image: logo,
                                    //width: 24
                                },
                                {
                                    alignment: 'center',
                                    italics: true,
                                    text: 'Registro de Ingresos MES DE SEPTIEMBRE 2022',
                                    fontSize: 14,
                                    margin: [1,1]
                                },
                                {
                                    /*  alignment: 'right',
                                      fontSize: 14,
                                      text: 'Custom PDF export with dataTables'
                                  */
                                }

                            ],
                            margin: 20
                        }
                    });

                    doc['footer']=(function(page, pages) {
                        return {
                            columns: [
                                {
                                    //  alignment: 'left',
                                    // text: ['Created on: ', { text: jsDate.toString() }]
                                },
                                {
                                    alignment: 'right',
                                    text: ['Página ', { text: page.toString() },	' de ',	{ text: pages.toString() }]
                                }
                            ],
                            margin: 20
                        }
                    });
                    var objLayout = {};
                    objLayout['hLineWidth'] = function(i) { return .5; };
                    objLayout['vLineWidth'] = function(i) { return .5; };
                    objLayout['hLineColor'] = function(i) { return '#aaa'; };
                    objLayout['vLineColor'] = function(i) { return '#aaa'; };
                    objLayout['paddingLeft'] = function(i) { return 4; };
                    objLayout['paddingRight'] = function(i) { return 4; };
                    doc.content[0].layout = objLayout;
                }
            }],
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>"
        }
        ],

        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });
    

    $("#btnNuevo").click(function () {
        $("#formPersonas").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Persona");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

   

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function () {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        nombre = fila.find('td:eq(1)').text();
        apellido = fila.find('td:eq(2)').text();
        dni = fila.find('td:eq(3)').text();
        dominio = fila.find('td:eq(4)').text();
        marca = fila.find('td:eq(5)').text();
        modelo = fila.find('td:eq(6)').text();
        $("#nombre").val(nombre);
        $("#apellido").val(apellido);
        $("#dni").val(dni);
        $("#dominio").val(dominio);
        $("#marca").val(marca);
        $("#modelo").val(modelo);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#4e73df");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Persona");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function () {
        fila = $(this);
        id = ($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");
        if (respuesta) {
            $.ajax({
                url: "bd/crudPersona.php",
                type: "POST",
                dataType: "json",
                data: { opcion: opcion, id: id },
                success: function () {
                    tablaPersonas.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    $("#formPersonas").submit(function (e) {
//        alert("anda");
        e.preventDefault();

        //id =  "";
        nombre = $.trim($("#nombre").val());
        apellido = $.trim($("#apellido").val());
        dni = $.trim($("#dni").val());
        dominio = $.trim($("#dominio").val());
        marca = $.trim($("#marca").val());
        modelo = $.trim($("#modelo").val());


//alert(dominio);alert(nombre);
        $.ajax({
            url: "bd/crudPersona.php",
            type: "POST",
            dataType: "json",
            data: { id:id,nombre: nombre, apellido: apellido, dni: dni,dominio: dominio,marca:marca,modelo:modelo, opcion: opcion },
            success: function (data) {
                console.log(data);
                id = data[0].id;
                nombre = data[0].nombre;
                apellido = data[0].apellido;
                dni = data[0].dni;
                dominio = data[0].dominio;
                marca = data[0].marca;
                modelo = data[0].modelo;
                
               // dpto = data[0].dpto;
                if (opcion == 1) { 
                    
                    tablaPersonas.row.add([id, nombre, apellido, dni, dominio, marca, modelo]).draw(); 
                    
                }
                else { 
                    
                    tablaPersonas.row(fila).data([id, nombre, apellido, dni, dominio, marca, modelo]).draw(); }
            }
        });
        $("#modalCRUD").modal("hide");

    });

    $(document).on("click", ".btnQR", function (event) {
        var sizeqr="300";
        fila = $(this).closest("tr");
        id = (fila.find('td:eq(0)').text());
        var textqr=id;

        var b64 = id;

        var txt = decodeURIComponent(escape(window.btoa(b64)));
        textqr=txt;
        console.log("txt:"+b64);
        console.log("convertido:"+txt);


        parametros={"textqr":textqr,"sizeqr":sizeqr};
        $.ajax({
            type: "POST",
            url: "qr.php",
            data: parametros,
            success: function(datos){
                $(".result").html(datos);
            }

        })
        //alert(sizeqr);
        event.preventDefault();
        $(".modal-title").text("Imprimir Codigo QR");

        $("#modalQR").modal("show");
    });


    $("#formDetalle").submit(function (e) {
        alert("anda detalle" +opcion);
        e.preventDefault();
        
        micro = $.trim($("#micro").val());
     /*   INE = $.trim($("#INE").val());
        NI = $.trim($("#NI").val());
        dpto = $.trim($("#dpto").val());*/

        $.ajax({
            url: "bd/crudPersona.php",
            type: "POST",
            dataType: "json",
            data: {id: id, micro: micro, opcion: opcion },
            success: function (data) {
                //console.log(data);
                id = data[0].id;
                micro = data[0].micro;
              /*  INE = data[0].INE;
                NI = data[0].NI;
                dpto = data[0].dpto;
                idDetalle = data[0].idDetalle;
                marcaProcesador = data[0].marcaProcesador;
                procesador = data[0].procesador;
                ram = data[0].ram;
                tipoDisco = data[0].tipoDisco;
                capacidadDisco = data[0].capacidadDisco;
                medidaCapacidad = data[0].medidaCapacidad;
                sistemaOperativo = data[0].sistemaOperativo;
                observaciones = data[0].observaciones;*/
                if (opcion == 1) { tablaPersonas.row.add([id, , "", "", "", "", "", "", "", "", "", "", "", ""]).draw(); }
                else { tablaPersonas.row(fila).data([id, NNE, INE, NI, dpto, idDetalle, marcaProcesador, procesador, ram, tipoDisco, capacidadDisco, medidaCapacidad, sistemaOperativo, observaciones]).draw(); }
            }
        });
        $("#modalDetalle").modal("hide");

    });

});