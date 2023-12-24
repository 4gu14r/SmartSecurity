<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioDTO
 *
 * @author jvcag
 */

class usuarioDTO {
    private $id;
    private $nome;
    private $sobre;
    private $dt_nascimento;
    private $cpf;
    private $sexo;
    private $email;
    private $senha;
    private $endereco;
    private $perfil_cod;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSobre() {
        return $this->sobre;
    }

    public function getDt_nascimento() {
        return $this->dt_nascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getEndereco() {
        return $this->endereco;
    }

    public function getPerfil_cod() {
        return $this->perfil_cod;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setSobre($sobre) {
        $this->sobre = $sobre;
    }

    public function setDt_nascimento($dt_nascimento) {
        $this->dt_nascimento = $dt_nascimento;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    public function setPerfil_cod($perfil_cod) {
        $this->perfil_cod = $perfil_cod;
    }


}
