<?php
$school_id = school_id();
$classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); 
if (count($classes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('section'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($classes as $class): ?>
            <tr>
                <td><?php echo $class['name']; ?></td>
                <td>
                    <ul>
                        <?php
                        $sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
                        foreach($sections as $section){
                            echo '<li>'.$section['name'].'</li>';

                            $class_rooms = $this->db->get_where('class_rooms', array('section_id' => $section['id']))->result_array();
                            foreach($class_rooms as $class_room){ ?>
                                <!-- <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/class_room/edit/'.$class_room['id'])?>', '<?php echo get_phrase('update_class_room'); ?>');"><b><?=$class_room['name']?></b></a> -->
                                <div class="dropdown text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><b><?=$class_room['name']?></b></button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/class_room/edit/'.$class_room['id'])?>', '<?php echo get_phrase('update_class_room'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('class_room/delete/'.$class_room['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
                                    </div>
                                </div>
                            <?php }
                        }
                        ?>
                    </ul>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/class/sections/'.$class['id'])?>', '<?php echo get_phrase('sctions'); ?>');"><?php echo get_phrase('sections'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/class/edit/'.$class['id'])?>', '<?php echo get_phrase('update_class'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('manage_class/delete/'.$class['id']); ?>', showAllClasses)"><?php echo get_phrase('delete'); ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
