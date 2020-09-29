<?php include('TemplateLeitor.php'); ?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>    
        
    <header>
        <nav  class="navbar navbar-expand-lg navbar-light ">
            <div  class="container">
                <a style="color:white" class="navbar-brand" href="#">Painel CMS</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <span class="navbar-text">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Cadastrar Página <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Listar Páginas <span class="sr-only">(current)</span></a>
                            </li>
                        </ul>
                    </span>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="alert alert-dark" role="alert">
            <?php
                if (isset($_POST['acao'])) {
                    $nomeArquivo = $_POST['nome_arquivo'];
                    $nomePagina = $_POST['nome_pagina'];
                    $conteudoPagina = '';

                    foreach ($_POST as $key => $value) {
                        if ($key != 'acao' && $key != 'nome_arquivo' && $key != 'nome_pagina') {
                            $conteudoPagina.=$value;
                            $conteudoPagina.="--!--";
                        }
                    }
                     $pdo = new PDO('mysql:host=localhost;dbname=projeto_cms','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                     $exec = $pdo->prepare("INSERT INTO `paginas` VALUES(null,?,?,?)");
                     $exec->execute(array($nomePagina,$nomeArquivo,$conteudoPagina));
                     echo '<script>alert("Sua página foi salva com sucesso!")</script>';
                }


                if (!isset($_POST['etapa_2'])) {
            ?>
            <form method="post">
                <div class="form-group">
                    <select class="form-control" name="arquivo">
                        <?php
                            $files = glob("templates/*.html");
                            foreach ($files as $key => $value) {
                                $files= explode('/',$value);
                                $fileName = $files[count($files) - 1];
                                echo '<option value="'.$fileName.'">'.$fileName.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="nome_pagina" placeholder="Nome da sua página...">
                </div>
                <input class="btn btn-success" type="submit" name="etapa_2" value="Próxima Etapa!"> 
            </form>
            <?php
                 }else{
                     $nomeArquivo = $_POST['arquivo'];
                     $nomePagina = $_POST['nome_pagina'];

                     //Pegamos os dados do arquivo e calculamos quantos campos tem para serem substituidos

                     $getContent = file_get_contents('templates/'.$nomeArquivo);

                     $fields = TemplateLeitor::pegaCampos($getContent,'\{\{!(.*?)\}\}');
                ?>

                    <h2>Editando página: <span class="badge badge-pill badge-info"><?= $nomePagina ?></span> | Arquivo Base: <span class="badge badge-pill badge-info"><?= $nomeArquivo ?></span></h2>
                    <form method="post">
                        <?php
                            for ($i=0; $i < count($fields['chave']); $i++) { 
                                echo '<input type="text" name="'.$fields['campo'][$i].'" placeholder="'.$fields['campo'][$i].'">';
                                echo '<hr>';
                            }
                        ?>
                        <input type="hidden" name="nome_pagina" value="<?=$nomePagina ?>">
                        <input type="hidden" name="nome_arquivo" value="<?=$nomeArquivo?>">
                        <input class="btn btn-success" type="submit" name="acao" value="Salvar!">    
                    </form>

            <?php } 
                ?>
        </div>
    </div>




      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>