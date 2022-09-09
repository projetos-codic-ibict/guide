    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Seções</h2>
                    <a href="createsecao.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Adicionar nova seção</a>
                    <a href="index.php" class="btn btn-primary pull-right"><i class="fa fa-home"></i> Página Principal</a>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Ordem</th>
                            <th>Nome</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <?php foreach ($data as $id => $row) { ?>
                        <tbody>
                            <tr>
                                <td><?= $row['id_sc']; ?></td>
                                <td><?= $row['sc_seq']; ?></td>
                                <td><?= $row['sc_name']; ?></td>
                                <td>
                                    <a href="/index/guide/sections/view?id=<?= $row['id_sc']; ?>" class="mr-3" title="Explorar" data-toggle="tooltip"><span class="fa fa-eye"></span></a>
                                    <a href="/index/guide/sections/upload?id=<?= $row['id_sc']; ?>" class="mr-3" title="Alterar" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                                    <a href="/index/guide/sections/delete?id=<?= $row['id_sc']; ?>" title="Excluir" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>