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
class Home extends Site_controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('produtos_model');
        $this->load->model('produtos_fotos_model');
        $this->load->model('categorias_model');
    }

    function index($categoria = 0) {
        $v_dados = array();
        $v_dados['paginacao'] = '';
        $v_dados['produtos'] = array();
        $params = array();

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblCategorias') . ' as ct',
            'AND' => 'pr.id_categorias = ct.id_categorias',
            'TIPO' => 'LEFT',
        );

        $params['AND']['pr.data_exclusao'] = NULL;
        if ($categoria != 0) {
            $params['AND']['pr.id_categorias'] = $categoria;
            $b_consultar_categoria = $this->categorias_model->consultar(array('AND' => array('id_categorias' => $categoria)));
            $this->template->set_meta('<meta name="description" content="' . $b_consultar_categoria[0]->descricao . '" />');
            $this->template->set_meta('<meta name="keywords" content="' . $this->template->keywords($b_consultar_categoria[0]->descricao) . '" />');
            $this->template->set_breadcrumbs('Categoria: ' . $b_consultar_categoria[0]->descricao);
            $this->template->set_conteudo_titulo($b_consultar_categoria[0]->descricao);
        } else {
            $params['AND']['pr.exibir'] = 'S';
            $this->template->set_conteudo_titulo('Início');
        }

        $b_consultar_total = $this->produtos_model->consultar_total($params);

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblProdutosFotos') . ' as prf',
            'AND' => 'prf.id_produtos = pr.id_produtos',
            'TIPO' => 'LEFT',
        );
        $params['GROUPBY'] = 'pr.id_produtos';
        $params['CAMPOS'] = 'pr.*, prf.id_produtos_fotos, prf.nome as prf_nome, prf.largura, prf.altura, prf.extensao, ct.descricao as ct_descricao';
        $params['LIMIT']['inicio'] = $this->uri->segment(5, NULL);
        $params['LIMIT']['fim'] = 10;
        $b_consultar = $this->produtos_model->consultar($params);

        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                if ($v->extensao != null) {
                    $ext = explode('/', $v->extensao);
                    $v_dados['produtos'][$k]['extensao'] = ($ext[1] == "jpeg" ? 'jpg' : $ext[1]);
                    $v_dados['produtos'][$k]['id_produtos'] = $v->id_produtos;
                    $new_dimession = redimensionar_img($v->largura, $v->altura, 150, 150);
                    $v_dados['produtos'][$k]['largura'] = $new_dimession['width'];
                    $v_dados['produtos'][$k]['altura'] = $new_dimession['height'];
                } else {
                    $v_dados['produtos'][$k]['extensao'] = 'jpg';
                    $v_dados['produtos'][$k]['id_produtos'] = 0;
                    $v_dados['produtos'][$k]['largura'] = 150;
                    $v_dados['produtos'][$k]['altura'] = 150;
                }
                $v_dados['produtos'][$k]['id_usuarios'] = $v->id_usuarios;
                $v_dados['produtos'][$k]['id_categorias'] = $v->id_categorias;
                $v_dados['produtos'][$k]['nome'] = $v->nome;
                $v_dados['produtos'][$k]['quantidade'] = $v->quantidade;
                $v_dados['produtos'][$k]['valor'] = ($v->quantidade > 0 ? 'R$ ' . number_format($v->valor, 2, ',', '.') : 'Esgotado');
                $v_dados['produtos'][$k]['descricao'] = $v->descricao;
                $v_dados['produtos'][$k]['data_cadastro'] = $v->data_cadastro;
                $v_dados['produtos'][$k]['exibir'] = $v->exibir;
                $v_dados['produtos'][$k]['id_produtos_fotos'] = $v->id_produtos_fotos;
                $v_dados['produtos'][$k]['prf_nome'] = $v->prf_nome;
                $v_dados['produtos'][$k]['ct_descricao'] = $v->ct_descricao;
                $v_dados['produtos'][$k]['links'] = '<a class="detalhar" link="' . url_site() . 'home/detalhes/' . $v->id_produtos . '/' . url_title($v->nome, '_', TRUE) . '"></a>';
                if ($v->quantidade > 0) {
                    $v_dados['produtos'][$k]['links'] .= '<a class="adicionar" link="' . $v->id_produtos . '"></a>';
                }
            }
            $config = array();
            $config['base_url'] = url_site() . "home/index/" . $categoria;
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

        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/produtos/lst_produtos_view', $v_dados, true));
    }

    function detalhes() {
        $this->template->set_js('jquery_maskedinput.js');
        $this->template->set_css("demo.css");
        $this->template->set_js("socialite.min.js");
        $v_dados = array();
        $params = array();
        $params['AND']['pr.id_produtos'] = $this->uri->segment(4);
        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblCategorias') . ' as ct',
            'AND' => 'pr.id_categorias = ct.id_categorias',
            'TIPO' => 'LEFT',
        );

        $params['JOIN'][] = array(
            'TABELA' => $this->config->item('dbFabricaPinheiro') . '.' . $this->config->item('tblProdutosFotos') . ' as prf',
            'AND' => 'prf.id_produtos = pr.id_produtos',
            'TIPO' => 'LEFT',
        );

        $params['CAMPOS'] = 'pr.*, prf.id_produtos_fotos as prf_id_produtos_fotos, prf.nome as prf_nome, prf.largura as prf_largura, prf.altura as prf_altura, prf.extensao as prf_extensao, ct.descricao as ct_descricao';
        $params['GROUPBY'] = 'pr.id_produtos';
        $b_consultar = $this->produtos_model->consultar($params);
        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {

                if ($v->prf_extensao != NULL) {
                    $ext = explode('/', $v->prf_extensao);
                    $v_dados['prf_id_produtos_fotos'] = $v->prf_id_produtos_fotos;
                    $v_dados['prf_nome'] = $v->prf_nome;
                    $v_dados['prf_largura'] = $v->prf_largura;
                    $v_dados['prf_altura'] = $v->prf_altura;
                    $v_dados['prf_extensao'] = ($ext[1] == "jpeg" ? 'jpg' : $ext[1]);
                } else {
                    $v_dados['prf_id_produtos_fotos'] = 0;
                    $v_dados['prf_nome'] = 'Imagem indisponivel';
                    $v_dados['prf_largura'] = 250;
                    $v_dados['prf_altura'] = 250;
                    $v_dados['prf_extensao'] = 'jpg';
                }
                $v_dados['id_produtos'] = $v->id_produtos;
                $v_dados['id_usuarios'] = $v->id_usuarios;
                $v_dados['id_categorias'] = $v->id_categorias;
                $v_dados['nome'] = $v->nome;
                $v_dados['quantidade'] = $v->quantidade;
                $v_dados['valor'] = number_format($v->valor, 2, ',', '.');
                $v_dados['descricao'] = $v->descricao;
                $v_dados['data_cadastro'] = $v->data_cadastro;
                $v_dados['exibir'] = $v->exibir;
                $v_dados['ct_descricao'] = $v->ct_descricao;
                $v_dados['esgotado'] = ($v->quantidade > 0 ? '<strong>Quantidade:</strong> <input type="text" name="qtd" value="1" class="qtd" /> <button class="bt_adicionar"></button>' : 'Esgotado');
            }
        }

        $params = array();
        $params['AND']['id_produtos'] = $this->uri->segment(4);
        $b_fotos = $this->produtos_fotos_model->consultar($params);

        $v_dados['imagens'] = array();

        if ($b_fotos != null) {
            foreach ($b_fotos as $k => $v) {
                $new_dimession = redimensionar_img($v->largura, $v->altura, 120, 120);
                $ext = explode('/', $v->extensao);
                foreach ($v as $k1 => $v1) {
                    $v_dados['imagens'][$k][$k1] = $v1;
                    if ($k1 == 'extensao') {
                        $v_dados['imagens'][$k][$k1] = ($ext[1] == "jpeg" ? 'jpg' : $ext[1]);
                    }
                    if ($k1 == 'largura') {
                        $v_dados['imagens'][$k][$k1] = $new_dimession['width'];
                    }
                    if ($k1 == 'altura') {
                        $v_dados['imagens'][$k][$k1] = $new_dimession['height'];
                    }
                }
            }
        }

        $this->template->set_conteudo_titulo('Detalhes');
        $params = array();
        $params['AND']['id_categorias'] = $v_dados['id_categorias'];
        $b_consultar_categoria = $this->categorias_model->consultar($params);
        $this->template->set_meta('<meta name="description" content="' . $v_dados['nome'] . '" />');
        $this->template->set_meta('<meta name="keywords" content="' . $this->template->keywords($v_dados['nome'] . ' ' . $v_dados['descricao']) . '" />');
        $this->template->set_breadcrumbs('Categoria: ' . $b_consultar_categoria[0]->descricao, url_site() . 'home/index/' . $v_dados['id_categorias']);
        $this->template->set_breadcrumbs('Produto: ' . $v_dados['nome']);

        $v_dados['uri_string'] = $this->uri->uri_string();
        $v_dados['uri_title'] = $this->template->get_title() . ' ' . strip_tags($v_dados['nome']);

        $this->template->display($this->parser->parse($this->template->get_diretorio() . '/produtos/lst_detalhes_produtos_view', $v_dados, true));
    }

    function ver_foto($id_produtos_fotos) {
        $this->load->helper('imagem');
        ver_foto_db($id_produtos_fotos);
    }

}

?>
