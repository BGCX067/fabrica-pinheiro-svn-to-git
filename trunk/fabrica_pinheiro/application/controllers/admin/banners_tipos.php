<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of banners_tipos
 *
 * @author Lucas Pinheiro
 */
class Banners_tipos extends Admin_controller {

    //id_banners_tipos, nome, largura, altura, extensao

    function __construct() {
        parent::__construct();
        $this->template->set_js('banners_tipos.js');
        $this->load->model('banners_tipos_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $v_dados = array();
        $v_dados['id_banners_tipos'] = '';
        $v_dados['nome'] = '';
        $v_dados['largura'] = '';
        $v_dados['altura'] = '';
        $v_dados['extensao'] = '';
        $this->template->set_conteudo_titulo('Cadastrar Tipos de Banners');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/banners_tipos/frm_cad_banners_tipos_view', $v_dados, true));
    }

    function alterar() {
        $params = array();
        $params['AND']['id_banners_tipos'] = $this->uri->segment(4);
        $b_consultar = $this->banners_tipos_model->consultar($params);
        $b_consultar = $b_consultar[0];
        $v_dados = array();

        $v_dados['id_banners_tipos'] = $b_consultar->id_banners_tipos;
        $v_dados['nome'] = $b_consultar->nome;
        $v_dados['largura'] = $b_consultar->largura;
        $v_dados['altura'] = $b_consultar->altura;
        $v_dados['extensao'] = $b_consultar->extensao;

        $this->template->set_conteudo_titulo('Alterar Tipos de Banners');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/banners_tipos/frm_cad_banners_tipos_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['nome'] = '';
        $dados = (Object) array();
        $dados->nome = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['nome'] = $dados->nome;
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Tipos de Banners');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/banners_tipos/frm_con_banners_tipos_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['nome'] = $this->input->post('nome');

        redirect(url_admin() . 'banners_tipos/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->nome != NULL) {
            $params['LIKE']['nome'] = $dados->nome;
        }

        $b_consultar_total = $this->banners_tipos_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->banners_tipos_model->consultar($params);

        $v_dados = array();
        $v_dados['banners_tipos'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['banners_tipos'][$k]['id_banners_tipos'] = $v->id_banners_tipos;
                $v_dados['banners_tipos'][$k]['nome'] = $v->nome;
                $v_dados['banners_tipos'][$k]['largura'] = $v->largura;
                $v_dados['banners_tipos'][$k]['altura'] = $v->altura;
                $v_dados['banners_tipos'][$k]['extensao'] = $v->extensao;
                $v_dados['banners_tipos'][$k]['acao'] = anchor(url_admin() . 'banners_tipos/alterar/' . $v->id_banners_tipos, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "banners_tipos/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/banners_tipos/lst_con_banners_tipos_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('nome', 'Nome', 'required|trim');
        $this->form_validation->set_rules('largura', 'Largura', 'required|trim');
        $this->form_validation->set_rules('altura', 'Altura', 'required|trim');
        $this->form_validation->set_rules('extensao', 'Extansão', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['nome'] = $this->input->post('nome');
            $params['SET']['largura'] = $this->input->post('largura');
            $params['SET']['altura'] = $this->input->post('altura');
            $params['SET']['extensao'] = $this->input->post('extensao');
            if ($this->input->post('id_banners_tipos') == "") {
                $v_dados['id_banners_tipos'] = $this->banners_tipos_model->cadastrar($params);
                $v_dados['msg'] = 'Tipo de banner cadastrado com sucesso.';
            } else {
                $params['AND']['id_banners_tipos'] = $this->input->post('id_banners_tipos');
                $v_dados['id_banners_tipos'] = $this->input->post('id_banners_tipos');
                $this->banners_tipos_model->alterar($params);
                $v_dados['msg'] = 'Tipo de banner alterado com sucesso.';
            }
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

}

?>