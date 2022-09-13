<?php
$link = 'content_edit?id=' . $id_ct;
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

            <?= form_hidden('id_ct', $id_ct); ?>

            <div class="form-group">
                <label>Ordem</label>
                <?php
                $options = array();
                for ($r = 1; $r < 100; $r++) {
                    $options[$r] = $r;
                }
                echo form_dropdown(array('name' => 'ct_seq', 'selected' => round($ct_seq), 'class' => 'form-control', 'options' => $options, 'value' => $ct_seq));
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
                $ds = $Sections->where('sc_father > 0')->findAll();
                $options = array();
                $options[''] = 'Selecione';
                for ($r = 0; $r < count($ds); $r++) {
                    $line = $ds[$r];
                    $options[$line['id_sc']] = $line['sc_name'];
                }
                echo form_dropdown(array('name' => 'ct_section', 'class' => 'form-control', 'selected'=> $ct_section ,'options' => $options, 'value' => $ct_section));
                ?>
                <?php if (isset($ERROS['sc_seq'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $ERROS['sc_seq'] ?>
                    </div>
                <?php } ?>
            </div>

            <span class="label">Nome da Seção</span>
            <?= form_input(array('name' => 'ct_title', 'class' => 'form-control', 'value' => $ct_title)); ?>
            <?php if (isset($ERROS['ct_title'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $ERROS['ct_title'] ?>
                </div>
            <?php } ?>

            <span class="label">Caminho da Seção (Dataverse Guide)</span>
            <?= form_textarea(array('name' => 'ct_description', 'class' => 'form-control', 'value' => $ct_description)); ?>
            <?php if (isset($ERROS['ct_title'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $ERROS['ct_title'] ?>
                </div>
            <?php } ?>
            <br/>
            <input type="submit" class="btn btn-primary" value="Salvar">
            <a href="<?= PATH . '/index/guide/sections'; ?>" class="btn btn-secondary ml-2">Cancelar</a>
            </form>
        </div>
    </div>
</div>