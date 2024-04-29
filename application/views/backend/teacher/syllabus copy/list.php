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
$this->db->where('school_id', $school_id);
$this->db->where('session_id', $active_session);
$syllabuses = $this->db->get('syllabuses')->result_array();
if(count($syllabuses) > 0):?>
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('classes'); ?></th>
                <th><?php echo get_phrase('subject'); ?></th>
                <th><?php echo get_phrase('title'); ?></th>
                <th><?php echo get_phrase('syllabus'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($syllabuses as $syllabus):?>
                <tr>
                    <td><?php echo $this->db->get_where('classes', array('id' => $syllabus['class_id']))->row('name'); ?> <?php echo $this->db->get_where('sections', array('id' => $syllabus['section_id']))->row('name'); ?></td>
                    <td><?php echo $this->db->get_where('subjects', array('id' => $syllabus['subject_id']))->row('name'); ?></td>
                    <td><?php echo $syllabus['title']; ?></td>
                    <td><a href="<?php echo base_url('uploads/syllabus/'.$syllabus['file']); ?>" class="btn btn-info mdi mdi-download" download><?php echo get_phrase('download'); ?></a></td>
                    <td>
                        <button type="button" class="btn btn-icon btn-secondary btn-sm" style="margin-right:5px;" onclick="confirmModal('<?php echo route('syllabus/delete/'.$syllabus['id']); ?>', showAllSyllabuses)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete_syllabus'); ?>"> <i class="mdi mdi-window-close"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
