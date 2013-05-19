<?php 
$error = 0;

  if(isset($_POST['submit'])){
    // Create connection
    // $con=mysqli_connect("localhost","root","root","dummy");
    $con=mysqli_connect("localhost","root","","catalogos");

    // Check connection
    if (mysqli_connect_errno($con)){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $codigo = $_POST[codigo];
    $descCorta = mysql_real_escape_string($_POST[descCorta]);
    $descLarga = mysql_real_escape_string($_POST[descLarga]);
    $precio = $_POST[precio];
    $promo = $_POST[tienePromocion];
    $precioReg = $_POST[precioRegular];
    $tagX = $_POST[tagX];
    $tagY = $_POST[tagY];

    $sql=mysqli_query($con,"UPDATE Producto SET codigo=$codigo, descripcionCorta=$descCorta, descripcionLarga=$descLarga,precio=$precio, tienePromocion=$promo,
    	precioRegular=$precioReg Where codigo = 123456789");

    mysqli_close($con);

  }
?>
<?php
 	$error = 0;

	// Create connection
	// mysql_connect("localhost","root","root")
	mysql_connect("localhost","root","","catalogos")
	or die(mysql_error());

	// mysql_select_db("dummy") or die(mysql_error());
	mysql_select_db("catalogos") or die(mysql_error());

	// Check connection
	if (mysqli_connect_errno($con)){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$sql = mysql_query("SELECT posX, posY FROM ProductoTag")
	or die(mysql_error());
	$codigo = "Codigo";
	$descCorta = "Descripción corta";
	$descLarga = "Descripción Larga";
	$precio = "Precio";
	$precioRegular = "Precio regular";

	function recoje_info_tag(){
		$x = $_COOKIE['x'];
		$y = $_COOKIE['y'];
		echo $x;
		echo ",";
		echo $y;
		$con=mysqli_connect("localhost","root","","catalogos");
			// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$result = mysqli_query($con,"SELECT * FROM Producto");

		$row = mysqli_fetch_array($result);
		$codigo = $row['codigo'];
		$descCorta = $row['descripcionCorta'];
		$descLarga = $row['descripcionLarga'];
		$precio= $row['precio'];
		$tienePromocion = $row['tienePromocion'];
		$precioRegular = $row['precioRegular'];
		mysqli_close($con);
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
<script>
	function tag(x,y){
		x =x - 70;
		y = y - 40;
		create_cookie(x,y);
		alert("<?php recoje_info_tag(); ?>");
	}
</script>
<body>
	<div class="grid">
		<div class="grid__item one-whole">
			<header class="mainbar">
				<ul>
					<li><a href="#">Catálogo Administrador</a></li>
					<li><a href="#">Catálogos</a></li>
					<li><a href="#">Tags</a></li>
					<li><a href="#">En sesión como <span>Administrador</span></a></li>
				</ul>
			</header>
		</div>
		<div class="grid__item one-whole">
			<div class="subbar">
				<ul class="subnav">
					<li><a href="template.php">Crear Tags</a></li>
					<li><a href="#">Editar Tags</a></li>
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

						echo "<img src='images/tag.svg' onclick=tag(".(((int)($tags['posX']))+70).",".(((int)($tags['posY']))+40).") style='width: 1em; height: auto; position: absolute; top: ".(((int)($tags['posY']))+40)."px; left: ".(((int)($tags['posX']))+70)."px;'>";
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
		  		Los datos se guardaron con éxito.
		  	</div>
		  	 <?php
              }
            ?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<fieldset>
					<legend>Datos de la página</legend>
					<label for="codigo">Código</label>
					<input type="text" id="codigo" name="codigo" placeholder="<?php echo $codigo; ?>"><br>
					<label for="descCorta">Descripción Corta</label><br>
					<textarea name="descCorta" id="descCorta" cols="30" rows="5" placeholder="<?php echo $descCorta; ?>"></textarea><br>
					<label for="descLarga">Descripción Larga</label><br>
					<textarea name="descLarga" id="descLarga" cols="30" rows="5" placeholder="<?php echo $descLarga; ?>"></textarea><br>
					<label for="precio">Precio</label>
					<input type="text" id="precio" name="precio" placeholder="<?php echo $precio; ?>"><br>
					<label for="precioRegular">Precio Regular</label>
					<input type="text" id="precioRegular" name="precioRegular" placeholder="<?php echo $precioRegular; ?>"><br>
					<label for="promocion">Promoción</label>
					<label class="radio">Si</label>
					<input type="radio" name="tienePromocion" value="1">
					<label class="radio">No</label>
					<input type="radio" name="tienePromocion" value="0">
					<br>
					<input type="text" id="tagX" name="tagX" class="tag">
					<input type="text" id="tagY" name="tagY" class="tag">
					<input type="submit" name="submit" id="button" class="btn btn-primary" value="Guardar">
					<button class="btn" type="button">Limpiar</button>
				</fieldset>
			</form>
		</div>
	</div>
	<script src="../js/jquery.js"></script>
	<script src="../js/cookie.js"></script>
	<script>
		function create_cookie(a,b){
			$.cookie("x",a);
			$.cookie("y",b);
		}
	</script>
	<script>
    function getOffsets(){
      img = document.getElementById("foto");
      parent = img.parentNode;
      clientX = event.clientX;
      clientY = event.clientY;
      imgX = img.offsetLeft+15;
      imgY = img.offsetTop+167;
      alert("La imagen se encuentra en la coordenada: (" + imgX + ", " + imgY + ")");
      alert("El mouse dio click en: (" + clientX + ", " + clientY + ")");
      offsetX = clientX - imgX;
      offsetY = clientY - imgY;
      document.getElementById("tagX").value = offsetX;
      document.getElementById("tagY").value = offsetY;
      alert("Total: (" + offsetX + ", " + offsetY + ")");
      offsetX+= 70;
      offsetY+= 40;

      im_bar = document.createElement("img");
      im_bar.src = "images/tag.svg";
      im_bar.display = "block";
      im_bar.style.width = "1em";
      im_bar.style.height = "auto";
      im_bar.style.position = "absolute";
      im_bar.style.top = offsetY.toString() + "px";
      im_bar.style.left = offsetX.toString() + "px";
      parent.insertBefore(im_bar);
    }
  </script>
</body>
</html>