<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author lucas
 */
class Home extends Blogs_controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('blogs_model');
        $this->load->model('blogs_categorias_model');
        $this->load->model('blogs_tags_model');
    }

    function index() {
        $v_dados = array();
        $v_dados['paginacao'] = '';
        $v_dados['blogs'] = array();
        $params = array();
        $params['AND']['exibir'] = 'S';
        $b_consultar_total = $this->blogs_model->consultar_total($params);
        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = 10;
        $b_consultar = $this->blogs_model->consultar($params);
        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                $v_dados['blogs'][$k]['id_blogs'] = $v->id_blogs;
                $v_dados['blogs'][$k]['url_titulo'] = url_title($v->titulo, '_', TRUE);
                $v_dados['blogs'][$k]['titulo'] = $v->titulo;
                $v_dados['blogs'][$k]['descricao'] = $v->descricao;
                $v_dados['blogs'][$k]['data_hora_cadastro'] = formatarData($v->data_hora_cadastro, array('formato' => 'd/m/Y H:i:s'));
                $v_dados['blogs'][$k]['categorias'] = $this->_categorias($v->id_blogs);
                $v_dados['blogs'][$k]['tags'] = $this->_tags($v->id_blogs);
                ;
            }
            $config = array();
            $config['base_url'] = url_blog() . "home/index/";
            $config['total_rows'] = $b_consultar_total;
            $config['per_page'] = $params['LIMIT']['fim'];
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

        $this->template->display($this->parser->parse($this->template->get_diretorio() . 'lst_blog_view', $v_dados, true));
    }

    function detalhes($id_blogs) {
        $this->template->set_js('jquery_maskedinput.js');
        $this->template->set_css("demo.css");
        $this->template->set_js("socialite.min.js");
        $v_dados = array();
        $v_dados['paginacao'] = '';
        $v_dados['blogs'] = array();
        $params = array();
        $params['AND']['id_blogs'] = $id_blogs;
        $b_consultar = $this->blogs_model->consultar($params);
        $v = $b_consultar[0];
        $v_dados['id_blogs'] = $v->id_blogs;
        $v_dados['url_titulo'] = url_title($v->titulo, '_', TRUE);
        $v_dados['titulo'] = $v->titulo;
        $v_dados['descricao'] = $v->descricao;
        $v_dados['data_hora_cadastro'] = formatarData($v->data_hora_cadastro, array('formato' => 'd/m/Y H:i:s'));

        $this->template->set_meta('<meta name="description" content="' . $v_dados['titulo'] . '" />');
        $this->template->set_meta('<meta name="keywords" content="' . $this->template->keywords($v_dados['titulo'] . ' ' . $v_dados['descricao']) . '" />');
        $this->template->set_breadcrumbs('Blog : ' . $v_dados['titulo']);

        $v_dados['uri_string'] = $this->uri->uri_string();
        $v_dados['uri_title'] = $this->template->get_title() . ' ' . strip_tags($v_dados['titulo']);

        $this->template->display($this->parser->parse($this->template->get_diretorio() . 'lst_detalhes_blog_view', $v_dados, true));
    }

    private function _categorias($id_blogs) {
        $params = array();
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBlogsCategoriasHasBlogs') . ' as blch',
            'AND' => 'blch.id_blogs_categorias = blc.id_blogs_categorias',
            'TIPO' => 'INNER',
        );

        $params['AND']['blch.id_blogs'] = $id_blogs;
        $b_consultar = $this->blogs_categorias_model->consultar($params);
        $categorias = '';
        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                if ($categorias != '') {
                    $categorias .= ', ';
                }
                $categorias .= $v->nome;
            }
        }
        return $categorias;
    }

    private function _tags($id_blogs) {
        $params = array();
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBlogsTagsHasBlogs') . ' as blth',
            'AND' => 'blth.id_blogs_tags = blt.id_blogs_tags',
            'TIPO' => 'INNER',
        );

        $params['AND']['blth.id_blogs'] = $id_blogs;
        $b_consultar = $this->blogs_tags_model->consultar($params);
        $categorias = '';
        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                if ($categorias != '') {
                    $categorias .= ', ';
                }
                $categorias .= $v->nome;
            }
        }
        return $categorias;
    }

}