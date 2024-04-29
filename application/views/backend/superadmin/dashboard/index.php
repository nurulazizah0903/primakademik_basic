<style type="text/css">
  .highcharts-figure,
  .highcharts-data-table table {
      min-width: 100%;
      max-width: 100%;
  }

  #container {
      height: 400px;
  }

  .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #ebebeb;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
  }

  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }

  .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
      padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }
</style>

<?php
  $school_id = school_id();
  $active_session = active_session();
  $this->db->select("classes.id, classes.name");
  $this->db->where("school_id", $school_id);
  $this->db->order_by("classes.name", "ASC");
  $classes = $this->db->get("classes")->result_array();

  $class_group = [];
  $num_students_male = [];
  $num_students_female = [];
  foreach($classes AS $class){
    $this->db->join("students", "enrols.student_id = students.id");
    $this->db->join("users", "students.user_id = users.id");
    $this->db->where("enrols.school_id", $school_id);
    $this->db->where("enrols.class_id", $class['id']);
    $this->db->where("users.gender", "Male");
    $male_students = $this->db->get("enrols")->num_rows();

    $this->db->join("students", "enrols.student_id = students.id");
    $this->db->join("users", "students.user_id = users.id");
    $this->db->where("enrols.school_id", $school_id);
    $this->db->where("enrols.class_id", $class['id']);
    $this->db->where("users.gender", "Female");
    $female_students = $this->db->get("enrols")->num_rows();
    
    $num_students_male[] = $male_students;                        
    $num_students_female[] = $female_students;                        
    $class_group[] = $class['name'];                        
    
  }

  $role_employee = ['teacher', 'accountant', 'librarian'];

  $data_employee = [];
  foreach($role_employee AS $group_role){
    $this->db->where("role", $group_role);
    $this->db->where("school_id", $school_id);
    $count_employee = $this->db->get("users")->num_rows();

    $data_employee[] = ["name" => get_phrase($group_role), "y" => $count_employee];
  }
?>

<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-view-dashboard title_icon"></i> <?php echo get_phrase('dashboard'); ?> - <?= $this->db->get_where('schools', 'id = '.school_id())->first_row()->name ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->

<!-- announcement -->
<?php
  $announcements = $this->crud_model->get_announcements();
?>
<?php if (count($announcements) > 0): ?>
<div class="card">
  <div class="card-body">
    <div class="alert alert-warning" role="alert">
      <h4 class="header-title"><?php echo get_phrase('announcement'); ?></h4>
    </div>
      <table width="100%">
          <thead>
              <tr>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($announcements as $announcement): ?>
                  <tr>
                      <td>
                          <?php echo $announcement['name']; ?>
                      </td>
                  </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
  </div>
</div>
<?php else: ?>
<?php endif; ?>
<!-- end announcement -->

<div class="row">
  <div class="col-xl-3">
    <div class="card widget-flat" id="male_student">
      <div class="card-body">
          <div class="row">
            <div class="col-sm-5 d-flex align-items-center">
              <i class="mdi mdi-human-male title_icon"></i>
            </div>
            <div class="col-sm-7 d-flex align-items-center justify-content-end">
              <?php
                  $this->db->join("students", "enrols.student_id = students.id");
                  $this->db->join("users", "students.user_id = users.id");
                  $this->db->where("enrols.school_id", $school_id);
                  $this->db->where("users.gender", "Male");
                  $total_of_male = $this->db->get("enrols")->num_rows();

                  echo "<h2><b>".$total_of_male."</b></h2>";
              ?>
            </div>
          </div>
          <div class="row">
              <div class="col-sm-12 d-flex justify-content-start">
                <h5 class="mt-0 text-muted font-weight-normal"> <?php echo get_phrase('total_number_of_male_student'); ?>  <a href="<?php echo route('student'); ?>" style="color: #6c757d; display: none;" id = "male_student_list"><i class = "mdi mdi-export"></i></a></h5>
              </div>
          </div>          
      </div> <!-- end card-body-->
    </div> <!-- end card-->
  </div>
  <div class="col-xl-3">
    <div class="card widget-flat" id="female_student">
      <div class="card-body">
          <div class="row">
            <div class="col-sm-5 d-flex align-items-center">
              <i class="mdi mdi-human-female title_icon"></i>
            </div>
            <div class="col-sm-7 d-flex align-items-center justify-content-center">
              <?php
                  $this->db->join("students", "enrols.student_id = students.id");
                  $this->db->join("users", "students.user_id = users.id");
                  $this->db->where("enrols.school_id", $school_id);
                  $this->db->where("users.gender", "Female");
                  $total_of_female = $this->db->get("enrols")->num_rows();

                  echo "<h2><b>".$total_of_female."</b></h2>";
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 d-flex justify-content-start">
              <h5 class="mt-0 text-muted font-weight-normal"> <?php echo get_phrase('total_number_of_female_student'); ?>  <a href="<?php echo route('student'); ?>" style="color: #6c757d; display: none;" id = "female_student_list"><i class = "mdi mdi-export"></i></a></h5>
            </div>
          </div>
      </div> <!-- end card-body-->
    </div> <!-- end card-->
  </div>
  <div class="col-xl-3">
    <div class="card widget-flat" id="student">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-5 d-flex align-items-center">
            <i class="mdi mdi-account-group title_icon"></i>
          </div>
          <div class="col-sm-7 d-flex align-items-center justify-content-center">
            <?php

                $this->db->join("students", "enrols.student_id = students.id");
                $this->db->where("enrols.school_id", $school_id);
                $current_students = $this->db->get("enrols")->num_rows();
                echo "<h2><b>".$current_students."</b></h2>";
            ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 d-flex justify-content-start">
            <h5 class="mt-0 text-muted font-weight-normal" title="Number of Student">
              <?php echo get_phrase('total_number_of_student'); ?> 
              <a href="<?php echo route('student'); ?>" style="color: #6c757d; display: none;" id = "student_list">
                <i class = "mdi mdi-export"></i>
              </a>
            </h5>
          </div>
        </div>
      </div> <!-- end card-body-->
    </div> <!-- end card-->    
  </div>
  <div class="col-xl-3">
    <div class="card widget-flat" id="teacher">
      <div class="card-body">
          <div class="row">
            <div class="col-sm-5 float-left">
              <i class="mdi mdi-teach title_icon"></i>
            </div>
            <div class="col-sm-7 d-flex align-items-center justify-content-center">
              <?php
                  $teachers = $this->user_model->get_teachers();
                  echo "<h2><b>".$teachers->num_rows()."</b></h2>";
              ?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 d-flex justify-content-start">
              <h5 class="mt-0 text-muted font-weight-normal" title="Number of Teacher"> <?php echo get_phrase('total_number_of_teacher'); ?>  <a href="<?php echo route('teacher'); ?>" style="color: #6c757d; display: none;" id = "teacher_list"><i class = "mdi mdi-export"></i></a></h5>
            </div>
          </div>
      </div> <!-- end card-body-->
    </div> <!-- end card-->      
  </div>
