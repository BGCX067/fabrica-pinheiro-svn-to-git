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
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set_js("jquery.js");
        $this->template->set_js("jquery-ui.js");
        $this->template->set_js("jquery_maskedinput.js");
        $this->template->set_css("jquery-ui.css");
        $this->template->set_css("geral.css");
        $this->load->library('user_agent');
        //echo $this->agent->browser();
        if ($this->agent->browser() == 'Internet Explorer') {
            if ($this->agent->version() < 7) {
                $this->template->set_meta('<meta http-equiv="X-UA-Compatible" Content="IE=8">');
                $this->template->set_js("jquery.pngFix.pack.js");
                $this->template->set_js("pngfix.js");
            } else {
                $this->template->set_meta('<meta http-equiv="X-UA-Compatible" Content="IE=' . substr((int) $this->agent->version(), 0, 1) . '">');
            }
        }
    }

}

?>