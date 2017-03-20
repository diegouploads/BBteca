<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$cod_livro = mysqli_real_escape_string($con, $_POST['cod_livro']);
$titulo = mysqli_real_escape_string($con, $_POST['titulo']);
$autor = mysqli_real_escape_string($con, $_POST['autor']);
$descricao = mysqli_real_escape_string($con, $_POST['descricao']);
$editora = mysqli_real_escape_string($con, $_POST['editora']);
$edicao = mysqli_real_escape_string($con, $_POST['edicao']);
$exemplares = mysqli_real_escape_string($con, $_POST['exemplares']);
$multa = mysqli_real_escape_string($con, $_POST['multa_atraso']);
$dias_dev = mysqli_real_escape_string($con, $_POST['dias_dev']);

$result_cursos = "UPDATE livros SET
                    titulo = '$titulo',
                    autor = '$autor',
                    descricao = '$descricao',
                    editora = '$editora',
                    edicao = '$edicao',
                    exemplares = '$exemplares',
                    multa_atraso = '$multa',
                    dias_dev = '$dias_dev'
                    WHERE cod_livro = '$cod_livro'";
$resultado_cursos = mysqli_query($con, $result_cursos);

//echo $cod_livro . " - " . $titulo . " - " . $autor . " - " . $descricao . " - " . $editora . " - " . $edicao . " - " . $exemplares . " - " . $multa . " - " . $dias_dev;

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
    </head>

    <body> <?php
        if(mysqli_affected_rows($con) != 0){
            echo "
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/bbteca_ontheline/livro-listar.php'>
                <script type=\"text/javascript\">
                    alert(\"Informações do livro atualizadas com sucesso!\");
                </script>
            ";  
        }else{
            echo "
                <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/bbteca_ontheline/livro-listar.php'>
                <script type=\"text/javascript\">
                    alert(\"Erro ao atualizar informações do livro!\");
                </script>
            ";  
        }?>
    </body>
</html>
<?php $con->close(); ?>


