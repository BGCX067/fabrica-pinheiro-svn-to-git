<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of banners_model
 *
 * @author Lucas Pinheiro
 */

class Blogs_imagens_model extends MY_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->banco = $this->config->item('dbFabricaPinheiro');
        $this->tabela = $this->config->item('tblBlogsImagens');
        $this->apelido = 'bli';
    }

}