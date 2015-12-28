<form name="frm_con_produtos" id="frm_con_produtos" action="{url_admin}produtos/consulta" onsubmit="return false;">

    <div style="float: left;">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="{nome}" />
    </div>

    <div style="float: left;">
        <label for="descricao">Descrição</label>
        <input type="text" name="descricao" id="descricao" value="{descricao}" />
    </div>

    <div style="float: left;">
        <label for="id_categorias">Categorias</label>
        <select id="id_categorias" name="id_categorias">
            {id_categorias}
        </select>
    </div>
    <button class="bt_consultar bt_top"></button>

</form>
<div class="clear"></div>
<div class="conteudo_admin">
    {conteudo}
</div>