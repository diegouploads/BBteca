<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
// Pegar idemprestimo
if (!isset($_SESSION['emprestimo'])) {
    header('location:emprestimos-listar.php');
    exit;
}
$idemprestimo = $_SESSION['emprestimo'];
// Validar emprestimo
$sql = "Select cod_controle
From emprestimos
Where
    (cod_controle = $idemprestimo)
    And (status = " . EMPRESTIMO_ABERTO . ")";
$consulta = mysqli_query($con, $sql);
$emprestimo = mysqli_fetch_assoc($consulta);
if (!$emprestimo) {
    header('location:emprestimos-listar.php');
    exit;
}
// Finalizar emprestimo
$sql = "Update emprestimos Set status=" . EMPRESTIMO_FECHADO
    . " Where (cod_controle = $idemprestimo)";
mysqli_query($con, $sql);
unset($_SESSION['emprestimo']);
// Redirecionar usuario para emprestimos-listar.php
header('location:emprestimos-detalhes.php?idemprestimo=' . $idemprestimo);