<?php
  include_once "../../BACK/PHP/BANCO/banco.php";
  include_once "../../BACK/PHP/tecidoHelper.php";

  $id_tecido = filter_input(
      INPUT_GET,
      'id_tecido',
      FILTER_SANITIZE_NUMBER_INT
  );
  $te =  Tecido::carregar($id_tecido);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Cadastro Aviamentos - FabrikaWeb</title>
  <link rel="stylesheet" href="../css/cadastro-tecido.css" />
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

      <button class="btn-sair">Sair</button>
    </nav>
  </aside>

  <main class="main-content">
    <header class="page-header">
  <a href="tecidos.php" class="voltar" style="text-decoration:none; color:#111; display:flex; align-items:center; gap:8px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
    </svg>
    <h1 style="font-size:20px; font-weight:600; margin:0;">Editar Tecidos</h1>
  </a>
</header>


    <section class="form-container">
      <h2>Informações do Tecido</h2>
      <form method="POST" action="../../BACK/PHP/tecidoHelper.php" onsubmit="alert('Tecido salvo')">
        <input type="hidden" name="tipo" value="edit_tecido">
        <input type="hidden" name="id_tecido" value="<?= htmlspecialchars($te->getIdTecido()) ?>">

        <label>Nome do tecido:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($te->nome) ?>" required>

        <label>Cores disponíveis:</label>
        <input type="text" name="cor" value="<?= htmlspecialchars($te->cor) ?>" required>

        <label>Peso/Metros:</label>
        <input type="text" name="peso_metros" value="<?= htmlspecialchars($te->peso_metros) ?>" required>

        <label>Composição do tecido:</label>
        <input type="text" name="composicao" value="<?= htmlspecialchars($te->composicao) ?>" required>

        <label>Gramatura:</label>
        <input type="text" name="gramatura" value="<?= htmlspecialchars($te->gramatura) ?>" required>

        <label>Fabricante:</label>
        <input type="text" name="fabricante" value="<?= htmlspecialchars($te->fabricante) ?>" required>

        <div style="text-align:center; margin-top:18px;">
          <button class="btn-primary" type="submit">Salvar</button>
        </div>
      </form>

 
      <form action="../../BACK/PHP/tecidoHelper.php" 
            method="POST"
            onsubmit="return confirm('Tem certeza que deseja excluir este tecido?')"
            style="margin-top: 15px;">

          <input type="hidden" name="tipo" value="excluir_tecido">
          <input type="hidden" name="id_tecido" value="<?= $_GET['id_tecido'] ?>">

          <button type="submit" class="btn-danger"
                  style="background:#c62828; color:white; padding:10px 20px; border:none; border-radius:8px; cursor:pointer;">
              Excluir
          </button>
      </form>


    </section>
  </main>

  <script src="js/main.js"></script>
</body>
</html>