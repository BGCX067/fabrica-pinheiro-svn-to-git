<form name="frm_cad_produtos" id="frm_cad_produtos" onsubmit="return false;">
    <input type="hidden" name="id_produtos" id="id_produtos" value="{id_produtos}" />

    <div style="float: left;">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="{nome}" class="obrigatorio" />
    </div>

    <div style="float: left;">
        <label for="quantidade">Quantidade</label>
        <input type="text" id="quantidade" name="quantidade" value="{quantidade}" class="obrigatorio numero" />
    </div>

    <label for="valor">Valor R$</label>
    <input type="text" id="valor" name="valor" value="{valor}" class="obrigatorio moeda" />
    <div class="clear"></div>

    <div style="float: left;">
        <label for="data_cadastro">Data cadastro</label>
        <input type="text" id="data_cadastro" name="data_cadastro" value="{data_cadastro}" class="obrigatorio data" />
    </div>

    <div style="float: left;">
        <label for="exibir">Exibir</label>
        <select id="exibir" name="exibir" class="obrigatorio">
            {exibir}
        </select>
    </div>

    <label for="id_categorias">Categorias</label>
    <select id="id_categorias" name="id_categorias" class="obrigatorio">
        {id_categorias}
    </select>
    <div class="clear"></div>

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao" class="obrigatorio editor" style="width: 99%;">{descricao}</textarea>
    <div class="clear"></div>

    <button class="bt_gravar"></button>
    <button class="bt_novo"></button>

</form>
<div id="bt_fotos"></div>
<div class="fotos">
    {fotos}
    <div class="minha_foto">
        <img class="pre_img" src="{url_admin}produtos/ver_foto/{id_produtos_fotos}.{sub}" width="{largura}" title="{nome_foto}" id_foto="{id_produtos_fotos}" />
        <div class="acao">
            <a class="remover">Remover</a>
        </div>
    </div>
    {/fotos}
</div>
<div class="clear"></div>