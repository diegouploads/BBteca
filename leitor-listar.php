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
<div class="modal fade" id="editarLeitor" data-backdrop="static">
  <br><br>
  <div class="container">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho -->
        <div class="modal-header" align="center">
          <h2>Editar Leitor</h2>
        </div>

        <!-- Corpo -->
        <div class="modal-body">
            <form method="post" action="http://localhost/bbteca_ontheline/leitor-update.php">
              <input type="hidden" name="cod_leitor" id="cod_leitor">

              <div class="form-group">
                <label for="recipient-name" class="control-label">Nome:</label>
                <input type="text" class="form-control" id="recipient-name" name="nome">
              </div>

              <div class="row">
                  <div class="form-group col-xs-8">
                      <div class="form-group">
                          <label for="recipient-endereco"><i class="fa fa-pencil-square-o"></i> Endereço</label>
                          <input type="text" class="form-control" id="recipient-endereco" name="endereco">
                      </div> 
                  </div>

                  <div class="form-group col-xs-4">
                      <div class="form-group">
                          <label for="recipient-num_endereco"><i class="fa fa-pencil-square-o"></i> Número</label>
                          <input type="text" class="form-control" id="recipient-num_endereco" name="numero">
                      </div>         
                  </div>
              </div> 

              <div class="row">
                  <div class="form-group col-xs-8">
                      <div class="form-group">
                          <label for="recipient-bairro"><i class="fa fa-pencil-square-o"></i> Bairro</label>
                          <input type="text" class="form-control" id="recipient-bairro" name="bairro">
                      </div> 
                  </div>

                  <div class="form-group col-xs-4">
                      <div class="form-group">
                          <label for="recipient-telefone"><i class="fa fa-pencil-square-o"></i> Telefone</label>
                          <input type="text" class="form-control" id="recipient-telefone" name="telefone">
                      </div>         
                  </div>
              </div> 

              <div class="form-group">
                <label for="message-text" class="control-label">e-mail:</label>
                <input type="text" class="form-control" id="email" name="email">
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
<!-- Fim Modal Editar -->

<!-- Modal Altera Status -->
<div class="modal fade" id="statusLeitor" data-backdrop="static">
  <br><br>
  <div class="container">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho -->
        <div class="modal-header" align="center">
          <h2>Alterar Status</h2>
        </div>

        <!-- Corpo -->
        <div class="modal-body">
            <form method="post" action="http://localhost/bbteca_ontheline/leitor-updateStatus.php">
              <input type="hidden" name="cod_leitor" id="cod_leitor">

              <div class="form-group">
                <label for="recipient-name" class="control-label">Nome:</label>
                <input type="text" class="form-control" id="recipient-name" name="nome" readonly="true">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" id="recipient-status" name="status">
                <label for="recipient-status" class="control-label">0 = Inativo / 1 = Ativo</label>
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

<!-- Fim Alterar Status -->


<div class="container">

<div class="page-header ">
  <h2><i class="fa fa-group"></i> Leitores</h2>
</div>

