    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Seções</h2>
                    <a href="<?= PATH . '/index/guide/sections'; ?>" class="btn btn-primary pull-right"><i class="fa fa-home"></i> Página Principal</a>
                    <a href="/index/guide/export" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Exportar guia</a>
                    <a href="/index/guide/createsecao" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Adicionar nova seção</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th width="10%">Path</th>
                            <th width="10%">Father</th>
                            <th width="69%">Nome</th>
                            <th width="10%">Opções</th>
                        </tr>
                    </thead>
                    <?php foreach ($data as $id => $row) { ?>
                        <tbody>
                            <tr>
                                <td><?= $row['sc_seq']; ?></td>
                                <td><?= $row['sc_path']; ?></td>
                                <td><?= $row['sc_father_name']; ?></td>
                                <td><?= $row['sc_name']; ?></td>
                                <td class="text-center">
                                    <a href="/index/guide/sections_view?id=<?= $row['id_sc']; ?>" class="mr-3" title="Explorar" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
                                    <a href="/index/guide/sections_edit?id=<?= $row['id_sc']; ?>" class="mr-3" title="Alterar" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                    <a href="/index/guide/sections_delete?id=<?= $row['id_sc']; ?>" title="Excluir" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>