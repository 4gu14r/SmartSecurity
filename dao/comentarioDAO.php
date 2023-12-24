<?php
require_once '../conexao/conexao.php';
require_once '../dto/comentarioDTO.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comentarioDAO
 *
 * @author jvcag
 */
class comentarioDAO {
    private $pdo;
    public function __construct() {
        $this->pdo= Conexao::getInstance();
    }
    public function postarComentario(comentarioDTO $comentario){
        try {
            $sql = "INSERT INTO comentario(comentario,usuario_id)"
                    . "values(?,?)";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$comentario->getComentario());
            $stmt->bindValue(2,$comentario->getUsuario_id());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao enviar o Comentário" . $exc->getMessage();
        }
    }
    public function listarComentario(){
        try {
            $sql="SELECT * FROM comentario";
            $stmt=$this->pdo->prepare($sql);
            $stmt->execute();
            $lista=$stmt->fetchAll(PDO::FETCH_ASSOC);
            return $lista;
        } catch (Exception $exc) {
            echo "Erro ao listar os comentários postado".$exc->getMessage();
        }
    }
    public function alterarComentario(comentarioDTO $comentario){
        try {
            $sql="update comentario set comentario=?"
                    . "WHERE cod=?";
            $stmt= $this->pdo->prepare($sql);
            $stmt->bindValue(1,$comentario->getComentario());
            $stmt->bindValue(2,$comentario->getCod());
            return $stmt->execute();
        } catch (Exception $exc) {
            echo "Erro ao editar comentario" . $exc->getMessage();
        }
    }
    public function getComentarioByCod($cod){
        try {
            $sql="SELECT * FROM comentario WHERE cod=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1,$cod);
            $stmt->execute();
            $comentario = $stmt->fetch(PDO::FETCH_ASSOC);
            return $comentario;
        } catch (Exception $exc) {
            echo "Erro ao Carregar Comentário" . $exc->getTraceAsString();
        }
    }
    public function excluirComentario($cod){
        try {
            $sql="DELETE FROM comentario WHERE cod=?";
            $stmt=$this->pdo->prepare($sql);
            $stmt->bindValue(1,$cod);           
            return $stmt->execute();      
        } catch (Exception $exc) {
            echo "Erro ao excluir o comentario" . $exc->getMessage();
        }
    }
}
