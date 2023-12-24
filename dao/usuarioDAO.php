<?php
require_once '../conexao/conexao.php';
require_once '../dto/usuarioDTO.php';
class usuarioDAO {
    private $pdo = null;
    public function __construct() {
        $this->pdo= Conexao::getInstance();
    }
    public function cadastrarUsuario(usuarioDTO $usuario){
        
            try {
            $sql="insert into usuario(nome,sobrenome,dt_nascimento,cpf,sexo,email,senha,endereco,perfil_cod)"
                    . "values(?,?,?,?,?,?,?,?,?)";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$usuario->getNome());
            $stmt->bindValue(2,$usuario->getSobre());
            $stmt->bindValue(3,$usuario->getDt_nascimento());
            $stmt->bindValue(4,$usuario->getCpf());
            $stmt->bindValue(5,$usuario->getSexo());
            $stmt->bindValue(6,$usuario->getEmail());
            $stmt->bindValue(7,$usuario->getSenha());
            $stmt->bindValue(8,$usuario->getEndereco());
            $stmt->bindValue(9,$usuario->getPerfil_cod());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao Cadastrar Usuário" . $exc->getMessage();
        }
    }
    
    public function getUsuarioById($id){
        try{
            $sql = "SELECT * FROM usuario WHERE id=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1,$id);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $usuario;
        } catch (Exception $exc) {
            echo "Erro ao carregar Usuário". $exc->getMessage();
            die();
        }
    }
        
    public function listarUsuario(){
        try {
            $sql="SELECT * FROM usuario";
            $stmt= $this->pdo->prepare($sql);
            $stmt->execute();
            $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $ex) {
            echo "Erro ao Listar Usuários".$ex->getMessage();
            die();
        }
    }
    
    public function alterarUsuario(usuarioDTO $usuario) {
        try{
            
            $sql="update usuario set nome=?, sobrenome=?, dt_nascimento=?, sexo=?, email=?, senha=?, endereco=?, perfil_cod=?"
                    . " where id=?";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1, $usuario->getNome());
            $stmt->bindValue(2, $usuario->getSobre());
            $stmt->bindValue(3, $usuario->getDt_nascimento());
            $stmt->bindValue(4, $usuario->getSexo());
            $stmt->bindValue(5, $usuario->getEmail());
            $stmt->bindValue(6, $usuario->getSenha());
            $stmt->bindValue(7, $usuario->getEndereco());
            $stmt->bindValue(8, $usuario->getPerfil_cod());
            $stmt->bindValue(9, $usuario->getId());
            return $stmt->execute();
        } catch (Exception $ex) {
            echo "Erro ao Alterar Usuário".$ex->getMessage();
            die();
        }
    }
    public function alterarPerfilUsuario(usuarioDTO $usuarioPerfil) {
        try{
            
            $sql="update usuario set nome=?, sobrenome=?, dt_nascimento=?, sexo=?, email=?, senha=?, endereco=?"
                    . " where id=?";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1, $usuarioPerfil->getNome());
            $stmt->bindValue(2, $usuarioPerfil->getSobre());
            $stmt->bindValue(3, $usuarioPerfil->getDt_nascimento());
            $stmt->bindValue(4, $usuarioPerfil->getSexo());
            $stmt->bindValue(5, $usuarioPerfil->getEmail());
            $stmt->bindValue(6, $usuarioPerfil->getSenha());
            $stmt->bindValue(7, $usuarioPerfil->getEndereco());
            $stmt->bindValue(8, $usuarioPerfil->getId());
            return $stmt->execute();
        } catch (Exception $ex) {
            echo "Erro ao Alterar Usuário".$ex->getMessage();
            die();
        }
    }
    
    public function excluirUsuario($id){
        try{
            $sql = "DELETE FROM usuario WHERE id=? ";
            $stmt=$this->pdo->prepare($sql);
            $stmt->bindValue(1,$id);           
            return $stmt->execute();      
        } catch (Exception $exc) {
            echo "<center><h1 style='margin-top: 100px; font-size: 50pt;'>Não foi possivel deletar o usuário!</h1></center>"
            . "<script>"
            . "alert('Você não pode apagar este usuário pois tem atividades presentes!');"
            . "var variavel = setInterval(function sweetAlert() {
                window.location.href = '../view/listarUsuario.php';
            },3000);"
            . "</script>";
        }
    }
    
    
}

