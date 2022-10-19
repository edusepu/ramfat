$(document).ready(function () { 
    
    tablaReportes = $("#tablaReportes").DataTable({
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

   

    var fila; //capturar la fila para editar o borrar el registro

    
    $("#formReportes").submit(function (e) {
//        alert("anda");
        e.preventDefault();

        //id =  "";
        nombre = $.trim($("#nombre").val());
        apellido = $.trim($("#apellido").val());
        dni = $.trim($("#dni").val());
        dominio = $.trim($("#dominio").val());
        marca = $.trim($("#marca").val());
        modelo = $.trim($("#modelo").val());



    });



});