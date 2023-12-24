<?php
require_once '../conexao/conexao.php';
require_once '../dto/celularDTO.php';
class celularDAO {
    private $pdo;
    public function __construct() {
        $this->pdo= Conexao::getInstance();
    }
    public function cadastrarCelular(celularDTO $celular){
        try {
            $sql = "insert into celular(imei,marca,cor,modelo,usuario_id)"
                    . "values(?,?,?,?,?)";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$celular->getImei());
            $stmt->bindValue(2,$celular->getMarca());
            $stmt->bindValue(3,$celular->getCor());
            $stmt->bindValue(4,$celular->getModelo());
            $stmt->bindValue(5,$celular->getUsuario_id());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao Cadastrar o Smartphone" .$exc->getMessage();
        }
    }
    
    public function listarCelular(){
        try {
            $sql = "SELECT * FROM celular";
            $stmt=$this->pdo->prepare($sql);
            $stmt->execute();
            $lista=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc) {
            echo "Erro ao listar os Aparelhos cadastrados".$exc->getMessage();
        }
    }
    public function listarCelularByUsuario($usuario_id){
        try {
            $sql = "SELECT * FROM celular where usuario_id=?";
            $stmt=$this->pdo->prepare($sql);
            $stmt->bindValue(1,$usuario_id);
            $stmt->execute();
            $lista=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc) {
            echo "Erro ao listar os Aparelhos cadastrados".$exc->getMessage();
        }
    }
    
    public function alterarCelular(celularDTO $celular){
        try {
            $sql = "update celular set marca=?, modelo=?, cor=?"
                    . "WHERE cod=? ";
            $stmt = $this->pdo->prepare($sql);
            $stmt -> bindValue(1,$celular->getMarca());
            $stmt -> bindValue(2,$celular->getModelo());
            $stmt -> bindValue(3,$celular->getCor());
            $stmt -> bindValue(4,$celular->getCod());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao editar os dados" . $exc->getMessage();
        }
    }
    
    public function getCelularByCod($cod){
        try{
            $sql = "SELECT * FROM celular WHERE cod=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1,$cod);
            $stmt->execute();
            $celular = $stmt->fetch(PDO::FETCH_ASSOC);
            return $celular;
        } catch (Exception $exc) {
            echo "Erro ao carregar o aparelho". $exc->getMessage();
            die();
        }
    }
    
    public function excluirCelular($cod){
        try {
            $sql="DELETE FROM celular WHERE cod=?";
            $stmt=$this->pdo->prepare($sql);
            $stmt->bindValue(1,$cod);           
            return $stmt->execute();      
        } catch (Exception $exc) {
            echo "Erro ao remover o dispositivo" . $exc->getMessage();
        }
    }
}
