<?php 
include '../lib/recursionAmbiguedad.php';
include '../lib/primeroSiguiente.php';
include '../lib/tablaLL.php';
include '../lib/operaciones.php';
include '../lib/tablaAnalisisSintacticoLL.php';
session_start();
$reglas = array();
if (isset($_POST['reglas']))
{
  $_SESSION['reglas'] = array();
  
  $reglasPost = split(' ', $_POST['reglas']);

  foreach ($reglasPost as $key => $value)
  {
    if (strlen($value)>2)
    {
      // Agregar a variable de sessión
      $_SESSION['reglas'][] = $value;
      $reglas[] = $value;
    }
  }
}
if(count($_SESSION['reglas'])>1)
{
  $reglas = $_SESSION['reglas'];
}
else
  exit("<a href='index.php'>Ingresar reglas</a>");
//*/
//$reglas = array('V=V:V;','V=X','V=Y','L=i');
//print_r($reglas);
//$reglas = array('E=A*B','A=B','B=n');
//print_r($reglas);
//$reglas = array('E=E+E','E=E-E','E=E*E','E=E/E','E=n');
//$reglas = array('E=+EF','E=-EF','E=*EF','E=/EF','E=n','F=EF','F=3');
//$reglas = array('E=E+E','E=E-E','E=n');
//$reglas = array('S>L=R','S>R','L>*R','L>i','R>L');
//$reglas = array('D=Td;D','D=3','T=BC','T=r{D}','B=i','B=f','C=3','C=[n]C');
//$reglas = array('S=(A)','A=CB','B=;A','B=3','C=x','C=S');
//$cadena= "((x;x);x)";
$cadena = "(xx;)";
if(isset($_GET['cadena']))
  if (strlen($_GET['cadena'])) 
    $cadena = $_GET['cadena'];
$ra = new RecursionAmbiguedad();
$ra->setReglas($reglas);
$sr = $ra->sinRecursion();
$ps = new PrimeroSiguiente();
$ps->setReglas($sr);
$ps->primero();
$ps->siguiente();

$ta = new TablaLL();
$ta->setReglas($sr);
$ta->setTerminales($ps->getTerminales());
$ta->setNoTerminales($ps->getNoTerminales());
$ta->setPrimero($ps->getPrimero());
$ta->setSiguiente($ps->getSiguiente());
$ta->generar();

$tasll = new TablaAnalisisSintacticoLL();
$tasll->setTablaLL($ta->getTabla());
$tasll->setCadena($cadena);
$tasll->setTerminales($ps->getTerminales());
$tasll->setAxioma($ps->getAxioma());

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
        <h1 class="blog-title">C. COMPILADORES</h1>
        <p class="lead blog-description">Universidad Nacional San Antonio Abad del Cusco.</p>
      </div>
      <div class="row">
        <div class="col-sm-6 blog-main">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Reglas</h3>
            </div>
            <div class="panel-body">
              <?php imprimirArray($ra->getReglas(),"<br>"); ?>
            </div>
          </div>
        </div><!-- /.blog-main -->
        
        <div class="col-sm-6 blog-main">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Simbolos</h3>
            </div>
            <div class="panel-body">
              <p><b>Terminales:</b> {
              <?php imprimirArray($ps->getTerminales(),"   "); ?>}
              </p>
              <p><b>No Terminales:</b> {
              <?php imprimirArray($ps->getNoTerminales(),"  "); ?>}
              </p>
            </div>
          </div>
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Recursion y Ambiguedad</h3>
            </div>
            <div class="panel-body">
              <?php 
              if($ra->hayRecurrencia())
                echo "<p>Había Recurrencia</p>";
              else 
                echo "<p>Sin Recurrencia</p>";
              imprimirArray($sr); 
              ?>
            </div>
          </div>
        </div><!-- /.blog-main -->

      </div><!-- /.row -->
      <div class="row">
       <div class="col-sm-6 blog-main">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Primero</h3>
            </div>
            <div class="panel-body">
              <?php
              foreach ($ps->getPrimero() as $key => $value) {
                echo "<p><b>primero($key)</b> = { $value } </p>";
              }?>
            </div>
          </div>
       </div>
       <div class="col-sm-6 blog-main">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Siguientes</h3>
            </div>
            <div class="panel-body">
            <?php
              foreach ($ps->getSiguiente() as $key => $value) {
                echo "<p><b>siguiente($key)</b> = { $value } </p>";
              }?>
            </div>
          </div>
       </div>
       </div>
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Tabla LL</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
            <thead>
            <tr>
                <th> </th>
                <?php foreach ($ps->getTerminales() as $key => $value)
                {
                    echo "<th>$key</th>";
                }
                ?>
                <th>$</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($ta->getTabla() as $fila => $columa)
                {
                    echo "<tr>";
                    echo "<td><b>$fila</b></td>";
                    foreach ($columa as $valor)
                    {
                        echo "<td>$valor</td>";
                    }
                    echo "</tr>";
                }

             ?>
             </tbody>
            </table>
            </div>
          </div>
          <div class="row">
          <a name="tablaasll"></a>
          <div class="col-sm-6 blog-main">
            <form method="get" action="#tablaasll" class="form-horizontal" role="form">
              <div class="form-group">
                  <label class="col-sm-3 control-label" for="regla">Cadena:</label>
                  <div class="col-sm-9"><input type="text" name="cadena" class="form-control" value=""></div>
              </div>
              <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-9">
                  <button type="submit" name="guardar" class="btn btn-primary" >Verificar Cadena</button>
                  </div>
              </div>
          </form>
          </div>
          <div class="col-sm-6 blog-main">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <h3 class="panel-title">Tabla de Analisis Sintactico LL</h3>
              </div>
              <div class="panel-body">
              <?php $tasll->generar();
                if($tasll->getEstado()=='1')
                  echo "Cadena Aceptado";
                else 
                  echo "Cadena Rechazado";
               ?>
               <p><a href="?cadena=<?php echo $cadena; ?>&tablaasll=si#tablaasll" class="btn btn-lg btn-link">Mostrar tabla</a></p>
              </div>
            </div>
          </div>
          </div>
          <?php if (isset($_GET['tablaasll'])): ?>
            <table class="table table-striped">
            <thead>
              <tr>
                <th>Pila</th>
                <th>Cadena</th>
                <th>Acció</th>
              </tr>
              </thead>
              <tbody>
              <?php foreach ($tasll->getMensaje() as $key => $fila): ?>
                <tr>
                  <td><?php echo $fila['pila']; ?></td>
                  <td><?php echo $fila['cadena']; ?></td>
                  <td><?php echo $fila['accion']; ?></td>
                </tr>
              <?php endforeach ?>
              </tbody>
            </table>
            <?php
                if($tasll->getEstado()=='1')
                  echo "<div class='btn btn-lg btn-success'><p>Cadena Aceptado</p></div>";
                else 
                  echo "<div class='btn btn-lg btn-danger'><p>Cadena Rechazado</p></div>";
               ?>
          <?php endif ?>
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
