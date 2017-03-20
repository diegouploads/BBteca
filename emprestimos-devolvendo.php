<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
// Pegar idlivro e acao e idemprestimo
if (!isset($_GET['idemprestimo']) || !isset($_GET['acao']) || !isset($_GET['idlivro'])) {
    header('location:emprestimos-detalhes.php');
    exit;
}
$idemprestimo = $_GET['idemprestimo'];
$acao = $_GET['acao'];
$idlivro = $_GET['idlivro'];
// Validar emprestimo
$sql = "Select * From emprestimoslivros Where (idemprestimo = $idemprestimo)
 AND (idlivro = $idlivro)";
$consulta = mysqli_query($con, $sql);
$emprestimo = mysqli_fetch_assoc($consulta);
if (!$emprestimo) {
    header('location:emprestimos-detalhes.php');
    exit;
}
$dia = date('Y/m/d');
if ($acao == 2){
    // entrega do livro
    $sql = "Update emprestimoslivros Set data_devolvido='$dia' Where (idlivro = $idlivro) 
    AND (idemprestimo = $idemprestimo)";
    mysqli_query($con, $sql);
    // Redirecionar usuario para emprestimos-detalhes.php
    header("location:emprestimos-detalhes.php?idemprestimo=$idemprestimo");
}
$n = NULL;
if ($acao == 3){
    // estornar entrega do livro
    $sql = "Update emprestimoslivros Set data_devolvido = NULL Where (idlivro = $idlivro) 
    AND (idemprestimo = $idemprestimo)";
    var_dump($sql);
    mysqli_query($con, $sql);
    // Redirecionar usuario para emprestimos-detalhes.php
    header("location:emprestimos-detalhes.php?idemprestimo=$idemprestimo");
}