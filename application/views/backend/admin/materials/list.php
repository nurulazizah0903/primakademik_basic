<?php
$school_id = school_id();
$active_session = active_session();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
if(isset($section_id) && $section_id != ''){
  $this->db->where('section_id', $section_id);
}
if(isset($room_id) && $room_id != ''){
  $this->db->where('room_id', $room_id);
}
if(isset($subject_id) && $subject_id != ''){
    $this->db->where('subject_id', $subject_id);
  }
$this->db->where('school_id', $school_id);
$this->db->where('session_id', $active_session);
$materials = $this->db->get('materials')->result_array();
if(count($materials) > 0): ?>
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
