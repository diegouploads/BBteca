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
	<title>BBTeca - OnTheLine</title>

</head>

<body>

	<?php headCss(); ?>


	<!-- Modal Editar -->
	<div class="modal fade" id="editarLivro" data-backdrop="static">
		<br><br>
		<div class="container">
			<div class="modal-dialog">
				<div class="modal-content">

					<!-- Cabeçalho -->
					<div class="modal-header" align="center">
						<h2>Editar Livro</h2>
					</div>

					<!-- Corpo -->
					<div class="modal-body">
						<form method="post" action="livro-update.php">
							<input type="hidden" name="cod_livro" id="cod_livro">

							<div class="form-group">
								<label for="recipient-titulo" class="control-label"><i class="fa fa-pencil-square-o"></i> Título:</label>
								<input type="text" class="form-control" id="recipient-titulo" name="titulo">
							</div>

							<div class="form-group">
								<label for="recipient-autor"><i class="fa fa-user"></i> Nome do Autor</label>
								<input type="text" class="form-control" id="recipient-autor" name="autor">
							</div>    

							<div class="form-group">
								<label for="recipient-desc"><i class="fa fa-comment"></i> Prévia</label>
								<input type="text" class="form-control" id="recipient-desc" name="descricao">
							</div>  

							<div class="row">
								<div class="form-group col-xs-4">
									<div class="form-group">
										<label for="recipient-editora"><i class="fa fa-leaf"></i> Editora</label>
										<input type="text" class="form-control" id="recipient-editora" name="editora">
									</div> 
								</div>

								<div class="form-group col-xs-4">
									<div class="form-group">
										<label for="recipient-edicao"><i class="fa fa-pencil-square-o"></i> Ediçao</label>
										<input type="text" class="form-control" id="recipient-edicao" name="edicao">
									</div> 
								</div> 

								<div class="form-group col-xs-4">
									<div class="form-group">
										<label for="recipient-exemplares"><i class="fa fa-database"></i> Exemplares</label>
										<input type="text" class="form-control" id="recipient-exemplares" name="exemplares">
									</div> 
								</div> 
							</div>

							<div class="row">
								<div class="form-group col-xs-6">
									<label for="recipient-multa_atraso">Multa se Houver Atraso</label>
									<div class="input-group ">
										<span class="input-group-addon">R$</span>
										<input type="text" class="form-control" id="recipient-multa_atraso" name="multa_atraso">
									</div> 
								</div>

								<div class="form-group col-xs-4">
									<label for="recipient-dias_dev"><i class="fa fa-calendar"></i> Dias Disponíveis</label>
									<input type="number" class="form-control" id="recipient-dias_dev" name="dias_dev" min="1">
								</div>                  
							</div>                                         

							<hr / >

							<button type="submit" class="btn btn-primary">Alterar</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
						</form>                 
					</div>

				</div>
			</div>

		</div>
	</div>  

	<div class="container">

		<div class="page-header ">
			<h2><i class="fa fa-group"></i> Livros</h2>
		</div>

		<div class="panel panel-default ">

			<div class="panel-heading clearfix ">
				<h3 class="panel-title pull-left"></h3>
				<div class="btn-group pull-right" >
					<i class="fa fa-plus-square fa-lg" data-toggle="modal" data-target="#cadLivro"></i>
				</div>   

			</div>

			<div class="panel-body">
				<form class="form-inline" role="form" method="get" action="">
					<div class="form-group">
						<label class="sr-only" for="fq">Pesquisa</label>
						<input type="search" class="form-control" id="fq" name="q" placeholder="Pesquisa" value="<?php echo $q; ?>">
					</div>
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> </button>
				</form>
			</div>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th></th>
						<th>Título</th>
						<th>Autor</th>
						<th>Editora</th>
						<th>Num.Edição</th>
						<th>Total</th>
						<th>Disponivel</th>
						<th>Prazo max.</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "Select cod_livro, titulo, autor, descricao, editora, edicao, exemplares, multa_atraso, dias_dev, status from livros";
					$array = array();
					if($q != ''){
						$array[] = "((titulo like '%$q%') or (autor like '%$q%'))";
					}
					if($array){
						$sql .= " Where ".join(' or ', $array);   
					}

					$consulta = mysqli_query($con,$sql);
					while( $resultado = mysqli_fetch_assoc($consulta)){
						?>
						<tr>
							<td><?php echo $resultado['cod_livro'];   ?></td>
							<td>
								<?php if($resultado['status'] == LIVRO_DISPONIVEL){  ?>
								<span class="label label-success">Disponível</span>
								<?php } else { ?>
								<span class="label label-warning">INdisponível</span>
								<?php } ?>
							</td>
							<td><?php echo $resultado['titulo'];?></td>
							<td><?php echo $resultado['autor'];?></td>
							<td><?php echo $resultado['editora'];?></td>
							<td><?php echo $resultado['edicao'];?></td>
							<td><?php echo $resultado['exemplares'];?></td>
							<td><?php echo "desenvolver"; ?></td>
							<td><?php echo $resultado['dias_dev']." dias";?></td>

							<td>
								<a data-toggle="modal" data-target="#editarLivro"
								data-whatever="<?php echo $resultado['cod_livro']; ?>"
								data-whatevertitulo="<?php echo $resultado['titulo']; ?>"
								data-whateverautor="<?php echo $resultado['autor']; ?>"
								data-whateverdescricao="<?php echo $resultado['descricao']; ?>"
								data-whatevereditora="<?php echo $resultado['editora']; ?>"
								data-whateverdedicao="<?php echo $resultado['edicao']; ?>"
								data-whateverdexemplares="<?php echo $resultado['exemplares']; ?>"
								data-whatevermulta_atraso="<?php echo $resultado['multa_atraso']; ?>"
								data-whateverdias_dev = "<?php echo $resultado['dias_dev']; ?>"
								title="Editar Livro"><i class="fa fa-edit fa-lg"></i></a>

								<a href="" data-toggle="modal" data-target="#infoLivros" title="Informações"><i class="fa fa-lock fa-lg"></i></a>
							</td>
						</tr><?php
					}
					?>
				</tbody>
			</table>
		</div>

	</div> 

	<script src="./lib/jquery.js"></script>
	<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

	<!-- Script Editar Usuário -->
	<script type="text/javascript">
		$('#editarLivro').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget) // Button that triggered the modal
