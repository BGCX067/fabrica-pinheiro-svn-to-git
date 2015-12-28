<form name="frm_cad_categorias" id="frm_cad_categorias" onsubmit="return false;">
    <input type="hidden" name="id_categorias" id="id_categorias" value="{id_categorias}" />

    <label for="descricao">Descrição</label>
    <input type="text" id="descricao" name="descricao" value="{descricao}" size="50" maxlength="45" class="obrigatorio" />
    <div class="clear"></div>

    <label for="ordem">Ordem</label>
    <input type="text" id="ordem" name="ordem" value="{ordem}" size="3" maxlength="1" class="obrigatorio numero" />
    <div class="clear"></div>

    <button class="bt_gravar"></button>
    <button class="bt_novo"></button>

</form>