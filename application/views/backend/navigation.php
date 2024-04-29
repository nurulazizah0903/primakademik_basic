<?php
$controller = "";
if ($user_type == 'parent') {
  $controller = 'parents';
} else {
  $controller = $user_type;
}
?>

<style>
  .leftbar span.select2.select2-container {
    max-width: 209px;
  }
</style>

<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu left-side-menu-detached content-main">

  <div class="leftbar-user">
    <a href="javascript: void(0);">
      <img src="<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>" alt="user-image" height="42" class="shadow-sm rounded-circle">
      <?php
      $user_details = $this->user_model->get_user_details($this->session->userdata('user_id'));
      ?>
      <span class="leftbar-user-name"><?php echo $user_details['name']; ?></span>
    </a>
  </div>

  <?php if ($this->session->userdata('superadmin_login') ==  true) { ?>
    <!-- Left Bar T.A. Superadmin -->
    <div class="leftbar">
      <div class="alert alert-info" role="alert" style="margin-bottom:0 !important;">
        <?php echo get_phrase('active_session '); ?>
        <span class="badge badge-success pt-1" id="active_session"><?php echo active_session("name"); ?></span>
      </div>
      <div class="input-group">
        <select class="form-control select2" data-toggle="select2" id="session_dropdown">
          <option value=""><?php echo get_phrase('select_a_session'); ?></option>
          <?php $sessions = $this->db->get('sessions')->result_array();
          foreach ($sessions as $session) : ?>
            <option value="<?php echo $session['id']; ?>" <?php if ($session['status'] == 1) echo 'selected'; ?>><?php echo $session['name']; ?></option>
          <?php endforeach; ?>
        </select>
        <div class="input-group-append">
          <button type="button" class="btn btn-icon btn-secondary btn-sm" onclick="makeSessionActive()"><i class="mdi mdi-check"></i></button>
        </div>
      </div>
    </div>
  <?php } else if ($this->session->userdata('admin_login') ==  true) { ?>
    <!-- Left Bar T.A. Admin -->
    <div class="leftbar">
      <div class="alert alert-info" role="alert" style="margin-bottom:0 !important;">
        <?php echo get_phrase('active_session '); ?>
        <span class="badge badge-success pt-1" id="active_session"><?php echo active_session("name"); ?></span>
      </div>
    </div>
  <?php } ?>

  <!--- Sidemenu -->
  <ul class="metismenu side-nav side-nav-light">
    <li class="side-nav-title side-nav-item"><?php echo get_phrase('navigation'); ?></li>
    <li class="side-nav-item">
      <a href="<?php echo site_url($controller . '/dashboard'); ?>" class="side-nav-link">
        <i class="dripicons-meter"></i>
        <span> <?php echo get_phrase('dashboard'); ?> </span>
      </a>
    </li>

    <?php
    $this->db->order_by('sort_order', 'asc');
    $main_menus = $this->db->get_where('menus', array('parent' => 0, 'status' => 1, $this->session->userdata('user_type') . '_access' => 1))->result_array();
    foreach ($main_menus as $main_menu) {
    ?><li class="side-nav-item"><?php
                                  $this->db->order_by('sort_order', 'asc');
                                  $check_menus = $this->db->get_where('menus', array('parent' => $main_menu['id'], 'status' => 1, $this->session->userdata('user_type') . '_access' => 1));
                                  if ($check_menus->num_rows() > 0) { ?>
          <a href="javascript: void(0);" class="side-nav-link">
            <div class="row">
              <div class="col-sm-2">
                <i class="<?php echo $main_menu['icon']; ?>"></i>
              </div>
              <div class="col-sm-8">
                <span><?php echo get_phrase($main_menu['displayed_name']); ?></span>&emsp;
              </div>
              <div class="col-sm-2">
                <span class="menu-arrow"></span>
              </div>
            </div>
          </a>
          <ul class="side-nav-second-level" aria-expanded="false">
            <?php $this->db->order_by('sort_order', 'asc'); ?>
            <?php $menus = $this->db->get_where('menus', array('parent' => $main_menu['id'], 'status' => 1, $this->session->userdata('user_type') . '_access' => 1))->result_array();
                                    foreach ($menus as $menu) {
                                      $this->db->order_by('sort_order', 'asc');
                                      $check_sub_menus = $this->db->get_where('menus', array('parent' => $menu['id'], 'status' => 1, $this->session->userdata('user_type') . '_access' => 1));
                                      if ($check_sub_menus->num_rows() > 0) { ?>
                <li class="side-nav-item">
                  <a href="javascript: void(0);" aria-expanded="false"><?php echo get_phrase($menu['displayed_name']); ?>
                    <span class="menu-arrow"></span>
                  </a>
                  <ul class="side-nav-third-level" aria-expanded="false">
                    <?php
                                        $this->db->order_by('sort_order', 'asc');
                                        $sub_menus = $this->db->get_where('menus', array('parent' => $menu['id'], $this->session->userdata('user_type') . '_access' => 1))->result_array();
                                        foreach ($sub_menus as $sub_menu) {
                    ?>
                      <li>
                        <?php
                                          if ($menu['is_addon']) {
                                            $route = 'addons/' . $sub_menu['route_name'];
                                          } else {
                                            $route = $controller . '/' . $sub_menu['route_name'];
                                          }
                        ?>
                        <a href="<?php echo site_url($route); ?>"><?php echo get_phrase($sub_menu['displayed_name']); ?></a>
                      </li>
                    <?php } ?>
                  </ul>
                </li>
              <?php } else { ?>
                <li>
                  <?php
                                        if ($menu['is_addon']) {
                                          $route = 'addons/' . $menu['route_name'];
                                        } else {
                                          $route = $controller . '/' . $menu['route_name'];
                                        }
                  ?>
                  <a href="<?php echo site_url($route); ?>"><?php echo get_phrase($menu['displayed_name']); ?></a>
                </li>
              <?php } ?>
            <?php } ?>
          </ul><?php
                                  } else { ?>
          <?php
                                    if ($main_menu['is_addon']) {
                                      $route = 'addons/' . $main_menu['route_name'];
                                    } else {
                                      if ($main_menu['unique_identifier'] == 'online_courses') {
                                        $route = 'addons/' . $main_menu['route_name'];
                                      } else {
                                        $route = $controller . '/' . $main_menu['route_name'];
                                      }
                                    }
          ?>
          <a href="<?php echo site_url($route); ?>" class="side-nav-link">
            <i class="<?php echo $main_menu['icon']; ?>"></i>
            <span><?php echo get_phrase($main_menu['displayed_name']); ?></span>
          </a>
      </li>
  <?php }
                                }
  ?>
  </ul>
  <!-- End Sidebar -->

  <div class="clearfix"></div>
  <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
<script>
  function makeSessionActive() {
    var session_id = $('#session_dropdown').val();
    var url = '<?php echo route('session_manager/active_session/'); ?>' + session_id
    $.ajax({
      type: 'GET',
      url: url,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(response) {
        (response.status === true) ? toastr.success(response.notification): toastr.error(response.notification);
        location.reload();
      }
    });
  }

  $(document).ready(function() {
    initSelect2(['#session_dropdown']);
  })
</script>