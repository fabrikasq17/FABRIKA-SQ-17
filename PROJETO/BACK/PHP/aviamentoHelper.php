<?php
    include_once 'BANCO/banco.php';
    include_once 'aviamento.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
        if($tipo === 'cad_aviamento'){
            cadastrarAviamento();
        }

        if ($tipo === 'editar') {
            editarAviamento();
        }

        if ($tipo === 'excluir') {
            excluirAviamento();
        }

    }


    function cadastrarAviamento(){
      //  echo "oi";
        $nome = $_POST['nome'];
        $cor = $_POST['cor'];
        $peso_quantidade = $_POST['peso_quantidade'];
        $composicao = $_POST['composicao'];
        $tamanho = $_POST['tamanho'];
        $id_fornecedor = $_POST['id_fornecedor'];

        $aviamento = new Aviamento($nome, $cor, $peso_quantidade, $composicao, $tamanho, $id_fornecedor);
        $result = $aviamento->inserir();

        session_start();

        if($result){
            $_SESSION['mensagem'] = "Aviamento cadastrado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar aviamento!";
        }
        
        header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/cadastro-aviamentos.php");
        exit(); // IMPORTANTE: Para o script após redirecionar

    }

    function editarAviamento(){
        session_start();

        // obrigar id_Aviamento existir
        if (!isset($_POST['id_aviamento']) || empty($_POST['id_aviamento'])) {
            $_SESSION['erro'] = "ID do aviamento ausente!";
            header("Location: ../../FRONT/HTML/aviamentos.php");
            exit();
        }

        $aviamento = Aviamento::carregar($_POST['id_aviamento']);
        if (!$aviamento) {
            $_SESSION['erro'] = "Aviamento não encontrado!";
            header("Location: ../../FRONT/HTML/aviamentos.php");
            exit();
        }

        // atualizar propriedades
        $aviamento->nome = $_POST['nome'];
        $aviamento->cor = $_POST['cor'];
        $aviamento->peso_quantidade = $_POST['peso_quantidade'];
        $aviamento->composicao = $_POST['composicao'];
        $aviamento->tamanho = $_POST['tamanho'];

        $ok = $aviamento->editar();

        if ($ok) {
            $_SESSION['mensagem'] = "Aviamento atualizado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar aviamento!";
        }

        header("Location: ../../FRONT/HTML/aviamentos.php");
        exit();
    }


    function excluirAviamento() {
        session_start();

        // Verifica se o ID veio
        if (!isset($_POST['id_aviamento']) || empty($_POST['id_aviamento'])) {
            $_SESSION['erro'] = "ID do aviamento não informado!";
            header("Location: ../../FRONT/HTML/aviamentos.php");
            exit();
        }

        // Carrega o aviamento
        $aviamento = Aviamento::carregar($_POST['id_aviamento']);
        if (!$aviamento) {
            $_SESSION['erro'] = "Aviamento não encontrado!";
            header("Location: ../../FRONT/HTML/aviamentos.php");
            exit();
        }

        // Tenta excluir
        $ok = $aviamento->excluir();

        if ($ok) {
            $_SESSION['mensagem'] = "Aviamento excluído com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao excluir aviamento!";
        }

        header("Location: ../../FRONT/HTML/aviamentos.php");
        exit();
    }



    function getAviamentos(){
        try{
            $banco = new Banco();
            $conn = $banco->conectar();
            $stmt = $conn->prepare("select * from aviamento");
            $stmt->execute();
           
            $aviamentos = array();
            foreach($stmt->fetchAll((PDO::FETCH_ASSOC)) as $value){
                $aviamento = new Aviamento($value['nome'], $value['cor'], $value['peso_quantidade'], $value['composicao'], $value['tamanho'], $value['id_fornecedor']);
                $aviamento->setIdAviamento($value['id_aviamento']);
                array_push($aviamentos,$aviamento);
            }

            //var_dump($aviamentos);
            return $aviamentos;

        }catch(PDOException $e){
            echo "Erro " . $e->getMessage();
            return array();
        }
    }

?>