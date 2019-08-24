<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
$old_get=$_GET;
	if(isset($old_get['id'])){
	unset($old_get['id']);
}
if(isset($old_get['per_page'])){
	unset($old_get['per_page']);
	unset($old_get['p']);
} 
$config=array(
	'case1'=>array(
   'base_url'=>$_SERVER['PHP_SELF'],
   // 'suffix'=> count($_GET) > 0 ? ''.http_build_query($old_get,'',"&") : '',
   'per_page' => 10,
   'full_tag_open' => '<div class="pagination pagination-centered"><ul class="">',
   'full_tag_close' => '</ul></div>',
   'first_tag_open' => '<li>',
   'first_tag_close' => '</li>',
   'prev_link' => '<i class="fa fa-angle-double-left"></i> Previous',
   'prev_tag_open' => '<li class="prev">',
   'prev_tag_close' => '</li>',
   'next_link' => 'Next <i class="fa fa-angle-double-right"></i>',
   'next_tag_open' => '<li>',
   'next_tag_close' => '</li>',
   'last_tag_open' => '<li>',
   'last_tag_close' => '</li>',
   'cur_tag_open' => '<li class="active"><a href="#">',
   'cur_tag_close' => '</a></li>',
   'num_tag_open' => '<li class="paginate_button">',
   'num_tag_close' => '</li>',
   'anchor_class' =>  'class="page-link"'
	),
	'case2'=>array(
   'base_url'=>$_SERVER['PHP_SELF'],
   'per_page' => 10,
   'full_tag_open' => '<nav aria-label="Page navigation example"><ul class="pagination pull-right">',
   'full_tag_close' => '</ul></nav>',
   'first_tag_open' => '<li class="page-item">',
   'first_tag_close' => '</li>',
   'prev_link' => '<i class="fa fa-angle-double-left"></i> Previous',
   'prev_tag_open' => '<li class="page-item">',
   'prev_tag_close' => '</li>',
   'next_link' => 'Next <i class="fa fa-angle-double-right"></i>',
   'next_tag_open' => '<li class="page-item">',
   'next_tag_close' => '</li>',
   'last_tag_open' => '<li class="page-item">',
   'last_tag_close' => '</li>',
   'cur_tag_open' => '<li class="page-item active"><a href="#" >',
   'cur_tag_close' => '</a></li>',
   'num_tag_open' => '<li class="page-item">',
   'num_tag_close' => '</li>',
	 'anchor_class' =>  'class="page-link"'
	),
);
?>
