<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FabrikaWeb</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="login-page">

    <div class="login-container">
        <h1 class="logo">Login</h1>
        <form action="../../BACK/PHP/clienteHelper.php" method="POST" class="login-form">
            <input type="hidden" name="tipo" value="login">
        
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="Digite seu e-mail" required name="email">

            <label for="senha">Senha</label>
            <input type="password" id="senha" placeholder="Digite sua senha" required name="senha">

            <div class="row-between">
               <label class="checkbox">
                 <input type="checkbox" checked> Manter login
               </label>
           </div>

            <button type="submit" class="btn-login">Logar</button>

            <p class="cadastro-link">
                Não tem uma conta? <a href="cadastro.php">Cadastre-se</a>
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




