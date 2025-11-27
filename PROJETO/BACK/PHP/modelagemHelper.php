<?php
    include_once 'BANCO/banco.php';
    include_once 'modelagem.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
        if($tipo === 'cad_modelagem'){
            cadastrarModelagem();
        }

        if ($tipo === 'editar') {
            editarModelagem();
        }

        if ($tipo === 'excluir') {
            excluirModelagem();
        }

    }


    function cadastrarModelagem(){
      //  echo "oi";
        $tipo_molde = $_POST['tipo_molde'];
        $codigo_molde = $_POST['codigo_molde'];
        $tamanho = $_POST['tamanho'];


        $modelagem = new Modelagem($tipo_molde, $codigo_molde, $tamanho);
        $result = $modelagem->inserir();


        if($result){
            session_start();
            $_SESSION['mensagem'] = "Modelagem cadastrado com sucesso!";
        } else {
            session_start();
            $_SESSION['erro'] = "Erro ao cadastrar modelagem!";
        }

        header('Location: ../../FRONT/HTML/modelagens.php');
        exit(); // IMPORTANTE: Para o script após redirecionar

    }


    function editarModelagem(){
        session_start();

        // obrigar id_Modelagem existir
        if (!isset($_POST['id_modelagem']) || empty($_POST['id_modelagem'])) {
            $_SESSION['erro'] = "ID do modelagem ausente!";
            header("Location: ../../FRONT/HTML/modelagem.php");
            exit();
        }

        $modelagem = Modelagem::carregar($_POST['id_modelagem']);
        if (!$modelagem) {
            $_SESSION['erro'] = "Modelagem não encontrado!";
            header("Location: ../../FRONT/HTML/modelagem.php");
            exit();
        }

        // atualizar propriedades
        $modelagem->tipo_molde = $_POST['tipo_molde'];
        $modelagem->codigo_molde = $_POST['codigo_molde'];
        $modelagem->tamanho = $_POST['tamanho'];

        $ok = $modelagem->editar();

        if ($ok) {
            $_SESSION['mensagem'] = "Modelagem atualizado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar modelagem!";
        }

        header("Location: ../../FRONT/HTML/modelagem.php");
        exit();
    }


    function excluirModelagem() {
        session_start();

        if (!isset($_POST['id_modelagem']) || empty($_POST['id_modelagem'])) {
            $_SESSION['erro'] = "ID da modelagem não informado!";
            header("Location: ../../FRONT/HTML/modelagem.php");
            exit();
        }

        $modelagem = Modelagem::carregar($_POST['id_modelagem']);
        if (!$modelagem) {
            $_SESSION['erro'] = "Modelagem não encontrada!";
            header("Location: ../../FRONT/HTML/modelagem.php");
            exit();
        }

        $modelagem->excluir();

        $_SESSION['mensagem'] = "Modelagem excluída com sucesso!";
        header("Location: ../../FRONT/HTML/modelagem.php");
        exit();
    }


    function getModelagems(){
        try{
            $banco = new Banco();
            $conn = $banco->conectar();
            $stmt = $conn->prepare("select * from modelagem");
            $stmt->execute();
           
            $modelagems = array();
            foreach($stmt->fetchAll((PDO::FETCH_ASSOC)) as $value){
                $modelagem = new Modelagem($value['tipo_molde'], $value['codigo_molde'], $value['tamanho']);
                $modelagem->setIdModelagem( $value['id_modelagem']);
                array_push($modelagems,$modelagem);
            }

            //var_dump($modelagems);
            return $modelagems;

        }catch(PDOException $e){
            echo "Erro " . $e->getMessage();
            return array();
        }
    }

?>