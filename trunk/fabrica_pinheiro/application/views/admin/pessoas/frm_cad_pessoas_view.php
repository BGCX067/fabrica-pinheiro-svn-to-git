<form name="frm_cad_pessoas" id="frm_cad_pessoas" onsubmit="return false;">
    <input type="hidden" name="id_pessoas" id="id_pessoas" value="{id_pessoas}" />

    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" value="{nome}" maxlength="50" size="55" class="obrigatorio" />
    <div class="clear"></div>

    <label for="tipo_pessoa">Tipo de Pessoa</label>
    <select id="tipo_pessoa" name="tipo_pessoa" class="obrigatorio">
        {tipo_pessoa}
    </select>
    <div class="clear"></div>

    <div style="float: left;">
        <label for="inscricao">CPF/CNPJ</label>
        <input type="text" id="inscricao" name="inscricao" value="{inscricao}" maxlength="9" size="10" class="obrigatorio" />
    </div>

    <div style="float: left;">
        <label for="identidade">Identidade</label>
        <input type="text" id="identidade" name="identidade" value="{identidade}" maxlength="15" size="15" class="obrigatorio" />
    </div>
    <div class="clear"></div>

    <div style="float: left;">
        <label for="telefone">Telefone</label>
        <input type="text" id="telefone" name="telefone" value="{telefone}" maxlength="15" size="15" class="obrigatorio ddd_telefone" />
    </div>

    <div style="float: left;">
        <label for="celular">Celular</label>
        <input type="text" id="celular" name="celular" value="{celular}" maxlength="15" size="15" class="ddd_telefone" />
    </div>
    <div class="clear"></div>

    <label for="email_moip">Email Moip</label>
    <input type="text" id="email_moip" name="email_moip" value="{email_moip}" maxlength="15" size="15" class="obrigatorio email" />
    <div class="clear"></div>

    <label for="cep">CEP</label>
    <input type="text" id="cep" name="cep" value="{cep}" maxlength="9" size="10" class="obrigatorio cep" />
    <div class="clear"></div>

    <div style="float: left;">
        <label for="endereco">Endereço</label>
        <input type="text" id="endereco" name="endereco" value="{endereco}" maxlength="50" size="55" class="obrigatorio" />
    </div>

    <div style="float: left;">
        <label for="numero">Número</label>
        <input type="text" id="numero" name="numero" value="{numero}" maxlength="10" size="12" class="obrigatorio numero" />
    </div>
    <div class="clear"></div>

    <div style="float: left;">
        <label for="complemento">Complemento</label>
        <input type="text" id="complemento" name="complemento" value="{complemento}" maxlength="30" size="35" class="" />
    </div>

    <div style="float: left;">
        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="bairro" value="{bairro}" maxlength="50" size="50" class="obrigatorio" />
    </div>
    <div class="clear"></div>

    <div style="float: left;">
        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" value="{cidade}" maxlength="50" size="50" class="obrigatorio" />
    </div>

    <div style="float: left;">
        <label for="estado">Estado</label>
        <input type="text" id="estado" name="estado" value="{estado}" maxlength="2" size="3" class="obrigatorio" />
    </div>
    <div class="clear"></div>

    <button class="bt_gravar"></button>

</form>