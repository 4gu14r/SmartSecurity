<?php
class celularDTO {
    private $cod;
    private $imei;
    private $marca;
    private $cor;
    private $modelo;
    private $usuario_id;
    
    public function getCod() {
        return $this->cod;
    }

    public function getImei() {
        return $this->imei;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getCor() {
        return $this->cor;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setCod($cod) {
        $this->cod = $cod;
    }

    public function setImei($imei) {
        $this->imei = $imei;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }


}
