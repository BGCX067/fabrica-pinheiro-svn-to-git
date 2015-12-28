<div class="paginacao">{paginacao}</div>
<table class="tabela">
    <thead>
        <tr>
            <th class="cols05">ID</th>
            <th class="cols25">Nome</th>
            <th class="cols05">Quantidade</th>
            <th class="cols05">Valor R$</th>
            <th class="cols05">Exibir</th>
            <th class="cols10">Categoria</th>
            <th class="cols15">Cadastrado Por</th>
            <th class="cols05">Cadastro</th>
            <th class="cols05">Exclusão</th>
            <th class="cols10">Ação</th>
        </tr>
    </thead>
    <tbody>
        {produtos}
        <tr>
            <td>{id_produtos}</td>
            <td>{nome}</td>
            <td>{quantidade}</td>
            <td>{valor}</td>
            <td>{exibir}</td>
            <td>{ct_descricao}</td>
            <td>{id_usuarios}</td>
            <td>{data_cadastro}</td>
            <td>{data_exclusao}</td>
            <td>{acao}</td>
        </tr>
        {/produtos}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>