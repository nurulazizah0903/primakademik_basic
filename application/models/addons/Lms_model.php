<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lms_model extends CI_Model {

  // constructor
    function __construct()
    {
        parent::__construct();
    }

    function index(){
        
    }

    public function get_course_by_id($course_id){
        return $this->db->get_where('course', array('id' => $course_id))->row_array();
    }

    public function filter_course_for_backend($class_id ="", $user_id="", $status="", $subject_id=""){
        $superadmin_login = $this->session->userdata('superadmin_login');
        $admin_login = $this->session->userdata('admin_login');
        $teacher_login = $this->session->userdata('teacher_login');
        $student_login = $this->session->userdata('student_login');

        if($superadmin_login == 1 || $admin_login == 1):
            return $this->filter_course_for_admin($class_id, $user_id, $status);
        endif;

        if($teacher_login == 1):
            return $this->filter_course_for_teacher($class_id, $user_id, $status);
        endif;
        
        if($student_login == 1):
            return $this->filter_course_for_student($class_id, $user_id, $status, $subject_id);
        endif;
    }
    public function filter_course_for_admin($class_id, $user_id, $status){
        $this->db->where('school_id', school_id());

        if ($class_id != "all") {
            $this->db->where('class_id', $class_id);
        }

        if ($user_id != "all") {
            $this->db->where('user_id', $user_id);
        }

        if ($status != "all") {
            $this->db->where('status', $status);
        }

        return $this->db->get('course')->result_array();
    }
    public function filter_course_for_teacher($class_id, $user_id, $status){
        $this->db->where('school_id', school_id());
        $this->db->where('user_id', $this->session->userdata('user_id'));

        if ($class_id != "all") {
            $this->db->where('class_id', $class_id);
        }

        if ($status != "all") {
            $this->db->where('status', $status);
        }
        return $this->db->get('course')->result_array();
    }
    public function filter_course_for_student($class_id, $user_id, $status, $subject_id){
        $class_id = $this->get_class_id_by_user($this->session->userdata('user_id'));
        $this->db->where('school_id', school_id());
        $this->db->where('status', 'active');
        $this->db->where('class_id', $class_id);

        if ($user_id != "all") {
            $this->db->where('user_id', $user_id);
        }
        if ($subject_id != "all") {
            $this->db->where('subject_id', $subject_id);
        }

        return $this->db->get('course')->result_array();
    }

    public function get_subject_by_class_id($class_id = ""){
        return $this->db->get_where('subjects', array('class_id' => $class_id))->result_array();

    }

    public function get_status_wise_courses($status = ""){
        if ($status != "") {
            $courses = $this->db->get_where('course', array('status' => $status, 'school_id' => school_id()));
        } else {
            if($this->session->userdata('teacher_login') == 1){
                $teacher_id  = $this->session->userdata('user_id');
                $courses['inactive'] = $this->db->get_where('course', array('status' => 'inactive', 'user_id' => $teacher_id));
                $courses['active'] = $this->db->get_where('course', array('status' => 'active', 'user_id' => $teacher_id));
            }else{
                $courses['inactive'] = $this->db->get_where('course', array('status' => 'inactive', 'school_id' => school_id()));
                $courses['active'] = $this->db->get_where('course', array('status' => 'active', 'school_id' => school_id()));
            }
        }
        return $courses;
    }

    public function get_section($type_by, $id){
        $this->db->order_by("orders", "asc");
        if ($type_by == 'course') {
            return $this->db->get_where('course_section', array('course_id' => $id));
        } elseif ($type_by == 'section') {
            return $this->db->get_where('course_section', array('id' => $id));
        }
    }

    public function course_activity($course_id){
        $course = $this->db->get_where('course', array('id' => $course_id))->row_array();
        if($course['status'] == 'active'){
            $data['status'] = 'inactive';
            $this->db->where('id', $course_id);
            $this->db->update('course', $data);

            $history_data['ket'] = 'Update data course '.$course_id.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }else{
            $data['status'] = 'active';
            $this->db->where('id', $course_id);
            $this->db->update('course', $data);

            $history_data['ket'] = 'Update data course '.$course_id.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }
    }

    public function delete_course($course_id){

		$history_data['ket'] = 'Delete data delete_course '.$course_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

        $course = $this->db->get_where('course', array('id' => $course_id))->row_array();

        if(file_exists('uploads/course_thumbnail/'.$course['thumbnail']))
        unlink('uploads/course_thumbnail/'.$course['thumbnail']);

        $this->db->where('id', $course_id);
        $this->db->delete('course');

        $this->db->where('course_id', $course_id);
        $this->db->delete('course_section');

        $this->db->where('course_id', $course_id);
        $this->db->delete('lesson');

        $response = array(
            'status' => true,
            'notification' => get_phrase('course_data_deleted_successfully')
        );
        return json_encode($response);
    }

    public function get_lessons($type = "", $id = ""){
        $this->db->order_by("order", "asc");
        if ($type == "course") {
            return $this->db->get_where('lesson', array('course_id' => $id));
        } elseif ($type == "section") {
            return $this->db->get_where('lesson', array('section_id' => $id));
        } elseif ($type == "lesson") {
            return $this->db->get_where('lesson', array('id' => $id));
        } else {
            return $this->db->get('lesson');
        }
    }

    public function get_subject_by_class($class_id = '') {
        $subjects = $this->db->get_where('subjects', array('class_id' => $class_id))->result_array();
        $option = '<option value="">'.get_phrase('select_a_subject').'</option>';
        $count = 0;
        foreach ($subjects as $subject):
            $count++;
            $option .= '<option value="'.$subject['id'].'">'.$subject['name'].'</option>';
        endforeach;

        if($count > 0){
            return $option;
        }else{
            return '<option value="">'.get_phrase('data_not_found').'</option>';;
        }
    }

    public function get_subject_by_section($section_id = '') {
        $subjects = $this->db->get_where('subjects', array('section_id' => $section_id))->result_array();
        $option = '<option value="">'.get_phrase('select_a_subject').'</option>';
        $count = 0;
        foreach ($subjects as $subject):
            $count++;
            $option .= '<option value="'.$subject['id'].'">'.$subject['name'].'</option>';
        endforeach;

        if($count > 0){
            return $option;
        }else{
            return '<option value="">'.get_phrase('data_not_found').'</option>';;
        }
    }

    public function get_section_by_class($class_id = '') {
        $sections = $this->db->get_where('sections', array('class_id' => $class_id))->result_array();
        $option = '<option value="">'.get_phrase('select_section').'</option>';
        $count = 0;
        foreach ($sections as $section):
            $count++;
            $option .= '<option value="'.$section['id'].'">'.$section['name'].'</option>';
        endforeach;

        if($count > 0){
            return $option;
        }else{
            return '<option value="">'.get_phrase('data_not_found').'</option>';;
        }
    }

    public function course_add(){
        $subject_id = html_escape($this->input->post('subject_id'));
		$subject_data =  $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
        $section_data =  $this->db->get_where('sections', array('id' => $subject_data['section_id']))->row_array();
        $teacher_data =  $this->db->get_where('teachers', array('id' => $subject_data['teacher_id']))->row_array();
		$room_data =  $this->db->get_where('class_rooms', array('section_id' => $subject_data['section_id']))->row_array();

        $data['title'] = html_escape($this->input->post('title'));
        $data['user_id'] = $teacher_data['user_id'];
        $data['class_id'] = $section_data['class_id'];
		$data['section_id'] = $subject_data['section_id'];
		$data['room_id'] = $room_data['id'];
        $data['subject_id'] = $subject_id;
        $data['description'] = html_escape($this->input->post('description'));
        $data['outcomes'] = html_escape($this->input->post('outcomes'));
        $data['course_overview_provider'] = html_escape($this->input->post('course_overview_provider'));
        $data['course_overview_url'] = html_escape($this->input->post('course_overview_url'));
        $data['thumbnail'] = rand().'.jpg';

        $data['status'] = 'active';
        $data['date_added'] = strtotime(date('d M Y'));
        $data['school_id'] = school_id();
        
        $this->db->insert('course', $data);

        $history_data['ket'] = 'Insert data course';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);

        move_uploaded_file($_FILES['course_thumbnail']['tmp_name'], 'uploads/course_thumbnail/'.$data['thumbnail']);
    }

    public function course_edit($course_id){
        $subject_id = html_escape($this->input->post('subject_id'));
		$subject_data =  $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
        $section_data =  $this->db->get_where('sections', array('id' => $subject_data['section_id']))->row_array();
        $teacher_data =  $this->db->get_where('teachers', array('id' => $subject_data['teacher_id']))->row_array();
		$room_data =  $this->db->get_where('class_rooms', array('section_id' => $subject_data['section_id']))->row_array();

        $data['title'] = html_escape($this->input->post('title'));
        $data['user_id'] = $teacher_data['user_id'];
        $data['class_id'] = $section_data['class_id'];
		$data['section_id'] = $subject_data['section_id'];
		$data['room_id'] = $room_data['id'];
        $data['subject_id'] = $subject_id;

        $data['title'] = html_escape($this->input->post('title'));
        // $data['class_id'] = html_escape($this->input->post('class_id'));
        // $data['room_id'] = html_escape($this->input->post('room_id'));
        // $data['user_id'] = html_escape($this->input->post('user_id'));
        // $data['section_id'] = html_escape($this->input->post('section_id'));
        // $data['subject_id'] = html_escape($this->input->post('subject_id'));
        $data['description'] = html_escape($this->input->post('description'));
        $data['outcomes'] = html_escape($this->input->post('outcomes'));
        $data['course_overview_provider'] = html_escape($this->input->post('course_overview_provider'));
        $data['course_overview_url'] = html_escape($this->input->post('course_overview_url'));
        $data['last_modified'] = strtotime(date('d M Y'));

        if($_FILES['course_thumbnail']['tmp_name']){
            unlink('uploads/course_thumbnail/'.html_escape($this->input->post('current_thumbnail')));
            $data['thumbnail'] = rand().'.jpg';
            move_uploaded_file($_FILES['course_thumbnail']['tmp_name'], 'uploads/course_thumbnail/'.$data['thumbnail']);
        }

        $this->db->where('id', $course_id);
        $this->db->update('course', $data);

        $history_data['ket'] = 'Update data course '.$course_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
    }

    public function add_course_section($course_id)
    {
        $data['title'] = html_escape($this->input->post('title'));
        $data['course_id'] = $course_id;
        $this->db->insert('course_section', $data);
        $section_id = $this->db->insert_id();

        $history_data['ket'] = 'Insert data course section';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);

        $course_details = $this->get_course_by_id($course_id);
        $previous_sections = json_decode($course_details['section']);

        if (sizeof($previous_sections) > 0) {
            array_push($previous_sections, $section_id);
            $updater['section'] = json_encode($previous_sections);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);

            $history_data['ket'] = 'Update data course '.$course_id.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        } else {
            $previous_sections = array();
            array_push($previous_sections, $section_id);
            $updater['section'] = json_encode($previous_sections);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);

            $history_data['ket'] = 'Update data course '.$course_id.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }
    }

    public function edit_course_section($section_id)
    {
        $data['title'] = html_escape($this->input->post('title'));
        $this->db->where('id', $section_id);
        $this->db->update('course_section', $data);

        $history_data['ket'] = 'Update data course_section '.$section_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
    }

    public function add_lesson(){
        $data['course_id'] = html_escape($this->input->post('course_id'));
        $data['title'] = html_escape($this->input->post('title'));
        $data['section_id'] = html_escape($this->input->post('section_id'));

        $lesson_type_array = explode('-', html_escape($this->input->post('lesson_type')));
        $lesson_type = $lesson_type_array[0];

        $data['attachment_type'] = $lesson_type_array[1];
        $data['lesson_type'] = $lesson_type;

        if ($lesson_type == 'video') {
            // This portion is for web application's video lesson
            $lesson_provider = html_escape($this->input->post('lesson_provider'));
            if ($lesson_provider == 'youtube') {
                if (html_escape($this->input->post('video_url')) == "") {
                    $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url('addons/courses/course_edit/' . $data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('video_url'));

                // $data['duration'] = html_escape($this->input->post('duration'));

                $data['video_type'] = 'youtube';
                
            } elseif ($lesson_provider == 'vimeo') {
                if (html_escape($this->input->post('video_url')) == "") {
                    $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url('addons/courses/course_edit/' . $data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('video_url'));

                // $data['duration'] = html_escape($this->input->post('duration'));

                $data['video_type'] = 'vimeo';

            } elseif ($lesson_provider == 'html5') {
                if (html_escape($this->input->post('html5_video_url')) == "") {
                    $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url('addons/courses/course_edit/' . $data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('html5_video_url'));
                
                // $data['duration'] = html_escape($this->input->post('duration'));

                $data['video_type'] = 'html5';
            } else {
                $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_provider'));
                redirect(site_url('addons/courses/course_edit/' . $data['course_id']), 'refresh');
            }

        } else {
            if ($_FILES['attachment']['name'] == "") {
                $this->session->set_flashdata('error_message', get_phrase('invalid_attachment'));
                redirect(site_url('addons/courses/course_edit/' . $data['course_id']), 'refresh');
            } else {
                $data['duration']   = 0;
                $fileName           = $_FILES['attachment']['name'];
                $tmp                = explode('.', $fileName);
                $fileExtension      = end($tmp);
                $uploadable_file    =  md5(uniqid(rand(), true)) . '.' . $fileExtension;
                $data['attachment'] = $uploadable_file;

                if (!file_exists('uploads/lesson_files')) {
                    mkdir('uploads/lesson_files', 0777, true);
                }
                move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/lesson_files/' . $uploadable_file);
            }
        }

        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = html_escape($this->input->post('summary'));

        $this->db->insert('lesson', $data);
        $inserted_id = $this->db->insert_id();

        $history_data['ket'] = 'Insert data lesson';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);

        if ($_FILES['thumbnail']['name'] != "") {
            if (!file_exists('uploads/thumbnails/lesson_thumbnails')) {
                mkdir('uploads/thumbnails/lesson_thumbnails', 0777, true);
            }
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/thumbnails/lesson_thumbnails/' . $inserted_id . '.jpg');
        }
    }

    public function edit_lesson($lesson_id){
        $previous_data = $this->db->get_where('lesson', array('id' => $lesson_id))->row_array();

        $data['course_id'] = html_escape($this->input->post('course_id'));
        $data['title'] = html_escape($this->input->post('title'));
        $data['section_id'] = html_escape($this->input->post('section_id'));

        $lesson_type_array = explode('-', html_escape($this->input->post('lesson_type')));
        $lesson_type = $lesson_type_array[0];

        $data['attachment_type'] = $lesson_type_array[1];
        $data['lesson_type'] = $lesson_type;
        if ($lesson_type == 'video') {
            $lesson_provider = html_escape($this->input->post('lesson_provider'));
            if ($lesson_provider == 'youtube' || $lesson_provider == 'vimeo') {
                if (html_escape($this->input->post('video_url')) == "" || html_escape($this->input->post('duration')) == "") {
                    $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url(strtolower($this->session->userdata('role')) . '/course_form/course_edit/' . $data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('video_url'));

                $duration_formatter = explode(':', html_escape($this->input->post('duration')));
                $hour = sprintf('%02d', $duration_formatter[0]);
                $min = sprintf('%02d', $duration_formatter[1]);
                $sec = sprintf('%02d', $duration_formatter[2]);
                $data['duration'] = $hour . ':' . $min . ':' . $sec;

                $video_details = $this->video_model->getVideoDetails($data['video_url']);
                $data['video_type'] = $video_details['provider'];
            } elseif ($lesson_provider == 'html5') {
                if (html_escape($this->input->post('html5_video_url')) == "" || html_escape($this->input->post('html5_duration')) == "") {
                    $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url(strtolower($this->session->userdata('role')) . '/course_form/course_edit/' . $data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('html5_video_url'));

                $duration_formatter = explode(':', html_escape($this->input->post('html5_duration')));
                $hour = sprintf('%02d', $duration_formatter[0]);
                $min = sprintf('%02d', $duration_formatter[1]);
                $sec = sprintf('%02d', $duration_formatter[2]);
                $data['duration'] = $hour . ':' . $min . ':' . $sec;
                $data['video_type'] = 'html5';

                if ($_FILES['thumbnail']['name'] != "") {
                    if (!file_exists('uploads/thumbnails/lesson_thumbnails')) {
                        mkdir('uploads/thumbnails/lesson_thumbnails', 0777, true);
                    }
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/thumbnails/lesson_thumbnails/' . $lesson_id . '.jpg');
                }
            } else {
                $this->session->set_flashdata('error_message', get_phrase('invalid_lesson_provider'));
                redirect(site_url(strtolower($this->session->userdata('role')) . '/course_form/course_edit/' . $data['course_id']), 'refresh');
            }
            $data['attachment'] = "";

        } else {
            if ($_FILES['attachment']['name'] != "") {
                // unlinking previous attachments
                if ($previous_data['attachment'] != "") {
                    unlink('uploads/lesson_files/' . $previous_data['attachment']);
                }

                $fileName           = $_FILES['attachment']['name'];
                $tmp                = explode('.', $fileName);
                $fileExtension      = end($tmp);
                $uploadable_file    =  md5(uniqid(rand(), true)) . '.' . $fileExtension;
                $data['attachment'] = $uploadable_file;
                $data['video_type'] = "";
                $data['duration'] = "";
                $data['video_url'] = "";
                if (!file_exists('uploads/lesson_files')) {
                    mkdir('uploads/lesson_files', 0777, true);
                }
                move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/lesson_files/' . $uploadable_file);
            }
        }

        $data['last_modified'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = html_escape($this->input->post('summary'));

        $this->db->where('id', $lesson_id);
        $this->db->update('lesson', $data);

        $history_data['ket'] = 'Update data lesson '.$lesson_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
    }

    public function delete_lesson($lesson_id){

		$history_data['ket'] = 'Delete data delete_lesson '.$lesson_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

        $this->db->where('id', $lesson_id);
        $this->db->delete('lesson');
        $response = array(
            'status' => true,
            'notification' => get_phrase('lesson_deleted_successfully')
        );
        return json_encode($response);
    }

    // Adding quiz functionalities
    public function add_quiz($course_id = ""){
        $data['course_id'] = $course_id;
        $data['title'] = html_escape($this->input->post('title'));
        $data['section_id'] = html_escape($this->input->post('section_id'));

        $data['lesson_type'] = 'quiz';
        $data['duration'] = 0;
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = html_escape($this->input->post('summary'));
        $this->db->insert('lesson', $data);

        $history_data['ket'] = 'Insert data lesson';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
    }

    // updating quiz functionalities
    public function edit_quiz($lesson_id = ""){
        $data['title'] = html_escape($this->input->post('title'));
        $data['section_id'] = html_escape($this->input->post('section_id'));
        $data['last_modified'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = html_escape($this->input->post('summary'));
        $this->db->where('id', $lesson_id);
        $this->db->update('lesson', $data);

        $history_data['ket'] = 'Update data lesson '.$lesson_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
    }

    public function delete_course_section($course_id, $section_id){

		$history_data['ket'] = 'Delete data delete_course_section '.$course_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

        $this->db->where('id', $section_id);
        $this->db->delete('course_section');

        $this->db->where('course_id', $course_id);
        $this->db->where('section_id', $section_id);
        $this->db->delete('lesson');

        $course_details = $this->get_course_by_id($course_id);
        $previous_sections = json_decode($course_details['section']);

        if (sizeof($previous_sections) > 0) {
            $new_section = array();
            for ($i = 0; $i < sizeof($previous_sections); $i++) {
                if ($previous_sections[$i] != $section_id) {
                    array_push($new_section, $previous_sections[$i]);
                }
            }
            $updater['section'] = json_encode($new_section);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);

            $history_data['ket'] = 'Update data course '.$course_id.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }
        $response = array(
            'status' => true,
            'notification' => get_phrase('course_section_deleted_successfully')
        );
        return json_encode($response);
    }

    public function sort_section($section_json){
        $sections = json_decode($section_json);
        foreach ($sections as $key => $value) {
            $updater = array(
                'orders' => $key + 1
            );
            $this->db->where('id', $value);
            $this->db->update('course_section', $updater);

            $history_data['ket'] = 'Update data course_section '.$value.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }
    }

    public function sort_lesson($lesson_json){
        $lessons = json_decode($lesson_json);
        foreach ($lessons as $key => $value) {
            $updater = array(
                'order' => $key + 1
            );
            $this->db->where('id', $value);
            $this->db->update('lesson', $updater);

            $history_data['ket'] = 'Update data lesson '.$value.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }
    }

    public function get_quiz_questions($quiz_id){
        $this->db->order_by("order", "asc");
        $this->db->where('quiz_id', $quiz_id);
        return $this->db->get('question');
    }

    public function sort_question($question_json){
        $questions = json_decode($question_json);
        foreach ($questions as $key => $value) {
            $updater = array(
                'order' => $key + 1
            );
            $this->db->where('id', $value);
            $this->db->update('question', $updater);

            $history_data['ket'] = 'Update data question '.$value.'';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);
        }
    }
    // Add Quiz Questions
    public function add_quiz_questions($quiz_id){
        $question_type = html_escape($this->input->post('question_type'));
        if ($question_type == 'mcq') {
            $response = $this->add_multiple_choice_question($quiz_id);
            return $response;
        }
    }
    // multiple_choice_question crud functions
    public function add_multiple_choice_question($quiz_id){
        if (sizeof(html_escape($this->input->post('options'))) != html_escape($this->input->post('number_of_options'))) {
            return false;
        }
        foreach (html_escape($this->input->post('options')) as $option) {
            if ($option == "") {
                return false;
            }
        }
        if (sizeof(html_escape($this->input->post('correct_answers'))) == 0) {
            $correct_answers = [""];
        } else {
            $correct_answers = html_escape($this->input->post('correct_answers'));
        }
        $data['quiz_id']            = $quiz_id;
        $data['title']              = html_escape($this->input->post('title'));
        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
        $data['type']               = 'multiple_choice';
        $data['options']            = json_encode(html_escape($this->input->post('options')));
        $data['correct_answers']    = json_encode($correct_answers);
        $this->db->insert('question', $data);

        $history_data['ket'] = 'Insert data question';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
        return true;
    }
    public function update_quiz_questions($question_id){
        $question_type = html_escape($this->input->post('question_type'));
        if ($question_type == 'mcq') {
            $response = $this->update_multiple_choice_question($question_id);
            return $response;
        }
    }
    // update multiple choice question
    public function update_multiple_choice_question($question_id){

        if (sizeof(html_escape($this->input->post('options'))) != html_escape($this->input->post('number_of_options'))) {
            return false;
        }
        foreach (html_escape($this->input->post('options')) as $option) {
            if ($option == "") {
                return false;
            }
        }

        if (sizeof(html_escape($this->input->post('correct_answers'))) == 0) {
            $correct_answers = [""];
        } else {
            $correct_answers = html_escape($this->input->post('correct_answers'));
        }

        $data['title']              = html_escape($this->input->post('title'));
        $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
        $data['type']               = 'multiple_choice';
        $data['options']            = json_encode(html_escape($this->input->post('options')));
        $data['correct_answers']    = json_encode($correct_answers);
        $this->db->where('id', $question_id);
        $this->db->update('question', $data);

        $history_data['ket'] = 'Update data question '.$question_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);

        return true;
    }
    public function delete_quiz_question($question_id){

		$history_data['ket'] = 'Delete data delete_quiz_question '.$question_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

        $this->db->where('id', $question_id);
        $this->db->delete('question');
        $response = array(
            'status' => true,
            'notification' => get_phrase('quiz_questions_deleted_successfully')
        );
        return json_encode($response);
    }
    public function get_quiz_question_by_id($question_id){
        $this->db->order_by("order", "asc");
        $this->db->where('id', $question_id);
        return $this->db->get('question');
    }

    // code of mark this lesson as completed
    function save_course_progress(){
        $lesson_id = html_escape($this->input->post('lesson_id'));
        $progress = html_escape($this->input->post('progress'));
        $user_id   = html_escape($this->session->userdata('user_id'));
        $user_details  = $this->user_model->get_all_users($user_id)->row_array();
        $watch_history = $user_details['watch_history'];
        $watch_history_array = array();
        if ($watch_history == '') {
            array_push($watch_history_array, array('lesson_id' => $lesson_id, 'progress' => $progress));
        } else {
            $founder = false;
            $watch_history_array = json_decode($watch_history, true);
            for ($i = 0; $i < count($watch_history_array); $i++) {
                $watch_history_for_each_lesson = $watch_history_array[$i];
                if ($watch_history_for_each_lesson['lesson_id'] == $lesson_id) {
                    $watch_history_for_each_lesson['progress'] = $progress;
                    $watch_history_array[$i]['progress'] = $progress;
                    $founder = true;
                }
            }
            if (!$founder) {
                array_push($watch_history_array, array('lesson_id' => $lesson_id, 'progress' => $progress));
            }
        }
        $data['watch_history'] = json_encode($watch_history_array);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);

        $history_data['ket'] = 'Update data users '.$user_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);

        return $progress;
    }

    public function get_class_id_by_user($user_id = ""){
        if($user_id == ""){
            $user_id = $this->session->userdata('user_id');
        }
        $student_id = $this->db->get_where('students', array('user_id' => $user_id))->row('id');
        return $class_id = $this->db->get_where('enrols', array('student_id' => $student_id, 'school_id' => school_id(), 'session' => active_session()))->row('class_id');
    }

}