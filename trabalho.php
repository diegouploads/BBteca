Especificações do Trabalho:
-> Cadastro de Livros
-> Cadastro de Clientes
-> Emprestimo de Livros
-> Devolução de Livros
-> Relatorios
	* Emprestimos por periodo
	* Emprestimos que estao com devolucao atrasada

<--------------------------------------------------->

Cadastro de Livros
	-> Codigo Interno
	-> Titulo
	-> Autor
	-> Descrição
	-> Editora
	-> Edição
	-> Exemplares
	-> Multa por atraso
	-> Status (se o livro está disponivel)

Cadastro de Funcionario
	-> Nome
	-> Login
	-> Senha

Cadastro de Leitor
	-> Codigo
	-> Nome
	-> Telefone
	-> Endereco
	-> Num_Endereco
	-> bairro
	-> e-mail

Controle de Emprestimo
	-> Controle
	-> ID_Livro
	-> ID_Leitor
	-> Data do emprestimo
	-> Data prevista de devolucao
	-> Data da devoluçao
	-> Multa
	-> Status (pendente/atraso/finalizado)

	

vai permitir emprestimo de um livro
devolucao do livro emprestado

verificar multa por atrazo na devolução


