<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
//pegar id leitor
$idleitor = $_GET['idleitor'];
//pegar id usuario
$idusuario = $_SESSION['cod_usuario'];
// Verificar se existe uma venda aberta para $idcliente
// Se existir não abrir outra venda
$sql = "Select cod_controle From emprestimos
Where  (id_leitor = $idleitor) 
And (status = " . EMPRESTIMO_ABERTO . ")";
$consulta = mysqli_query($con, $sql);
$emprestimo = mysqli_fetch_assoc($consulta);
if ($emprestimo) {
    // Existe outro emprestimo
    header('location:emprestimos-continuar.php?idemprestimo=' . $emprestimo['cod_controle']);
    exit;
}
// Criar um emprestimo
//Criar um registro na tabela emprestimo
$data = date('Y-m-d');
$status = EMPRESTIMO_ABERTO;
$sql = "Insert into emprestimos
(id_leitor, idusuario, data_emprestimo, status)
Values
($idleitor, $idusuario, '$data', '$status')";
$result = mysqli_query($con, $sql);
//Pegar o codigo do emprestimo
$idemprestimo = mysqli_insert_id($con);
//Salvar codigo do emprestimo em sessao
$_SESSION['emprestimo'] = $idemprestimo;
//Redirecionar usuario para emprestimo-livro.php
header('location:emprestimos-livro.php');