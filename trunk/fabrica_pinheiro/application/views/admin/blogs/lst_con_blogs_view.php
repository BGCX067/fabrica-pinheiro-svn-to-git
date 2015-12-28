<div class="paginacao">{paginacao}</div>
<table class="tabela">
    <thead>
        <tr>
            <th class="cols05">ID</th>
            <th class="cols20">Titulo</th>
            <th class="cols40">Descrição</th>
            <th class="cols10">Data/Hora Cadastro</th>
            <th class="cols05">Exibir</th>
            <th class="cols10">Categoria</th>
            <th class="cols10">Ação</th>
        </tr>
    </thead>
    <tbody>
        {blogs}
        <tr>
            <td>{id_blogs}</td>
            <td>{titulo}</td>
            <td>{descricao}</td>
            <td>{data_hora_cadastro}</td>
            <td>{exibir}</td>
            <td>{blc_nome}</td>
            <td>{acao}</td>
        </tr>
        {/blogs}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>