<?php
	session_start();
	require 'config.php';
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
		<div class="container">
			<div class="row">
				<div class="col-xs-14 col-sm-12 col-md-4 col-sm-offset-2 col-md-offset-4">
					<div class='image'>
						<img src="image/logo.png" class="img-responsive center-block"/>
					</div>
				</div>
				<div class="col-xs-14 col-sm-12 col-md-4 col-sm-offset-2 col-md-offset-4">
					<div class="intro">

						<?php if(empty($_SESSION['nombre'])){?>
							<form class="form-signin" method="post" id='signin' name="signin" action="questions.php">
								<div class="form-group">
									<input type="text" id='name' name='nombre' class="form-control" placeholder="Escribe un nombre"/>
									<span class="help-block"></span>
								</div>
								<div class="form-group">
								    <select class="form-control" name="categoria" id="category">
								    <option value="">SELECCIONA UN TEST</option>

									<?php
									$categorias = 'select * from categorias';
									$resultado = mysql_query($categorias);
	  
									while($fila=mysql_fetch_array($resultado)){
	    								echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
									} ?>

									</select>

	                                <span class="help-block"></span>
								</div>

								<br>
								<button class="btn btn-primary btn-block" type="submit">
									Comenzar!!
								</button>
							</form>

						<?php } else { ?>
						    <form class="form-signin" method="post" id='signin' name="signin" action="questions.php">

								<div class="form-group">
								    <select class="form-control" name="categoria" id="category">
								    <option value="">SELECCIONA UN TEST</option>

									<?php
									$categorias = 'select * from categorias';
									$resultado = mysql_query($categorias);
	  
									while($fila=mysql_fetch_array($resultado)){
	    								echo "<option value='".$fila['nombre']."'>".$fila['nombre']."</option>";
									} ?>

									</select>

	                                <span class="help-block"></span>
	                            </div>

	                            <br>
	                            <button class="btn btn-primary btn-block" type="submit">Comenzar!!</button>
                        	</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<p class="text-center" id="foot">
				&copy; <a href="http://www.toString.es/" target="_blank">Francisco Recio 2015 </a>
			</p>
		</footer>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

		<script>
			$(document).ready(function() {
				$("#signin").validate({
					submitHandler : function() {

						if ($("#signin").valid()) {

							return true;
						} else {
							return false;
						}

					},
					rules : {
						nombre : {
							required : true,
							minlength : 3,
							remote : {
								url : "comprobar_nombre.php",
								type : "post",
								data : {
									username : function() {
										return $("#nombre").val();
									}
								}
							}
						},
						categoria:{
						    required : true
						}
					},
					messages : {
						nombre : {
							required : "Escriba un nombre",
							remote : "El nombre ya existe, elige otro nombre"
						},
						categoria:{
                            required : "Elige una categoria para comenzar"
                        }
					},
					errorPlacement : function(error, element) {
						$(element).closest('.form-group').find('.help-block').html(error.html());
					},
					highlight : function(element) {
						$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
					},
					success : function(element, lab) {
						var messages = new Array("Buena eleccion", "Buena idea");
						var num = Math.floor(Math.random() * 2);
						$(lab).closest('.form-group').find('.help-block').text(messages[num]);
						$(lab).addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success');
					}
				});
			});
		</script>

	</body>
</html>
