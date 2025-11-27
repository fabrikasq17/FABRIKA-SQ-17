 <?php
    include_once 'BANCO/banco.php';
    include_once 'cliente.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])){
        $tipo = $_POST['tipo'];
        if($tipo === 'cad_cliente'){
            cadastrarCliente();
        }
        if($tipo === 'login'){
        loginCliente();
        }
        if ($tipo === 'editar_cliente') {
            editarCliente();
        }

    }




function cadastrarCliente(){
    session_start();

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];


    if($senha !== $confirmar_senha){
        $_SESSION['erro'] = "As senhas não coincidem!";
        header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/cadastro.php");
        exit();
    }

    $banco = new Banco();
    $conn = $banco->conectar();

    $check = $conn->prepare("SELECT * FROM cliente WHERE email = :email");
    $check->bindParam(':email', $email);
    $check->execute();


    if($check->rowCount() > 0){
        $_SESSION['erro'] = "Este e-mail já está cadastrado!";
        header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/cadastro.php");
        exit();
    }


    $cliente = new Cliente($nome, $cpf, $email, $senha, $confirmar_senha);
    $result = $cliente->inserir();

    if($result){
        $_SESSION['mensagem'] = "Cliente cadastrado com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao cadastrar cliente!";
    }

    header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/login.php");
    exit();
}



    function getClientes(){
        try{
            $banco = new Banco();
            $conn = $banco->conectar();
            $stmt = $conn->prepare("select * from cliente");
            $stmt->execute();
           
            $clientes = array();
            foreach($stmt->fetchAll((PDO::FETCH_ASSOC)) as $value){
                $cliente = new Cliente($value['nome'], $value['cpf'], $value['email'], $value['senha'], $value['confirmar_senha']);
                $cliente->setIdCliente($value['id_cliente']);
                array_push($clientes,$cliente);
            }

            //var_dump($clientes);
            return $clientes;

        }catch(PDOException $e){
            echo "Erro " . $e->getMessage();
            return array();
        }
    }

function loginCliente(){
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $banco = new Banco();
    $conn = $banco->conectar();

    $stmt = $conn->prepare("SELECT * FROM cliente WHERE email = :email AND senha = :senha");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    if($stmt->rowCount() == 1){
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['id_cliente'] = $cliente['id_cliente'];
        $_SESSION['nome'] = $cliente['nome'];

        header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/dashboard.php");
        exit();
    } else {
        $_SESSION['erro'] = "Email ou senha incorretos!";
        header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/login.php");
        exit();
    }
}

function editarCliente(){
    session_start();

    $id = $_POST['id_cliente'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];

    $cliente = Cliente::carregar($id);

    if (!$cliente) {
        $_SESSION['erro'] = "Cliente não encontrado!";
        header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/configuracoes.php");
        exit();
    }

    $cliente->nome = $nome;
    $cliente->cpf = $cpf;
    $cliente->email = $email;

    if ($cliente->atualizar()) {
        $_SESSION['mensagem'] = "Informações atualizadas com sucesso!";
    } else {
        $_SESSION['erro'] = "Erro ao atualizar dados!";
    }

    header("Location: /FABRIKA-SQ-17/PROJETO/FRONT/HTML/configuracoes.php");
    exit();
}


     

?>