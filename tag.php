<?php
  $error = 0;

  if(isset($_POST['submit'])){
    // Create connection
    $con=mysqli_connect("localhost","root","root","dummy");

    // Check connection
    if (mysqli_connect_errno($con)){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $codigo = $_POST[codigo];
    $descCorta = mysql_real_escape_string($_POST[descripcionCorta]);
    $descLarga = mysql_real_escape_string($_POST[descripcionLarga]);
    $precio = $_POST[precio];
    $promo = $_POST[tienePromocion];
    $precioReg = $_POST[precioRegular];

     $sql="INSERT INTO Producto (codigo, descripcionCorta, descripcionLarga, precio, tienePromocion, precioRegular) 
          VALUES ('$codigo', '$descCorta', '$descLarga', '$precio', '$promo', '$precioReg')";

    if (!mysqli_query($con,$sql)){
      $error = 1;
    }

    $error = 2;

    mysqli_close($con);

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Catalogos | Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="favicon.ico">

  <!-- CSS -->
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/main.css" rel="stylesheet">

  <!-- Slider -->
  <link rel="stylesheet" href="css/flexslider.css" type="text/css">


  <style>
  body {
    padding-top: 60px; 
  }
  </style>
  <link href="css/bootstrap-responsive.css" rel="stylesheet">

  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->

      <!-- Javascript-->
      <script src="js/jquery.js"></script>
      <script src="js/bootstrap-transition.js"></script>
      <script src="js/bootstrap-alert.js"></script>
      <script src="js/bootstrap-modal.js"></script>
      <script src="js/bootstrap-dropdown.js"></script>
      <script src="js/bootstrap-scrollspy.js"></script>
      <script src="js/bootstrap-tab.js"></script>
      <script src="js/bootstrap-tooltip.js"></script>
      <script src="js/bootstrap-popover.js"></script>
      <script src="js/bootstrap-button.js"></script>
      <script src="js/bootstrap-collapse.js"></script>
      <script src="js/bootstrap-carousel.js"></script>
      <script src="js/bootstrap-typeahead.js"></script>
      <script src="js/jquery.fittext.js"></script>
      <script src="js/jquery.flexslider.js"></script>

      <script type="text/javascript" charset="utf-8">
      $(window).load(function() {
            $('.flexslider').flexslider({
                    animation: "slide",
                    controlsContainer: ".flex-container"
            });
      });
      </script>

    </head>

    <body>

      <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">Catalogos</a>
            <div class="nav-collapse collapse">
              <p class="navbar-text pull-right">
                Logged in as <a href="#" class="navbar-link">Username</a>
              </p>
              <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span3">
            <div class="well sidebar-nav">
              <ul class="nav nav-list">
                <li><p><a href="#" class="btn btn-primary btn-large"><i class="icon-tags icon-white"></i> Crear Tag</a></p></li>
                <li><p><a href="#" class="btn btn-primary btn-large"><i class="icon-pencil icon-white"></i> Editar</a></p></li>
              </ul>
            </div><!--/.well -->
          </div><!--/span-->
          <div class="span5">
            <ul class="pager">
              <li><a href="#">Previous</a></li>
              <li><a href="#">Next</a></li>
            </ul>
            <div class="hero-unit">
              <div class="media">
                <a class="pull-left" href="#">
                  <img class="media-object" data-src="holder.js/64x64">
                </a>
                <div class="media-body">
                  <h4 class="media-heading-center">Catalogo N</h4>
                  <br>
                  <h4 class="media-heading-center">Pagina #</h4>
                  <div class="media">
                    <img src="img/bebe4.jpg">
                  </div>
                </div>
              </div>
            </div>
            <div class="pagination pagination-centered">
              <ul>
                <li><a href="#">Prev</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">Next</a></li>
              </ul>
            </div>
          </div><!--/span-->
          <div class="span4">
            <?php
              if($error == 1){
            ?>
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Error! Los datos no pudieron ser guardados.
            </div>
            <?php
              }else if($error == 2){
            ?>
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Los datos fueron guardados exitosamente.
            </div>
            <?php
              }
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
              <fieldset>
                <legend>Datos de la pagina</legend>
                <br>

                <label>Codigo:</label>
                  <input type="text" name="codigo" placeholder="Codigo">

                <label>Descripcion Corta:
                  <textarea rows="5" name="descripcionCorta" placeholder="Descripcion corta"></textarea>
                </label>
                <label>Descripcion larga:
                  <textarea rows="5" name="descripcionLarga" placeholder="Descripcion larga"></textarea>
                </label>
                <label>Precio:
                   <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input name="precio" class="span5" type="text">
                  </div>
                </label>
                <label>
                  <p>Precio regular:</p>
                  <div class="input-prepend input-append">
                    <span class="add-on">$</span>
                    <input name="precioRegular" class="span5" type="text">
                  </div>
                </label>
                <label> Promocion:
                  <br>
                  <label class="radio">Si
                    <input type="radio" name="tienePromocion" id="optionsRadios1" value="1">
                  </label>
                  <label class="radio">No
                    <input type="radio" name="tienePromocion" id="optionsRadios2" value="0">
                  </label>
                </label>
              </fieldset>
              <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn">Guardar y Nuevo</button>
                <button type="button" class="btn">Limpiar</button>
              </div>
            </form>
          </div><!--/span-->
        </div><!--/row-->
      </div>
      <hr>
    </body>

    </html>
