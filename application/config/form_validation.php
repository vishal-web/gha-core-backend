<?php
	$custom_err_message = [
		'greater_than' => '%s must be greater than 0',
		'required' => '%s feild is required.'
	];

	$config = [
		'admin_user_create' => [
			[
				'field' => 'firstname',
				'label' => 'firstname',
				'rules' => 'required|trim',
			],
			[
				'field' => 'lastname',
				'label' => 'lastname',
				'rules' => 'required|trim',
			],
			[
				'field' => 'profession',
				'label' => 'profession',
				'rules' => 'required|trim',
			],
			[
				'field' => 'email',
				'label' => 'email',
				'rules' => 'required|trim|valid_email|callback_check_email_exists',
			],
			[
				'field' => 'phone',
				'label' => 'phone',
				'rules' => 'required|trim',
			],
			[
				'field' => 'city',
				'label' => 'city',
				'rules' => 'required|trim',
			],
			[
				'field' => 'state',
				'label' => 'state',
				'rules' => 'required|trim',
			],
			[
				'field' => 'country',
				'label' => 'country',
				'rules' => 'required|trim',
			],
		],
		'admin_category_create' => [
			[
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim'
			],
			[
				'field' => 'description',
				'label' => 'Price',
				'rules' => 'trim'
			],
		],
		'admin_course_create' => [
			[
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim',
				'errors' => $custom_err_message,
			],
			[
				'field' => 'price',
				'label' => 'Price',
				'rules' => 'required|trim',
				'errors' => $custom_err_message,
			],
			[
				'field' => 'duration',
				'label' => 'Duration',
				'rules' => 'required|trim',
				'errors' => $custom_err_message,
			],
			[
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'required|trim',
				'errors' => $custom_err_message,
			]
		],	
		'admin_homepage_create' => [
			[
				'field' => 'course_id',
				'label' => 'Course',
				'rules' => 'required|trim',
				'errors' => array('required' => 'Please select a course')
			],
			[
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'required|trim',
 			],
		],
		'admin_homepage_banner' => [
			[
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'required|trim',
 			],
		],
		'admin_question_create' => [
			[
				'field' => 'question_title',
				'label' => 'Question title',
				'rules' => 'required|trim',
 			],
			[
				'field' => 'course_id',
				'label' => 'Course',
				'rules' => 'required|trim',
				'errors' => array('required' => 'Please select a course')
 			],
 			/*[
 				'field' => 'is_multiple_choice',
 				'label' => 'Question type',
 				'rules' => 'required|trim'
 			]*/
		],
		'admin_studymaterial_create' => [
			[
				'field' => 'material_type',
				'label' => 'Material type',
				'rules' => 'required|trim',
 			],
			[
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'required|trim',
 			],
			[
				'field' => 'course_id',
				'label' => 'Course',
				'rules' => 'required|trim|callback_donot_change_course',
				'errors' => array('required' => 'Please select a course')
 			],
 			/*[
 				'field' => 'is_multiple_choice',
 				'label' => 'Question type',
 				'rules' => 'required|trim'
 			]*/
		],
		'admin_exam_create' => [
			[
				'field' => 'title',
				'label' => 'Title',
				'rules' => 'required|trim',
			],
			[
				'field' => 'duration',
				'label' => 'Duration',
				'rules' => 'required|trim|is_numeric|greater_than[0]',
				'errors' => $custom_err_message
			],
			[
				'field' => 'duration_type',
				'label' => 'Duration type',
				'rules' => 'required|trim',
			],
			[ 
				'field' => 'each_marks',
				'label' => 'Marks',
				'rules' => 'required|trim|is_numeric|greater_than[0]',
				'errors' => $custom_err_message
			],	
			[ 
				'field' => 'passing_percentage',
				'label' => 'Passing percentage',
				'rules' => 'required|trim|is_numeric|greater_than[0]',
				'errors' => $custom_err_message
			],
			[ 
				'field' => 'course_id',
				'label' => 'Course',
				'rules' => 'required|trim',
			],
			[ 
				'field' => 'total_question',
				'label' => 'Total question',
				'rules' => 'required|trim|is_numeric|greater_than[0]',
				'errors' => $custom_err_message
			],
			[ 
				'field' => 'status',
				'label' => 'Status',
				'rules' => 'required|trim',
			],
		]
	]
?>