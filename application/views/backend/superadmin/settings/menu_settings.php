<div class="col-12">
  <div class="card">
      <div class="card-body menu_content">
        <div class="col-md-12">
          <div class="table-responsive"> 
            <table id="example" class="table table-striped dt-responsive" width="100%">
                <thead>
                  <tr>
                    <th><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('status'); ?></th>
                    <th><?php echo get_phrase('superadmin_access'); ?></th>
                    <th><?php echo get_phrase('admin_access'); ?></th>
                    <th><?php echo get_phrase('accountant_access'); ?></th>
                    <th><?php echo get_phrase('librarian_access'); ?></th>
                    <th><?php echo get_phrase('teacher_access'); ?></th>
                    <th><?php echo get_phrase('parent_access'); ?></th>
                    <th><?php echo get_phrase('student_access'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  // $this->db->where_not_in('parent', 0);
                  // $this->db->where('status', 1);
                  $this->db->order_by('id', 'ASC');
                  $menus = $this->db->get('menus')->result_array();
                  foreach($menus as $menu){
                    ?>
                    <tr>
                      <td><?php echo get_phrase($menu['displayed_name']); ?></td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['status']; ?>" data-switch="success" id="<?php echo $menu['id'].'1'; ?>" onchange="togglePermission(this.id, 'status', '<?php echo $menu['id']; ?>')" <?php if($menu['status'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'1'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['superadmin_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'2'; ?>" onchange="togglePermission(this.id, 'superadmin_access', '<?php echo $menu['id']; ?>')" <?php if($menu['superadmin_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'2'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['admin_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'3'; ?>" onchange="togglePermission(this.id, 'admin_access', '<?php echo $menu['id']; ?>')" <?php if($menu['admin_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'3'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['accountant_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'4'; ?>" onchange="togglePermission(this.id, 'accountant_access', '<?php echo $menu['id']; ?>')" <?php if($menu['accountant_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'4'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['librarian_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'5'; ?>" onchange="togglePermission(this.id, 'librarian_access', '<?php echo $menu['id']; ?>')" <?php if($menu['librarian_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'5'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['teacher_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'6'; ?>" onchange="togglePermission(this.id, 'teacher_access', '<?php echo $menu['id']; ?>')" <?php if($menu['teacher_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'6'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['parent_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'7'; ?>" onchange="togglePermission(this.id, 'parent_access', '<?php echo $menu['id']; ?>')" <?php if($menu['parent_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'7'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                      <td>
                        <input type="checkbox" value="<?php echo $menu['student_access']; ?>" data-switch="success" id="<?php echo $menu['id'].'8'; ?>" onchange="togglePermission(this.id, 'student_access', '<?php echo $menu['id']; ?>')" <?php if($menu['student_access'] == 1) echo 'checked'; ?>>
                        <label for="<?php echo $menu['id'].'8'; ?>" data-on-label="Yes" data-off-label="No">
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table><br>
            </div>
          </div>
      </div>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "info":     false
    } );
} );
</script>