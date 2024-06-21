<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

$CI =& get_instance();    //do this only once in this file

$CI->config->load();

$CI->lang->load('config_lang', 'indonesian');
$CI->load->library('session');

if ($CI->session->userdata('semester_aktif') == '1') {
	$config['tahun_ajaran']  = 2;
    $config['semester']      = 1;
}else{
    $config['tahun_ajaran']  = 2;
    $config['semester']      = 2;
}


