<?php
    
    $url = @$_GET['url'];

    if ($url == '') {
        include('painel.php');
    }else{
        include('TemplateLeitor.php');
        $pdo = new PDO('mysql:host=localhost;dbname=projeto_cms','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $select = $pdo->prepare("SELECT * FROM `paginas` WHERE slug = ?");
        $select->execute(array($url));
        if ($select->rowCount() >= 1) {
            $conteudo = $select->fetch();
            $contentPagina = file_get_contents('templates/'.$conteudo['template']);
            $fields = TemplateLeitor::pegaCampos($contentPagina,'\{\{!(.*?)\}\}');
            
            $conteudoFinal = explode('--!--',$conteudo['valores']);
            $contentPagina = str_replace($fields['chave'], $conteudoFinal, $contentPagina);

            echo $contentPagina;
        }else{
            include('painel.php');
        }
    }
    

?>