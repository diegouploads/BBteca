<?php
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';
$q ='';
if(isset($_GET['q'])){
    $q =trim($_GET['q']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emprestimos</title>

    <?php headCss(); ?>
</head>
<body>

<div class="container">

    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Emprestimos</h1>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Emprestimoa</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" role="form" method="get" action="">
                <div class="form-group">
                    <label class="sr-only" for="fq">Pesquisa</label>
                    <input type="search" class="form-control" id="fq" name="q" placeholder="Pesquisa" value="<?php echo $q; ?>">
                </div>
                <button type="submit" class="btn btn-default">Pesquisar</button>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Situação</th>
                <th>Leitor</th>
                <th>Data do Emprestimo</th>
                <th>Total emprestado</th>
				<th>Total Devolvido</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "Select
	E.cod_controle,
	E.data_emprestimo,
	L.nome leitorNome,
    E.status emprestimoStatus,
	(Select Sum(EL.qtd_emprestado) From emprestimoslivros EL Where (EL.idemprestimo = E.cod_controle)) livrosTotal
From emprestimos E
Inner Join leitor L
	On (L.cod_leitor = E.id_leitor)
Inner Join usuario u
	On (u.cod_usuario = E.idusuario)";

            $array = array();
            if($q != ''){
                $array[] = "(L.nome like '%$q%')";
            }
            if($q != ''){
                $array[] = "(u.nome like '%$q%')";
            }

            if($array){
                $sql .= " Where ".join(' or ', $array);
            }

            $consulta = mysqli_query($con,$sql);
            if (mysqli_num_rows($consulta) > 0) {
                while ($resultado = mysqli_fetch_assoc($consulta)) {
                    $emprestimoDataE = strtotime($resultado['data_emprestimo']);
                    ?>
                    <tr>
                        <td><?php echo $resultado['cod_controle']; ?></td>
                        <td>
                            <?php
                            if ($resultado['emprestimoStatus'] == EMPRESTIMO_FECHADO) {
                                $idemprestimo = $resultado['cod_controle'];
                                $sqllivros = "Select * from emprestimoslivros INNER JOIN livros on idlivro = cod_livro where idemprestimo = $idemprestimo and data_devolvido is NULL";
                                $consultasql = mysqli_query($con, $sqllivros);
                                $d = date('Y-m-d');
                                $atrasado = 0;
								$devolvido = 0;
                                while ($livrosEmprestado = mysqli_fetch_assoc($consultasql)) {
                                    if ($livrosEmprestado['data_previa'] <= $d) {
                                        $atrasado++;
                                    } else {
										if($livrosEmprestado['data_devolvido'] != NULL){
											$devolvido++;
										}
									}
                                }
                                if (mysqli_num_rows($consultasql) == 0) { ?>
                                    <span class="label label-default">devolvidos</span> <?php
                                } else {
                                    if ($atrasado == 0) { ?>
                                        <span class="label label-success">emprestado</span>
                                    <?php } else { ?>
                                        <span class="label label-danger">atrasado</span>
                                    <?php }
                                }
                            }
                            if ($resultado['emprestimoStatus'] == EMPRESTIMO_ABERTO) { ?>
                                <span class="label label-warning">em andamento</span>
                            <?php } ?>
                        </td>
                        <td><?php echo $resultado['leitorNome']; ?></td>
                        <td><?php echo date('d/m/Y', $emprestimoDataE); ?></td>
                        <td><?php echo $resultado['livrosTotal']; ?></td>
						<td><?php echo $devolvido; ?></td>
                        <td>
                            <?php if ($resultado['emprestimoStatus'] == EMPRESTIMO_FECHADO) { ?>
                                <a href="emprestimos-detalhes.php?idemprestimo=<?php echo $resultado['cod_controle']; ?>"
                                   title="Detalhes do emprestimo"><i class="fa fa-align-justify fa-lg"></i></a>
                            <?php } else { ?>
                                <a href="emprestimos-continuar.php?idemprestimo=<?php echo $resultado['cod_controle']; ?>"
                                   title="Continuar emprestimo"><i class="fa fa-play fa-lg"></i></a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="6"><center>Nenhum emprestimo no sistema</center></center></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>