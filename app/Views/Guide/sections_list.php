<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="1%">#</th>
            <th width="30%">Path</th>
            <th width="1%">R</th>
            <th width="49%">Nome</th>
            <th width="10%">Opções</th>
        </tr>
    </thead>
    <?php foreach ($data as $id => $row) { ?>
        <tbody>
            <tr>
                <td><?= $row['sc_seq']; ?></td>
                <td><a href="<?= PATH . '/admin/section/viewid/' . $row['id_sc']; ?>" class="text-secondary" style="text-decoration: none;"><?= $row['sc_path']; ?></a></td>
                <td><?= $row['sc_father_name']; ?></td>
                <td><a href="<?= PATH . '/admin/section/viewid/' . $row['id_sc']; ?>" class="text-secondary" style="text-decoration: none;"><?= $row['sc_name']; ?></a></td>
                <td class="text-center">
                    <a href="/admin/section/viewid/<?= $row['id_sc']; ?>" class="mr-3" title="Explorar" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
                    <a href="/admin/section/edit/<?= $row['id_sc']; ?>" class="mr-3" title="Alterar" data-toggle="tooltip"><span class="fa fa-pen"></span></a>
                    <a href="/admin/section/delete/<?= $row['id_sc']; ?>" title="Excluir" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
</table>