var recipient = button.data('whatever') // aqui faz o recebimento das variaveis que colocamos lá no whatever
var recipienttitulo = button.data('whatevertitulo')
var recipientautor = button.data('whateverautor')
var recipientdesc = button.data('whateverdescricao')
var recipienteditora = button.data('whatevereditora')
var recipientedicao = button.data('whateverdedicao')
var recipientexemplares = button.data('whateverdexemplares')
var recipientmulta_atraso = button.data('whatevermulta_atraso')
var recipientdias_dev = button.data('whateverdias_dev')
var modal = $(this)
modal.find('.modal-title').text('New message to ' + recipient)
modal.find('#cod_livro').val(recipient)
modal.find('#recipient-titulo').val(recipienttitulo)
modal.find('#recipient-autor').val(recipientautor)
modal.find('#recipient-desc').val(recipientdesc)
modal.find('#recipient-editora').val(recipienteditora)
modal.find('#recipient-edicao').val(recipientedicao)
modal.find('#recipient-exemplares').val(recipientexemplares)
modal.find('#recipient-multa_atraso').val(recipientmulta_atraso)
modal.find('#recipient-dias_dev').val(recipientdias_dev)
})  
</script>

</body>
</html>


<!-- Modal Cadastrar -->
<div class="modal fade" id="cadLivro" data-backdrop="static">
	<br><br>
	<div class="container">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Cabeçalho -->
				<div class="modal-header" align="center">
					<h2>Cadastrar Livro</h2>
				</div>

				<!-- Corpo -->
				<div class="modal-body">
					<?php include 'livro-cadastrar.php'; ?>        
				</div>

			</div>
		</div>

	</div>
</div>


