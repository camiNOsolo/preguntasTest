<?php

session_start();

require 'config.php';

if(!empty($_POST['nombre']) && !empty($_POST['categoria'])){
    
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $_SESSION['categoria'] = $categoria;
    $_SESSION['nombre'] = $nombre;

}



if(!empty($_SESSION['nombre'])){
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ADIADOS</title>
    <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lobster">
    <link href='http://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" media="screen">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="../../assets/js/html5shiv.js"></script>
		<script src="../../assets/js/respond.min.js"></script>
		<![endif]-->
		<style>

		</style>
	</head>
	<body>
    <header style="margin-top:20px;">

      <?php if(!empty($_SESSION['nombre'])){?>
        
        <h2>ADIADOS</h2>

        <p>Estas realizando el Test con <?php if(!empty($_SESSION['nombre'])){echo $_SESSION['nombre'];}?> - <a href="logout.php"> Salir </a></p>

      <?php }else{?>

        <h2>ADIADOS</h2>

      <?php }?>

    </header>

		<div class="container question">
			<div class="col-xs-12 col-sm-8 col-md-6 col-xs-offset-4 col-sm-offset-3 col-md-offset-3">
				<p>
					<h1>Calcula tu dependencia psíquica a la nicotina.</h1>
				</p>
				<hr>
				<form class="form-horizontal" role="form" id='login' method="post" name="formulario" action="result.php">
					
          <?php

          $res = mysql_query("SELECT preguntas.id as pregunta_id, preguntas.descripcion as pregunta FROM preguntas where id_categoria = '$categoria'") or die(mysql_error());

          $rows = mysql_num_rows($res);
					$i=1;

                while($result=mysql_fetch_array($res)){

                    $pregunta_id = $result['pregunta_id'];
                    $pregunta_des = $result['pregunta'];

                    if($i==1){

                    ?>       

                    
                    <div id='question<?php echo $i;?>' class='cont'>

                    <p class='questions' id="qname<?php echo $i;?>"><legend><?php echo $i?> - <?php echo $result['pregunta'];?></legend></p>
                        
                        <?php

                        $respuesta = mysql_query("SELECT respuestas.id as id_respuesta, respuestas.descripcion as respuesta FROM respuestas WHERE respuestas.id_pregunta = '$pregunta_id'") or die(mysql_error());

                        while($resultado = mysql_fetch_array($respuesta)){?>

                        <input type="radio" value='<?php echo $resultado['id_respuesta'];?>' id='<?php echo $resultado['id_respuesta'];?>' name='<?php echo $i; ?>'/> 
                        <label for='radio1_<?php echo $resultado['id_respuesta'];?>'><?php echo $resultado['respuesta'];?></label>

                        <br/>
                        

                        <?php } ?>

                    <button id='next<?php echo $i;?>' class='next btn btn-primary' type='button'>SIGUIENTE</button>
                    </div>     
                    
                    <?php }elseif($i<1 || $i<$rows){?>

                    <div id='question<?php echo $i;?>' class='cont'>
                    <p class='questions' id="qname<?php echo $i;?>"><legend><?php echo $i?> - <?php echo $result['pregunta'];?></legend></p>
                  
                        <?php

                        $respuesta = mysql_query("SELECT respuestas.id as id_respuesta, respuestas.descripcion as respuesta FROM respuestas WHERE respuestas.id_pregunta = '$pregunta_id'") or die(mysql_error());

                        while($resultado = mysql_fetch_array($respuesta)){?>

                        <input type="radio" value='<?php echo $resultado['id_respuesta'];?>' id='<?php echo $resultado['id_respuesta'];?>' name='<?php echo $i; ?>'/>
                        <label for='radio1_<?php echo $resultado['id_respuesta'];?>'><?php echo $resultado['respuesta'];?></label>   
                        <br/>

                        <?php } ?>

                    <button id='pre<?php echo $i;?>' class='previous btn btn-primary' type='button'>RETROCEDER</button>                    
                    <button id='next<?php echo $i;?>' class='next btn btn-primary' type='button' >SIGUIENTE</button>
                    </div>

                   <?php }elseif($i==$rows){?>
                    <div id='question<?php echo $i;?>' class='cont'>
                    <p class='questions' id="qname<?php echo $i;?>"> <legend><?php echo $i?> - <?php echo $result['pregunta'];?></legend></p>
                  
                        <?php
                        $respuesta = mysql_query("SELECT respuestas.id as id_respuesta, respuestas.descripcion as respuesta FROM respuestas WHERE respuestas.id_pregunta = '$pregunta_id'") or die(mysql_error());
                        while($resultado = mysql_fetch_array($respuesta)){?>

                        <input type="radio" value='<?php echo $resultado['id_respuesta'];?>' id='<?php echo $resultado['id_respuesta'];?>' name='<?php echo $i; ?>'/>
                        <label for='radio1_<?php echo $resultado['id_respuesta'];?>'><?php echo $resultado['respuesta'];?></label>
                        <!--<input id="valores" type="text" name="valores" value="" style="display:none"/> -->
                        <br/>

                        <?php } ?>

                    <button id='pre<?php echo $i;?>' class='previous btn btn-primary' type='button'>RETROCEDER</button>                    
                    <button id='next<?php echo $i;?>' class='next btn btn-primary' type='submit'>FINALIZAR</button>
                    </div>
					<?php } $i++;} ?>

				</form>
			</div>
		</div>
       <footer>
            <p class="text-center" id="foot">
                &copy; <a href="http://www.toString.es" target="_blank">Francisco Recio 2015</a>
            </p>
        </footer>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>


		<script>
		$('.cont').addClass('hide');
		count = $('.questions').length;
		$('#question'+1).removeClass('hide');


    $(document).ready(function() {

      //var longitud_preguntas = <?php echo $i; ?> - 1;
      var longitud_preguntas = $('.questions').length;
      

        $(".next").click(function () {  


               $(document).on('click','.next',function(){
                   element=$(this).attr('id');

                   last = parseInt(element.substr(element.length - 1));
                   nex=last+1;

                    if( $("input[name='" + last + "']:radio").is(':checked')) {

                    //var prueba = $("input[name='" + last + "']:checked", '#login').val();
                    var prueba = $("input:checked", '#login');
                    var valor = "";

                    if (prueba.length == longitud_preguntas) {
                        for (var i=0; i<longitud_preguntas; i++) {

                        //console.log(prueba[i].value);
                            valor = valor + ',' + prueba[i].value;
                        }
                      
                        $('#valores').val(valor);
                    }

                   $('#question'+last).addClass('hide');
                   $('#question'+nex).removeClass('hide');

                  } else {
                   //No hay alguno seleccionado 

                  }

               });

               $(document).on('click','.previous',function(){
                       element=$(this).attr('id');

                       last = parseInt(element.substr(element.length - 1));
                       pre=last-1;
                       $('#question'+last).addClass('hide');

                       $('#question'+pre).removeClass('hide');
               });


        });


    });


		</script>
	</body>
</html>
<?php }else{

 header( 'Location: http://localhost/index.php' ) ;

}
?>
