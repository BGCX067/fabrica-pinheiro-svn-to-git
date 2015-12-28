<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author Lucas Pinheiro
 */
class Admin_controller extends MY_Controller {

    protected $total_registro_por_pagina = 25;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('idUsuario')) {
            $this->session->sess_destroy();
            redirect(url_site() . 'administracao');
        } else {
            $this->template->set_diretorio('admin');
            //$this->template->set_title("Fábrica Pinheiro");
            $this->template->set_title("Pinheiro Shop");
            $this->template->set_css("admin.css");
            $this->template->set_css("select2.css");
            $this->template->set_js("geral.js");
            $this->template->set_js("select2.min.js");
            $this->template->set_js("admin.js");
            $this->template->set_css(FCPATH . "template/admin/js/redactor/css/redactor.css");
            $this->template->set_js("redactor/redactor.js");
            $rodape = '<div>Todos os direitos reservados 2011-' . date('Y') . '</div>';
            $rodape .= '<div>Designer: ' . mailto('pinheirolouco@gmail.com', 'Lucas Pinheiro') . '</div>';
            $this->template->set_rodape($rodape);
        }
    }

}

?>