<?php

/**
 * Description of FormataStrings
 *
 * @author Ricardo Sergio
 * @version 05/03/2010
 */

/**
 * Metodo para validar dados
 * @author Ricardo Rosa
 * @version 05/03/2010
 * @param ARRAY $parametros defevera ser informado: entrada (valor a
 *                          ser validado), formato (numeros, letras,
 *                          letras_numeros, cpf, placa, pgu, registro, cnpj,
 *                          chassi, email ), min (tamanho minimo),
 *                          max (tamanho maximo),
 * @return boolean
 */
function validaString($parametros) {
    $entrada = utf8_decode($parametros['entrada']);
    $min = (!isset($parametros['min']) ? 3 : $parametros['min']);
    $max = (!isset($parametros['max']) ? 10 : $parametros['max']);

    switch ($parametros['formato']) {
        case 'numeros':
            $expressao = '/^([0-9]{' . $min . ',' . $max . '})$/';
            break;

        case 'letras':
            $parametrosLimpa = array('entrada' => $entrada, 'formato' => 'acento');
            $entrada = limpaString($parametrosLimpa);
            $expressao = '/^([A-Za-z\ ]{' . $min . ',' . $max . '})$/';
            break;

        case 'letras_numeros':
            $parametrosLimpa = array('entrada' => $entrada, 'formato' => 'acento');
            $entrada = limpaString($parametrosLimpa);
            $expressao = '/^([0-9A-Za-z\ ]{' . $min . ',' . $max . '})$/';
            break;

        case 'cpf':
            $parametrosLimpa = array('entrada' => $entrada);
            $entrada = limpaString($parametrosLimpa);
            $expressao = '/^\d{11}$/';
            break;

        case 'placa':
            $entrada = limpaString(array('entrada' => $entrada));
            if (strlen($entrada) == '7') {
                $expressao = "/^[A-Za-z]{3}+[0-9]{4}$/";
            } else {
                $expressao = '/^[A-Za-z]{2}+[0-9]{4}$/';
            }
            break;

        case 'pgu':
            $parametrosLimpa = array('entrada' => $entrada);
            $entrada = limpaString($parametrosLimpa);
            $expressao = '/^\d{4,9}$/';
            break;

        case 'registro':
            $parametrosLimpa = array('entrada' => $entrada);
            $entrada = limpaString($parametrosLimpa);
            $expressao = '/^\d{11}$/';
            break;

        case 'cnpj':
            $parametrosLimpa = array('entrada' => $entrada);
            $entrada = limpaString($parametrosLimpa);
            $expressao = '/^\d{14}$/';
            break;

        case 'chassi':
            $expressao = '/^[A-Za-z0-9]{5,22}$/';
            break;

        case 'email':
            $expressao = '/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/';
            break;

        default:
            return false;
            break;
    }

    $retorno = validaExpressao($entrada, $expressao);

    if ($retorno) {
//validacao extra
        switch ($parametros['formato']) {
            case 'cpf':
                $retorno = validaCpf($entrada);
                break;
            case 'pgu':
                $retorno = validaPgu($entrada);
                break;
            case 'registro':
                $retorno = validaRegistro($entrada);
                break;
            case 'cnpj':
                $retorno = validaCnpj($entrada);
                break;
        }

        return $retorno;
    } else {
        return false;
    }
}

/**
 * Metodo para limpar dados
 * @author Ricardo Rosa
 * @version 05/03/2010
 * @param ARRAY $parametros devera ser informado: entrada (valor a
 *                          ser limpo), formato (acento, zero,
 *                          acentoMaiusculo, expressao a ser retirada, vazia para [\.\-()\/]  )
 * @return string
 */
