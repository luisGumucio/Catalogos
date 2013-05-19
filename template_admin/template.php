<?php
  $error = 0;

  if(isset($_POST['submit'])){
    // Create connection
    // $con=mysqli_connect("localhost","root","root","dummy");
    $con=mysqli_connect("ochonuev","ochonuev","dB147Wmwf5","_dummy");

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

    $sql="INSERT INTO Producto (codigo, descripcionCorta, descripcionLarga, precio, tienePromocion,
    	precioRegular) VALUES ('$codigo', '$descCorta', '$descLarga', '$precio', '$promo', '$precioReg')";

	$sql2="INSERT INTO ProductoTag (posX, posY) VALUES ('$tagX', '$tagY')";

    if (!mysqli_query($con,$sql) || !mysqli_query($con,$sql2)){
    	$error = 1;
    }else{
    	$error = 2;
    }

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
					<li><a href="#">Crear Tags</a></li>
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
					<input type="text" id="codigo" name="codigo" placeholder="Código"><br>
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
					<input type="submit" name="submit" id="button" class="btn btn-primary" value="Guardar">
					<button class="btn" type="button">Limpiar</button>
				</fieldset>
			</form>
		</div>
	</div>
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