<?php
include_once "../../BACK/PHP/beneficiamento.php";
include_once "../../BACK/PHP/beneficiamentoHelper.php";

if (!isset($_GET['id_beneficiamento'])) {
    die("ID do beneficiamento não informado!");
}

$beneficiamento = Beneficiamento::carregar($_GET['id_beneficiamento']);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Cadastro Aviamentos - FabrikaWeb</title>
  <link rel="stylesheet" href="../css/cadastro-beneficiamentos.css" />
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
  <a href="beneficiamentos.php" class="voltar" style="text-decoration:none; color:#111; display:flex; align-items:center; gap:8px;">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
    </svg>
    <h1 style="font-size:20px; font-weight:600; margin:0;">Editar Beneficiamentos</h1>
  </a>
</header>


    <section class="form-container">
      <h2>Informações do Beneficiamento</h2>
      <form action="../../BACK/PHP/beneficiamentoHelper.php" method="POST" onsubmit="alert('Aviamento salvo')">
        <input type="hidden" name="id_beneficiamento" value="<?= $beneficiamento->id_beneficiamento ?>">
        <input type="hidden" name="tipo" value="editar">

      
        <label>Categoria:</label>
        <input type="text" placeholder="Ex: Bordado" name="categoria" value="<?= htmlspecialchars($beneficiamento->categoria) ?>">

        <label>Descrição:</label>
        <input type="text" placeholder="Ex: Impressão digital em alta resolução para tecidos" name="descricao" value="<?= htmlspecialchars($beneficiamento->descricao) ?>">


        <div style="text-align:center; margin-top:18px;">
          <button class="btn-primary" type="submit">Salvar</button>
        </div>
        
      </form>

      <form action="../../BACK/PHP/beneficiamentoHelper.php" method="POST"
      onsubmit="return confirm('Tem certeza que deseja excluir este beneficiamento?')"
      style="margin-top: 15px; text-align:center;">

          <input type="hidden" name="id_beneficiamento" value="<?= $beneficiamento->id_beneficiamento ?>">
          <input type="hidden" name="tipo" value="excluir">

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