<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$cod_usuario = mysqli_real_escape_string($con, $_POST['cod_usuario']);
$nome = mysqli_real_escape_string($con, $_POST['nome']);
$senha = mysqli_real_escape_string($con, $_POST['senha']);

$result_cursos = "UPDATE usuario SET senha = '$senha' WHERE cod_usuario = '$cod_usuario'";
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
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/bbteca_ontheline/usuario-listar.php'>
				<script type=\"text/javascript\">
					alert(\"Senha do usuário atualizada!\");
				</script>
			";	
		}else{
			echo "
				<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=http://localhost/bbteca_ontheline/usuario-listar.php'>
				<script type=\"text/javascript\">
					alert(\"Erro ao atualizar senha do Usuário!\");
				</script>
			";	
		}?>
	</body>
</html>
<?php $con->close(); ?>

