<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of template
 *
 * @author Lucas Pinheiro
 */
class Template {

//put your code here

    private $css = array();
    private $ci = null;
    private $js = array();
    private $meta = '';
    private $title = '';
    private $diretorio = '';
    private $lateral_direita = '';
    private $lateral_esquerda = '';
    private $rodape = '';
    private $logo = '';
    private $conteudo_titulo = '';
    private $msg = array();
    private $breadcrumbs = array();

    public function __construct() {
        $this->ci = &get_instance();
        $this->ci->load->library('parser');
        $this->ci->load->helper('imagem');
    }

    public function get_breadcrumbs() {
        if (count($this->breadcrumbs) > 0) {
            $breadcrumbs = '<div class="breadcrumb"><span class="left"></span><ul>';
            foreach ($this->breadcrumbs as $k => $v) {
                if ($v['link'] != '') {
                    $breadcrumbs .= '<li><a href="' . $v['link'] . '" title="' . $v['titulo'] . '">' . $v['titulo'] . '</a></li>';
                } else {
                    $breadcrumbs .= '<li><a title="' . $v['titulo'] . '">' . $v['titulo'] . '</a></li>';
                }
            }
            $breadcrumbs .= '</ul><span class="right"></span></div>';
            return $breadcrumbs;
        } else {
            return '';
        }
    }

    public function get_meta() {
        return $this->meta;
    }

    public function set_meta($meta) {
        $this->meta .= $meta . "\n";
    }

    public function set_breadcrumbs($titulo, $link = '') {
        $this->breadcrumbs[] = array('titulo' => $titulo, 'link' => $link);
    }

    public function set_lateral_direita($lateral_direita) {
        $this->lateral_direita = $lateral_direita;
    }

    public function set_lateral_esquerda($lateral_esquerda) {
        $this->lateral_esquerda = $lateral_esquerda;
    }

    public function set_rodape($rodape) {
        $this->rodape = $rodape;
    }

    public function set_logo($logo) {
        $this->logo = $logo;
    }

    public function set_conteudo_titulo($conteudo_titulo) {
        $this->conteudo_titulo = $conteudo_titulo;
    }

    /**
     *
     * @param String $conteudo 
     */
    public function display($conteudo = '') {
        $msg = $this->_msg();
        $v_dados = array();
        $v_dados['css'] = $this->_css();
        $v_dados['msg_class'] = ($msg['class'] == 'error' ? 'ui-state-error' : 'ui-state-highlight');
        $v_dados['msg_descricao'] = $msg['descricao'];
        $v_dados['msg_icon'] = $msg['icon'];
        $v_dados['style'] = ($msg['descricao'] != "" ? 'style="display:block;"' : 'style="display:none;"');
        $v_dados['js'] = $this->_js();
        $v_dados['title'] = $this->title;
        $v_dados['conteudo_titulo'] = $this->conteudo_titulo;
        $v_dados['logo'] = $this->logo;
        $v_dados['rodape'] = $this->rodape;
        $v_dados['lateral_esquerda'] = $this->lateral_esquerda;
        $v_dados['lateral_direita'] = $this->lateral_direita;
        $v_dados['conteudo'] = $conteudo;
        $v_dados['meta'] = $this->get_meta();
        $v_dados['base_url'] = base_url();
        $v_dados['url_site'] = base_url() . 'site/';
        $v_dados['url_admin'] = base_url() . 'admin/';
        $v_dados['url_blog'] = base_url() . 'blog/';
        $v_dados['breadcrumbs'] = $this->get_breadcrumbs();
        $this->ci->parser->parse($this->diretorio . 'template', $v_dados);
    }

    public function display_imprimir($conteudo = '') {
        $msg = $this->_msg();
        $v_dados = array();
        $v_dados['css'] = $this->_css();
        $v_dados['msg_class'] = $msg['class'];
        $v_dados['msg_descricao'] = $msg['descricao'];
        $v_dados['msg_icon'] = $msg['icon'];
        $v_dados['js'] = $this->_js();
        $v_dados['title'] = $this->title;
        $v_dados['conteudo_titulo'] = $this->conteudo_titulo;
        $v_dados['logo'] = $this->logo;
        $v_dados['rodape'] = $this->rodape;
        $v_dados['lateral_esquerda'] = $this->lateral_esquerda;
        $v_dados['lateral_direita'] = $this->lateral_direita;
        $v_dados['conteudo'] = $conteudo;
        $v_dados['meta'] = $this->get_meta();
        $v_dados['base_url'] = base_url();
        $v_dados['url_site'] = base_url() . 'site/';
        $v_dados['url_admin'] = base_url() . 'admin/';
        $this->ci->parser->parse($this->diretorio . 'template_imprimir', $v_dados);
    }

