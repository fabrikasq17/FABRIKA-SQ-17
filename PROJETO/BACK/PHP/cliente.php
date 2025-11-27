<?php
    include_once 'BANCO/banco.php';

/*onsubmit=" event.preventDefault(); alert('Cliente salvo (simulado)')"*/ 
    class Cliente{
        public $id_cliente;
        public $nome;
        public $cpf;
        public $email;
        public $senha;
        public $confirmar_senha; 

        function __construct($nome, $cpf, $email, $senha, $confirmar_senha){
            $this->nome = $nome;
            $this->cpf = $cpf;
            $this->email = $email;
            $this->senha = $senha;
            $this->confirmar_senha = $confirmar_senha;
        }

        function inserir(){
            $banco = new Banco();
            $conn = $banco->conectar();
            try{
                $stmt = $conn->prepare("insert into cliente (nome, cpf, email, senha, confirmar_senha) values(:nome, :cpf, 
                :email, :senha, :confirmar_senha)");
                $stmt->bindParam(':nome',$this->nome);
                $stmt->bindParam(':cpf',$this->cpf);
                $stmt->bindParam(':email',$this->email);
                $stmt->bindParam(':senha',$this->senha);
                $stmt->bindParam(':confirmar_senha',$this->confirmar_senha);
                
                $result = $stmt->execute();
                $banco->fecharConexao();

                return $result;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        function atualizar(){
            $banco = new Banco();
            $conn = $banco->conectar();

            try {
                $stmt = $conn->prepare("
                    UPDATE cliente
                    SET nome = :nome, cpf = :cpf, email = :email
                    WHERE id_cliente = :id_cliente
                ");

                $stmt->bindParam(':id_cliente', $this->id_cliente);
                $stmt->bindParam(':nome', $this->nome);
                $stmt->bindParam(':cpf', $this->cpf);
                $stmt->bindParam(':email', $this->email);

                return $stmt->execute();

            } catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
        }

        function getIdCliente(){
            return $this->id_cliente;
        }

        function setIdCliente($id_cliente){
            $this->id_cliente = $id_cliente;
        }

        static function carregar($id_cliente){
            try{
                $banco = new Banco();
                $conn = $banco->conectar();
                $stmt = $conn->prepare("select * from cliente where id_cliente = :id_cliente");
                $stmt->bindParam(':id_cliente',$id_cliente);
                $stmt->execute();
                $cliente = null;
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                foreach($stmt->fetchAll() as $v => $value){
                    $cliente = new Cliente($value['nome'], $value['cpf'], $value['email'], $value['senha'],
                    $value['confirmar_senha']);
                    $cliente->setIdCliente( $value['id_cliente']);
                }
                return $cliente;

            }catch(PDOException $e){
                echo "Erro " . $e->getMessage();
            }
        }


    }
?>