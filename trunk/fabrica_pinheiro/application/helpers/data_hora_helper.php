<?php

/**
 * Description of FormataDataHora
 *
 * @author Ricardo Sergio
 * @version 04/03/2010
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!function_exists('formatarData')) {

    /**
     * Metodo para formatar a data e/o hora em um novo formato
     * @author Ricardo Rosa
     * @version 04/03/2010
     * @param DATA $entrada data em qualquer formato, quando vazio retorna o dia
     *                      atual
     * @param ARRAY $parametros defevera ser informado: formato (dia, mes, texto), diferenca + data (para calcular a diferenca)
     *                          , aceita padroes nativos do Date PHP.
     */
    function formatarData($entrada, $parametros) {
        $dataFormatada = novaDataHora($entrada);
        if ($dataFormatada) {
            switch ($parametros['formato']) {
                case 'dia':
                    return formataDiaSemanaTexto($dataFormatada);
                    break;
                case 'mes':
                    return formataMesTexto($dataFormatada);
                    break;
                case 'texto':
                    return formataTexto($dataFormatada);
                    break;
                case 'diferenca':
                    $dataFormatada2 = novaDataHora($parametros['data']);
                    if ($dataFormatada2) {
                        return diferencaData($dataFormatada, $dataFormatada2);
                    } else {
                        return false;
                    }
                    break;
                default:
                    return $dataFormatada->format($parametros['formato']);
            }
        } else {
            return false;
        }
    }

}

function formataDiaSemanaTexto($dataFormatada) {
    switch ($dataFormatada->format('N')) {
        case 0:
            return 'domingo';
            break;
        case 1:
            return 'segunda-feira';
            break;
        case 2:
            return 'terça-feira';
            break;
        case 3:
            return 'quarta-feira';
            break;
        case 4:
            return 'quinta-feira';
            break;
        case 5:
            return 'sexta-feira';
            break;
        case 6:
            return 'sabado';
            break;
    }
}

function formataMesTexto($dataFormatada) {
    switch ($dataFormatada->format('m')) {
        case "01" : $mes = "Janeiro";
            break;
        case "02" : $mes = "Fevereiro";
            break;
        case "03" : $mes = "Março";
            break;
        case "04" : $mes = "Abril";
            break;
        case "05" : $mes = "Maio";
            break;
        case "06" : $mes = "Junho";
            break;
        case "07" : $mes = "Julho";
            break;
        case "08" : $mes = "Agosto";
            break;
        case "09" : $mes = "Setembro";
            break;
        case "10" : $mes = "Outubro";
            break;
        case "11" : $mes = "Novembro";
            break;
        case "12" : $mes = "Dezembro";
            break;
        default : return false;
    }
    return $mes;
}

function formataTexto($dataFormatada) {
    return $dataFormatada->format('d') . ' de ' . $dataFormatada->formataMesTexto($mes) . ' de ' . $dataFormatada->format('Y');
}

function novaDataHora($entrada) {
    //deixa como padrao a "/"
    $entrada = str_replace('-', '/', $entrada);

    if (substr($entrada, 0, 2) === '00') {
        return false;
    } elseif ($entrada == '') {
        $novaData = 'now';
    } elseif (preg_match('/^\d{8}$/', $entrada)) {// 00000000
        $novaData = $entrada;
    } elseif (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $entrada)) {// 00/00/0000
        list($dia, $mes, $ano) = explode("/", $entrada);
        $novaData = $ano . $mes . $dia;
    } elseif (preg_match('/^\d{4}\/\d{1,2}\/\d{1,2}$/', $entrada)) {// 0000/00/00
        $novaData = $entrada;
    } elseif (preg_match('/^\d{1,2}\/\d{1,2}\/\d{1,2}$/', $entrada)) {// 00/00/00
        list($dia, $mes, $ano) = explode("/", $entrada);
        if ($ano >= 00 && $ano < 50) {
            $novaData = '20' . $ano . $mes . $dia;
        } else {
            $novaData = '19' . $ano . $mes . $dia;
        }
    } elseif (preg_match('/^(\d{4}\/\d{1,2}\/\d{1,2}) (\d{1,2}\:\d{1,2})$/', $entrada)) {// 0000/00/00 00:00
        $novaData = $entrada;
    } elseif (preg_match('/^(\d{1,2}\/\d{1,2}\/\d{4}) (\d{1,2}\:\d{1,2})$/', $entrada)) {// 00/00/0000 00:00
        list($data, $hora) = explode(" ", $entrada);
        list($dia, $mes, $ano) = explode("/", $data);
        $novaData = $ano . $mes . $dia . ' ' . $hora;
    } elseif (preg_match('/^(\d{1,2}\/\d{1,2}\/\d{1,2}) (\d{1,2}\:\d{1,2})$/', $entrada)) {// 00/00/00 00:00
        list($data, $hora) = explode(" ", $entrada);
        list($dia, $mes, $ano) = explode("/", $data);
        if ($ano >= 00 && $ano < 50) {
            $novaData = '20' . $ano . $mes . $dia . ' ' . $hora;
        } else {
            $novaData = '19' . $ano . $mes . $dia . ' ' . $hora;
        }
    } elseif (preg_match('/^(\d{4}\/\d{1,2}\/\d{1,2}) (\d{1,2}\:\d{1,2}:\d{1,2})$/', $entrada)) {// 0000/00/00 00:00:00
        $novaData = $entrada;
    } elseif (preg_match('/^(\d{1,2}\/\d{1,2}\/\d{4}) (\d{1,2}\:\d{1,2}:\d{1,2})$/', $entrada)) {// 00/00/0000 00:00:00
        list($data, $hora) = explode(" ", $entrada);
        list($dia, $mes, $ano) = explode("/", $data);
        $novaData = $ano . $mes . $dia . ' ' . $hora;
    } elseif (preg_match('/^(\d{1,2}\/\d{1,2}\/\d{1,2}) (\d{1,2}\:\d{1,2}:\d{1,2})$/', $entrada)) {// 00/00/00 00:00:00
        list($data, $hora) = explode(" ", $entrada);
        list($dia, $mes, $ano) = explode("/", $data);
        if ($ano >= 00 && $ano < 50) {
            $novaData = '20' . $ano . $mes . $dia . ' ' . $hora;
        } else {
            $novaData = '19' . $ano . $mes . $dia . ' ' . $hora;
        }
    } else {
        return false;
    }

    try {
        //define o timezone
        //date_default_timezone_set('America/Sao_Paulo');

        $datetime = new DateTime($novaData);
        return $datetime;
    } catch (Exception $exc) {
        return false;
    }
}

