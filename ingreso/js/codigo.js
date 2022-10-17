$('#formLogin').submit(function(e){
   e.preventDefault();
   var usuario = $.trim($("#usuario").val());    
   var password =$.trim($("#password").val());
   var idurl =$.trim($("#id").val());
   //alert('primer '+idurl);
    if(usuario.length == "" || password == ""){
      Swal.fire({
          type:'warning',
          title:'Debe ingresar un usuario y/o password',
      });
      return false; 
    }else{
        $.ajax({
           url:"ingreso/bd/login.php",
           type:"POST",
           datatype: "json",
           data: {usuario:usuario, password:password}, 
           success:function(data){               
               if(data == "null"){
                   Swal.fire({
                       type:'error',
                       title:'Usuario y/o password incorrecta',
                   });
               }else{
                   Swal.fire({
                       type:'success',
                       title:'¡Conexión exitosa!',
                       confirmButtonColor:'#3085d6',
                       confirmButtonText:'Ingresar'
                   }).then((result) => {
                       if(result.value){
                      //     console.log(data);
//console.log(data.usuario);
                          // var data = jQuery.parseJSON(response);

                           //window.location.href = "vistas/pag_inicio.php";
                        //   alert("segundo "+idurl);
                          // console.log(data);
                         //  console.log("hola");
                           //if(idurl){
                               //hacemos lo que se requiera en caso de que la variable contenga null

                              // window.location.href = "redirect.php?id="+idurl;
                           //}else{
                             //  alert("sdsdds"+idurl);
                               window.location.href = "index.php";
                          // }

                       }
                   })
                   
               }
           }    
        });
    }     
});