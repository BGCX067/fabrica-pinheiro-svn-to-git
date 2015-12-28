<form name="frm_cad_blogs" id="frm_cad_blogs" onsubmit="return false;">
    <input type="hidden" name="id_blogs" id="id_blogs" value="{id_blogs}" />

    <label for="titulo">Titulo</label>
    <input type="text" id="titulo" name="titulo" value="{titulo}" class="obrigatorio" style="width: 99%;" maxlength="255" />
    <div class="clear"></div>

    <div style="float: left;">
        <label for="data_hora_cadastro">Data/Hora cadastro</label>
        <input type="text" id="data_hora_cadastro" name="data_hora_cadastro" value="{data_hora_cadastro}" class="obrigatorio data_hora" />
    </div>

    <div style="float: left;">
        <label for="exibir">Exibir</label>
        <select id="exibir" name="exibir" class="obrigatorio">
            {exibir}
        </select>
    </div>

    <div style="float: left;">
        <label for="id_categorias">Categorias</label>
        <select id="id_categorias" name="id_categorias[]" multiple="multiple" style="width: 300px;" class="obrigatorio">
            {id_categorias}
        </select>
    </div>

    <div style="float: left;">
        <label for="id_tags">Tags</label>
        <input type="hidden" id="id_tags" name="id_tags" value="{id_tags}" class="obrigatorio" style="width: 300px;" />
    </div>
    <div class="clear"></div>

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao" class="obrigatorio editor" style="width: 99%;">{descricao}</textarea>
    <div class="clear"></div>

    <button class="bt_gravar"></button>
    <button class="bt_novo"></button>

</form>
<div class="clear"></div>