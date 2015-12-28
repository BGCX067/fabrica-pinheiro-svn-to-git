<div class="paginacao">{paginacao}</div>
<table class="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Link</th>
            <th>Banner</th>
            <th>Data cadastro</th>
            <th>Data exclusão</th>
            <th>Tipo banner</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        {banners}
        <tr>
            <td>{id_banners}</td>
            <td>{descricao}</td>
            <td>{link}</td>
            <td>{path}</td>
            <td>{data_cadastro}</td>
            <td>{data_exclusao}</td>
            <td>{id_banners_tipos}</td>
            <td>{acao}</td>
        </tr>
        {/banners}
    </tbody>
</table>
<div class="paginacao">{paginacao}</div>