<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$cod_leitor = mysqli_real_escape_string($con, $_POST['cod_leitor']);
$nome = mysqli_real_escape_string($con, $_POST['nome']);
$endereco = mysqli_real_escape_string($con, $_POST['endereco']);
$num_endereco = mysqli_real_escape_string($con, $_POST['num_endereco']);
$bairro = mysqli_real_escape_string($con, $_POST['bairro']);
$telefone = mysqli_real_escape_string($con, $_POST['telefone']);
$email = mysqli_real_escape_string($con, $_POST['email']);

$result_cursos = "UPDATE leitor SET
				nome = '$nome',
				endereco = '$endereco',
				num_endereco = '$num_endereco',
				bairro = '$bairro',
				telefone = '$telefone',
				email = '$email' WHERE cod_leitor = '$cod_leitor'";
				
$resultado_cursos = mysqli_query($con, $result_cursos);

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
	</head>

	<body> <?php
		if(mysqli_affected_rows($con) != 0){
			echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/bbteca_ontheline/leitor-listar.php'>
				<script type=\"text/javascript\">
					alert(\"Leitor alterado com sucesso!\");
				</script>
			";	
		}else{
			echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/bbteca_ontheline/leitor-listar.php'>
				<script type=\"text/javascript\">
					alert(\"Erro ao atualizar Leitor!\");
				</script>
			";	
		}?>
	</body>
</html>
<?php $con->close(); ?>