<div class="panel panel-default ">

  <div class="panel-heading clearfix ">
    <h3 class="panel-title pull-left"></h3>
    <div class="btn-group pull-right" >
    <i class="fa fa-plus-square fa-lg" data-toggle="modal" data-target="#cadLeitor"></i>
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
        <th>Nome</th>
        <th>Endereço</th>
        <th>Num.</th>
        <th>Bairro</th>
        <th>Telefone</th>
        <th>e-mail</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <?php
        $sql = "Select cod_leitor, nome, endereco, num_endereco, bairro, telefone, email, status from leitor";
        $array = array();
        if($q != ''){
          $array[] = "((nome like '%$q%') or (email like '%$q%'))";
        }
        if($array){
          $sql .= " Where ".join(' or ', $array);   
        }
        
        $consulta = mysqli_query($con,$sql);
        while( $resultado = mysqli_fetch_assoc($consulta)){
      ?>
      <tr>
        <td><?php echo $resultado['cod_leitor'];   ?></td>

        <td>
          <?php if($resultado['status'] == 1){  ?>
          <button data-toggle="modal" data-target="#statusLeitor"
          data-whatever="<?php echo $resultado['cod_leitor']; ?>" 
          data-whatevernome="<?php echo $resultado['nome']; ?>" 
          data-whateverstatus="<?php echo $resultado['status']; ?>" 
          title="Alterar Status"
          class="label label-success">Ativo</button>
          <?php } else { ?>
          <button data-toggle="modal" data-target="#statusLeitor"
          data-whatever="<?php echo $resultado['cod_leitor']; ?>" 
          data-whatevernome="<?php echo $resultado['nome']; ?>" 
          data-whateverstatus="<?php echo $resultado['status']; ?>" 
          title="Alterar Status"
          class="label label-danger">Inativo</button>
          <?php } ?>
        </td>

        <td><?php echo $resultado['nome'];?></td>
        <td><?php echo $resultado['endereco'];?></td>
        <td><?php echo $resultado['num_endereco'];?></td>
        <td><?php echo $resultado['bairro'];?></td>
        <td><?php echo $resultado['telefone'];?></td>
        <td><?php echo $resultado['email'];?></td>
        

        <td>
            <a data-toggle="modal" data-target="#editarLeitor" 
            data-whatever="<?php echo $resultado['cod_leitor']; ?>" 
            data-whatevernome="<?php echo $resultado['nome']; ?>"
            data-whateverendereco="<?php echo $resultado['endereco']; ?>"
            data-whatevernum_endereco="<?php echo $resultado['num_endereco']; ?>" 
            data-whateverbairro="<?php echo $resultado['bairro']; ?>" 
            data-whatevertelefone="<?php echo $resultado['telefone']; ?>" 
            data-whateveremail="<?php echo $resultado['email']; ?>" 
            title="Editar Leitor"><i class="fa fa-edit fa-lg"></i></a>

            <a href="emprestimos-novo.php?idleitor=<?php echo $resultado['cod_leitor'];?>" title="Emprestimos"><i class="fa fa-book fa-lg"></i></a>
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
  $('#editarLeitor').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // aqui faz o recebimento das variaveis que colocamos lá no whatever
    var recipientnome = button.data('whatevernome')
    var recipientendereco = button.data('whateverendereco')
    var recipientnum_endereco = button.data('whatevernum_endereco')
    var recipientbairro = button.data('whateverbairro')
    var recipienttelefone = button.data('whatevertelefone')
    var recipientemail = button.data('whateveremail')   
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('#cod_leitor').val(recipient)
    modal.find('#recipient-name').val(recipientnome)
    modal.find('#recipient-endereco').val(recipientendereco)
    modal.find('#recipient-num_endereco').val(recipientnum_endereco)
    modal.find('#recipient-bairro').val(recipientbairro)
    modal.find('#recipient-telefone').val(recipienttelefone)
    modal.find('#email').val(recipientemail)

  })  
</script>
<!-- Script Editar Status Leitor -->
<script type="text/javascript">
  $('#statusLeitor').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // aqui faz o recebimento das variaveis que colocamos lá no whatever
    var recipientnome = button.data('whatevernome')
    var recipientstatus = button.data('whateverstatus')   
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('#cod_leitor').val(recipient)
    modal.find('#recipient-name').val(recipientnome)
    modal.find('#recipient-status').val(recipientstatus)
  })  
</script>


</body>
</html>


<!-- Modal Cadastrar -->
<div class="modal fade" id="cadLeitor" data-backdrop="static">
  <br><br>
  <div class="container">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho -->
        <div class="modal-header" align="center">
          <h2>Cadastrar Leitor</h2>
        </div>

        <!-- Corpo -->
        <div class="modal-body">
          <?php include 'leitor-cadastrar.php'; ?>        
        </div>

      </div>
    </div>

  </div>
</div>
