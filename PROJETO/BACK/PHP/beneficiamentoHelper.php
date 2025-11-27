<?php
    include_once 'BANCO/banco.php';
    include_once 'beneficiamento.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
        
        if($tipo === 'cad_beneficiamento'){
            cadastrarBeneficiamento();
        }

        if ($tipo === 'editar') {
            editarBeneficiamento();
        }

        if ($tipo === 'excluir') {
            excluirBeneficiamento();
        }

    }


    function cadastrarBeneficiamento(){
      //  echo "oi";
        $categoria = $_POST['categoria'];
        $descricao = $_POST['descricao'];

        $beneficiamento = new Beneficiamento($categoria, $descricao);
        $result = $beneficiamento->inserir();

        session_start();

        if($result){
            $_SESSION['mensagem'] = "Beneficiamento cadastrado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao cadastrar beneficiamento!";
        }
        
        header("Location: ../../FRONT/HTML/beneficiamentos.php");
        exit(); // IMPORTANTE: Para o script após redirecionar

    }


    function editarBeneficiamento(){
        session_start();

        // obrigar id_Beneficiamento existir
        if (!isset($_POST['id_beneficiamento']) || empty($_POST['id_beneficiamento'])) {
            $_SESSION['erro'] = "ID do beneficiamento ausente!";
            header("Location: ../../FRONT/HTML/beneficiamentos.php");
            exit();
        }

        $beneficiamento = Beneficiamento::carregar($_POST['id_beneficiamento']);
        if (!$beneficiamento) {
            $_SESSION['erro'] = "beneficiamento não encontrado!";
            header("Location: ../../FRONT/HTML/beneficiamentos.php");
            exit();
        }

        // atualizar propriedades
        $beneficiamento->categoria = $_POST['categoria'];
        $beneficiamento->descricao = $_POST['descricao'];

        $ok = $beneficiamento->editar();

        if ($ok) {
            $_SESSION['mensagem'] = "Beneficiamento atualizado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao atualizar beneficiamento!";
        }

        header("Location: ../../FRONT/HTML/beneficiamentos.php");
        exit();
    }


    function excluirBeneficiamento(){
        session_start();

        if (!isset($_POST['id_beneficiamento']) || empty($_POST['id_beneficiamento'])) {
            $_SESSION['erro'] = "ID não informado para exclusão!";
            header("Location: ../../FRONT/HTML/beneficiamentos.php");
            exit();
        }

        $beneficiamento = Beneficiamento::carregar($_POST['id_beneficiamento']);

        if (!$beneficiamento) {
            $_SESSION['erro'] = "Beneficiamento não encontrado!";
            header("Location: ../../FRONT/HTML/beneficiamentos.php");
            exit();
        }

        $beneficiamento->excluir();

        $_SESSION['mensagem'] = "Beneficiamento excluído com sucesso!";
        header("Location: ../../FRONT/HTML/beneficiamentos.php");
        exit();
    }



    function getBeneficiamentos(){
        try{
            $banco = new Banco();
            $conn = $banco->conectar();
            $stmt = $conn->prepare("select * from beneficiamento");
            $stmt->execute();
           
            $beneficiamentos = array();
            foreach($stmt->fetchAll((PDO::FETCH_ASSOC)) as $value){
                $beneficiamento = new Beneficiamento($value['categoria'], $value['descricao']);
                $beneficiamento->setIdBeneficiamento($value['id_beneficiamento']);
                array_push($beneficiamentos,$beneficiamento);
            }

            //var_dump($beneficiamentos);
            return $beneficiamentos;

        }catch(PDOException $e){
            echo "Erro " . $e->getMessage();
            return array();
        }
    }

?>