<?php
    include_once 'BANCO/banco.php';
    include_once 'tecido.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
        if($tipo === 'cad_tecido'){
            cadastrarTecido();
        }

        if ($_POST['tipo'] === 'edit_tecido') {
            editarTecido();
        }

        if ($_POST['tipo'] === 'excluir_tecido') {
        excluirTecido();
    }
    }


    function cadastrarTecido(){
      //  echo "oi";
        $nome = $_POST['nome'];
        $cor = $_POST['cor'];
        $peso_metros = $_POST['peso_metros'];
        $composicao = $_POST['composicao'];
        $gramatura = $_POST['gramatura'];
        $fabricante = $_POST['fabricante'];

        $tecido = new Tecido($nome, $cor, $peso_metros, $composicao, $gramatura, $fabricante);
        $result = $tecido->inserir();


        if($result){
            session_start();
            $_SESSION['mensagem'] = "Tecido cadastrado com sucesso!";
        } else {
            session_start();
            $_SESSION['erro'] = "Erro ao cadastrar tecido!";
        }

        header('Location: ../../FRONT/HTML/tecidos.php');
        exit(); // IMPORTANTE: Para o script após redirecionar

    }

    function editarTecido(){
        session_start();

        // obrigar id_tecido existir
        if (!isset($_POST['id_tecido']) || empty($_POST['id_tecido'])) {
            $_SESSION['erro'] = "ID do tecido ausente!";
            header("Location: ../../FRONT/HTML/tecidos.php");
            exit();
        }

        $tecido = Tecido::carregar($_POST['id_tecido']);
        if (!$tecido) {
            $_SESSION['erro'] = "Tecido não encontrado!";
            header("Location: ../../FRONT/HTML/tecidos.php");
            exit();
        }

        // atualizar propriedades
        $tecido->nome        = $_POST['nome'];
        $tecido->cor         = $_POST['cor'];
        $tecido->peso_metros = $_POST['peso_metros'];
        $tecido->composicao  = $_POST['composicao'];
        $tecido->gramatura   = $_POST['gramatura'];
        $tecido->fabricante  = $_POST['fabricante'];

        $ok = $tecido->editar();

        if ($ok) {
            $_SESSION['mensagem'] = "Tecido atualizado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar tecido!";
        }

        header("Location: ../../FRONT/HTML/tecidos.php");
        exit();
    }


    function excluirTecido(){
        session_start();

        if (!isset($_POST['id_tecido'])) {
            $_SESSION['erro'] = "ID não informado!";
            header("Location: ../../FRONT/HTML/tecidos.php");
            exit();
        }

        $tecido = Tecido::carregar($_POST['id_tecido']);

        if (!$tecido) {
            $_SESSION['erro'] = "Tecido não encontrado!";
            header("Location: ../../FRONT/HTML/tecidos.php");
            exit();
        }

        $tecido->excluir();

        $_SESSION['mensagem'] = "Tecido excluído com sucesso!";
        header("Location: ../../FRONT/HTML/tecidos.php");
        exit();
    }

    function getTecidos(){
        try{
            $banco = new Banco();
            $conn = $banco->conectar();
            $stmt = $conn->prepare("select * from tecido");
            $stmt->execute();
           
            $tecidos = array();

            foreach($stmt->fetchAll((PDO::FETCH_ASSOC)) as $value){
                $tecido = new Tecido($value['nome'], $value['cor'], $value['peso_metros'], $value['composicao'], $value['gramatura'], $value['fabricante']);
                $tecido->setIdTecido( $value['id_tecido']);
                array_push($tecidos,$tecido);
            }

            //var_dump($tecidos);
            return $tecidos;

        }catch(PDOException $e){
            echo "Erro " . $e->getMessage();
            return array();
        }
    }

?>