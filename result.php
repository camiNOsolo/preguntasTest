<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
?>

<?php 
require 'config.php';
if(!empty($_SESSION['nombre'])){

  if($_POST)
    {
        $nombre = $_SESSION['nombre'];
        $total_usuario = 0;

        mysql_query("INSERT INTO usuario (id, nombre) VALUES ('NULL','$nombre')") or die(mysql_error());
        $usuario = mysql_insert_id();
        $total_usuario = $total_usuario +1;

        foreach ($_GET as $clave=>$valor) {

            mysql_query("INSERT INTO registros (id, id_usuario, id_respuesta) VALUES ('NULL',$usuario, $valor)") or die(mysql_error());
        }
        
        $danone = mysql_query("SELECT id FROM usuario") or die(mysql_error());

        $array = array();
        $dependencia_muy_baja = 0;
        $dependencia_baja = 0;
        $dependencia_moderada = 0;
        $dependencia_alta = 0;
        $dependencia_muy_alta = 0;

        while($resultado_usuario = mysql_fetch_array($danone)){
            
            $usu = $resultado_usuario['id'];
            $suma = 0;

            $puntos = mysql_query("SELECT puntos FROM registros, respuestas WHERE respuestas.id = registros.id_respuesta AND id_usuario = $usu ") or die(mysql_error());
            
            while($resultado = mysql_fetch_array($puntos)){
                
                $suma = $suma + $resultado['puntos'];
            }

           if ($suma <= 0) {
            $dependencia_muy_baja ++;
           }

           if ($suma >= 2 && $suma <= 3) {
            $dependencia_baja = 0;
           }

           if ($suma >= 4 && $suma <= 5) {
            $dependencia_moderada ++;
           }

          if ($suma >= 6 && $suma <= 7) {
            $dependencia_alta ++;
           }

          if ($suma >= 8 && $suma <= 10) {
            $dependencia_muy_alta ++;
           }


            $array[] = $suma;
        }

    }



  //print_r($array);
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Latest compiled and minified CSS -->
        <link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
        <link href="css/style.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../../assets/js/html5shiv.js"></script>
        <script src="../../assets/js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>
    <header>

      <?php if(!empty($_SESSION['nombre'])){?>
        
        <h2>ADIADOS</h2>

        <p>Estas realizando el Test con <?php if(!empty($_SESSION['nombre'])){echo $_SESSION['nombre'];}?> - <a href="logout.php"> Salir </a></p>

      <?php }else{?>
        
        <h2>ADIADOS</h2>

      <?php }?>

    </header>
        <div class="container result">

            <div class="row"> 
              <div class="col-md-7 col-md-offset-5"> 
                    <div class='result-logo center'>
                            <img src="image/logo.png" class="img-responsive center"/>
                    </div>   
              </div> 
           </div>  
        <hr>   
           <div class="row"> 
                  <div class="col-md-4 col-md-offset-2"> 
                    <div style="background-color:#C6C6C6;margin-left:100px;margin-bottom:50px;padding:10px;border-radius: 1em;">
                     <!--<a href="<?php echo BASE_PATH;?>" class='btn btn-success'>Hacer un Nuevo Test</a> -->                  
                       
                       <h4>Eres el Usuario número: <?php echo $usuario;?></h4>
                       <h4>Tu puntuación ha sido: 

                       <?php 
                       $puntuacion = end($array);
                       if ($puntuacion <= 0) {
                        echo "Dependencia muy baja";
                       }

                       if ($puntuacion >= 2 && $puntuacion <= 3) {
                        echo "Dependencia baja";
                       }

                       if ($puntuacion >= 4 && $puntuacion <= 5) {
                        echo "Dependencia moderada";
                       }

                      if ($puntuacion >= 6 && $puntuacion <= 7) {
                        echo "Dependencia alta";
                       }

                      if ($puntuacion >= 8 && $puntuacion <= 10) {
                        echo "Dependencia muy alta";
                       }
                       ?>
                       </h4>
                    </div>

                  
                    <div class='center'>
                            <img src="image/tabaco.jpg" width="400px;" class="img-responsive center" style="margin: 0 auto;"/>
                    </div>
                  </div>

                 

            <div class="col-md-6">    
            <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
            </div>
            </div>    

        </div>
        <footer>
            <p class="text-center" id="foot">
                &copy; <a href="http://www.toString.es" target="_blank">Francisco Recio 2015 </a>
            </p>
        </footer>

      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
      <script src="https://code.highcharts.com/highcharts.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>



    <script>
$(function () {
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Estadisticas de los test realizados a los Usuarios'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'adicción',
            colorByPoint: true,
            data: [{
                name: 'Dependencia muy baja',
                y: <?php echo $dependencia_muy_baja; ?>,
                sliced: true,
                selected: true
            }, {
                name: 'Dependencia baja',
                y: <?php echo $dependencia_baja; ?>

            }, {
                name: 'Dependencia moderada',
                y: <?php echo $dependencia_moderada; ?>
            }, {
                name: 'Dependencia alta',
                y: <?php echo $dependencia_alta; ?>
            }, {
                name: 'Dependencia muy alta',
                y: <?php echo $dependencia_muy_alta; ?>
            }]
        }]
    });
});

    </script>
    </body>
</html>
<?php }else{

 header( 'Location: http://localhost/index.php' ) ;

}?>
