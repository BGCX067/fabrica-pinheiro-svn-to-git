<form name="frm_cad_banners" id="frm_cad_banners" onsubmit="return false;">
    <input type="hidden" name="id_banners" id="id_banners" value="{id_banners}" />

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao" class="obrigatorio editor" style="width: 99%;">{descricao}</textarea>
    <div class="clear"></div>

    <label for="link">link</label>
    <input type="text" id="link" name="link" value="{link}" size="210" maxlength="255" class="obrigatorio" />
    <div class="clear"></div>

    <label for="path">Imagem</label>
    <input type="text" id="path" name="path" value="{path}" size="210" maxlength="255" readonly="readonly" class="obrigatorio" />
    <div class="clear"></div>
    
    <div class="fotos">{banner}</div>

    <label for="id_banners_tipos">Tipo Banner</label>
    <select id="id_banners_tipos" name="id_banners_tipos" class="obrigatorio">
        {id_banners_tipos}
    </select>
    <div class="clear"></div>

    <button class="bt_gravar"></button>
    <button class="bt_novo"></button>

</form>

<div id="bt_fotos"></div>