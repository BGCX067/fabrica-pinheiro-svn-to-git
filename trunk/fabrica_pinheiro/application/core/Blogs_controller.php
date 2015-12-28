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
class Blogs_controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set_breadcrumbs('Início', url_blog() . 'home/index/');
        $this->template->set_diretorio('blog');
        $this->template->set_title("Blog Pinheiro Shop");
        $this->template->set_css("blog.css");
        $this->template->set_js("geral.js");
        $this->template->set_js("blog.js");
        $this->template->set_rodape($this->rodape());
        $this->get_menu_lateral_esquerda();
        $this->get_menu_lateral_direita();
    }

    function get_menu_lateral_esquerda() {
        $this->load->model('blogs_categorias_model');
        $params = array();
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBlogsCategoriasHasBlogs') . ' as blch',
            'AND' => 'blch.id_blogs_categorias = blc.id_blogs_categorias',
            'TIPO' => 'INNER',
        );
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblBlogs') . ' as bl',
            'AND' => 'blch.id_blogs = bl.id_blogs',
            'TIPO' => 'INNER',
        );
        $params['CAMPOS'] = 'blc.*';
        $params['GROUPBY'] = 'blc.id_blogs_categorias';
        $params['ORDERBY'] = 'blc.nome ASC';

        $lateral_esquerda = '<div class="menu_lateral_esquerda borda_redonda borda_content"><h2 class="conteudo_titulo">Categorias</h2>';
        $b_consultar = $this->blogs_categorias_model->consultar($params);
        if ($b_consultar != null) {
            $lateral_esquerda .= '<ul>';
            foreach ($b_consultar as $k => $v) {
                $lateral_esquerda .= '<li><a href="' . url_blog() . 'home/index/' . $v->id_blogs_categorias . '">' . $v->nome . '</a></li>';
            }
            $lateral_esquerda .= '</ul>';
        }
        $lateral_esquerda .= '</div>' . $this->_get_banners(2, ' != ');
        $this->template->set_lateral_esquerda($lateral_esquerda);
    }

    function get_menu_lateral_direita() {
        $lateral_esquerda = $this->_get_banners(2, ' != ');
        $this->template->set_lateral_direita($lateral_esquerda);
    }

    function rodape() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['admin'] = anchor(url_site() . 'administracao', "Área administrativa");
        $v_dados['site'] = anchor(url_site() . 'home/index', "Loja Virtual");
        return $this->parser->parse($this->template->get_diretorio() . 'rodape', $v_dados, true);
    }

   function _get_banners($tipo, $direfente = ' = ') {
        $this->load->model('banners_model');
        $params = array();
        $params['AND']['id_banners_tipos' . $direfente] = $tipo;
        $params['LIMIT']['inicio'] = 0;
        $params['LIMIT']['fim'] = 1;
        $params['ORDERBY'] = 'RAND()';
        $b_consultar = $this->banners_model->consultar($params);
        if ($b_consultar != null) {
            return '<div class="site_banner">' . anchor($b_consultar[0]->link, '<img src="' . base_url() . 'banners/' . $b_consultar[0]->path . '" />', 'target="_blank"') . '</div>';
        } else {
            return '';
        }
    }
}

?>