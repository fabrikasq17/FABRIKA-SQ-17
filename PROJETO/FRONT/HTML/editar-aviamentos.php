<?php
include_once "../../BACK/PHP/aviamento.php";
include_once "../../BACK/PHP/aviamentoHelper.php";

if (!isset($_GET['id_aviamento'])) {
    die("ID do aviamento não informado!");
}

$aviamento = Aviamento::carregar($_GET['id_aviamento']);
if (!$aviamento) {
    die("Aviamento não encontrado!");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Editar Aviamentos - FabrikaWeb</title>
  <link rel="stylesheet" href="../css/cadastro-aviamentos.css" />
</head>
<body>

  <!-- SIDEBAR -->
  <aside class="sidebar">
      <div class="logo-s">
        <img src="../img/logo.jpeg" alt="Logo FBIK">
      </div>

      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

      <nav class="menu">
        <h2>Menu principal</h2>
        <a href="dashboard.php" class="menu-item"><i class="bi bi-grid"></i> Dashboard</a>
        <a href="pedidos.php" class="menu-item"><i class="bi bi-cart3"></i> Pedidos</a>

        <h2>Cadastro</h2>
        <a href="tecidos.php" class="menu-item"><i class="bi bi-scissors"></i> Tecidos</a>
        <a href="aviamentos.php" class="menu-item active"><i class="bi bi-box-seam"></i> Aviamentos</a>
        <a href="modelagem.php" class="menu-item"><i class="bi bi-grid-3x3-gap"></i> Modelagem</a>
        <a href="beneficiamentos.php" class="menu-item"><i class="bi bi-brush"></i> Beneficiamentos</a>
        <a href="configuracoes.php" class="menu-item"><i class="bi bi-gear"></i> Configurações</a>

        <button class="btn-sair">
          <a href="../../BACK/PHP/logout.php">Sair</a>
        </button>
      </nav>
  </aside>

  <main class="main-content">
    <header class="page-header">
      <a href="aviamentos.php" class="voltar" style="text-decoration:none; color:#111; display:flex; align-items:center; gap:8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left">
          <path d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
        <h1 style="font-size:20px; font-weight:600; margin:0;">Editar Aviamentos</h1>
      </a>
    </header>

    <section class="form-container">
      <h2>Informações do Aviamento</h2>

      <!-- FORMULÁRIO DE EDITAR -->
      <form action="../../BACK/PHP/aviamentoHelper.php" method="POST">
        <input type="hidden" name="tipo" value="editar">
        <input type="hidden" name="id_aviamento" value="<?= $aviamento->getIdAviamento() ?>">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($aviamento->nome) ?>">

        <label>Cores disponíveis:</label>
        <input type="text" name="cor" value="<?= htmlspecialchars($aviamento->cor) ?>">

        <label>Unidades:</label>
        <input type="text" name="peso_quantidade" value="<?= htmlspecialchars($aviamento->peso_quantidade) ?>">

        <label>Composição:</label>
        <input type="text" name="composicao" value="<?= htmlspecialchars($aviamento->composicao) ?>">

        <label>Gramatura/Tamanho:</label>
        <input type="text" name="tamanho" value="<?= htmlspecialchars($aviamento->tamanho) ?>">

        <label>Fabricante (ID Fornecedor):</label>
        <input type="text" name="id_fornecedor" value="<?= htmlspecialchars($aviamento->id_fornecedor) ?>">

        <div style="text-align:center; margin-top:18px;">
          <button class="btn-primary" type="submit">Salvar</button>
        </div>
      </form>

      <form action="../../BACK/PHP/aviamentoHelper.php" method="POST"
            onsubmit="return confirm('Tem certeza que deseja excluir este aviamento?')"
            style="margin-top: 15px; text-align:center;">

          <input type="hidden" name="tipo" value="excluir">
          <input type="hidden" name="id_aviamento" value="<?= $aviamento->getIdAviamento() ?>">

          <button type="submit" class="btn-excluir"
                  style="background:#c62828; color:white; padding:10px 20px; border:none; border-radius:8px; cursor:pointer;">
              Excluir Aviamento
          </button>
      </form>

    </section>
  </main>

</body>
</html>
