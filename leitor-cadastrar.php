<?php

$msg = array();

$nome = '';
$endereco = '';
$num_endereco = '';
$bairro = '';
$telefone = '';
$email = '';
$ativo = LEITOR_ATIVO;

if ($_POST) {
    $nome = trim($_POST['nome']);
    $endereco = trim($_POST['endereco']);
    $num_endereco = trim($_POST['num_endereco']);
    $bairro = trim($_POST['bairro']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);

    if (isset($_POST['ativo'])) {
        $status = LEITOR_ATIVO;
    } else {
        $status = LEITOR_ATIVO;
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
    

    $sql = "select cod_leitor from leitor where email = '$email'";
    $consulta = mysqli_query($con, $sql);

    $resultado = mysqli_fetch_assoc($consulta);
    if($resultado){
        $msg[] = "Este email ja esta cadastrado.";
    }

    if (!$msg) {

        $sql = "Insert Into leitor (nome, endereco, num_endereco, bairro, telefone, email, status) Values ('$nome', '$endereco', '$num_endereco', '$bairro', 
        '$telefone', '$email', '$status')";

        $resultado = mysqli_query($con, $sql);

        // Testar se foi inserido
        if (!$resultado) {
            $msg[] = 'Nao foi possivel inserir o registro.';
            $msg[] = mysqli_error($con);
        } else {
            $cod_usuario = mysqli_insert_id($con);
            $url = 'leitor-listar.php';
            $mensagem = 'Leitor Cadastrado!';

            javascriptAlertFim($mensagem, $url);
        }
    }
}
?>


<form role="form" method="post" action="leitor-listar.php">
    <div class="form-group">
        <label for="fnome"><i class="fa fa-pencil-square-o"></i> Nome</label>
        <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome completo do leitor" value="<?php echo $nome; ?>" required>
    </div> 

    <div class="row">
        <div class="form-group col-xs-8">
            <div class="form-group">
                <label for="fendereco"><i class="fa fa-pencil-square-o"></i> Endereço</label>
                <input type="text" class="form-control" id="fendereco" name="endereco" placeholder="Nome da Rua/Avenida/Travessa/etc" value="<?php echo $endereco; ?>" required>
            </div> 
        </div>

        <div class="form-group col-xs-4">
            <div class="form-group">
                <label for="fnumero"><i class="fa fa-pencil-square-o"></i> Número</label>
                <input type="text" class="form-control" id="fnumero" name="num_endereco" placeholder="Número" value="<?php echo $num_endereco; ?>" required>
            </div>         
        </div>
    </div> 

    <div class="row">
        <div class="form-group col-xs-5">
            <div class="form-group">
                <label for="fbairro"><i class="fa fa-pencil-square-o"></i> Bairro</label>
                <input type="text" class="form-control" id="fbairro" name="bairro" placeholder="Bairro" value="<?php echo $bairro; ?>" required>
            </div> 
        </div>

        <div class="form-group col-xs-7">
            <div class="form-group">
                <label for="ftelefone"><i class="fa fa-pencil-square-o"></i> Telefone</label>
                <input type="text" class="form-control" id="ftelefone" name="telefone" placeholder="(  )    -    " value="<?php echo $telefone; ?>" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="femail"><i class="fa fa-envelope"></i> e-mail</label>
        <input type="email" class="form-control" id="femail" name="email" placeholder="Endereço de email" value="<?php echo $email; ?>" required>
    </div>  

    <div class="checkbox">
        <label for="fativo">
            <input type="checkbox" name="ativo" id="fativo" <?php if ($ativo == LEITOR_ATIVO) { ?>checked<?php } ?>> Leitor Ativo
        </label>
    </div>

    <hr />

    <button type="submit" class="btn btn-primary" href="leitor-listar.php">Cadastrar</button>
    <a href="leitor-listar.php"><button type="button" class="btn btn-danger">Cancelar</button></a> 
</form>