    /**
     *
     * @param String $title 
     */
    public function set_title($title) {
        $this->title = $title;
    }
    /**
     *
     * @param String $title 
     */
    public function get_title() {
        return $this->title;
    }

    /**
     *
     * @param String $diretorio 
     */
    public function set_diretorio($diretorio) {
        $this->diretorio = $diretorio . '/';
    }

    /**
     *
     * @param String $diretorio 
     */
    public function get_diretorio() {
        return $this->diretorio;
    }

    /**
     *
     * @param String $msg 
     * @param String $class 
     */
    public function set_msg($msg, $class, $icon) {
        $this->msg[] = array(
            'icon' => $icon,
            'descricao' => $msg,
            'class' => $class
        );
    }

    /**
     *
     * @param String $css 
     */
    public function set_css($css) {
        $this->css[] = $css;
    }

    /**
     *
     * @param String $js 
     */
    public function set_js($js) {
        $this->js[] = $js;
    }

    private function _msg() {
        $msg = '';
        $class = '';
        $icon = '';
        if (count($this->msg) > 0) {
            foreach ($this->msg as $k => $v) {
                if ($msg != '') {
                    $msg .= '<br />';
                }
                $msg .= $v['descricao'];
                $class = $v['class'];
                $icon = $v['icon'];
            }
        }
        return array('icon' => $icon, 'descricao' => $msg, 'class' => $class);
    }

    private function _css() {
        $css = '';
        if (count($this->css) > 0) {
            foreach ($this->css as $k => $v) {
                if (file_exists(FCPATH . 'template/' . $this->diretorio . 'css/' . $v)) {
                    $arquivo = $this->_mini($this->diretorio . 'css/' . $v, $this->diretorio);
                    $css .= '<link  href="' . base_url() . $arquivo . '" rel="stylesheet" type="text/css" />' . "\n";
                } else if (file_exists(FCPATH . 'template/defaut/css/' . $v)) {
                    $arquivo = $this->_mini('defaut/css/' . $v, 'defaut/');
                    $css .= '<link  href="' . base_url() . $arquivo . '" rel="stylesheet" type="text/css" />' . "\n";
                } else if (file_exists($v)) {
                    $css .= '<link  href="' . base_url() . str_replace(FCPATH, '', $v). '" rel="stylesheet" type="text/css" />' . "\n";
                }
            }
        }
        return $css;
    }

    private function _js() {
        $js = '';
        if (count($this->js) > 0) {
            foreach ($this->js as $k => $v) {
                if (file_exists(FCPATH . 'template/' . $this->diretorio . 'js/' . $v)) {
                    $js .= '<script type="text/javascript" src="' . base_url() . 'template/' . $this->diretorio . 'js/' . $v . '"></script>' . "\n";
                } else if (file_exists(FCPATH . 'template/defaut/js/' . $v)) {
                    $js .= '<script type="text/javascript" src="' . base_url() . 'template/defaut/js/' . $v . '"></script>' . "\n";
                }
            }
        }
        return $js;
    }

    private function _mini($arquivo, $diretorio) {

        $novo_nome = str_replace('.css', '_min.css', $arquivo);
        $novo_nome = str_replace('\\', '/', $novo_nome);
        $new = file_get_contents(FCPATH . 'template/' . $arquivo);
        $new_arquivo = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $new);
        $new_arquivo = str_replace(array('{url_site}', '{url_admin}', '{base_url}', '{diretorio}'), array(url_site(), url_admin(), base_url(), 'template/' . $diretorio), $new_arquivo);
        $new_arquivo = str_replace(array("\n", "\t", "\r", " ", "  ", "   ", "    ", "     ", "      "), ' ', $new_arquivo);
        $new_arquivo = str_replace('}', "}\n", $new_arquivo);
        $new_arquivo = str_replace(array(' {', ' { ', '{ '), "{", $new_arquivo);
        $new_arquivo = str_replace('{', " { ", $new_arquivo);

        $dp = propriedades_arquivos(FCPATH . 'template/' . $arquivo);
        $dpn = propriedades_arquivos(FCPATH . 'template/' . $novo_nome);
        if ($dpn['localizacao'] == false) {
            @chmod(FCPATH . 'template/' . $diretorio . 'css', DIR_READ_MODE);
            file_put_contents(FCPATH . 'template/' . $novo_nome, $new_arquivo, FILE_TEXT);
            @chmod(FCPATH . 'template/' . $novo_nome, DIR_READ_MODE);
        } else if ($dpn['date_formatado'] <= $dp['date_formatado']) {
            file_put_contents(FCPATH . 'template/' . $novo_nome, $new_arquivo, FILE_TEXT);
        }
        return 'template/' . $novo_nome;
    }

    public function keywords($string) {
        $string = explode(' ', strip_tags($string));
        $string = implode(', ', $string);
        return str_replace(",,", ",", $string);
    }

}

?>
