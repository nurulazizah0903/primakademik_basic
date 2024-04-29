<option value=""><?php echo get_phrase('select_knowledge_base'); ?></option>
<?php
$knowledge_bases = $this->db->get_where('knowledge_base', array('subject_id' => $subject_id))->result_array();
if (count($knowledge_bases) > 0):
  foreach ($knowledge_bases as $knowledge_base): ?>
    <option value="<?php echo $knowledge_base['id']; ?>"><?php echo $knowledge_base['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_subject_found'); ?></option>
<?php endif; ?>