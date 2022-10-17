(function ($) {
    $.fn.codeScanner = function (options) {
        var settings = $.extend({}, $.fn.codeScanner.defaults, options);

        return this.each(function () {
            var pressed = false;
            var chars = [];
            var $input = $(this);
            var num = "";

            $(window).keypress(function (e) {
                var keycode = (e.which) ? e.which : e.keyCode;
                if ((keycode >= 61 && keycode <= 90) ||
                    (keycode >= 97 && keycode <= 122) ||
                    (keycode >= 48 && keycode <= 57)
                ) {
                    chars.push(String.fromCharCode(e.which));
                    num = num + (String.fromCharCode(e.which));
                }
                // console.log(e.which + ":" + chars.join("|"));
                if (pressed == false) {
                    setTimeout(function () {
                        if (chars.length >= settings.minEntryChars) {
                            var barcode = chars.join('');
                            settings.onScan($input, barcode);
                        }
                        chars = [];
                        pressed = false;
                    }, settings.maxEntryTime);
                }
                pressed = true;

                if (e.which === 13) {
                    var b64 = num;
                    num = "";
                    var txt = decodeURIComponent(escape(window.atob(b64)));
                    console.log("txt:"+b64);
                    console.log("convertido:"+txt);

                  

                    var horario = new Date();
                    idPersona = txt;
                    var puesto = $('#puesto').val();
                    console.log(puesto);
                    opcion = 1;
                    $.ajax({
                        url: "bd/crud.php",
                        type: "POST",
                        dataType: "json",
                        data: { idPersona:idPersona, opcion:opcion, puesto:puesto },
                        success: function (data) {
                            console.log(data);
                            if(data.length==0){
                               // alert("OBLEA NO ASIGNADA O NO AUTORIZADA");
                               Swal.fire(
                                'OBLEA NO ASIGNADA O NO AUTORIZADA',
                                ' ',
                                'error'
                              )
                            }else{
                           
                            id = data[0].id;   
                            nombre = data[0].nombre+" "+data[0].apellido;
                            dni = data[0].dni;
                            dominio = data[0].dominio;
                            marca = data[0].marca;
                            modelo = data[0].modelo;
                            if(data[0].estado==0){
                                estado="Entrada";
                            }else{
                                estado="salida";
                            }
                           // puesto = data[0].puesto;
                           // horario = data[0].horario;
                            /*id = data[0].id;
                            NNE = data[0].NNE;
                            INE = data[0].INE;
                            NI = data[0].NI;
                            dpto = data[0].dpto;
                            idDetalle = data[0].idDetalle;*/
                            $("#id").text(id);
                            $("#nom").text(nombre);
                            $("#dni").text(dni);
                            $("#puesto").text(puesto);
                            $("#dominio").text(dominio);
                            $("#marca").text(marca);
                            $("#modelo").text(modelo);
                            
                           // $("#horario").text(horario);
                          //  tablaPersonas.row.add([idPersona, "edu", "00:00", "entrando"]).draw();
                           // tablaPersonas.order([2, 'asc']).draw();


                            var d = new Date();
                            var horario = String(d.getHours()).padStart(2, "0") + ":" + String(d.getMinutes()).padStart(2, "0") + ":" + String(d.getSeconds()).padStart(2, "0");
                            //console.log(time);
                            tablaPersonas.row.add([id, nombre, horario, estado]).draw();

                            }


                        }
                    });






                }

            });

            $(this).keypress(function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                }
            });

            return $(this);
        });
    };

    $.fn.codeScanner.defaults = {
        minEntryChars: 8,
        maxEntryTime: 100,
        onScan: function ($element, barcode) {
            $element.val(barcode);
        }
    };
})(jQuery);
