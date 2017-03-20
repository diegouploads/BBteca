<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
$msgOk = array();
$msgAviso = array();
if (!isset($_SESSION['emprestimo'])) {
    header('location:emprestimos-listar.php');
    exit;
}
$idemprestimo = $_SESSION['emprestimo'];
$sql = "Select
	E.cod_controle,
	E.data_emprestimo,
	L.nome leitorNome,
	u.nome usuarioNome
From emprestimos E
Inner Join leitor L
	On (L.cod_leitor = E.id_leitor)
Inner Join usuario u
	On (u.cod_usuario = E.idusuario)
Where
    (E.cod_controle = $idemprestimo)
    And (E.status = " . EMPRESTIMO_ABERTO . ")";
$consulta = mysqli_query($con, $sql);
$emprestimo = mysqli_fetch_assoc($consulta);
if (!$emprestimo) {
    header('location:emprestimos-listar.php');
    exit;
}
/*
Valores para acao
1 = Incluir livro na emprestimo
2 = Remover livro na emprestimo
*/
$acao = 0;
if (isset($_GET['acao'])) {
    $acao = (int)$_GET['acao'];
} elseif (isset($_POST['acao'])) {
    $acao = (int)$_POST['acao'];
}
if ($acao == 1) {
    $idlivro = (int)$_POST['idlivro'];

    $sql = "Select * From livros Where (cod_livro = $idlivro)";
    $consulta = mysqli_query($con, $sql);
    $livro = mysqli_fetch_assoc($consulta);

    $diasDev = $livro['dias_dev'];
    $d = date('Y-m-d');
    $dataPrevia = date('Y/m/d', strtotime("+$diasDev days", strtotime($d)));
    $qtd = $_POST['qtd'];

    $sql = "INSERT INTO emprestimoslivros
(idlivro, idemprestimo, multa_atraso_pg, qtd_emprestado, data_previa, data_devolvido)
VALUES
($idlivro, $idemprestimo, 0.00, $qtd, '$dataPrevia', NULL)";
    $inserir = mysqli_query($con, $sql);

    if ($inserir) {
        $l = "Livro";
        if ($qtd > 1) {
            $l = "Livros";
        }
        $msgOk[] = "Adicionado $qtd $l " . $livro['titulo'];
    } else {
        $msgAviso[] = "Erro para inserir o livro no emprestimo: " . mysqli_error($con);
    }
}
if ($acao == 2) {
    $idlivro = (int)$_GET['idlivro'];

    $sql = "Delete From emprestimoslivros Where (idlivro = $idlivro)";
    $consulta = mysqli_query($con, $sql);

    $msgOk[] = "Livro removido do emprestimo";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Livros do Emprestimo</title>

    <?php headCss(); ?>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Andamento do emprestimo #<?php echo $idemprestimo; ?></h1>
    </div>

    <?php if ($msgOk) {
        msgHtml($msgOk, 'success');
    } ?>
    <?php if ($msgAviso) {
        msgHtml($msgAviso, 'warning');
    } ?>

    <form role="form" method="post" action="emprestimos-livro.php">

        <input type="hidden" name="acao" value="1">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Adicionar livro</h3>
            </div>

            <div class="panel-body">

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-8">
                            <div class="form-group">
                                <label for="fidproduto">Livro</label>
                                <select id="fidlivro" name="idlivro" class="form-control" required>
                                    <option value="">Selecione um livro</option>
                                    <?php
                                    $sql = 'Select * From livros Where status=' . PRODUTO_ATIVO;
                                    $result = mysqli_query($con, $sql);
                                    while ($linha = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $linha['cod_livro']; ?>"><?php echo $linha['titulo']; ?>
                                            - <?php echo $linha['autor']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label for="fqtd">Quantidade</label>
                                <input type="number" class="form-control" id="fqtd" value="0" name="qtd" min="1"
                                       required>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <button type="submit" class="btn btn-primary">Inserir</button>
                <button type="reset" class="btn btn-danger">Limpar</button>
            </div>
        </div>
    </form>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Livros Emprestados</h3>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Qtd.</th>
                <th>Data para entrega</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "Select
	*
From emprestimoslivros E
Inner Join livros L
	On (L.cod_livro = E.idlivro)
Where (E.idemprestimo = $idemprestimo)";
            $consulta = mysqli_query($con, $sql);

            $emprestimoTotal = 0;

            while ($livro = mysqli_fetch_assoc($consulta)) {
                $emprestimoTotal = $livro['qtd_emprestado'] + $emprestimoTotal;
                ?>
                <tr>
                    <td><?php echo $livro['cod_livro']; ?></td>
                    <td><?php echo $livro['titulo']; ?></td>
                    <td><?php echo $livro['qtd_emprestado']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($livro['data_previa'])); ?></td>
                    <td><a href="emprestimos-livro.php?acao=2&idlivro=<?php echo $livro['idlivro']; ?>"
                           title="Remover livro emprestado"><i class="fa fa-times fa-lg"></i></a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <form class="form-horizontal" method="post" action="emprestimos-fechar.php">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Fechar Emprestimo</h3>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="fcliente" class="col-sm-2 control-label">Código:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo $idemprestimo; ?></p>
                    </div>

                    <label for="fcliente" class="col-sm-2 control-label">Data:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo date('d/m/Y', strtotime($emprestimo['data_emprestimo'])); ?></p>
                    </div>

                    <label for="fcliente" class="col-sm-2 control-label">Cliente:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo $emprestimo['leitorNome']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fcliente" class="col-sm-2 control-label">Atendente:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo $emprestimo['usuarioNome']; ?></p>
                    </div>
                </div>

            </div>

            <div class="panel-footer">
                <button type="submit" class="btn btn-success">Finalizar Emprestimo</button>
            </div>
        </div>
    </form>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>