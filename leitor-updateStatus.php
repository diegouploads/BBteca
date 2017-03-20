<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$cod_leitor = mysqli_real_escape_string($con, $_POST['cod_leitor']);
$nome = mysqli_real_escape_string($con, $_POST['nome']);
$status = mysqli_real_escape_string($con, $_POST['status']);

$result_cursos = "UPDATE leitor SET status = '$status' WHERE cod_leitor = $cod_leitor";
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
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=leitor-listar.php'>
				<script type=\"text/javascript\">
					alert(\"Status do leitor atualizada!\");
				</script>
			";	
		}else{
			echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=leitor-listar.php'>
				<script type=\"text/javascript\">
					alert(\"Erro ao atualizar Status do leitor!\");
				</script>
			";	
		}?>
	</body>
</html>
<?php $con->close(); ?>

