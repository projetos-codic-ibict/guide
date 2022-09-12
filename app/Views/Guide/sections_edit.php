<?php
$link = 'sections_edit?id=' . $id_sc;
if ($id_sc == 0)
    {
        $link = 'createsecao';
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-5">Adicionar Seção</h2>
            <p>Preencher para inserir nova seção no banco.</p>
            <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
            <script type="text/javascript">
                bkLib.onDomLoaded(function() {
                    nicEditors.allTextAreas()
                });
            </script>
            <?= form_open(PATH . '/index/guide/'.$link) ?>
            <?= form_hidden('id_sc', $id_sc); ?>
            <div class="form-group">
                <label>Ordem</label>
                <?php
                $options = array();
                for ($r = 1; $r < 100; $r++) {
                    $options[$r] = $r;
                }
                echo form_dropdown(array('name' => 'sc_seq', 'selected' => $sc_seq, 'class' => 'form-control', 'options' => $options, 'value' => $sc_seq));
                ?>
                <?php if (isset($ERROS['sc_seq'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $ERROS['sc_seq'] ?>
                    </div>
                <?php } ?>
            </div>

            <div class="form-group">
                <label>Father Class</label>
                <?php
                $Sections = new \App\Models\Guide\GuideSection();
                $ds = $Sections->where('sc_father', null)->findAll();
                $options = array();
                $options[''] = 'Selecione';
                for ($r = 0; $r < count($ds); $r++) {
                    $line = $ds[$r];
                    $options[$line['id_sc']] = $line['sc_name'];
                }
                echo form_dropdown(array('name' => 'sc_father', 'class' => 'form-control', 'selected'=>$sc_father ,'options' => $options, 'value' => $sc_father));
                ?>
                <?php if (isset($ERROS['sc_seq'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $ERROS['sc_seq'] ?>
                    </div>
                <?php } ?>
            </div>

            <span class="label">Nome da Seção</span>
            <?= form_input(array('name' => 'sc_name', 'class' => 'form-control', 'value' => $sc_name)); ?>
            <?php if (isset($ERROS['sc_name'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $ERROS['sc_name'] ?>
                </div>
            <?php } ?>

            <span class="label">Caminho da Seção (Dataverse Guide)</span>
            <?= form_input(array('name' => 'sc_path', 'class' => 'form-control', 'value' => $sc_path)); ?>
            <?php if (isset($ERROS['sc_path'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $ERROS['sc_path'] ?>
                </div>
            <?php } ?>
            <br/>
            <input type="submit" class="btn btn-primary" value="Salvar">
            <a href="<?= PATH . '/index/guide/sections'; ?>" class="btn btn-secondary ml-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>