<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blogs_categorias
 *
 * @author Lucas Pinheiro
 */
class Blogs_categorias extends Admin_controller {

    //id_blogs_categorias, nome

    function __construct() {
        parent::__construct();
        $this->template->set_js('blogs_categorias.js');
        $this->load->model('blogs_categorias_model');
    }

    function index() {
        $this->template->display('Selecione uma opção no menu.');
    }

    function cadastrar() {
        $v_dados = array();
        $v_dados['id_blogs_categorias'] = '';
        $v_dados['nome'] = '';
        $this->template->set_conteudo_titulo('Cadastrar Categoria');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/blogs_categorias/frm_cad_blogs_categorias_view', $v_dados, true));
    }

    function alterar() {
        $params = array();
        $params['AND']['id_blogs_categorias'] = $this->uri->segment(4);
        $b_consultar = $this->blogs_categorias_model->consultar($params);
        $b_consultar = $b_consultar[0];
        $v_dados = array();
        $v_dados['id_blogs_categorias'] = $b_consultar->id_blogs_categorias;
        $v_dados['nome'] = $b_consultar->nome;
        $this->template->set_conteudo_titulo('Alterar Categoria');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/blogs_categorias/frm_cad_blogs_categorias_view', $v_dados, true));
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
        $this->template->set_conteudo_titulo('Consultar Blog Categoria');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/blogs_categorias/frm_con_blogs_categorias_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['nome'] = $this->input->post('nome');

        redirect(url_admin() . 'blogs_categorias/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->nome != NULL) {
            $params['LIKE']['nome'] = $dados->nome;
        }

        $b_consultar_total = $this->blogs_categorias_model->consultar_total($params);

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->blogs_categorias_model->consultar($params);

        $v_dados = array();
        $v_dados['blogs_categorias'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['blogs_categorias'][$k]['id_blogs_categorias'] = $v->id_blogs_categorias;
                $v_dados['blogs_categorias'][$k]['nome'] = $v->nome;
                $v_dados['blogs_categorias'][$k]['acao'] = anchor(url_admin() . 'blogs_categorias/alterar/' . $v->id_blogs_categorias, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "blogs_categorias/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . '/blogs_categorias/lst_con_blogs_categorias_view', $v_dados, true);
    }

    function gravar() {
        $this->form_validation->set_rules('nome', 'Descrição', 'required|trim');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['nome'] = $this->input->post('nome');
            if ($this->input->post('id_blogs_categorias') == "") {
                $v_dados['id_blogs_categorias'] = $this->blogs_categorias_model->cadastrar($params);
                $v_dados['msg'] = 'Categoria cadastrada com sucesso.';
            } else {
                $params['AND']['id_blogs_categorias'] = $this->input->post('id_blogs_categorias');
                $v_dados['id_blogs_categorias'] = $this->input->post('id_blogs_categorias');
                $this->blogs_categorias_model->alterar($params);
                $v_dados['msg'] = 'Categoria alterada com sucesso.';
            }
            $v_dados['cod'] = 999;
        }
        echo json_encode($v_dados);
    }

}

?>