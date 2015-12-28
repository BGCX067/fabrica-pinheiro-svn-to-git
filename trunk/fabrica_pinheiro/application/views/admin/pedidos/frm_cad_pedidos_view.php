<form name="frm_cad_pedidos" id="frm_cad_pedidos" onsubmit="return false;">
    <input type="hidden" name="id_pedidos" id="id_pedidos" value="{id_pedidos}" />

    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" value="{nome}" maxlength="50" size="55" class="obrigatorio" />
    <div class="clear"></div>

    <label for="tipo_pessoa">Tipo de Pessoa</label>
    <select id="tipo_pessoa" name="tipo_pessoa" class="obrigatorio">
        {tipo_pessoa}
    </select>
    <div class="clear"></div>

    <label for="inscricao">CPF/CNPJ</label>
    <input type="text" id="inscricao" name="inscricao" value="{inscricao}" maxlength="9" size="10" class="obrigatorio" />
    <div class="clear"></div>

    <label for="cep">CEP</label>
    <input type="text" id="cep" name="cep" value="{cep}" maxlength="9" size="10" class="obrigatorio cep" />
    <div class="clear"></div>

    <label for="endereco">Endereço</label>
    <input type="text" id="endereco" name="endereco" value="{endereco}" maxlength="50" size="55" class="obrigatorio" />
    <div class="clear"></div>

    <label for="numero">Número</label>
    <input type="text" id="numero" name="numero" value="{numero}" maxlength="10" size="12" class="obrigatorio numero" />
    <div class="clear"></div>

    <label for="complemento">Complemento</label>
    <input type="text" id="complemento" name="complemento" value="{complemento}" maxlength="30" size="35" class="" />
    <div class="clear"></div>

    <label for="bairro">Bairro</label>
    <input type="text" id="bairro" name="bairro" value="{bairro}" maxlength="50" size="50" class="obrigatorio" />
    <div class="clear"></div>

    <label for="cidade">Cidade</label>
    <input type="text" id="cidade" name="cidade" value="{cidade}" maxlength="50" size="50" class="obrigatorio" />
    <div class="clear"></div>

    <label for="estado">Estado</label>
    <input type="text" id="estado" name="estado" value="{estado}" maxlength="2" size="3" class="obrigatorio" />
    <div class="clear"></div>

    <button class="bt_gravar"></button>
    <button class="bt_novo"></button>

</form>