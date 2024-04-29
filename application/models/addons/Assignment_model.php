<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addon
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com
*/

class Assignment_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_assignments($id = ""){
		if($id > 0){
			$this->db->where('id', $id);
		}
		return $this->db->get('assignments');
	}
	public function create_assignment(){
		$user_id = $this->session->userdata('user_id');
		$subject_id = htmlspecialchars($this->input->post('subject_id'));
		$subject_data =  $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
		$section_data =  $this->db->get_where('sections', array('id' => $subject_data['section_id']))->row_array();
		$room_data =  $this->db->get_where('class_rooms', array('section_id' => $subject_data['section_id']))->row_array();
		$question_type_one = htmlspecialchars($this->input->post('question_type_one'));
		$question_total_one = htmlspecialchars($this->input->post('question_total_one'));

		$question_type_two = htmlspecialchars($this->input->post('question_type_two'));
		$question_total_two = htmlspecialchars($this->input->post('question_total_two'));

		$question_type_tree = htmlspecialchars($this->input->post('question_type_tree'));
		$question_total_tree = htmlspecialchars($this->input->post('question_total_tree'));


		$data['assignment_types_id'] = htmlspecialchars($this->input->post('assignment_types_id'));
		$data['class_id'] = $section_data['class_id'];
		$data['section_id'] = $subject_data['section_id'];
		$data['room_id'] = $room_data['id'];
		if(empty($data['room_id'])){
			$data['room_id'] = '0';
		}
		$data['subject_id'] = $subject_id;
		$data['course_id'] = htmlspecialchars($this->input->post('course_id'));
		if(empty($data['course_id'])){
			$data['course_id'] = '0';
		}
		$data['deadline'] = htmlspecialchars(strtotime($this->input->post('deadline')));
		$data['teacher_id'] = $user_id;
		$data['school_id'] = school_id();
		$data['session_id'] = active_session();
		$data['status'] = 0;
		$data['date_added'] = strtotime(date('d M Y'));

		$this->db->insert('assignments', $data);
		$assign_id = $this->db->insert_id();

		$history_data['ket'] = 'Insert data assignments';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('assignment_id', $assign_id);
		$this->db->order_by('num', 'desc');
		$this->db->limit(1);
		$assignment_questions = $this->db->get('assignment_questions')->result_array();
		if (!empty($assignment_questions)) {
			$num = $assignment_questions['num'] + 1;
		} else {
			$num =1;
		}

			for($a = 1; $a <= $question_total_one; $a++){
				$data = array(
					'assignment_id' => $assign_id,
					'num' => $num++,
					'question_type' => $question_type_one,
					'date_added' => strtotime(date('d M Y'))
				);
				$this->db->insert('assignment_questions', $data);

				$history_data['ket'] = 'Insert data enrols';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
				
			}

			for($b=1; $b <= $question_total_two; $b++){
				$data = array(
					'assignment_id' => $assign_id,
					'num' => $num++,
					'question_type' => $question_type_two,
					'date_added' => strtotime(date('d M Y'))
				);
				$this->db->insert('assignment_questions', $data);

				$history_data['ket'] = 'Insert data assignment questions';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}

			for($c=1; $c <= $question_total_tree; $c++){
				$data = array(
					'assignment_id' => $assign_id,
					'num' => $num++,
					'question_type' => $question_type_tree,
					'date_added' => strtotime(date('d M Y'))
				);
				$this->db->insert('assignment_questions', $data);

				$history_data['ket'] = 'Insert data assignment questions';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}

		$response = array(
			'status' => true,
			'notification' => get_phrase('assignment_added_successfully')
		);
		return json_encode($response);
	}

	public function update_assignment($id = ""){
		$subject_id = htmlspecialchars($this->input->post('subject_id'));
		$subject_data =  $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
		$section_data =  $this->db->get_where('sections', array('id' => $subject_data['section_id']))->row_array();
		$room_data =  $this->db->get_where('class_rooms', array('section_id' => $subject_data['section_id']))->row_array();
		
		$data['assignment_types_id'] = htmlspecialchars($this->input->post('assignment_types_id'));
		// $data['class_id'] = htmlspecialchars($this->input->post('class_id'));
		// $data['section_id'] = htmlspecialchars($this->input->post('section_id'));
		// $data['room_id'] = htmlspecialchars($this->input->post('room_id'));
		// $data['subject_id'] = htmlspecialchars($this->input->post('subject_id'));
		$data['class_id'] = $section_data['class_id'];
		$data['section_id'] = $subject_data['section_id'];
		$data['room_id'] = $room_data['id'];
		if(empty($data['room_id'])){
			$data['room_id'] = '0';
		}
		$data['subject_id'] = $subject_id;
		$data['course_id'] = htmlspecialchars($this->input->post('course_id'));
		$data['deadline'] = htmlspecialchars(strtotime($this->input->post('deadline')));
		$this->db->where('id', $id);
		$this->db->update('assignments', $data);

		$history_data['ket'] = 'Update data assignments '.$id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('assignment_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_assignment($id = ""){
		$this->db->where('id', $id);
		$this->db->delete('assignments');

		$history_data['ket'] = 'Delete data assignments '.$id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('assignment_deleted_successfully')
		);
		return json_encode($response);
	}

	public function mark_null($id = ""){
		$this->db->where('mark', NULL);
		$this->db->where('assignment_id', $id);
		return $this->db->get('assignment_questions')->num_rows();
	}

	public function mark_not_null($id = ""){
		$this->db->where('mark !=', NULL);
		$this->db->where('assignment_id', $id);
		return $this->db->get('assignment_questions')->num_rows();
	}

	public function assignment_publish($id = ""){
		$this->db->where('mark', NULL);
		$this->db->where('assignment_id', $id);
		$mark_null = $this->db->get('assignment_questions')->num_rows();

		$this->db->where('mark !=', NULL);
		$this->db->where('assignment_id', $id);
		$mark_not_null = $this->db->get('assignment_questions')->num_rows();

		if($mark_null > 0){
			$response = array(
				'status' => false,
				'notification' => get_phrase('incomplete_mark_value')
			);
			return json_encode($response);

		}else {
			$data['status'] = 1;
			$this->db->where('id', $id);
			$this->db->update('assignments', $data);

			$history_data['ket'] = 'Update data assignments '.$id.'';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('the_assignment_has_been_published_successfully')
			);
			return json_encode($response);
		}

	}

	public function assignment_pending($id = ""){
		$data['status'] = 0;
		$this->db->where('id', $id);
		$this->db->update('assignments', $data);

		$history_data['ket'] = 'Update data assignments '.$id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('assignment_status_updated_successfully')
		);
		return json_encode($response);
	}


	public function get_questions($question_id = ""){
		if($question_id > 0){
			$this->db->where('id', $question_id);
		}
		return $this->db->get('assignment_questions');
	}

	public function get_questions_by_assignment($assignment_id = ""){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('num', 'asc');
		return $this->db->get('assignment_questions');
	}

	public function add_question($assignment_id = ""){
		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('num', 'desc');
		$this->db->limit(1);
		$assignment_questions = $this->db->get('assignment_questions')->result_array();
		if (!empty($assignment_questions)) {
			$num = $assignment_questions[0]['num'] + 1;
		} else {
			$num =1;
		}

		$data = array(
			'assignment_id' => $assignment_id,
			'num' => $num++,
			'date_added' => strtotime(date('d M Y'))
		);
		
		$this->db->insert('assignment_questions', $data);

		$history_data['ket'] = 'Insert data assignment question';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);
	}

	public function create_question($assignment_id = ""){
		// $data['assignment_id'] = $assignment_id;
		// $data['question'] = htmlspecialchars($this->input->post('question'));

		$choices_array = $this->input->post('choices_array');
		$choices = implode(";", $choices_array);

		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('num', 'desc');
		$this->db->limit(1);
		$assignment_questions = $this->db->get('assignment_questions')->result_array();
		if (!empty($assignment_questions)) {
			$num = $assignment_questions[0]['num'] + 1;
		} else {
			$num =1;
		}

		$assignments = $this->db->get_where('assignments', array('id' => $assignment_id))->row_array();
		$teachers = $this->db->get_where('teachers', array('user_id' => $assignments['teacher_id']))->row_array();

		$bank_data = array(
			'subject_id' => $assignments['subject_id'],
			'class_id' => $assignments['class_id'],
			'section_id' => $assignments['section_id'],
			'teacher_id' => $teachers['id'],
			'choices' => $choices,
			'correct_choices' => htmlspecialchars($this->input->post('correct_choices')),
			'question_type' => htmlspecialchars($this->input->post('question_type')),
			'question' => htmlspecialchars($this->input->post('question')),
			'level' => htmlspecialchars($this->input->post('level')),
			'school_id' => school_id(),
			'session_id' => active_session()
		);
		
		$this->db->insert('question_bank', $bank_data);

		$data = array(
			'assignment_id' => $assignment_id,
			'choices' => $choices,
			'num' => $num++,
			'correct_choices' => htmlspecialchars($this->input->post('correct_choices')),
			'mark' => htmlspecialchars($this->input->post('mark')),
			'question_type' => htmlspecialchars($this->input->post('question_type')),
			'question' => htmlspecialchars($this->input->post('question')),
			'level' => htmlspecialchars($this->input->post('level')),
			'date_added' => strtotime(date('d M Y'))
		);
		
		$this->db->insert('assignment_questions', $data);
		$questions_id = $this->db->insert_id();

		$history_data['ket'] = 'Insert data assignment question';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('question_added_successfully')
		);
		return json_encode($response);
	}

	public function add_question_bank($assignment_id = ""){
		// $data['assignment_id'] = $assignment_id;
		$enrolIds = $this->input->post('enrol_ids');

		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('num', 'desc');
		$this->db->limit(1);
		$assignment_questions = $this->db->get('assignment_questions')->result_array();
		if (!empty($assignment_questions)) {
			$num = $assignment_questions[0]['num'] + 1;
		} else {
			$num =1;
		}

		if (empty($enrolIds)) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('please_select_questions')
			);
			return json_encode($response);
		}

		if ($this->input->post('action') == 'submit_question') {
			foreach ($enrolIds as $enrolId) {
				$question_data = $this->db->get_where('question_bank', array('id' => $enrolId))->row_array();
				
				$data['question'] = $question_data['question'];
				$data['level'] = $question_data['level'];
				$data['question_type'] = $question_data['question_type'];
				$data['choices'] = $question_data['choices'];
				$data['correct_choices'] = $question_data['correct_choices'];
				$data['assignment_id'] = $assignment_id;
				$data['num'] = $num++;
				$data['date_added'] = strtotime(date('d M Y'));

				$this->db->insert('assignment_questions', $data);

				$history_data['ket'] = 'Insert data assignment question';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('question_added_successfully')
			);
		} else {

		}

		return json_encode($response);
	}

	public function take_question($bank_id = "", $question_id = ""){
		$questions = $this->db->get_where('assignment_questions', array('id' => $question_id))->row_array();
		$question_bank = $this->db->get_where('question_bank', array('id' => $bank_id))->row_array();
		
		$data = array(
			'choices' => $question_bank['choices'],
			'level' => $question_bank['level'],
			'question' => $question_bank['question'],
			'correct_choices' => $question_bank['correct_choices']
		);

		$this->db->where('id', $question_id);
		$this->db->update('assignment_questions', $data);

		$history_data['ket'] = 'Update data assignment_questions '.$question_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);
	}

	public function excel_question($assignment_id = "") {

		$this->db->where('assignment_id', $assignment_id);
		$this->db->order_by('num', 'desc');
		$this->db->limit(1);
		$assignment_questions = $this->db->get('assignment_questions')->result_array();
		if (!empty($assignment_questions)) {
			$num = $assignment_questions[0]['num'] + 1;
		} else {
			$num =1;
		}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'],'uploads/csv_file/uploadquestion.csv');

		if (($handle = fopen('uploads/csv_file/uploadquestion.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if($count > 0){

					$question_type = '';
					switch (trim($all_data[1])) {
						case 'pilihan':
							$question_type = 'choices';
							break;
						case 'pilihan ganda':
							$question_type = 'choices';
							break;
						case 'text':
							$question_type = 'text';
							break;
						case 'file':
							$question_type = 'file';
							break;
						default:
							$question_type = 'text';
							break;
					}
					
					$questiondata['question'] = trim($all_data[0]);
					$questiondata['mark'] = trim($all_data[2]);
					$questiondata['choices'] = trim($all_data[3]);
					$questiondata['correct_choices'] = trim($all_data[4]);
					$questiondata['level'] = trim($all_data[5]);
					$questiondata['question_type'] = $question_type;
					$questiondata['date_added'] = strtotime(date('d M Y'));
					$questiondata['assignment_id'] = $assignment_id;
					$questiondata['num'] = $num++;

					$this->db->insert('assignment_questions', $questiondata);

					$history_data['ket'] = 'Insert data assignment question';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					$assignments = $this->db->get_where('assignments', array('id' => $assignment_id))->row_array();
					$teachers = $this->db->get_where('teachers', array('user_id' => $assignments['teacher_id']))->row_array();

					$bank_data = array(
						'subject_id' => $assignments['subject_id'],
						'class_id' => $assignments['class_id'],
						'section_id' => $assignments['section_id'],
						'teacher_id' => $teachers['id'],
						'choices' => $questiondata['choices'],
						'correct_choices' => $questiondata['correct_choices'],
						'question_type' => $questiondata['question_type'],
						'question' => $questiondata['question'],
						'level' => $questiondata['level'],
						'school_id' => school_id(),
						'session_id' => active_session()
					);
					
					$this->db->insert('question_bank', $bank_data);

					$history_data['ket'] = 'Insert data question bank';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
				$count++;
			}
				fclose($handle);
			}
			if ($duplication_counter > 0) {
				$response = array(
					'status' => true,
					'notification' => get_phrase('data sudah ada')
				);
			}else{
				$response = array(
					'status' => true,
					'notification' => get_phrase('added_successfully')
				);
			}
	
			return json_encode($response);
		}


	public function update_question($question_id = ""){
		$question = htmlspecialchars($this->input->post('question'));
		$choices_array = $this->input->post('choices_array');
		$choices = implode(";", $choices_array);

		$assignment_question = $this->db->get_where('assignment_questions', array('id' => $question_id))->row_array();
		$assignments = $this->db->get_where('assignments', array('id' => $assignment_question['assignment_id']))->row_array();
		$teachers = $this->db->get_where('teachers', array('user_id' => $assignments['teacher_id']))->row_array();

		$check_data = $this->db->get_where('question_bank', array('question' => $question,'subject_id' => $assignments['subject_id'], 'question_type' => $this->input->post('question_type'), 'class_id' => $assignments['class_id'], 'section_id' => $assignments['section_id']));
		if($check_data->num_rows() > 0){
			
		}else{
			$bank_data = array(
				'subject_id' => $assignments['subject_id'],
				'class_id' => $assignments['class_id'],
				'section_id' => $assignments['section_id'],
				'teacher_id' => $teachers['id'],
				'choices' => $choices,
				'question_type' => htmlspecialchars($this->input->post('question_type')),
				'question' => htmlspecialchars($this->input->post('question')),
				'correct_choices' => htmlspecialchars($this->input->post('correct_choices')),
				'level' => htmlspecialchars($this->input->post('level')),
				'school_id' => school_id(),
				'session_id' => active_session()
			);
			
			$this->db->insert('question_bank', $bank_data);

			$history_data['ket'] = 'Insert data question bank';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$data = array(
			'choices' => $choices,
			'mark' => htmlspecialchars($this->input->post('mark')),
			'question_type' => htmlspecialchars($this->input->post('question_type')),
			'question' => htmlspecialchars($this->input->post('question')),
			'level' => htmlspecialchars($this->input->post('level')),
			'correct_choices' => $this->input->post('correct_choices')
		);

		$this->db->where('id', $question_id);
		$this->db->update('assignment_questions', $data);

		$history_data['ket'] = 'Update data assignment_questions '.$question_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('question_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_question($question_id = ""){
		$this->db->where('id', $question_id);
		$this->db->delete('assignment_questions');

		$history_data['ket'] = 'Delete data assignment_questions '.$question_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('question_deleted_successfully')
		);
		return json_encode($response);
	}

	function save_obtained_mark($answer_id = ""){
		$obtained_mark = htmlspecialchars($this->input->post('obtained_mark'));
		$this->db->where('id', $answer_id);
		$this->db->update('assignment_answers', array('obtained_mark' => $obtained_mark));

		$history_data['ket'] = 'Update data assignment_answers '.$answer_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$answer_details = $this->db->get_where('assignment_answers', array('id' => $answer_id))->row_array();

		$this->db->select_sum('obtained_mark');
        $this->db->where('assignment_id', $answer_details['assignment_id']);
		$this->db->where('student_id', $answer_details['student_id']);
        $this->db->where('status', 1);
        $student_answers = $this->db->get('assignment_answers');
        $student_obtained_marks = $student_answers->row('obtained_mark');
        if($student_obtained_marks > 0){
            $student_obtained_marks;
        }else{
            $student_obtained_marks = 0;
        }
		$response = array(
			'status' => true,
			'message' => get_phrase('obtained_mark_provided_successfully'),
			'student_obtained_marks' => $student_obtained_marks
		);
		return json_encode($response);
	}

	public function submit_mark($assignment_id = "", $student_id = ""){

		$this->db->where('assignment_id', $assignment_id);
		$this->db->update('assignment_answers', array('mark' => 1));

		$history_data['ket'] = 'Update data assignment_answers '.$assignment_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->select_sum('obtained_mark');
		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('student_id', $student_id);
		$this->db->where('mark', 1);
		$student_answers = $this->db->get('assignment_answers');
		$data_mark = $student_answers->row('obtained_mark');

		$data = array(
			'assignment_id' => $assignment_id,
			'student_id' => $student_id,
			'total_mark' => $data_mark,
			'school_id' => school_id()
		);
		$check_data = $this->db->get_where('assignment_remarks', array('assignment_id' => $assignment_id,'student_id' => $student_id));
		if($check_data->num_rows() > 0){
		
			$this->db->where('assignment_id', $assignment_id);
			$this->db->update('assignment_remarks', $data);

			$history_data['ket'] = 'Update data assignment_answers '.$assignment_id.'';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

		}else{

			$this->db->insert('assignment_remarks', $data);

			$history_data['ket'] = 'Insert data assignment remarks';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

		}
	}





//-----------------STUDENT------------------//
	public function get_student_assignments($class_id = "", $section_id = "", $deadline = ""){
		if($deadline == 'active'){
			$this->db->where('deadline >=', strtotime(date('m/d/Y')));
		}else{
			$this->db->where('deadline <', strtotime(date('m/d/Y')));
		}
		$this->db->where('status', 1);
		$this->db->where('class_id', $class_id);
		$this->db->where('section_id', $section_id);
		$this->db->where('school_id', school_id());
		return $this->db->get('assignments');
	}

	public function get_student_assignment_by_filter($class_id = "", $section_id = "", $deadline = ""){
		$subject_id = htmlspecialchars($this->input->post('subject_id'));
		$teacher_id = htmlspecialchars($this->input->post('teacher_id'));

		if($deadline == 'active'){
			$this->db->where('deadline >=', strtotime(date('m/d/Y')));
		}else{
			$this->db->where('deadline <', strtotime(date('m/d/Y')));
		}
		if($subject_id != 'all'){
			$this->db->where('subject_id', $subject_id);
		}
		if($teacher_id != 'all'){
			$this->db->where('teacher_id', $teacher_id);
		}
		$this->db->where('status', 1);
		$this->db->where('class_id', $class_id);
		$this->db->where('section_id', $section_id);
		$this->db->where('school_id', school_id());
		return $this->db->get('assignments');
	}

	public function save_answers($question_id = "", $assignment_id = ""){
		$error_message = null;
		$student_id = $this->session->userdata('user_id');
		$question_type = $this->get_questions($question_id)->row('question_type');
		$mark = $this->get_questions($question_id)->row('mark');
		$correct_choice = $this->get_questions($question_id)->row('correct_choices');
		$question_answer = $this->db->get_where('assignment_answers', array('question_id' => $question_id, 'student_id' => $student_id));


		if($question_type == 'file'){
			if(!empty($_FILES['question_answer']['name'])){
				$file_extension = pathinfo($_FILES['question_answer']['name'], PATHINFO_EXTENSION);
				$data['answer'] = md5(rand(10000000, 20000000)).'.'.$file_extension;
	            move_uploaded_file($_FILES['question_answer']['tmp_name'], 'uploads/assignment_files/' . $data['answer']);
            }else{
            	$error_message = get_phrase('first_choose_a_file');
            }
		}elseif($question_type == 'text'){
			if(!empty(htmlspecialchars($this->input->post('question_answer')))){
				$data['answer'] = htmlspecialchars($this->input->post('question_answer'));
			}else{
				$error_message = get_phrase('first_write_your_answer');
			}
		}elseif($question_type == 'choices'){
			if(!empty($this->input->post('question_answer'))){
				$data['answer'] = $this->input->post('question_answer'); 
				if ($data['answer'] == $correct_choice) {
					$data['obtained_mark'] = $mark;
				} else {
					$data['obtained_mark'] = 0;
				}
			}else{
				$error_message = get_phrase('first_write_your_answer');
			}
		}

		// $data['obtained_mark'] = $mark;
		$data['date_updated'] = strtotime(date('d M Y'));
		$data['answer_type'] = $question_type;

		if($question_answer->num_rows() > 0 && $error_message == null){
			$previews_uploaded_file = 'uploads/assignment_files/'.$question_answer->row('answer');
			if(file_exists($previews_uploaded_file)){
				unlink($previews_uploaded_file);
			}
			$this->db->where('question_id', $question_id);
			$this->db->update('assignment_answers', $data);

			$history_data['ket'] = 'Update data assignment_answers '.$question_id.'';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response['status'] = true;
			$response['message'] = get_phrase('your_answer_has_been_saved');
		}elseif($error_message == null){
			$data['status'] = 0;
			$data['assignment_id'] = $assignment_id;
			$data['question_id'] = $question_id;
			$data['student_id'] = $student_id;
			$this->db->insert('assignment_answers', $data);

			$history_data['ket'] = 'Insert data assignment answers';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response['status'] = true;
			$response['message'] = get_phrase('your_answer_has_been_saved');
		}else{
			$response['status'] = false;
			$response['message'] = $error_message;
		}
			
		return json_encode($response);
	}

	public function submit_assignment($assignment_id = ""){
		$student_id = $this->session->userdata('user_id');

		$this->db->where('assignment_id', $assignment_id);
		$this->db->where('student_id', $student_id);
		$this->db->update('assignment_answers', array('status' => 1));

		$history_data['ket'] = 'Update data assignment_answers '.$assignment_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);
	}
//-----------------STUDENT END------------------//
}