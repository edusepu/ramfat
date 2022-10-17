<style>
body {

    width: 21cm;

}

.oblea {
    text-align: center;
    width: 5cm;
    height: 7.5cm;
    border-style: dotted;
}
</style>
<link rel="stylesheet" href="css/bootstrap.css" />

<body>
    <br>
    <div class="container">
    <?php
    if(isset($_POST['desde'])){
        $desde=$_POST['desde'];
        $hasta=$_POST['hasta'];
        $inicio=$hasta-$desde;
    }else{
        $desde=$_GET['una'];
        
        $hasta=$_GET['una'];
        $inicio=1;
    }



$i=0;

$contadorFilas=1;
//echo ("cantidad de obleas: ".$inicio+1);echo "<br>";
echo "<div class='row gx-1 justify-content-center' style='height:9.8cm'>";
$varia=0;
for ($i = $desde; $i <= $hasta; $i++) {
    $numeroConCeros = str_pad($i, 6, "0", STR_PAD_LEFT);
    //echo "|".$numeroConCeros;



      //  echo "".$contadorFilas."";
        

       
            echo "<div class='col-lg-4 col-md-6'>";
                echo "<div class='oblea justify-content-center'>";
                    echo "<div class='justify-content-center'>";
                        echo "<img style='width: 100%' src='img/images.jpg'>";
                    echo "</div>";
                    echo "<div style='font-family: fantasy;'>";
                        echo "<div class='result' style='text-align:center;'>";
                            $textqr = $numeroConCeros;
                            $sizeqr = 120;
                            include("qrvarios.php");
                            echo "<h4>ID: $numeroConCeros</h4>";
                        echo "</div>";
                        
                    echo "</div>";
                echo "</div>";
            echo "</div>";
 
            $contadorFilas=$contadorFilas+1;


        if($contadorFilas==4){
        //echo "<br>-<br>-<br>";
        //$pdf->AddPage(); 
        echo "</div>";
        if($varia==0){
            echo "<div class='row gx-1 justify-content-center' style='height:9.8cm'>";
            $varia=1;
        }else{
            echo "<div class='row gx-1 justify-content-center' style='height:9.9cm'>";
            $varia=0;
        }
        $contadorFilas=1;
    }
}
echo "</div>";
?>

       

    </div>

    <!-- JavaScript -->
    <script type="text/javascript">
    //jsFunction("1");
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

    document.addEventListener("DOMContentLoaded", () => {
      //  alert("hola");

        // Escuchamos el click del botón
       // const $boton = document.querySelector("#btnCrearPdf");
        //$boton.addEventListener("click", () => {
            const $elementoParaConvertir = document
            .body; // <-- Aquí puedes elegir cualquier elemento del DOM
            html2pdf()
                .set({
                    margin: 1,
                    filename: 'documento.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 3, // A mayor escala, mejores gráficos, pero más peso
                        letterRendering: true,
                    },
                    jsPDF: {
                        unit: "mm",
                        format: "a4",
                        orientation: 'portrait' // landscape o portrait
                    }
                })
                .from($elementoParaConvertir)
                .save()
                .catch(err => console.log(err));
       // });
    });
    </script>
    <script type="text/javascript">

    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>

</body>