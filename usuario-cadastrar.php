<?php

$msg = array();

$nome = '';
$email = '';
$ativo = USUARIO_ATIVO;

if ($_POST) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $senha2 = trim($_POST['senha2']);

    if (isset($_POST['ativo'])) {
        $status = USUARIO_ATIVO;
    } else {
        $status = USUARIO_INATIVO;
    }

    if ($nome == '') {
        $msg[] = "Insira um nome";
    }
    if (strlen($nome) < 3) {
        $msg[] = "O campo Nome deve conter no minimo 3 caracteres";
    }
    if ($email == '') {
        $msg[] = "Insira um endereço de email correto";
    }
    if ($senha == '') {
        $msg[] = "Insira uma senha";
    }

    if ($senha != $senha2){
        $msg[] = "As senhas não coferem digite novamente";
    }

    $sql = "select cod_usuario from usuario where email = '$email'";
    $consulta = mysqli_query($con, $sql);

    $resultado = mysqli_fetch_assoc($consulta);
    if($resultado){
        $msg[] = "Este email ja esta cadastrado.";
    }

    if (!$msg) {
        $senha = $senha;

        $sql = "Insert Into usuario (nome,email,senha,status) Values ('$nome', '$email', '$senha', $status)";

        $resultado = mysqli_query($con, $sql);

        // Testar se foi inserido
        if (!$resultado) {
            $msg[] = 'Nao foi possivel inserir o registro.';
            $msg[] = mysqli_error($con);
        } else {
            $cod_usuario = mysqli_insert_id($con);
            $url = 'usuario-listar.php';
            $mensagem = 'Usuário cadastrado!';

            javascriptAlertFim($mensagem, $url);
        }
    }
}
?>

            <form role="form" method="post" action="usuario-listar.php">
                <div class="form-group">
                    <label for="fnome"><i class="fa fa-pencil-square-o"></i> Nome</label>
                    <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome completo do usuário" value="<?php echo $nome; ?>" required>
                </div>

                <div class="form-group">
                    <label for="femail"><i class="fa fa-envelope"></i> e-mail</label>
                    <input type="email" class="form-control" id="femail" name="email" placeholder="Endereço de email" value="<?php echo $email; ?>" required>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 col-xs-6">
                        <label for="fsenha"><i class="fa fa-lock"></i> Senha</label>
                        <input type="password" class="form-control" id="fsenha" name="senha" placeholder="Senha do usuário" required>
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="fsenha2"><i class="fa fa-lock"></i> Repita a senha</label>
                        <input type="password" class="form-control" id="fsenha2" name="senha2" placeholder="Confirme a senha" required>
                    </div>
                </div>

                <div class="checkbox">
                    <label for="fativo">
                        <input type="checkbox" name="ativo" id="fativo" <?php if ($ativo == USUARIO_ATIVO) { ?>checked<?php } ?>> Usuário ativo
                    </label>
                </div>

                <hr />

                <button type="submit" class="btn btn-primary" href="usuario-listar.php">Cadastrar</button>
                <a href="usuario-listar.php"><button type="button" class="btn btn-danger">Cancelar</button></a>


            </form>