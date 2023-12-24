<?php
require_once '../conexao/conexao.php';
require_once '../dto/ocorrenciaDTO.php';
class ocorrenciaDAO {
    private $pdo;
    public function __construct() {
        $this->pdo= Conexao::getInstance();
    }
    public function registrarOcorrencia(ocorrenciaDTO $ocorrencia){
        try {
            $sql="insert into ocorrencia(tipo,localizacao,referencia,dt_registro,hr_registro,titulo_registro,marca,modelo,cor,imei,descricao,usuario_id)"
                    . "values(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$ocorrencia->getTipo());
            $stmt->bindValue(2,$ocorrencia->getLocalizacao());
            $stmt->bindValue(3,$ocorrencia->getReferencia());
            $stmt->bindValue(4,$ocorrencia->getDt_registro());
            $stmt->bindValue(5,$ocorrencia->getHr_registro());
            $stmt->bindValue(6,$ocorrencia->getTitulo_registro());
            $stmt->bindValue(7,$ocorrencia->getMarca());
            $stmt->bindValue(8,$ocorrencia->getModelo());
            $stmt->bindValue(9,$ocorrencia->getCor());
            $stmt->bindValue(10,$ocorrencia->getImei());
            $stmt->bindValue(11,$ocorrencia->getDescricao());
            $stmt->bindValue(12,$ocorrencia->getUsuario_id());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao registrar Ocorrência" . $exc->getMessage();
        }
    }
    
    public function getOcorrenciaByCod($cod){
        try{
            $sql = "SELECT * FROM ocorrencia WHERE cod=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1,$cod);
            $stmt->execute();
            $ocorrencia = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ocorrencia;
        } catch (Exception $exc) {
            echo "Erro ao carregar a Ocorrência". $exc->getMessage();
            die();
        }
    }
    
    public function getAllOcorrenciaByOcorrencia($ocorrencia){
        try{
            $sql="SELECT * from ocorrencia where localizacao like ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1,"%".$ocorrencia."%");
            $stmt->execute();
            $lista  =$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc){
            echo "Erro ao Carregar as ocorrencia".$exc->getMessage();
            die();
        }
    }
    public function getAllOcorrenciaByOcorrencia2($ocorrencia){
        try{
            $sql="SELECT * from ocorrencia where marca like ? or modelo like  ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1,"%".$ocorrencia."%");
            $stmt->bindValue(2,"%".$ocorrencia."%");
            $stmt->execute();
            $lista  =$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc){
            echo "Erro ao Carregar as ocorrencia".$exc->getMessage();
            die();
        }
    }
    
    public function listarOcorrencia(){
        try {
            $sql="SELECT * FROM ocorrencia";
            $stmt= $this->pdo->prepare($sql);
            $stmt->execute();
            $lista=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc) {
            echo "Erro ao listar a Oorrência" . $exc->getMessage();
        }
    }
    public function listarOcorrenciaByUsuario($usuario_id){
        try {
            $sql="SELECT * FROM ocorrencia where usuario_id=?";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$usuario_id);
            $stmt->execute();
            $lista=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc) {
            echo "Erro ao listar a Oorrência" . $exc->getMessage();
        }
    }
    
    public function alterarOcorrencia(ocorrenciaDTO $ocorrencia){
        try {
            $sql = "update ocorrencia set tipo=?, localizacao=?, referencia=?, dt_registro=?,hr_registro=?, titulo_registro=?,marca=?,modelo=?"
                    . "where cod=?";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$ocorrencia->getTipo());
            $stmt->bindValue(2,$ocorrencia->getLocalizacao());
            $stmt->bindValue(3,$ocorrencia->getReferencia());
            $stmt->bindValue(4,$ocorrencia->getDt_registro());
            $stmt->bindValue(5,$ocorrencia->getHr_registro());
            $stmt->bindValue(6,$ocorrencia->getTitulo_registro());
            $stmt->bindValue(7,$ocorrencia->getMarca());
            $stmt->bindValue(8,$ocorrencia->getModelo());
            $stmt->bindValue(9,$ocorrencia->getCod());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao editar os dados da ocorrência".$exc->getMessage();
        }
    }
    
    public function excluirOcorrencia($cod){
        try {
            $sql="DELETE FROM ocorrencia WHERE cod=?";
            $stmt=$this->pdo->prepare($sql);
            $stmt->bindValue(1,$cod);           
            return $stmt->execute();      
        } catch (Exception $exc) {
            echo "Erro ao deletar a ocorrência" . $exc->getMessage();
        }
        }
}