function diferencaData($dataFormatada, $dataFormatada2) {
    $age = strtotime($dataFormatada2->format("Y-m-d")) - strtotime($dataFormatada->format("Y-m-d"));
    $retorno = floor($age / 86400);
    return $retorno;
}

function valida_data($entrada) {
    $data = explode('/', $entrada);
    return checkdate($data[1], $data[0], $data[2]);
}

function subtrair_horas($hora_inicio = null, $hora_fim = null) {
    $hora_inicio = ($hora_inicio == null ? date('H:i:s') : $hora_inicio);
    $hora_fim = ($hora_fim == null ? date('H:i:s') : $hora_fim);

    //$hora_inicio = formatarData($hora_inicio, array('formato' => 'H:i:s'));
    //$hora_fim = formatarData($hora_fim, array('formato' => 'H:i:s'));

    $explode_hora_inicio = explode(":", $hora_inicio);
    $explode_hora_fim = explode(":", $hora_fim);

    $explode_hora_inicio[0] = $explode_hora_inicio[0] * 3600;
    $explode_hora_inicio[1] = $explode_hora_inicio[1] * 60;

    $total_hora_inicio = $explode_hora_inicio[0] + $explode_hora_inicio[1] + $explode_hora_inicio[2];

    $explode_hora_fim[0] = $explode_hora_fim[0] * 3600;
    $explode_hora_fim[1] = $explode_hora_fim[1] * 60;

    $total_hora_fim = $explode_hora_fim[0] + $explode_hora_fim[1] + $explode_hora_fim[2];

    $total = ($total_hora_fim - $total_hora_inicio);

    $time = ($total / 3600);
    list($horas) = explode(".", $time);
    $resto_segundos = ($total % 3600); // resto da divisao por 3600
    $c = ($resto_segundos / 60);
    list($minutos) = explode(".", $c);
    $segundos = ($total % 60);

    if ($horas > 0) {
        $horas = (strlen($horas) == 1 ? "0" . $horas : $horas);
    } else {
        $horas = (strlen($horas) == 2 ? "-0" . ($horas * -1) : $horas);
    }
    if ($minutos < 0) {
        $minutos = ($minutos * -1);
    }
    if ($segundos < 0) {
        $segundos = ($segundos * -1);
    }
    $minutos = (strlen($minutos) == 1 ? "0" . $minutos : $minutos);
    $segundos = (strlen($segundos) == 1 ? "0" . $segundos : $segundos);

    return date('H:i:s', mktime($horas, $minutos, $segundos));
}

function combo_meses($mes = null) {
    $messes = array();
    $messes['1'] = "Janeiro";
    $messes['2'] = "Fevereiro";
    $messes['3'] = "Março";
    $messes['4'] = "Abril";
    $messes['5'] = "Maio";
    $messes['6'] = "Junho";
    $messes['7'] = "Julho";
    $messes['8'] = "Agosto";
    $messes['9'] = "Setembro";
    $messes['10'] = "Outubro";
    $messes['11'] = "Novembro";
    $messes['12'] = "Dezembro";

    $option = '<option value="">Selecionar</option>' . "\n";
    foreach ($messes as $k => $v) {
        if ($mes == $k) {
            $option .= '<option value="' . $k . '" selected="selected">' . $v . '</option>' . "\n";
        } else {
            $option .= '<option value="' . $k . '">' . $v . '</option>' . "\n";
        }
    }
    return $option;
}

function combo_dias($dia = null, $mes = null) {
    $mes = ($mes == null ? 31 : date('t', mktime(0, 0, 0, $mes)) );
    $option = '<option value="">Selecionar</option>' . "\n";
    for ($i = 1; $i <= $mes; $i++) {
        if ($mes == $i) {
            $option .= '<option value="' . $i . '" selected="selected">' . $i . '</option>' . "\n";
        } else {
            $option .= '<option value="' . $i . '">' . $i . '</option>' . "\n";
        }
    }
    return $option;
}