<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
// Pegar emprestimo
$idemprestimo = $_GET['idemprestimo'];
// Validar emprestimo
$sql = "Select cod_controle From emprestimos
Where
  (cod_controle = $idemprestimo)
  And (status = '" . EMPRESTIMO_ABERTO . "')";
$consulta = mysqli_query($con, $sql);
$emprestimo = mysqli_fetch_assoc($consulta);
if (!$emprestimo) {
    // Nao encontrou a emprestimo
    header('location:emprestimos-listar.php');
    exit;
}
// Criar o emprestimo na sessao
$_SESSION['emprestimo'] = $idemprestimo;
// Redirecionar usuario para venda-produto.php
header('location:emprestimos-livro.php');
