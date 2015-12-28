<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of administracao
 *
 * @author lucas
 */
class Administracao extends Site_controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->template->set_js('php.min.js');
        $this->template->set_js('administracao.js');
    }

    function index() {
        $v_dados = array();
        $this->template->set_conteudo_titulo('Área Administrativa');
        $this->template->set_breadcrumbs('Área Administrativa');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/admin/login_view', $v_dados, true));
    }

    function logar() {
        $this->form_validation->set_rules('email', 'E-mail', 'email|required|trim');
        $this->form_validation->set_rules('senha', 'Senha', 'required|trim');

        $v_dados = array();
        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $this->load->model('usuarios_model');
            $params = array();
            $params['AND']['email'] = $this->input->post('email');
            $params['AND']['senha'] = $this->input->post('senha');
            $b_consultar = $this->usuarios_model->consultar($params);
            if ($b_consultar == null) {
                $v_dados['cod'] = 222;
                $v_dados['msg'] = 'Usuário ou senha inválidos.';
            } else {
                $v_dados['cod'] = 999;
                $v_dados['msg'] = 'Aguarde... Redirecionando para a área administrativa.';
                $v_dados['link'] = url_admin() . 'home/index';
                $this->session->set_userdata('idUsuario',$b_consultar[0]->id_usuarios);
                $this->session->set_userdata('idPessoas',$b_consultar[0]->id_pessoas);
            }
        }
        echo json_encode($v_dados);
    }

}

?>
