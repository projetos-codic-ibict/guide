<input type="hidden" name="id_sc" id="id_sc" value="<?= $id_sc; ?>">
<input type="hidden" name="sc_project" id="sc_project" value="<?= $sc_project; ?>">
<input type="hidden" name="sc_order" id="sc_order" value="<?= $sc_order; ?>">
<input type="hidden" name="sc_path" id="sc_path" value="<?= $sc_path; ?>">
<input type="hidden" name="sc_project" id="sc_project" value="<?= $sc_project; ?>">
<table width="100%">
    <tr>
        <td class="small"><?= lang('guide.section_name'); ?></td>
    </tr>

    <tr>
        <!-- SECTION NAME -->
        <td colspan="2">
            <input type="text" name="sc_name" style="width: 100%;" id="sc_name" class="form-control" value="<?php echo $sc_name; ?>">
        </td>
    </tr>

    <tr>
        <td class="small"><?= lang('guide.section_path'); ?></td>
    </tr>

    <tr>
        <!-- SECTION PATH -->
        <td colspan="2">
            <input type="text" name="sc_path" style="width: 100%;" id="sc_path" class="form-control" value="<?php echo $sc_path; ?>">
        </td>
    </tr>

    <tr>
        <td>
            <button type="submit" class="btn btn-outline-primary supersmall" onclick="section_save();"><?= msg('guide.save'); ?></button>
        </td>
    </tr>
</table>