function limpaString($parametros) {
    if (!isset($parametros['formato'])) {
        $retorno = preg_replace('@[\.\-()\/\ ]@', "", $parametros['entrada']);
    } else {
        switch ($parametros['formato']) {
            case 'acento':
                $retorno = html_entity_decode(preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', htmlentities($parametros['entrada'])));
                //$retorno = html_entity_decode(preg_replace('/&([A-Z])(uml|acute|grave|circ|tilde|cedil|ring);/', '$1', htmlentities($retorno)));
                break;

            case 'zero':
// retita todos os zeros da esquerda.
                $retorno = retiraZero();
                break;

            case 'acentoMaiusculo':
                $retorno = strtoupper(strtr($parametros['entrada'], "áàãâéèêíìîóòõôúùûçñ", "aaaaeeeiiioooouuucn"));
                break;

            case 'retiraAcento':
                //$retorno = strtr($parametros['entrada'], "áàâãéèêẽíìîĩóòôõúùûũçÁÀÂÃÉÈÊẼÍÌÎĨÓÒÔÕÚÙÛŨÇ", "aaaaeeeeiiiioooouuuucAAAAEEEEIIIIOOOOUUUUC");
                $retorno = retiraAcentos($parametros['entrada']);
                break;

            case 'acentoMinusculo':
                $retorno = strtoupper(strtr($parametros['entrada'], "ÁÀÃÂÉÈÊÍÌÎÓÒÕÔÚÙÛÇÑ", "AAAAEEEIIIOOOOUUUCN"));
                break;

            default:
                $retorno = preg_replace($parametros['formato'], "", $parametros['entrada']);
        }
    }
    return $retorno;
}

function retiraAcentos($texto) {
    $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
    return str_replace($array1, $array2, $texto);
}

/**
 * Metodo para formatar string
 * @author Ricardo Rosa
 * @version 05/03/2010
 * @param ARRAY $parametros defevera ser informado: entrada (valor a
 *                          ser formatado), formato (cep, cpf,
 *                          cnpj, nome, vExtenso, expressao a ser colocada na mascara)
 * @return string
 */
function formataString($parametros) {
    $entrada = utf8_decode($parametros['entrada']);
    $formato = '';
    $tamanho = '';
    switch ($parametros['formato']) {
        case 'cep'://14074-140
            $formato = '99999-999';
            $tamanho = '8';
            break;
        case 'placa'://aaa-9999
            $formato = '999-9999';
            $tamanho = '7';
            break;
        case 'cpf':
            $formato = '999.999.999-99';
            $tamanho = '11';
            break;
        case 'cnpj':
            $formato = '99.999.999/9999-99';
            $tamanho = '14';
            break;
        case 'cpf_cnpj':
            if (strlen($parametros['entrada']) == 11) {
                $formato = '999.999.999-99';
                $tamanho = '11';
            } else {
                $formato = '99.999.999/9999-99';
                $tamanho = '14';
            }
            break;
        case 'telefone':
            if (strlen($parametros['entrada']) == 13) {
                $formato = '999 (99) 9999-9999';
                $tamanho = '13';
            } else if (strlen($parametros['entrada']) == 12) {
                $formato = '99 (99) 9999-9999';
                $tamanho = '12';
            } else {
                $formato = '(99) 9999-9999';
                $tamanho = '10';
            }
            break;
        case 'nome':
            return formataNome($entrada);
            break;
        case 'vExtenso':
            return valorPorExtenso($entrada);
            break;
        case 'moedaDb':
            return formata_numero_db($parametros['entrada'], $parametros['casas']);
            break;
        default:
            $formato = $parametros['formato'];
            $tamanho = $parametros['tamanho'];
    }
    return mascara($entrada, $formato, $tamanho);
}

/**
 * @param int $cpf CPF a ser verificado
 * @return boolean
 */
function validaCpf($cpf) {
    $cpf = str_pad($cpf, "11", "0", STR_PAD_LEFT);

//digito verificador
    $dv_informado = substr($cpf, 9, 2);

    for ($i = 0; $i <= 8; $i++) {
        $digito[$i] = substr($cpf, $i, 1);
    }
//calcula o valor dos 10 valores
    $posicao = 10;
    $soma = 0;

    for ($i = 0; $i <= 8; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[9] = $soma % 11;

    if ($digito[9] < 2) {
        $digito[9] = 0;
    } else {
        $digito[9] = 11 - $digito[9];
    }
    $posicao = 11;
    $soma = 0;

    for ($i = 0; $i <= 9; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[10] = $soma % 11;

    if ($digito[10] < 2) {
        $digito[10] = 0;
    } else {
        $digito[10] = 11 - $digito[10];
    }

//verifica se o digito verificador eh igual ao informado
    $dv = $digito[9] * 10 + $digito[10];
    if ($dv != $dv_informado) {
        return false;
    } else
        return true;
}

/**
 * @param string $valor
 * @param string $expressao
 * @return boolean
 */
function validaExpressao($valor, $expressao) {
    if (preg_match($expressao, $valor)) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param string $pgu
 * @return boolean
 */
function validaPgu($pgu) {
    for ($i = 0; $i < 8; $i++) {
        $pgu[$i] = substr($pgu, $i, 1);
    }

//PRIMEIRO DIGITO
    $dc = substr($pgu, 8, 1);

//CALCULA PRIMEIRO DIGITO
    $soma = (($pgu[0] * 9) + ($pgu[1] * 8) + ($pgu[2] * 7) + ($pgu[3] * 6) +
            ($pgu[4] * 5) + ($pgu[5] * 4) + ($pgu[6] * 3) + ($pgu[7] * 2));

//CALCULA O RESTO DA DIVISAO POR 11
    $modSoma = $soma % 11;

    if ($modSoma > 1) {
        $modSoma = 11 - $modSoma;
    } else {
        $modSoma = 0;
    }

    if ($modSoma == $dc) {
        return true;
    } else {
        return false;
    }
}

/**
 *
 * @param string $registro
 * @return boolean
 *
 */
function validaRegistro($registro) {
    $registro = str_pad($registro, "11", "0", STR_PAD_LEFT);

    for ($i = 0; $i < 10; $i++) {
        $registro[$i] = substr($registro, $i, 1);
    }

//primeiro digito
    $dc1 = substr($registro, 9, 1);
//segundo digito
    $dc2 = substr($registro, 10, 1);

//calcula primeiro digito
    $soma1 = (($registro[0] * 2) + ($registro[1] * 3) + ($registro[2] * 4) + ($registro[3] * 5) + ($registro[4] * 6) +
            ($registro[5] * 7) + ($registro[6] * 8) + ($registro[7] * 9) + ($registro[8] * 10));

//calcula o resto da divisao por 11
    $mod_soma1 = $soma1 % 11;

    if ($mod_soma1 > 1) {
        $mod_soma1 = 11 - $mod_soma1;
    } else {
        $mod_soma1 = 0;
    }

//calcula segundo digito
    $soma2 = (($mod_soma1 * 2 + $registro[0] * 3 + $registro[1] * 4 + $registro[2] * 5 + $registro[3] * 6 + $registro[4] * 7 +
            $registro[5] * 8 + $registro[6] * 9 + $registro[7] * 10 + $registro[8] * 11));


    $mod_soma2 = $soma2 % 11;

    if ($mod_soma2 > 1) {
        $mod_soma2 = 11 - $mod_soma2;
    } else {
        $mod_soma2 = 0;
    }

    if (( $mod_soma1 == $dc1 ) &&
            ( $mod_soma2 == $dc2 )) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param string $cnpj
 * @return boolean
 */
function validaCnpj($cnpj) {
    $k = 6;
    $soma1 = "";
    $soma2 = "";
    for ($i = 0; $i < 13; $i++) {
        $k = $k == 1 ? 9 : $k;
        $soma2 += ( $cnpj{$i} * $k );
        $k--;
        if ($i < 12) {
            if ($k == 1) {
                $k = 9;
                $soma1 += ( $cnpj{$i} * $k );
                $k = 1;
            } else {
                $soma1 += ( $cnpj{$i} * $k );
            }
        }
    }

    $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
    $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

    return ( $cnpj{12} == $digito1 and $cnpj{13} == $digito2 );
}

function retiraZero($num) {
    if ($num > 0) {
        $tm = strlen($num);
        if ($tm > 1) {
            for ($i = 0; $i <= $tm; $i++) {
                if (substr($num, $i, 1) > 0) {
                    $tmf = $tm - $i;
                    $num = substr($num, $i, $tmf);
                    break;
                }
            }
        }
    } else {
        $num = 0;
    }
    return $num;
}

function formataNome($nome) {

    $explodeNome = explode(' ', $nome);

    $cont = count($explodeNome);
    foreach ($explodeNome as $v) {

        if ($v == 'de' || $v == 'da') {
            $nomeAux .= ' ' . $v;
            $cont--;
        } else if ($nomeAux == '') {
            $nomeAux = $v;
            $cont--;
        } else if ($cont > '1') {
            $nomeAux .= " " . substr($v, 0, 1) . ".";
            $cont--;
        } else {
            $cont--;
            $nomeAux .= " " . $v;
        }
    }

    return $nomeAux;
}

function mascara($entrada, $formato, $tamanho) {

    if (strlen($entrada) > strlen($formato)) {
        return false;
    } else {
        $entrada = str_pad($entrada, (int) $tamanho, "0", STR_PAD_LEFT);
        $saida = '';
        $cont = 0;

        for ($i = 0; $i < strlen($formato); $i++) {
            if ($formato[$i] == '9') {
                $saida .= $entrada[$cont];
                $cont++;
            } else {
                $saida .= $formato[$i];
            }
        }
        return $saida;
    }
}

function valorPorExtenso($valor = 0) {

    $singular = array("centavo", "real", "mil", "milh�o", "bilh�o", "trilh�o", "quatrilh�o");
    $plural = array("centavos", "reais", "mil", "milh�es", "bilh�es", "trilh�es", "quatrilh�es");

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "tr�s", "quatro", "cinco", "seis", "sete", "oito", "nove");

    $z = 0;

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++)
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
            $inteiro[$i] = "0" . $inteiro[$i];

// $fim identifica onde que deve se dar jun��o de centenas por "e" ou por "," ;)
    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    $rt = "";
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000"
        )
            $z++; elseif ($z > 0)
            $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
            $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
        if ($r)
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? " " : " e ") : " ") . $r;
    }

    return($rt ? $rt : "zero");
}

function formata_numero_db($valor, $casa = "2") {
    if (trim($valor) != "") {
        $valorNovo = str_replace('.', '', trim($valor));
        $valorNovo = str_replace(',', '.', $valorNovo);
        return number_format($valorNovo, $casa, '.', '');
    } else {
        return $valor;
    }
}