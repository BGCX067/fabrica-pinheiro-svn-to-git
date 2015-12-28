<form name="frm_cad_clientes" id="frm_cad_clientes" onsubmit="return false;">
    <input type="hidden" name="id_pessoas" id="id_pessoas" value="{id_pessoas}" />
    <input type="hidden" name="id_clientes" id="id_clientes" value="{id_clientes}" />

    <label for="tipo_pessoa">Pessoa</label>
    <select name="tipo_pessoa" id="tipo_pessoa" class="obrigatorio">
        {tipo_pessoa}
    </select>
    <div class="clear"></div>

    <label for="nome">Nome</label>
    <input type="text" name="nome" id="nome" size="55" maxlength="50" value="{nome}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="inscricao">CPF</label>
    <input type="text" name="inscricao" id="inscricao" value="{inscricao}" class="obrigatorio cpf" />
    <div class="clear"></div>

    <label for="identidade">Identidade</label>
    <input type="text" name="identidade" id="identidade" size="45" maxlength="45" value="{identidade}" />
    <div class="clear"></div>

    <label for="cep">CEP</label>
    <input type="text" name="cep" id="cep" value="{cep}" class="obrigatorio cep" />
    <div class="clear"></div>

    <label for="endereco">Endereço</label>
    <input type="text" name="endereco" id="endereco" size="55" maxlength="50" value="{endereco}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="numero">Número</label>
    <input type="text" name="numero" id="numero" size="15" maxlength="10" value="{numero}" class="obrigatorio numero" />
    <div class="clear"></div>

    <label for="complemento">Complemento</label>
    <input type="text" name="complemento" id="complemento" size="35" maxlength="30" value="{complemento}" />
    <div class="clear"></div>

    <label for="bairro">Bairro</label>
    <input type="text" name="bairro" id="bairro" size="55" maxlength="50" value="{bairro}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="cidade">Cidade</label>
    <input type="text" name="cidade" id="cidade" size="55" maxlength="50" value="{cidade}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="estado">Estado</label>
    <input type="text" name="estado" id="estado" size="4" maxlength="2" value="{estado}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="telefone">Telefone</label>
    <input type="text" name="telefone" id="telefone" value="{telefone}" class="obrigatorio ddd_telefone" />
    <div class="clear"></div>

    <label for="celular">Celular</label>
    <input type="text" name="celular" id="celular" value="{celular}" class="ddd_telefone" />
    <div class="clear"></div>

    <label for="email">E-mail Moip</label>
    <input type="text" name="email_moip" id="email_moip" size="105" maxlength="100" value="{email_moip}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="email">E-mail</label>
    <input type="text" name="email" id="email" size="105" maxlength="100" value="{email}" class="obrigatorio" />
    <div class="clear"></div>

    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha" size="55" maxlength="50" value="{senha}" class="obrigatorio" />
    <div class="clear"></div>

    <button class="bt_gravar"></button>
</form>