$('#formLogin').submit(function(e){
   e.preventDefault();
   var usuario = $.trim($("#usuario").val());    
   var password =$.trim($("#password").val());
   var idurl =$.trim($("#id").val());
    if(usuario.length == "" || password == ""){
      Swal.fire({
          type:'warning',
          title:'Debe ingresar un usuario y/o password',
      });
      return false; 
    }else{
        $.ajax({
           url:"bd/login.php",
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
                               window.location.href = "index.php";
                       }
                   })
                   
               }
           }    
        });
    }     
});

//cambio de contraseña
$('#restablecer').submit(function(e){
    e.preventDefault();
    var usuario = $.trim($("#usuario").val());    
    var password =$.trim($("#actual").val());
    var nueva =$.trim($("#nueva").val());
    var repetir =$.trim($("#repetir").val());
   
     if(nueva == repetir){
        $.ajax({
            url:"cambio.php",
            type:"POST",
            datatype: "json",
            data: {usuario:usuario, password:password, nueva:nueva}, 
            success:function(data){               
                if(data == "null"){
                    Swal.fire({
                        type:'error',
                        title:'Usuario y/o password incorrecta',
                    });
                }else{
                    Swal.fire({
                        type:'success',
                        title:'¡Su contraseña de ha cambiado correctamente!',
                        confirmButtonColor:'#3085d6',
                        confirmButtonText:'Ingresar'
                    }).then((result) => {
                        if(result.value){                      
                                window.location.href = "../login.php";
                        }
                    })
                    
                }
            }    
         });
     }else{
        Swal.fire({
            type:'warning',
            title:'Las contraseñas no coinciden',
        });
        return false; 

     }     
 });