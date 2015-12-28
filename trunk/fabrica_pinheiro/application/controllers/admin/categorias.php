<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categorias
 *
 * @author Lucas Pinheiro
 */
class Categorias extends Admin_controller {

    //id_categorias, descricao, ordem

    function __construct() {
        parent::__construct();
        $this->template->set_js('categorias.js');
        $this->load->model('categorias_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $v_dados = array();
        $v_dados['id_categorias'] = '';
        $v_dados['descricao'] = '';
        $v_dados['ordem'] = '';
        $this->template->set_conteudo_titulo('Cadastrar Categoria');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/categorias/frm_cad_categorias_view', $v_dados, true));
    }

    function alterar() {
        $params = array();
        $params['AND']['id_categorias'] = $this->uri->segment(4);
        $b_consultar = $this->categorias_model->consultar($params);
        $b_consultar = $b_consultar[0];
        $v_dados = array();
        $v_dados['id_categorias'] = $b_consultar->id_categorias;
        $v_dados['descricao'] = $b_consultar->descricao;
        $v_dados['ordem'] = $b_consultar->ordem;
        $this->template->set_conteudo_titulo('Alterar Categoria');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/categorias/frm_cad_categorias_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['descricao'] = '';
        $dados = (Object) array();
        $dados->descricao = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['descricao'] = $dados->descricao;
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Categoria');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/categorias/frm_con_categorias_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['descricao'] = $this->input->post('descricao');

        redirect(url_admin() . 'categorias/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->descricao != NULL) {
            $params['LIKE']['descricao'] = $dados->descricao;
        }

        $b_consultar_total = $this->categorias_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->categorias_model->consultar($params);

        $v_dados = array();
        $v_dados['categorias'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['categorias'][$k]['id_categorias'] = $v->id_categorias;
                $v_dados['categorias'][$k]['descricao'] = $v->descricao;
                $v_dados['categorias'][$k]['ordem'] = $v->ordem;
                $v_dados['categorias'][$k]['acao'] = anchor(url_admin() . 'categorias/alterar/' . $v->id_categorias, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "categorias/consultar/" . json_url_base64_encode($dados);
            $config['total_rows'] = $b_consultar_total;
            $config['per_page'] = $this->total_registro_por_pagina;
            $config['cur_page'] = 0;
            $config['uri_segment'] = 5;
            $config['num_links'] = 4;
            $config['first_link'] = 'Primeiro';
            $config['last_link'] = 'Último';
            $config['next_link'] = 'Próximo';
            $config['prev_link'] = 'Anterior';

            $this->pagination->initialize($config);
            $v_dados['paginacao'] = $this->pagination->create_links();
        }

        return $this->parser->parse($this->template->get_diretorio() . '/categorias/lst_con_categorias_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('descricao', 'Descrição', 'required|trim');
        $this->form_validation->set_rules('ordem', 'Ordem', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['descricao'] = $this->input->post('descricao');
            $params['SET']['ordem'] = $this->input->post('ordem');
            if ($this->input->post('id_categorias') == "") {
                $v_dados['id_categorias'] = $this->categorias_model->cadastrar($params);
                $v_dados['msg'] = 'Categoria cadastrada com sucesso.';
            } else {
                $params['AND']['id_categorias'] = $this->input->post('id_categorias');
                $v_dados['id_categorias'] = $this->input->post('id_categorias');
                $this->categorias_model->alterar($params);
                $v_dados['msg'] = 'Categoria alterada com sucesso.';
            }
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

}

?>