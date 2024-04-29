<?php
$school_id = school_id();
if (isset($class_id) && isset($section_id) && isset($subject_id)):
    $materials = $this->db->get_where('materials', array('class_id' => $class_id, 'section_id' => $section_id, 'subject_id' => $subject_id, 'session_id' => active_session()))->result_array();
    if(count($materials) > 0):?>
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('title'); ?></th>
                <th><?php echo get_phrase('date'); ?></th>
                <th><?php echo get_phrase('materials'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($materials as $material):?>
                <tr>
                    <td><?php echo $material['title']; ?></td>
                    <td><?php echo date('D, d M Y', strtotime($material['date'])); ?></td>
                    <td><a href="<?php echo base_url('uploads/materials/'.$material['file']); ?>" class="btn btn-info mdi mdi-download" download><?php echo get_phrase('download'); ?></a></td>
                    <td>
                        <button type="button" class="btn btn-icon btn-secondary btn-sm" style="margin-right:5px;" onclick="confirmModal('<?php echo route('materials/delete/'.$material['id']); ?>', showAllMaterials)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete_materials'); ?>"> <i class="mdi mdi-window-close"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
