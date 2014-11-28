<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.ico">

    <title>Analizador Sintáctico LR - Construcción de Compiladores - Universidad Nacional San Antonio Abad del Cusco</title>

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
          <a class="blog-nav-item active" href="#">Home</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        <h1 class="blog-title">Analizador Sintáctico LR</h1>
        <p class="lead blog-description">Universidad Nacional San Antonio Abad del Cusco.</p>
      </div>
      <div class="row">
        <div class="col-sm-6 ">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Reglas</h3>
            </div>
            <div class="panel-body">
            <form method="post" action="_procesar_lr.php" class="form-horizontal" role="form">
              	<div class="form-group">
                  <label class="col-sm-11 " for="regla">Reglas:</label>
                  <div class="col-sm-11"><textarea rows="4" name="reglas" class="form-control"></textarea>
                  Separé con espacios las reglas
                  </div>
              	</div>
				<div class="form-group">
                  <label class="col-sm-11 " for="regla">Items:</label>
                  <div class="col-sm-11"><textarea rows="4" name="items" class="form-control"></textarea>
                  Separé con espacios los Items
                  </div>
              	</div>
              	<div class="form-group">
                  <div class="col-sm-offset-8 col-sm-9">
                  <button type="submit" name="guardar" class="btn btn-primary" >Procesar</button>
                  </div>
              	</div>
            </form>
			<p><a href="gramaticas.txt" target="_BLANCK">Gramaticas</a></p>
            </div>
          </div>

        </div><!-- /.blog-main -->
        
        <div class="col-sm-6 blog-main">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Contiene</h3>
            </div>
            <div class="panel-body">
              <ul>
                <li><a href="clausura.html">Clausura / Cerradura</a></li>
                <li><a href="ir_a.html">ir_a / goto</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.blog-main -->
        <p align="center"><a href="http://escodigo.com/analizador">http://escodigo.com/analizador</a></p>
      </div><!-- /.row -->
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
