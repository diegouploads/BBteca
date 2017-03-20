<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
$msgOk = array();
$msgAviso = array();
if (!isset($_GET['idemprestimo'])) {
    header('location:emprestimos-listar.php');
    exit;
}
$idemprestimo = (int)$_GET['idemprestimo'];
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
    And (E.status = " . EMPRESTIMO_FECHADO . ")";
$consulta = mysqli_query($con, $sql);
$emprestimo = mysqli_fetch_assoc($consulta);
if (!$emprestimo) {
    //header('location:emprestimos-listar.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes do Emprestimo</title>

    <?php headCss(); ?>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Detalhes do emprestimo #<?php echo $idemprestimo; ?></h1>
    </div>

    <?php if ($msgOk) {
        msgHtml($msgOk, 'success');
    } ?>
    <?php if ($msgAviso) {
        msgHtml($msgAviso, 'warning');
    } ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Livros Emprestados</h3>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Situacão</th>
                <th>Titulo</th>
                <th>Qtd.</th>
                <th>Data para entrega</th>
                <th>Multa unit. (caso atrasado)</th>
                <th>Data Devolvido</th>
                <th>Multa à receber</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "Select * From emprestimoslivros E Inner Join livros L On (L.cod_livro = E.idlivro) 
            Where (E.idemprestimo = $idemprestimo)";
            $consulta = mysqli_query($con, $sql);

            $multaTotal = 0;
            $total= 0;
            while ($livro = mysqli_fetch_assoc($consulta)) {
                if ($livro['data_devolvido'] != NULL && $livro['data_devolvido'] > $livro['data_previa']) {
                    $total = $livro['qtd_emprestado'] * $livro['multa_atraso'];
                    $multaTotal += $total;
                }
                ?>
                <tr>
                    <td><?php echo $livro['cod_livro']; ?></td>
                    <td>
                        <?php if($livro['data_devolvido'] == NULL && $livro['data_previa'] >= date('Y-m-d')) { ?>
                            <span class="label label-success">emprestado</span>
                        <?php } else {
                            if ($livro['data_devolvido'] != NULL){?>
                                <span class="label label-default">devolvido</span>
                            <?php } else{ ?>
                                <span class="label label-danger">Atrasado</span>
                                <?php } ?>
                        <?php } ?>
                    </td>
                    <td><?php echo $livro['titulo']; ?></td>
                    <td><?php echo $livro['qtd_emprestado']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($livro['data_previa'])); ?></td>
                    <td>R$ <?php echo number_format($livro['multa_atraso'], 2, ',', '.'); ?></td>
                    <td><?php if ($livro['data_devolvido'] != NULL) {
                            echo date('d/m/Y', strtotime($livro['data_devolvido']));
                        } else {
                            echo "";
                        } ?>
                    </td>
                    <td>R$ <?php
                        if ($livro['data_devolvido'] == NULL || $livro['data_devolvido'] < $livro['data_previa']) {
                            echo "0,00";
                        } else {
                            echo number_format($total, 2, ',', '.');
                        } ?>
                    </td>
                    <td> <?php if ($livro['data_devolvido'] == NULL) { ?>
                            <a href="emprestimos-devolvendo.php?acao=2&idemprestimo=<?php echo $livro['idemprestimo']; ?>&idlivro=<?php echo $livro['idlivro']; ?>"
                               title="Devolver livro"><i class="fa fa-check-square"></i></a>
                        <?php } else { ?>
                            <a href="emprestimos-devolvendo.php?acao=3&idemprestimo=<?php echo $livro['idemprestimo']; ?>&idlivro=<?php echo $livro['idlivro']; ?>"
                               title="Reverter devolução"><i class="fa fa-undo"></i></a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6"></th>
                <th>Total multa pago</th>
                <th colspan="2">R$ <?php
                    echo number_format($multaTotal, 2, ',', '.'); ?>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>

    <form class="form-horizontal" method="post" action="emprestimos-fechar.php">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Fechamento do Empréstimo</h3>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label for="fleitor" class="col-sm-2 control-label">Código:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo $idemprestimo; ?></p>
                    </div>

                    <label for="fleitor" class="col-sm-2 control-label">Data:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo date('d/m/Y', strtotime($emprestimo['data_emprestimo'])); ?></p>
                    </div>

                    <label for="fleitor" class="col-sm-2 control-label">Leitor:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo $emprestimo['leitorNome']; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fleitor" class="col-sm-2 control-label">Atendente:</label>
                    <div class="col-sm-2">
                        <p class="form-control-static"><?php echo $emprestimo['usuarioNome']; ?></p>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>