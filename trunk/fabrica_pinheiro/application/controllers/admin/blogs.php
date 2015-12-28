<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blogs
 *
 * @author lucas
 */
class blogs extends Admin_controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model('blogs_model');
        $this->load->model('blogs_categorias_has_blogs_model');
        $this->load->model('blogs_tags_has_blogs_model');
        $this->load->model('blogs_tags_model');
        $this->template->set_js("blogs.js");
        $this->load->helper('text');
    }

    public function cadastrar($id_blogs = null) {
        $v_dados = array();
        $v_dados['id_blogs'] = '';
        $v_dados['titulo'] = '';
        $v_dados['descricao'] = '';
        $v_dados['data_hora_cadastro'] = '';
        $v_dados['exibir'] = combo_exibir();
        $v_dados['id_categorias'] = combo_blogs_categorias();
        $v_dados['id_tags'] = '';

        $this->template->set_conteudo_titulo('Cadastrar Blog');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/blogs/frm_cad_blogs_view', $v_dados, true));
    }

    public function alterar($id_blogs = null) {
        $v_dados = array();
        $params = array();
        $params['AND']['id_blogs'] = $id_blogs;
        $b_consultar = $this->blogs_model->consultar($params);
        if ($b_consultar != null) {
            $v_dados['id_blogs'] = $b_consultar[0]->id_blogs;
            $v_dados['titulo'] = $b_consultar[0]->titulo;
            $v_dados['descricao'] = $b_consultar[0]->descricao;
            $v_dados['data_hora_cadastro'] = $b_consultar[0]->data_hora_cadastro;
            $v_dados['exibir'] = combo_exibir($b_consultar[0]->exibir);
            $v_dados['id_categorias'] = combo_blogs_categorias($b_consultar[0]->id_blogs);
            $v_dados['id_tags'] = lista_tags($b_consultar[0]->id_blogs);
        }
        $this->template->set_conteudo_titulo('Alterar Blog');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/blogs/frm_cad_blogs_view', $v_dados, true));
    }

    function consultar() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['titulo'] = '';
        $v_dados['descricao'] = '';
        $v_dados['id_categorias'] = combo_blogs_categorias();
        $dados = (Object) array();
        $dados->titulo = NULL;
        $dados->descricao = NULL;
        $dados->id_categorias = NULL;
        if ($this->uri->segment(4, NULL) != NULL) {
            $dados = json_url_base64_decode($this->uri->segment(4, NULL));
            $v_dados['titulo'] = $dados->titulo;
            $v_dados['descricao'] = $dados->descricao;
            $v_dados['id_categorias'] = combo_blogs_categorias($dados->id_categorias);
        }
        $v_dados['conteudo'] = $this->_consultar($dados);
        $this->template->set_conteudo_titulo('Consultar Blogs');
        $this->template->display($this->parser->parse($this->template->get_diretorio() . 'blogs/frm_con_blogs_view', $v_dados, true));
    }

    function consulta() {
        $v_dados = array();
        $v_dados['titulo'] = $this->input->post('titulo');
        $v_dados['descricao'] = $this->input->post('descricao');
        $v_dados['id_categorias'] = $this->input->post('id_categorias');

        redirect(url_admin() . 'blogs/consultar/' . json_url_base64_encode($v_dados));
    }

    function _consultar($dados) {
        $params = array();

        if ($dados->titulo != NULL) {
            $params['OR_LIKE']['bl.titulo'] = $dados->titulo;
        }
        if ($dados->descricao != NULL) {
            $params['OR_LIKE']['bl.descricao'] = $dados->descricao;
        }

        $b_consultar_total = $this->blogs_model->consultar_total($params);

        if ($dados->id_categorias != NULL) {
            $params['AND']['blc.id_blogs_categorias'] = $dados->id_categorias;
        }

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBlogsCategoriasHasBlogs') . ' as blch',
            'AND' => 'blch.id_blogs = bl.id_blogs',
            'TIPO' => 'INNER',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBlogsCategorias') . ' as blc',
            'AND' => 'blch.id_blogs_categorias = blc.id_blogs_categorias',
            'TIPO' => 'INNER',
        );

        $params['CAMPOS'] = 'bl.*, blc.nome as blc_nome';
        $params['GROUPBY'] = 'bl.id_blogs';

        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = $this->total_registro_por_pagina;
        $b_consultar = $this->blogs_model->consultar($params);

        $v_dados = array();
        $v_dados['blogs'] = array();
        $v_dados['paginacao'] = '';

        if ($b_consultar != NULL) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['blogs'][$k]['id_blogs'] = $v->id_blogs;
                $v_dados['blogs'][$k]['titulo'] = $v->titulo;
                $v_dados['blogs'][$k]['descricao'] = word_limiter(strip_tags($v->descricao),15);
                $v_dados['blogs'][$k]['data_hora_cadastro'] = formatarData($v->data_hora_cadastro, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['blogs'][$k]['exibir'] = ($v->exibir == 'S' ? 'Sim' : 'Não');
                $v_dados['blogs'][$k]['blc_nome'] = $v->blc_nome;
                $v_dados['blogs'][$k]['acao'] = anchor(url_admin() . 'blogs/alterar/' . $v->id_blogs, 'Alterar');
            }
            $config = array();
            $config['base_url'] = url_admin() . "blogs/consultar/" . json_url_base64_encode($dados);
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

        return $this->parser->parse($this->template->get_diretorio() . 'blogs/lst_con_blogs_view', $v_dados, true);
    }

    public function gravar() {
        $this->form_validation->set_rules('titulo', 'Titulo', 'trim|required');
        $this->form_validation->set_rules('data_hora_cadastro', 'Data/Hora cadastro', 'trim|required');
        $this->form_validation->set_rules('exibir', 'Exibir', 'trim|required');
        $this->form_validation->set_rules('descricao', 'Descrição', 'trim|required');
        $this->form_validation->set_rules('id_categorias', 'Categorias', 'required');
        $this->form_validation->set_rules('id_tags', 'Tags', 'trim|required');

        $v_dados = array();

        if ($this->form_validation->run() === FALSE) {
            $v_dados['cod'] = 111;
            $v_dados['msg'] = $this->form_validation->msg_erros_campos_json();
            $v_dados['campos'] = $this->form_validation->erros_campos_json();
        } else {
            $params = array();
            $params['SET']['titulo'] = $this->input->post('titulo');
            $params['SET']['descricao'] = $this->input->post('descricao');
            $params['SET']['exibir'] = $this->input->post('exibir');
            $params['SET']['data_hora_cadastro'] = formatarData($this->input->post('data_hora_cadastro'), array('formato' => 'Y-m-d H:i:s'));

            if ($this->input->post('id_blogs') == "") {
                $v_dados['id_blogs'] = $this->blogs_model->cadastrar($params);
                $v_dados['msg'] = 'Conteúdo cadastrado com sucesso.';
            } else {
                $params['AND']['id_blogs'] = $this->input->post('id_blogs');
                $v_dados['id_blogs'] = $this->input->post('id_blogs');
                $this->blogs_model->alterar($params);
                $v_dados['msg'] = 'Conteúdo alterado com sucesso.';
            }
            $v_dados['cod'] = 999;
            $this->cad_categorias_has($v_dados['id_blogs'], $this->input->post('id_categorias'));
            $this->cad_tags_has($v_dados['id_blogs'], $this->input->post('id_tags'));
        }
        echo json_encode($v_dados);
    }

    private function cad_categorias_has($id_blogs, $id_categorias) {
        $params = array();
        $params['AND']['id_blogs'] = $id_blogs;
        $this->blogs_categorias_has_blogs_model->excluir($params);
        foreach ($id_categorias as $value) {
            $params = array();
            $params['SET']['id_blogs'] = $id_blogs;
            $params['SET']['id_blogs_categorias'] = $value;
            $this->blogs_categorias_has_blogs_model->cadastrar($params);
        }
    }

    private function cad_tags_has($id_blogs, $id_tags) {

        $params = array();
        $params['AND']['id_blogs'] = $id_blogs;
        $this->blogs_tags_has_blogs_model->excluir($params);

        $id_tags = explode(',', $id_tags);
        foreach ($id_tags as $value) {
            $params = array();
            $params['AND']['nome'] = trim($value);
            $b_consultar = $this->blogs_tags_model->consultar($params);
            if ($b_consultar == null) {
                $params = array();
                $params['SET']['nome'] = trim($value);
                $id = $this->blogs_tags_model->cadastrar($params);
            } else {
                $id = $b_consultar[0]->id_blogs_tags;
            }

            $params = array();
            $params['SET']['id_blogs'] = $id_blogs;
            $params['SET']['id_blogs_tags'] = $id;
            $this->blogs_tags_has_blogs_model->cadastrar($params);
        }
    }

}
