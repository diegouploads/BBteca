<?php

$msg = array();

$titulo = '';
$autor = '';
$descricao = '';
$editora = '';
$edicao = '';
$exemplares = '';
$multa_atraso = 0;
$diasDev = 10;
$ativo = LIVRO_DISPONIVEL;

if ($_POST) {
    $titulo = trim($_POST['titulo']);
    $autor = trim($_POST['autor']);
    $descricao = trim($_POST['descricao']);
    $editora = trim($_POST['editora']);
    $edicao = trim($_POST['edicao']);
    $exemplares = trim($_POST['exemplares']);
    $multa_atraso = trim($_POST['multa_atraso']);

    if (isset($_POST['ativo'])) {
        $status = LEITOR_ATIVO;
    } else {
        $status = LEITOR_ATIVO;
    }

    $sql = "select cod_livro from livros where titulo = '$titulo'";
    $consulta = mysqli_query($con, $sql);

    $resultado = mysqli_fetch_assoc($consulta);
    if($resultado){
        $msg[] = "Este livro já está cadastrado!";
    }

    if (!$msg) {

        $sql = "Insert Into livros
        (titulo, autor, descricao, editora, edicao, exemplares, multa_atraso, status, dias_dev)
        Values
        ('$titulo', '$autor', '$descricao','$editora', '$edicao', '$exemplares', '$multa_atraso', '$status', $diasDev)";

        $resultado = mysqli_query($con, $sql);

        // Testar se foi inserido
        if (!$resultado) {
            $msg[] = 'Nao foi possivel inserir o registro.';
            $msg[] = mysqli_error($con);
        } else {
            $cod_usuario = mysqli_insert_id($con);
            $url = 'livro-listar.php';
            $mensagem = 'Livro Cadastrado!';

            javascriptAlertFim($mensagem, $url);
        }
    }
}
?>

<form role="form" method="post" action="livro-listar.php">

    <div class="form-group">
        <label for="fnome"><i class="fa fa-pencil-square-o"></i> Título do Livro</label>
        <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome completo do Título" value="<?php echo $titulo; ?>" required>
    </div>

    <div class="form-group">
        <label for="fautor"><i class="fa fa-pencil-square-o"></i> Nome do Autor</label>
        <input type="text" class="form-control" id="fautor" name="autor" placeholder="Nome Do Autor" value="<?php echo $autor; ?>" required>
    </div>    

    <div class="form-group">
        <label for="fdescricao"><i class="fa fa-pencil-square-o"></i> Prévia</label>
        <input type="text" class="form-control" id="fdescricao" name="descricao" placeholder="Prévia/Comentários" value="<?php echo $descricao; ?>" required>
    </div> 

    <div class="row">
        <div class="form-group col-xs-4">
            <div class="form-group">
                <label for="feditora"><i class="fa fa-pencil-square-o"></i> Editora</label>
                <input type="text" class="form-control" id="feditora" name="editora" placeholder="Editora" value="<?php echo $editora; ?>" required>
            </div> 
        </div>

        <div class="form-group col-xs-4">
            <div class="form-group">
                <label for="fedicao"><i class="fa fa-pencil-square-o"></i> Ediçao</label>
                <input type="text" class="form-control" id="fedicao" name="edicao" placeholder="Número da Ediçao" value="<?php echo $edicao; ?>" required>
            </div> 
        </div> 

        <div class="form-group col-xs-4">
            <div class="form-group">
                <label for="fexemplares"><i class="fa fa-pencil-square-o"></i> Exemplares</label>
                <input type="text" class="form-control" id="fexemplares" name="exemplares" placeholder="Quantia de Exemplares" value="<?php echo $exemplares; ?>" required>
            </div> 
        </div> 
    </div>   

    <div class="row">
        <div class="form-group col-xs-6">
            <label for="fmulta">Multa se Houver Atraso</label>
            <div class="input-group ">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" id="fmulta" name="multa_atraso" value="0.00">
            </div> 
        </div>
    </div>    



    <div class="checkbox">
        <label for="fativo">
            <input type="checkbox" name="ativo" id="fativo" <?php if ($ativo == LIVRO_DISPONIVEL) { ?>checked<?php } ?>> Livro Disponível
        </label>
    </div>

    <hr />

    <button type="submit" class="btn btn-primary" href="livro-listar.php">Cadastrar</button>
    <a href="livro-listar.php"><button type="button" class="btn btn-danger">Cancelar</button></a> 

</form>