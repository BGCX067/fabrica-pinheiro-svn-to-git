<form name="frm_con_blogs" id="frm_con_blogs" action="{url_admin}blogs/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="titulo">Titulo</label>
        <input type="text" name="titulo" id="titulo" value="{titulo}" />
    </div>

    <div style="float: left;">
        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" value="{descricao}" />
    </div>

    <div style="float: left;">
        <label for="id_categorias">Categorias</label>
        <select id="id_categorias" name="id_categorias">
            <option value="">Selecionar</option>
            {id_categorias}
        </select>
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>