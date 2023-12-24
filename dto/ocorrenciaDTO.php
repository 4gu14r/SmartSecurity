<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ocorrenciaDTO
 *
 * @author jvcag
 */
class ocorrenciaDTO {
    private $cod;
    private $tipo;
    private $localizacao;
    private $referencia;
    private $dt_registro;
    private $hr_registro;
    private $titulo_registro;
    private $marca;
    private $modelo;
    private $cor;
    private $imei;
    private $descricao;
    private $usuario_id;
    
    public function getCod() {
        return $this->cod;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getReferencia() {
        return $this->referencia;
    }

    public function getDt_registro() {
        return $this->dt_registro;
    }

    public function getHr_registro() {
        return $this->hr_registro;
    }

    public function getTitulo_registro() {
        return $this->titulo_registro;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getCor() {
        return $this->cor;
    }

    public function getImei() {
        return $this->imei;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function setCod($cod) {
        $this->cod = $cod;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    public function setDt_registro($dt_registro) {
        $this->dt_registro = $dt_registro;
    }

    public function setHr_registro($hr_registro) {
        $this->hr_registro = $hr_registro;
    }

    public function setTitulo_registro($titulo_registro) {
        $this->titulo_registro = $titulo_registro;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    public function setCor($cor) {
        $this->cor = $cor;
    }

    public function setImei($imei) {
        $this->imei = $imei;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }



}
