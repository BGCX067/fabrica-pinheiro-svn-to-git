<form name="frm_cad_clientes" id="frm_cad_clientes" onsubmit="return false;">
    <input type="hidden" name="id_clientes" id="id_clientes" value="{id_clientes}" />
    <input type="hidden" name="id_pessoas" id="id_pessoas" value="{id_pessoas}" />

    <label for="email">E-mail</label>
    <input type="text" id="email" name="email" value="{email}" maxlength="100" size="105" class="obrigatorio" />
    <div class="clear"></div>
    
    <label for="senha">Senha</label>
    <input type="password" id="senha" name="senha" value="{senha}" maxlength="32" size="35" class="" />
    <div class="clear"></div>

    <label for="status">Status</label>
    <select id="status" name="status" class="obrigatorio">
        {status}
    </select>
    <div class="clear"></div>

    <button class="bt_gravar"></button>

</form>