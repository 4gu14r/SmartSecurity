<?php

require_once '../conexao/conexao.php';

class loginDAO {

    public $pdo = null;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function login($email,$senha) {
        try {
            $sql = "SELECT u.cpf,u.email,p.perfil,u.id FROM usuario u
                    INNER JOIN perfil p ON (u.perfil_cod = p.cod)
                    WHERE email=? AND senha=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->bindValue(2, $senha);
            $stmt->execute();
            $login = $stmt->fetch(PDO::FETCH_ASSOC);
            return $login;
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            die();
        }
    }

}

