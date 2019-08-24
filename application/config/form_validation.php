<?php
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
				'rules' => 'required|trim'
			],
			[
				'field' => 'price',
				'label' => 'Price',
				'rules' => 'required|trim'
			],
			[
				'field' => 'duration',
				'label' => 'Duration',
				'rules' => 'required|trim'
			]
		],
		'admin_question_create' => [
			[
				'field' => 'question_title',
				'label' => 'Question title',
				'rules' => 'required|trim',
 			],
 			/*[
 				'field' => 'is_multiple_choice',
 				'label' => 'Question type',
 				'rules' => 'required|trim'
 			]*/
		],
	]
?>