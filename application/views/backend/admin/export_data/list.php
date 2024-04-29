<?php
    $school_id = school_id();
    $data=[];
    if($data_choosen == 'tahun'){
        $this->db->select('COUNT(name) AS jumlah');
        $this->db->where('school_id', $school_id);
        $data = $this->db->get('years')->result_array();
    } else if($data_choosen == 'siswa'){
        $this->db->select('COUNT(code) AS jumlah');
        $this->db->where('school_id', $school_id);
        $data = $this->db->get('students')->result_array();
    } else if($data_choosen == 'pegawai'){
        $this->db->select('COUNT(users.id) AS jumlah');
        $role_name = array('teacher', 'librarian', 'other_employee', 'accountant', '0');
		$this->db->or_where_in('role', $role_name);	
		$this->db->where('school_id', $school_id);
        $data = $this->db->get('users')->result_array();     
    } else if($data_choosen == 'jurusan'){
        $this->db->select('COUNT(id) AS jumlah');
		$this->db->where('school_id', $school_id);
        $data = $this->db->get('classes')->result_array();     
    } else if($data_choosen == 'matapelajaran'){
        $this->db->select('COUNT(id) AS jumlah');
		$this->db->where('school_id', $school_id);
        $data = $this->db->get('subjects')->result_array();     
    } else if($data_choosen == 'jadwalkelas'){
        $this->db->select('COUNT(id) AS jumlah');
		$this->db->where('school_id', $school_id);
        $data = $this->db->get('routines')->result_array();     
    } else if($data_choosen == 'buku'){
        $this->db->select('COUNT(id) AS jumlah');
		$this->db->where('school_id', $school_id);
        $data = $this->db->get('books')->result_array();     
    } else if($data_choosen == 'ektrakurikuler'){
        $this->db->select('COUNT(id) AS jumlah');
		$this->db->where('school_id', $school_id);
        $data = $this->db->get('organizations')->result_array();     
    }
    $count_tahun = array_column($data, 'jumlah');
        if (count($data) > 0):
?>

<div class="table-responsive-sm">
    <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
      <thead class="thead-dark">
        <tr>
            <th><?php echo get_phrase('jumlah_data'); ?></th>
            <th><?php echo get_phrase('action'); ?></th>
        </tr>
      </thead>
      <tbody>
            <td><?= $count_tahun[0]; ?></td>
            <td>
                <?php if($data_choosen == 'tahun'){ ?>
                    <a href="<?php echo route('export_data/download_tahun/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'siswa'){ ?>
                    <a href="<?php echo route('export_data/download_siswa/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'pegawai'){ ?>
                    <a href="<?php echo route('export_data/download_pegawai/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'jurusan'){ ?>
                    <a href="<?php echo route('export_data/download_jurusan/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'matapelajaran'){ ?>
                    <a href="<?php echo route('export_data/download_mapel/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'jadwalkelas'){ ?>
                    <a href="<?php echo route('export_data/download_jadwal/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'buku'){ ?>
                    <a href="<?php echo route('export_data/download_buku/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } elseif($data_choosen == 'ektrakurikuler'){ ?>
                    <a href="<?php echo route('export_data/download_ekskul/'); ?>" class="btn btn-secondary buttons-excel buttons-html5 btn-info btn-md p-2"><?php echo get_phrase('export to excel'); ?></a>
                <?php } ?>
            </td>
      </tbody>
    </table>    
</div>

<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script>
</script>