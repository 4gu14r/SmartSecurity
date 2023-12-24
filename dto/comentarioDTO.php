<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comentarioDTO
 *
 * @author jvcag
 */
class comentarioDTO {
    private $cod;
    private $comentario;
    private $celular_cod;
    private $usuario_id;
    
    public function getCod() {
        return $this->cod;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function getCelular_cod() {
        return $this->celular_cod;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setCod($cod) {
        $this->cod = $cod;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function setCelular_cod($celular_cod) {
        $this->celular_cod = $celular_cod;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }


}
