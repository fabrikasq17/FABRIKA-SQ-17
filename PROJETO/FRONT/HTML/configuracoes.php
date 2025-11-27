<?php
session_start();
include_once "../../BACK/PHP/clienteHelper.php";

if (!isset($_SESSION['id_cliente'])) {
    header("Location: login.php");
    exit();
}

$cliente = Cliente::carregar($_SESSION['id_cliente']);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Configurações - FabrikaWeb</title>
  <link rel="stylesheet" href="../css/configuracoes.css" />
</head>
<body>

    <!-- SIDEBAR -->
  <aside class="sidebar">
   <div class="logo-s">
    <img src="../img/logo.jpeg" alt="Logo FBIK">
   </div>

    <!-- 🔗 Biblioteca de ícones Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  
    <nav class="menu">
      <h2>Menu principal</h2>
      <a href="dashboard.php" class="menu-item">
        <i class="bi bi-grid"></i>
        Dashboard
      </a>
      <a href="pedidos.php" class="menu-item">
        <i class="bi bi-cart3"></i>
        Pedidos
      </a>

      <h2>Cadastro</h2>
      <a href="tecidos.php" class="menu-item active">
        <i class="bi bi-scissors"></i>
        Tecidos
      </a>
      <a href="aviamentos.php" class="menu-item">
        <i class="bi bi-box-seam"></i>
        Aviamentos
      </a>
      <a href="modelagem.php" class="menu-item">
        <i class="bi bi-grid-3x3-gap"></i>
        Modelagem
      </a>
      <a href="beneficiamentos.php" class="menu-item">
        <i class="bi bi-brush"></i>
        Beneficiamentos
      </a>

      <a href="configuracoes.php" class="menu-item">
        <i class="bi bi-gear"></i>
        Configurações
      </a>

      <button class="btn-sair"><a href="../../BACK/PHP/logout.php">Sair</a></button>
    </nav>

  </aside> 

  <main class="main-content">
    <header class="page-header">
      <h1>Configurações</h1>
    </header>

    <section class="config-container">

      <!-- SEÇÃO: SUAS INFORMAÇÕES -->
      <div class="config-card">
        <h2>Suas informações</h2>
        <form action="../../BACK/PHP/clienteHelper.php" method="POST">

          <input type="hidden" name="tipo" value="editar_cliente">
          <input type="hidden" name="id_cliente" value="<?= $cliente->id_cliente ?>">

          <label>Nome:</label>
          <input type="text" name="nome" value="<?= htmlspecialchars($cliente->nome) ?>" />

          <label>CPF:</label>
          <input type="text" name="cpf" value="<?= htmlspecialchars($cliente->cpf) ?>" />

          <label>Email:</label>
          <input type="email" name="email" value="<?= htmlspecialchars($cliente->email) ?>" />

          <label>Telefone:</label>
          <input type="text" name="telefone" value="<?= htmlspecialchars($cliente->telefone ?? '') ?>" />

          <button type="submit" class="btn-editar">Salvar alterações</button>
        </form>

      </div>

      <!-- SEÇÃO: NOTIFICAÇÕES -->
      <div class="config-card">
        <h2>Notificações</h2>
        <div class="notificacoes">
          <div class="notificacao-item">
            <span>Notificações de Pedidos</span>
            <label class="switch">
              <input type="checkbox" checked>
              <span class="slider"></span>
            </label>
          </div>
          <div class="notificacao-item">
            <span>Alertas de Estoque Baixo</span>
            <label class="switch">
              <input type="checkbox" checked>
              <span class="slider"></span>
            </label>
          </div>
          <div class="notificacao-item">
            <span>Atualizações de produção</span>
            <label class="switch">
              <input type="checkbox">
              <span class="slider"></span>
            </label>
          </div>
        </div>
      </div>

      <!-- SEÇÃO: IDIOMA -->
      <div class="config-card idioma">
        <h2>Idioma</h2>
        <div class="idioma-item">
          <span>Português - Brasil</span>
          <span class="seta">›</span>
        </div>
      </div>

    </section>
  </main>
   
  <script src="js/main.js"></script>
  <script src="js/configuracoes.js"></script>
</body>
</html>














