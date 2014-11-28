<?php 
include '../lib/ir_a.php';
session_start();
$reglas = array();
$items = array();
if (isset($_POST['reglas']))
{
  
  $_SESSION['reglas'] = array();
  $_SESSION['items'] = array();


  $reglasPost = split(' ', $_POST['reglas']);
  $itemsPost = split(' ', $_POST['items']);

  foreach ($reglasPost as $key => $value)
  {
    if (strlen($value)>2)
    {
      // Agregar a variable de sessión
      $_SESSION['reglas'][] = $value;
      $reglas[] = $value;
    }
  }

  foreach ($itemsPost as $key => $value)
  {
    if (strlen($value)>2)
    {
      // Agregar a variable de sessión
      $_SESSION['items'][] = $value;
      $items[] = $value;
    }
  }
}
if(count($_SESSION['reglas'])>1)
{
  $reglas = $_SESSION['reglas'];
  $items = $_SESSION['items'];
}
else
  exit("<a href='index.php'>Ingresar reglas e Items</a>");
//$reglas = array('S=(A)','A=CB','B=;A','B=3','C=x','C=S');
// $reglas = array('S=ABC','A=xB','B=y','C=ab');
// $items= array('S=A.BC');
$cadena = 'B';

if(isset($_GET['cadena']))
  if (strlen($_GET['cadena'])) 
    $cadena = $_GET['cadena'];

$ir_a = new Ir_A();
$ir_a->setReglas($reglas);
$ir_a->setItems($items);
$cc = $ir_a->ir($cadena);

$clausura = new Clausura();
$clausura->setReglas($reglas);
$clausura->setItems($items);
$clausura->clausura();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.ico">

    <title>Construcción de Compiladores - Universidad Nacional San Antonio Abad del Cusco</title>

    <!-- Bootstrap core CSS -->
    <link href="http://escodigo.com/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://escodigo.com/assets/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/blog.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="http://escodigo.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="index.php">Home</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Analizador Sintáctico LR</h1>
        <p class="lead blog-description">Universidad Nacional San Antonio Abad del Cusco.</p>
      </div>
      <div class="row">
        <div class="col-sm-6 blog-main">
			<div class="panel panel-primary">
            	<div class="panel-heading">
              		<h3 class="panel-title">Reglas</h3>
            	</div>
            	<div class="panel-body">
			<?php 
			foreach($reglas as $key => $value)
			{
				echo "<p>$value</p>";
			}
			?>
            	</div>
          	</div>
			<div class="panel panel-primary">
            	<div class="panel-heading">
              		<h3 class="panel-title">Items</h3>
            	</div>
            	<div class="panel-body">
			<?php 
			foreach($items as $key => $value)
			{
				echo "<p>$value</p>";
			}
			?>
            	</div>
          	</div>
			<a href="index.php">Volver</a>
		</div>
        <div class="col-sm-6 blog-main">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Clausura / Cerradudara</h3>
            </div>
            <div class="panel-body">
			<?php 
			foreach($clausura->getCerradura() as $key => $value)
			{
				echo "<p>$key</p>";
			}
			?>
            </div>
          </div>
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">ir_a(I,'<?php echo $cadena; ?>')</h3>
            </div>
            <div class="panel-body">
			<?php if(count($cc)>0): ?>
				<?php foreach($cc as $key => $valor): ?>
					<p><?php echo $key; ?></p>
				<?php endforeach; ?>
			<?php else:?>
				<p><b>No existe</b></p>
			<?php endif;?>
            </div>
          </div>
			<form method="get" class="form-horizontal" role="form">
              <div class="form-group">
                  <label class="col-sm-3 control-label" for="regla">Símbolo:</label>
                  <div class="col-sm-9"><input type="text" name="cadena" class="form-control" value=""></div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" name="guardar" class="btn btn-primary" >Calcular</button>
                  </div>
              </div>
          </form>

       </div>
       </div>
          <div class="row">
          <div class="col-sm-6 blog-main">
                      </div>
          </div>
          </div><!-- /.container -->

    <div class="blog-footer">
      <p>Juan E. Huamani Mendoza <a href="http://github.com">GitHub</a> <a href="https://twitter.com/Eraceo">@Eracleo</a>.</p>
      <p>Estudiante de Ing. Informatica y de Sistemas<br>Universidad Nacional San Antonio Abad del Cusco</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </div>
    <script src="http://escodigo.com/assets/js/jquery-v2.min.js"></script>
    <script src="http://escodigo.com/assets/js/bootstrap.min.js"></script>
  </body>
</html>
