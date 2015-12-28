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
class Site_controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->set_breadcrumbs('Início', url_site() . 'home/index/');
        $this->template->set_diretorio('site');
        $this->template->set_title("Pinheiro Shop");
        $this->template->set_css("site.css");
        $this->template->set_js("geral.js");
        $this->template->set_js("site.js");
        $this->template->set_rodape($this->rodape());
        $this->get_menu_lateral_esquerda();
        $this->get_menu_lateral_direita();
    }

    function get_menu_lateral_esquerda() {
        $this->load->model('categorias_model');
        $params = array();
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblProdutos') . ' as pr',
            'AND' => 'ct.id_categorias = pr.id_categorias',
            'TIPO' => 'INNER',
        );
        $params['CAMPOS'] = 'ct.*';
        $params['AND']['pr.exibir'] = 'S';
        $params['AND']['pr.data_exclusao'] = NULL;
        $params['GROUPBY'] = 'ct.id_categorias';
        $params['ORDERBY'] = 'ct.descricao ASC';

        $lateral_esquerda = '<div class="menu_lateral_esquerda borda_redonda borda_content"><h2 class="conteudo_titulo">Categorias</h2>';
        $b_consultar = $this->categorias_model->consultar($params);
        if ($b_consultar != null) {
            $lateral_esquerda .= '<ul>';
            foreach ($b_consultar as $k => $v) {
                $lateral_esquerda .= '<li><a href="' . url_site() . 'home/index/' . $v->id_categorias . '">' . $v->descricao . '</a></li>';
            }
            $lateral_esquerda .= '</ul>';
        }
        $lateral_esquerda .= '</div>' . $this->_get_banners(2, ' != ');
        $this->template->set_lateral_esquerda($lateral_esquerda);
    }

    function get_menu_lateral_direita() {

        $v_dados = array();

        if (!$this->session->userdata('clienteId')) {
            $v_dados['nome'] = '<a class="login"></a>';
        } else {
            $v_dados['nome'] = '<strong>Nome:</strong> ' . $this->session->userdata('clienteNome') . '<div><a class="encerrar"></a></div>';
        }
        $cliente = $this->parser->parse($this->template->get_diretorio() . '/cliente_view', $v_dados, true);

        $carrinho = '<div style="text-align: center;" class="borda_redonda borda_content">';
        $carrinho .= '<h2 class="conteudo_titulo">Carrinho</h2>';
        $carrinho .= '<div class="borda_content"><div style="height: 10px;padding-top: 10px;"> <strong style="font-size: 1.5em; color: blue;" class="carrinho_total">R$ ' . (!$this->session->userdata('carrinho_total') ? "0,00" : $this->session->userdata('carrinho_total')) . '</strong>';
        $carrinho .= '</div><br /><a class="ver_carrinho" style="margin-bottom: 5px;"></a></div>';
        $carrinho .= '</div>';

        $lateral_esquerda = $cliente . $carrinho . $this->_get_banners(2, ' != ');
        $this->template->set_lateral_direita($lateral_esquerda);
    }

    function rodape() {
        $v_dados = array();
        $v_dados['base_url'] = base_url();
        $v_dados['admin'] = anchor(url_site() . 'administracao', "Área administrativa");
        $v_dados['blog'] = anchor(url_blog() . 'home/index', "Blog");
        return $this->parser->parse($this->template->get_diretorio() . '/rodape', $v_dados, true);
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