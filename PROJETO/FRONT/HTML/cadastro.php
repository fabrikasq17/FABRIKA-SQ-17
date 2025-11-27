<?php
    session_start();
  include_once "../../BACK/PHP/BANCO/banco.php";
  include_once "../../BACK/PHP/clienteHelper.php";
  
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - FabrikaWeb</title>
    <link rel="stylesheet" href="../css/cadastro.css">
</head>
<body class="cadastro-page">

    <div class="cadastro-container">
        <h1 class="logo">Login</h1>
        <form action="../../BACK/PHP/clienteHelper.php" method="POST" class="cadastro-form">
            <input type="hidden" name="tipo" value="cad_cliente">
            <label for="nome">Nome</label>
            <input type="text" id="nome" placeholder="Digite seu nome" required name="nome">

            <label for="CPF">CPF</label>
            <input type="text" id="CPF" placeholder="000.000.000-00" required name="cpf">

            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="E-mail" required name="email">

            <label for="senha">Senha</label>
            <input type="password" id="senha" placeholder="Senha" required name="senha">

            <label for="confirmar">Confirmar Senha</label>
            <input type="password" id="confirmar" placeholder="Confirme sua senha" required name="confirmar_senha">

            <button type="submit" class="btn-login">Cadastrar</button>

            <p class="cadastro-link">
                Já tem uma conta? <a href="login.php">Faça login</a>
            </p>
        </form>
    </div>
    
    <?php
        // Set session variables
        $_SESSION["nome"] = "nome";
        $_SESSION["email"] = "email";
        ;
    ?>

</body>
</html>



