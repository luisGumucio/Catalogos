<?php
	require_once('PhpConsole.php');
	PhpConsole::start();

	//Variables globales
 	$error = 0;
 	$ajaxx = 0;
 	$codigo = "";
	$descCorta = "";
	$descLarga = "";
	$precio = "";
	$precioReg = "";
	$promo = "";

	// Create connection
	mysql_connect("localhost","root","root") or die(mysql_error());
	// mysql_connect("ochonuev","ochonuev","dB147Wmwf5") or die(mysql_error());
	mysql_select_db("dummy") or die(mysql_error());
	// mysql_select_db("_dummy") or die(mysql_error());

	//Obtención de coordenadas de tags
	$sql = mysql_query("SELECT posX, posY FROM ProductoTag") or die(mysql_error());

	//Obtener info del Tag dependiendo el click del tag
	if(isset($_POST['ajax'])){
		$x = $_COOKIE['x'];
		$y = $_COOKIE['y'];
		$ajaxx = 1;

		$dbh=mysql_connect ("localhost", "root", "root") or die ('problema conectando porque :' . mysql_error());
		mysql_select_db ("dummy",$dbh);
		$result=mysql_query("SELECT p.idProducto, codigo, descripcionCorta, descripcionLarga, precio, precioRegular, tienePromocion FROM Producto p, ProductoTag t WHERE p.idProducto = t.idProductoTag AND t.posX = $x AND t.posY = $y;");
		$res = mysql_fetch_array($result,MYSQL_NUM);
		$id = $res[0];
		$codigo = $res[1];
		$descCorta = $res[2];
		$descLarga = $res[3];
		$precio = $res[4];
		$precioReg = $res[5];
		$promo = $res[6];

		//Cookie sets
		setcookie("id",$id);
		setcookie("codigo",$codigo);
		setcookie("descCorta",$descCorta);
		setcookie("descLarga",$descLarga);
		setcookie("precio",$precio);
		setcookie("precioReg",$precioReg);
		setcookie("promo",$promo);
	}

	//Update de información de cierto tag
	if(isset($_POST['submit'])){
	    $dbh=mysql_connect ("localhost", "root", "root") or die ('problema conectando porque :' . mysql_error());
		mysql_select_db ("dummy",$dbh);

	    $codigo = $_POST[codigo];
	    $descCorta = mysql_real_escape_string($_POST[descCorta]);
	    $descLarga = mysql_real_escape_string($_POST[descLarga]);
	    $precio = $_POST[precio];
	    $promo = $_POST[tienePromocion];
	    $precioReg = $_POST[precioRegular];
	    $tagX = $_POST[tagX];
	    $tagY = $_POST[tagY];
	    $id = $_COOKIE['id'];

	    $sql="UPDATE Producto SET codigo='$codigo', descripcionCorta='$descCorta', descripcionLarga='$descLarga', precio='$precio', tienePromocion='$promo', precioRegular='$precioReg' WHERE idProducto = $id";

	    if (!mysql_query($sql,$dbh)){
	    	$error = 1;
	    }else{
	    	$error = 2;
	    }
 	}

 	//Eliminar información y tag
 	if(isset($_POST['delete'])){
	    $dbh=mysql_connect ("localhost", "root", "root") or die ('problema conectando porque :' . mysql_error());
		mysql_select_db ("dummy",$dbh);

	    $id = $_COOKIE['id'];

	    $sql="DELETE FROM Producto WHERE idProducto = $id";
	    $sql2="DELETE FROM ProductoTag WHERE idProducto = $id";

	    if (!mysql_query($sql,$dbh) || !mysql_query($sql2,$dbh)){
	    	$error = 1;
	    }else{
	    	$error = 2;
	    }
 	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>Admin</title>
	<link rel="stylesheet" href="stylesheets/screen.css">
</head>
<body>
	<div class="grid">
		<div class="grid__item one-whole">
			<header class="mainbar">
				<ul>
					<li><a href="intro.html">Catálogo Administrador</a></li>
					<li><a href="catalogo.html">Catálogos</a></li>
					<li><a href="template.php">Tags</a></li>
					<li><a href="#">En sesión como <span>Administrador</span></a></li>
				</ul>
			</header>
		</div>
		<div class="grid__item one-whole">
			<div class="subbar">
				<ul class="subnav">
					<li><a href="template.php">Crear Tags</a></li>
					<li><a href="edit.php">Editar Tags</a></li>
				</ul>
			</div>
		</div><!--
	 --><div class="grid__item two-thirds">
	 		<ul class="pager">
				<li><a href="#">Previous</a></li>
				<li><a href="#">Next</a></li>
			</ul>
			<div class="placeholder">
				<h3>Catálogo Nivea</h3>
				<!-- <img src="images/aldo.jpg" alt=""> -->
				<img id="foto" src="images/bebe4.jpg" alt="" onclick="getOffsets()">
				<?php
					while($tags = mysql_fetch_array($sql)){

						echo "<img onclick='coords(".(((int)($tags['posX']))).",".(((int)($tags['posY']))).")' class='tags' src='images/tag.svg' style='width: 1em; height: auto; position: absolute; top: ".(((int)($tags['posY']))+40)."px; left: ".(((int)($tags['posX']))+70)."px;'>";
					}

				?>
				<div class="pagination">
					<input class="input-mini" type="text" placeholder="5"><span><h5>/ 100</h5></span>
				</div>
			</div>
		</div><!--
		  --><div class="grid__item one-third">
		  <?php
              if($error == 1){
            ?>
		  <div class="alert alert-error">
		  		Los datos no pudieron ser guardados con éxito.
		  	</div>
		  	<?php
              }else if($error == 2){
            ?>
		  	<div class="alert alert-success">
		  		Los datos se actualizaron con éxito.
		  	</div>
		  	 <?php
              }
            ?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Datos de la página</legend>
					<label for="codigo">Código</label>
					<input type="text" id="codigo" name="codigo" placeholder="Código" value=""><br>
					<label for="descCorta">Descripción Corta</label><br>
					<textarea name="descCorta" id="descCorta" cols="30" rows="5" placeholder="Descripción Corta"></textarea><br>
					<label for="descLarga">Descripción Larga</label><br>
					<textarea name="descLarga" id="descLarga" cols="30" rows="5" placeholder="Descripción Larga"></textarea><br>
					<label for="precio">Precio</label>
					<input type="text" id="precio" name="precio" placeholder="Precio"><br>
					<label for="precioRegular">Precio Regular</label>
					<input type="text" id="precioRegular" name="precioRegular" placeholder="Precio Regular"><br>
					<label for="promocion">Promoción</label>
					<label class="radio">Si</label>
					<input type="radio" name="tienePromocion" value="1">
					<label class="radio">No</label>
					<input type="radio" name="tienePromocion" value="0">
					<br>
					<input type="text" id="tagX" name="tagX" class="tag">
					<input type="text" id="tagY" name="tagY" class="tag">
					<input type="submit" name="submit" id="button" class="btn btn-primary" value="Actualizar">
					<button class="btn" type="button" onclick="this.form.reset();">Limpiar</button>
					<input type="submit" name="delete" id="delete" class="btn" value="Eliminar"></button>
				</fieldset>
			</form>
		</div>
	</div>
	<script src="../js/jquery.js"></script>
	<script src="../js/cookie.js"></script>
	<script>
		//Obtención de coordenadas del tag
		function coords(x,y){
			$.cookie("x",x);
			$.cookie("y",y);
			$.post("edit.php", {ajax: ""}).done(function(){
													var id = $.cookie('id');
													var c = $.cookie('codigo');
													var dc = $.cookie('descCorta');
													var dl = $.cookie('descLarga');
													var p = $.cookie('precio');
													var pr = $.cookie('precioReg');
													var promo = $.cookie('promo');
													$("#codigo").val(c);
													$("#descCorta").val(dc);
													$("#descLarga").val(dl);
													$("#precio").val(p);
													$("#precioRegular").val(pr);
													if(1 == promo)
														$("input[name=tienePromocion][value=" + 1 + "]").prop('checked', true);
													else
														$("input[name=tienePromocion][value=" + 0 + "]").prop('checked', true);
												});
		}
	</script>
	<script>
		(function(){
			$.removeCookie('x');
			$.removeCookie('y');
		})();
	</script>
</body>
</html>