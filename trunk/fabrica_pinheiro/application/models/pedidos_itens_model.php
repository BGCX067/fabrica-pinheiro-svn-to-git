<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pedidos_itens_model
 *
 * @author Lucas Pinheiro
 */
class Pedidos_itens_model extends MY_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->banco = $this->config->item('dbFabricaPinheiro');
        $this->tabela = $this->config->item('tblPedidoItens');
        $this->apelido = 'pdi';
    }

}