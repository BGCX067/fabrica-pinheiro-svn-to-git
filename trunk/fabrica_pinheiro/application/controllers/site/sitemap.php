<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sitemap
 *
 * @author lucas
 */
class Sitemap extends Site_controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('produtos_model');
        $this->load->model('blogs_model');
    }

    public function index() {

        $params = array();
        $params['AND']['data_exclusao'] = NULL;
        $b_consultar = $this->produtos_model->consultar($params);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n\n";

        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                $xml .= '<url>' . "\n";
                $xml .= '<loc>' . url_site() . 'home/detalhes/' . $v->id_produtos . '/' . url_title($v->nome, '_', TRUE) . '</loc> ' . "\n";
                $xml .= '<lastmod>' . formatarData($v->data_cadastro, array('formato' => 'Y-m-d')) . '</lastmod> ' . "\n";
                $xml .= '<changefreq>daily</changefreq> ' . "\n";
                $xml .= '</url>' . "\n";
            }
        }

        $params = array();
        $b_consultar = $this->blogs_model->consultar($params);

        if ($b_consultar != null) {
            foreach ($b_consultar as $k => $v) {
                $xml .= '<url>' . "\n";
                $xml .= '<loc>' . url_blog() . 'home/detalhes/' . $v->id_blogs . '/' . url_title($v->titulo, '_', TRUE) . '</loc> ' . "\n";
                $xml .= '<lastmod>' . formatarData($v->data_hora_cadastro, array('formato' => 'Y-m-dTH:i:s+00:00')) . '</lastmod> ' . "\n";
                $xml .= '<changefreq>hourly</changefreq> ' . "\n";
                $xml .= '</url>' . "\n";
            }
        }

        $xml .= '</urlset>';
        header("Content-Type:text/xml");
        echo $xml;
    }

}