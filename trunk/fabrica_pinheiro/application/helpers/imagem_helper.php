<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!function_exists('propriedades_arquivos')) {

    function propriedades_arquivos($arquivo, $complemento = '') {
        $ci = &get_instance();
        if (!file_exists($arquivo)) {
            return $dadosImagem['localizacao'] = false;
        } else {
            $arquivoDados = explode('/', $arquivo);
            $extension = substr(strrchr($arquivo, '.'), 1);
            if ($extension != null) {
                $ci->load->helper('file');
                $mime = get_mime_by_extension($arquivo);
                if ($mime != false) {
                    $mime2 = explode('/', get_mime_by_extension($arquivo));
                } else {
                    $mime2[0] = "desconhecido";
                    $mime2[1] = "desconhecido";
                }
            } else {
                $mime2[0] = "desconhecido";
                $mime2[1] = "desconhecido";
                $mime = null;
            }
        }
        $ci->load->helper('file');
        $size = get_file_info($arquivo, array('name', 'server_path', 'size', 'date', 'readable', 'writable', 'executable', 'fileperms'));
        $dadosImagem = array();

        foreach ($size as $k => $v) {
            $dadosImagem[$complemento.$k] = $v;
        }
        $dadosImagem[$complemento.'localizacao'] = true;
        $dadosImagem[$complemento.'mime'] = $mime;
        $dadosImagem[$complemento.'mimeTipo'] = (isset($mime2[0]) ? $mime2[0] : '' );
        $dadosImagem[$complemento.'mimeSub'] = (isset($mime2[1]) ? $mime2[1] : '' );
        $dadosImagem[$complemento.'arquivo_formatado'] = renomear_arquivos($arquivoDados[(count($arquivoDados) - 1)]);
        $dadosImagem[$complemento.'date_formatado'] = (date('Y-m-d H:i:s', $size['date']));

        if ($mime2[0] == 'image') {
            $propriedades = getimagesize($arquivo);
            $dadosImagem[$complemento.'largura'] = $propriedades[0];
            $dadosImagem[$complemento.'altura'] = $propriedades[1];
        } else {
            $dadosImagem[$complemento.'largura'] = null;
            $dadosImagem[$complemento.'altura'] = null;
        }
        return $dadosImagem;
    }

}

if (!function_exists('renomear_arquivos')) {

    function renomear_arquivos($arquivo) {
        $ci = &get_instance();
        $ci->load->helper('strings');
        $ci->load->helper('url');
        $limpaTexto = limpaString(array('formato' => 'retiraAcento', 'entrada' => trim($arquivo)));
        $limpaTexto = utf8_decode($limpaTexto);
        $limpaTexto = limpaString(array('formato' => 'retiraAcento', 'entrada' => trim($limpaTexto)));
        $arquivo = str_replace(
                array(
            '_', "-", " ", "(", ")", "=", "+", "/", "\\", "?", "!", "*", "&", "$", "#", "@", "|", "{", "}", "[", "]", ","), "_", $limpaTexto
        );
        $a = strtolower(url_title($arquivo, 'underscore', TRUE));
        return $a;
    }

}

if (!function_exists('_return_bytes')) {

    function _return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

}

if (!function_exists('imagem_db')) {

    function imagem_db($img, $chaset = 'utf8') {
        $foto = '';
        if (trim($img) != '') {
            if (file_exists($img)) {
                $foto = trim(file_get_contents($img));
            }
        }
        return $foto;
    }

}

if (!function_exists('display_imagem')) {

    function display_imagem($img = null, $extension = "image/jpg") {
        /* $ci = &get_instance();
          $ci->load->helper('file'); */
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header('Content-Type: ' . $extension);
        header('Content-Length: ' . strlen(trim($img)));
        //write_file(DIRETORIO_FOTOS . 'teste.jpg', $img, FOPEN_WRITE_CREATE_DESTRUCTIVE);
        echo $img;
    }

}

if (!function_exists('ver_foto_db')) {

    function ver_foto_db($id_produtos_fotos) {
        $ci = &get_instance();
        if ($id_produtos_fotos > 0) {
            $ci->load->model('produtos_fotos_model');
            $params = array();
            $params['AND']['id_produtos_fotos'] = $id_produtos_fotos;
            $b_consultar = $ci->produtos_fotos_model->consultar($params);
            display_imagem(trim(base64_decode($b_consultar[0]->foto)), $b_consultar[0]->extensao);
        } else {
            $ci->load->helper('file');
            $foto = read_file(FCPATH . 'fotos/imagem_indisponivel.jpg');
            display_imagem($foto);
        }
    }

}

if (!function_exists('redimensionar_img')) {

    function redimensionar_img($width, $height, $max_width = 100, $max_height = 100) {
        if (($width > $max_width) OR ($height > $max_height)) {
            $ratioh = $max_height / $height;
            $ratiow = $max_width / $width;
            $ratio = min($ratioh, $ratiow);
            // New dimensions 
            $width = intval($ratio * $width);
            $height = intval($ratio * $height);
        }
        return array('width' => $width, 'height' => $height);
    }

}