</div>

<div class="row ">
  <div class="col-xl-12">
    <div class="row">
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card bg-primary">
          <div class="card-body">
            <h4 class="mb-2 text-white header-title"><?php echo get_phrase('todays_attendance'); ?></h4>
            <div class="text-center">
              <h3 class="mb-2 text-white font-weight-normal">
                <?php echo $this->crud_model->get_todays_attendance(); ?>
              </h3>
              <p class="text-light text-uppercase font-13 font-weight-bold"><?php echo $this->crud_model->get_todays_attendance(); ?> <?php echo get_phrase('students_are_attending_today'); ?></p>
              <a href="<?php echo route('attendance'); ?>" class="mb-1 btn btn-outline-light btn-sm"><?php echo get_phrase('go_to_attendance'); ?>
                <i class="ml-1 mdi mdi-arrow-right"></i>
              </a>

            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h4 class="header-title"><?php echo get_phrase('recent_events'); ?><a href="<?php echo route('event_calendar'); ?>" style="color: #6c757d;"><i class = "mdi mdi-export"></i></a></h4>
            <?php include 'event.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
          <figure class="highcharts-figure">
              <div id="container_bar_chart"></div>
          </figure>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {
  initDataTable("expense-datatable");
});
$(".widget-flat").mouseenter(function() {
  var id = $(this).attr('id');
  $('#'+id+'_list').show();

}).mouseleave(function() {
  var id = $(this).attr('id');
  $('#'+id+'_list').hide();
});

// Pie Chart

var employee_data = <?= json_encode($data_employee); ?>
// Highcharts.chart('container', {
//     chart: {
//         type: 'variablepie'
//     },
//     title: {
//         text: 'Countries compared by population density and total area.'
//     },
//     tooltip: {
//         headerFormat: '',
//         pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
//             'Area (square km): <b>{point.y}</b><br/>' +
//             'Population density (people per square km): <b>{point.z}</b><br/>'
//     },
//     series: [{
//         minPointSize: 10,
//         innerSize: '20%',
//         zMin: 0,
//         name: 'countries',
//         data: [{
//             name: 'Spain <br/><b>505370</b>',
//             y: 505370
         
//         }, {
//             name: 'France',
//             y: 551500
          
//         }, {
//             name: 'Poland',
//             y: 312685
//         }, {
//             name: 'Czech Republic',
//             y: 78867
//         }, {
//             name: 'Italy',
//             y: 301340
//         }, {
//             name: 'Switzerland',
//             y: 41277
//         }, {
//             name: 'Germany',
//             y: 357022
//         }]
//     }]
// });
// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Grafik Jumlah Guru'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} orang</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} orang'
            }
        }
    },
    series: [{
        name: 'Jumlah',
        colorByPoint: true,
        data: employee_data
    }]
});

// Bar Chart
var categories = <?= json_encode($class_group) ?>;
var total_student_male = <?= json_encode($num_students_male) ?>;
var total_student_female = <?= json_encode($num_students_female) ?>;
Highcharts.chart('container_bar_chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Jumlah Siswa per Jurusan'
    },
    xAxis: {
        categories: categories,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah siswa'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} siswa</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: '<?= get_phrase("male") ?>',
        data: total_student_male

    }, {
        name: '<?= get_phrase("female") ?>',
        data: total_student_female

    }]
});
</script>