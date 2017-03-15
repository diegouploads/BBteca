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

    <?php headCss(); ?>

  </head>
  <body>

<!-- Modal Editar -->
<div class="modal fade" id="editarUsuario" data-backdrop="static">
  <br><br>
  <div class="container">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho -->
        <div class="modal-header" align="center">
          <h2>Editar Usuário</h2>
        </div>

        <!-- Corpo -->
        <div class="modal-body">
            <form method="post" action="http://localhost/bbteca_ontheline/usuario-update.php">
              <input type="hidden" name="cod_usuario" id="cod_usuario">

              <div class="form-group">
                <label for="recipient-name" class="control-label">Nome:</label>
                <input type="text" class="form-control" id="recipient-name" name="nome">
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
<!-- Modal Editar -->

<!-- Modal Editar Senha -->
<div class="modal fade" id="senhaUsuario" data-backdrop="static">
  <br><br>
  <div class="container">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho -->
        <div class="modal-header" align="center">
          <h2>Alterar Senha</h2>
        </div>

        <!-- Corpo -->
        <div class="modal-body">
            <form method="post" action="http://localhost/bbteca_ontheline/usuario-updateSenha.php">
              <input type="hidden" name="cod_usuario" id="cod_usuario">

              <div class="form-group">
                <label for="recipient-name" class="control-label">Nome:</label>
                <input type="text" class="form-control" id="recipient-name" name="nome" readonly="true">
              </div>

              <div class="form-group">
                <label for="recipient-senha" class="control-label">Nova Senha:</label>
                <input type="password" class="form-control" id="recipient-senha" name="senha">
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

<!-- Modal Altera Status -->
<div class="modal fade" id="statusUsuario" data-backdrop="static">
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
            <form method="post" action="http://localhost/bbteca_ontheline/usuario-updateStatus.php">
              <input type="hidden" name="cod_usuario" id="cod_usuario">

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

<div class="container">

<div class="page-header ">
  <h2><i class="fa fa-group"></i> Usuários</h2>
</div>

<div class="panel panel-default ">

  <div class="panel-heading clearfix ">
    <h3 class="panel-title pull-left"></h3>
    <div class="btn-group pull-right" >
    <i class="fa fa-plus-square fa-lg" data-toggle="modal" data-target="#cadUsuario"></i>
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
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql = "Select cod_usuario, nome, email, senha, status from usuario";
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
        <td><?php echo $resultado['cod_usuario'];   ?></td>

        <td>
          <?php if($resultado['status'] == 1){  ?>
          <button data-toggle="modal" data-target="#statusUsuario"
          data-whatever="<?php echo $resultado['cod_usuario']; ?>" 
          data-whatevernome="<?php echo $resultado['nome']; ?>" 
          data-whateverstatus="<?php echo $resultado['status']; ?>" 
          title="Alterar Status"
          class="label label-success">Ativo</button>
          <?php } else { ?>
          <button data-toggle="modal" data-target="#statusUsuario"
          data-whatever="<?php echo $resultado['cod_usuario']; ?>" 
          data-whatevernome="<?php echo $resultado['nome']; ?>" 
          data-whateverstatus="<?php echo $resultado['status']; ?>" 
          title="Alterar Status"
          class="label label-danger">Inativo</button>
          <?php } ?>
        </td>
        
        <td><?php echo $resultado['nome'];?></td>
        <td><?php echo $resultado['email'];?></td>

        <td>
          <a data-toggle="modal" data-target="#editarUsuario"
          data-whatever="<?php echo $resultado['cod_usuario']; ?>" 
          data-whatevernome="<?php echo $resultado['nome']; ?>" 
          data-whateveremail="<?php echo $resultado['email']; ?>" 
          title="Editar Usuário"><i class="fa fa-edit fa-lg"></i></a>

          <a data-toggle="modal" data-target="#senhaUsuario"
          data-whatever="<?php echo $resultado['cod_usuario']; ?>" 
          data-whatevernome="<?php echo $resultado['nome']; ?>" 
          data-whateverstatus="<?php echo $resultado['status']; ?>"           
          title="Alterar senha"><i class="fa fa-lock fa-lg"></i></a>
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
  $('#editarUsuario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // aqui faz o recebimento das variaveis que colocamos lá no whatever
    var recipientnome = button.data('whatevernome')
    var recipientemail = button.data('whateveremail')   
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('#cod_usuario').val(recipient)
    modal.find('#recipient-name').val(recipientnome)
    modal.find('#email').val(recipientemail)

  })  
</script>
<!-- Script Editar Senha Usuário -->
<script type="text/javascript">
  $('#senhaUsuario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // aqui faz o recebimento das variaveis que colocamos lá no whatever
    var recipientnome = button.data('whatevernome')
    var recipientsenha = button.data('whateversenha')   
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('#cod_usuario').val(recipient)
    modal.find('#recipient-name').val(recipientnome)
    modal.find('#recipient-senha').val(recipientsenha)

  })  
</script>
<!-- Script Editar Status Usuário -->
<script type="text/javascript">
  $('#statusUsuario').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // aqui faz o recebimento das variaveis que colocamos lá no whatever
    var recipientnome = button.data('whatevernome')
    var recipientstatus = button.data('whateverstatus')   
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('#cod_usuario').val(recipient)
    modal.find('#recipient-name').val(recipientnome)
    modal.find('#recipient-status').val(recipientstatus)
  })  
</script>


</body>
</html>


<!-- Modal Cadastrar -->
<div class="modal fade" id="cadUsuario" data-backdrop="static">
  <br><br>
  <div class="container">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Cabeçalho -->
        <div class="modal-header" align="center">
          <h2>Cadastrar Usuário</h2>
        </div>

        <!-- Corpo -->
        <div class="modal-body">
          <?php include 'usuario-cadastrar.php'; ?>        
        </div>

      </div>
    </div>

  </div>
</div>
