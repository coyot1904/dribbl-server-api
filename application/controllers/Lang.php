<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
    $this->load->helper('language');
		$this->load->model('general_model');
	}
	//----------------------------------
  function index()
  {
		$lang = $this->general_model->get_lang();
    $this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("login_1"),
			'2'	=> $this->lang->line("login_2"),
			'3'	=> $this->lang->line("login_3"),
			'4'	=> $this->lang->line("login_4"),
			'5'	=> $this->lang->line("login_5"),
		);
    echo json_encode($data);
		die();
  }
  //----------------------------------
	function password()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("password_1"),
			'2'	=> $this->lang->line("password_2"),
			'3'	=> $this->lang->line("password_3"),
			'4'	=> $this->lang->line("password_4"),
			'5'	=> $this->lang->line("password_5"),
			'6'	=> $this->lang->line("password_6"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function splash()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("splash_1"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function home()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("home_1"),
			'2' => $this->lang->line("home_2"),
			'3' => $this->lang->line("home_3"),
			'4' => $this->lang->line("home_4"),
			'5' => $this->lang->line("home_5"),
			'6' => $this->lang->line("home_6"),
			'7' => $this->lang->line("home_7"),
			'8' => $this->lang->line("home_8"),
			'9' => $this->lang->line("home_9"),
			'10' => $this->lang->line("home_10"),
			'11' => $this->lang->line("home_11"),
			'12' => $this->lang->line("home_12"),
			'13' => $this->lang->line("play_1"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function profile()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("profile_1"),
			'2' => $this->lang->line("profile_2"),
			'3' => $this->lang->line("profile_3"),
			'4' => $this->lang->line("profile_4"),
			'5' => $this->lang->line("profile_5"),
			'6' => $this->lang->line("home_6"),
			'7' => $this->lang->line("home_1"),
			'8' => $this->lang->line("profile_6"),
			'9' => $this->lang->line("profile_7"),
			'10' => $this->lang->line("profile_8"),
			'11' => $this->lang->line("profile_9"),
			'12' => $this->lang->line("profile_10"),
			'13' => $this->lang->line("profile_11"),
			'14' => $this->lang->line("profile_12"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function setting()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("setting_1"),
			'2' => $this->lang->line("setting_2"),
			'3' => $this->lang->line("setting_3"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function shop()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("shop_1"),
			'2' => $this->lang->line("shop_2"),
			'3' => $this->lang->line("shop_3"),
			'4' => $this->lang->line("shop_4"),
			'5' => $this->lang->line("shop_5"),
			'6' => $this->lang->line("shop_6"),
			'7' => $this->lang->line("shop_7"),
			'8' => $this->lang->line("shop_8"),
			'9' => $this->lang->line("shop_9"),
			'10' => $this->lang->line("shop_10"),
			'11' => $this->lang->line("shop_11"),
			'12' => $this->lang->line("shop_12"),
			'13' => $this->lang->line("shop_13"),
			'14' => $this->lang->line("shop_14"),
			'15' => $this->lang->line("shop_15"),
			'16' => $this->lang->line("shop_16"),
			'17' => $this->lang->line("shop_17"),
			'18' => $this->lang->line("shop_18"),
			'19' => $this->lang->line("shop_19"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function play()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("play_1"),
			'2' => $this->lang->line("play_2"),
			'3' => $this->lang->line("play_3"),
			'4' => $this->lang->line("play_4"),
			'5' => $this->lang->line("play_5"),
			'6' => $this->lang->line("play_6"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function friends()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("friends_1"),
			'2' => $this->lang->line("friends_2"),
			'3' => $this->lang->line("friends_3"),
			'4' => $this->lang->line("friends_4"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function support()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("support_1"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function edit_pofile()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("edit_1"),
			'2' => $this->lang->line("edit_2"),
			'3' => $this->lang->line("edit_3"),
			'4' => $this->lang->line("edit_4"),
			'5' => $this->lang->line("edit_5"),
			'6' => $this->lang->line("edit_6"),
			'7' => $this->lang->line("edit_7"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function send_message()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("send_1"),
			'2' => $this->lang->line("send_2"),
			'3' => $this->lang->line("send_3"),
			'4' => $this->lang->line("send_4"),
			'5' => $this->lang->line("send_5"),
			'6' => $this->lang->line("send_6"),
			'7' => $this->lang->line("send_7"),
			'8' => $this->lang->line("send_8"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function wallet()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("wallet_1"),
			'2' => $this->lang->line("wallet_2"),
			'3' => $this->lang->line("wallet_3"),
			'4' => $this->lang->line("wallet_4"),
			'5' => $this->lang->line("wallet_5"),
			'6' => $this->lang->line("wallet_6"),
			'7' => $this->lang->line("wallet_7"),
			'8' => $this->lang->line("shop_13"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function leader()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("leader_1"),
			'2' => $this->lang->line("leader_2"),
			'3' => $this->lang->line("leader_3"),
			'4' => $this->lang->line("leader_4"),
			'5' => $this->lang->line("leader_5"),
			'6' => $this->lang->line("leader_6"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function category()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("category_1"),
			'2' => $this->lang->line("category_2"),
			'3' => $this->lang->line("category_3"),
			'4' => $this->lang->line("play_1"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function round()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("round_1"),
			'2' => $this->lang->line("round_2"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
	function game()
	{
		$lang = $this->general_model->get_lang();
		$this->lang->load('general',$lang);
		$data = array(
			'1' => $this->lang->line("game_1"),
			'2' => $this->lang->line("game_2"),
			'3' => $this->lang->line("home_6"),
		);
		echo json_encode($data);
		die();
	}
	//----------------------------------
}
?>
