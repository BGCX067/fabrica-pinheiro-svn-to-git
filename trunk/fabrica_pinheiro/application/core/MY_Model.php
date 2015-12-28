<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Model
 *
 * @author lucas
 */
class MY_Model extends CI_Model {

    //put your code here

    protected $banco = null;
    protected $tabela = null;
    protected $apelido = null;

    public function __construct() {
        parent::__construct();
    }

    public function get($parametros = array()) {
        $this->database_fabrica_pinheiro->gera_query($parametros);
        $query = $this->db->get(($this->banco == null ? '' : $this->banco . '.') . $this->tabela . ($this->apelido == null ? '' : ' as ' . $this->apelido));
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function consultar($parametros = array()) {
        $this->database_fabrica_pinheiro->gera_query($parametros);
        $query = $this->db->get(($this->banco == null ? '' : $this->banco . '.') . $this->tabela . ($this->apelido == null ? '' : ' as ' . $this->apelido));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function consultar_total($parametros = array()) {
        $this->database_fabrica_pinheiro->gera_query($parametros);
        $query = $this->db->count_all_results(($this->banco == null ? '' : $this->banco . '.') . $this->tabela . ($this->apelido == null ? '' : ' as ' . $this->apelido));
        return $query;
    }

    public function cadastrar($parametros = array()) {
        $this->database_fabrica_pinheiro->gera_query($parametros);
        $this->db->insert(($this->banco == null ? '' : $this->banco . '.') . $this->tabela);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return null;
        }
    }

    public function alterar($parametros = array()) {
        $this->database_fabrica_pinheiro->gera_query($parametros);
        $this->db->update(($this->banco == null ? '' : $this->banco . '.') . $this->tabela);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return null;
        }
    }

    public function excluir($parametros = array()) {
        $this->database_fabrica_pinheiro->gera_query($parametros);
        $this->db->delete(($this->banco == null ? '' : $this->banco . '.') . $this->tabela);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return null;
        }
    }

    public function debug() {
        pre($this->db->last_query());
    }

}