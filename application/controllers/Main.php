<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ios_model');
	}
	//----------------------------------
  function index()
  {
    $this->load->view('main/index');
  }
  //----------------------------------
	function home($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['user_data'][0]['poistion'] = $this->ios_model->get_user_position($data['user_data'][0]['id']);
		$data['user_data'][0]['all'] = $this->ios_model->get_count_all_user();
		$leage_pos = $this->ios_model->my_leauge($data['user_data'][0]['id']);
		$game = $this->ios_model->user_leauge($data['user_data'][0]['id']);
		$this->ios_model->check_game($data['user_data'][0]['id']);
		$ret = array();
		if($game[0]['level'] == 4)
		{
			$ret['level'] = "لیگ دسته چهارم";
			$ret['rate'] = 4;
		}
		if($game[0]['level'] == 3)
		{
			$ret['level'] = "لیگ دسته سوم";
			$ret['rate'] = 3;
		}
		if($game[0]['level'] == 2)
		{
			$ret['level'] = "لیگ دسته دوم";
			$ret['rate'] = 2;
		}
		if($game[0]['level'] == 1)
		{
			$ret['level'] = "لیگ دسته اول";
			$ret['rate'] = 1;
		}
		$mylevel = $this->ios_model->mylevelInLeauge($data['user_data'][0]['id'] , $game[0]['level']);
		$data['user_data'][0]['mylevel'] = $mylevel;
		$data['user_data'][0]['leageData'] = $ret;
		$mypos = 0;
		for($i=0;$i<count($leage_pos);$i++)
		{
			if($leage_pos[$i]['id'] == $data['user_data'][0]['id'])
			{
				$mypos = $i + 1;
			}
		}
		$data['user_data'][0]['leage_pos'] = $mypos;
		$dead = $this->ios_model->dead_time();
		$now = date('m/d/Y H:i:s', time());
		$date = new DateTime( $now );
		$date2 = new DateTime( $dead[0]['time'] );
		$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();
		if($diffInSeconds > 0)
			$data['showLive'] = 1;
		else
			 $data['showLive'] = 0;
		$yumy  = explode(" ", $dead[0]['time']);
		$data['hour'] = explode(":", $yumy[1]);
		$data['date'] = explode("-", $yumy[0]);
		$havij = $this->ios_model->game_history($data['user_data'][0]['id']);
		for($i=0;$i<count($havij);$i++)
		{
			$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
			$user_a = $this->ios_model->get_user_data_by_id($havij[$i]['user_a']);
			$havij[$i]['user_a_name'] = $user_a[0]['fname']." ".$user_a[0]['lname'];
			$havij[$i]['user_a_image'] = $user_a[0]['image'];
			if(@$havij[$i]['user_b'] != 0)
			{
				$user_b = $this->ios_model->get_user_data_by_id($havij[$i]['user_b']);
				$havij[$i]['user_b_name'] = $user_b[0]['fname']." ".$user_b[0]['lname'];
				$havij[$i]['user_b_image'] = $user_b[0]['image'];
			}
			else {
				$havij[$i]['user_b_name'] = "حریف تصادفی";
				$havij[$i]['user_b_image'] = 'useri1.png';
			}
			if($i%2== 0)
			{
				$havij[$i]['active'] = 1;
			}
			if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
			{
				if($havij[$i]['user_a'] == $data['user_data'][0]['id'])
				{
					if($havij[$i]['ponit_a'] > $havij[$i]['ponit_b'])
					{
						$havij[$i]['message'] = "بردی";
						$havij[$i]['status'] = '4';
					}
					elseif($havij[$i]['ponit_a'] == $havij[$i]['ponit_b'])
					{
						$havij[$i]['message'] = "مساوی";
						$havij[$i]['status'] = '3';
					}
					else {
						$havij[$i]['message'] = "باختی";
						$havij[$i]['status'] = '2';
					}
				}
				else {
					if($havij[$i]['ponit_b'] > $havij[$i]['ponit_a'])
					{
						$havij[$i]['message'] = "بردی";
						$havij[$i]['status'] = '4';
					}
					elseif($havij[$i]['ponit_a'] == $havij[$i]['ponit_b'])
					{
						$havij[$i]['message'] = "مساوی";
						$havij[$i]['status'] = '3';
					}
					else {
						$havij[$i]['message'] = "باختی";
						$havij[$i]['status'] = '2';
					}
				}
			}
			else {
				if($havij[$i]['queue'] == $data['user_data'][0]['id'])
				{
					$havij[$i]['status'] = '1';
					$havij[$i]['message'] = "نوبت شماست";
				}
				else {
					$havij[$i]['message'] = "نوبت حریف";
					$havij[$i]['status'] = '1';
				}
			}
		}
		$data['history'] = $havij;
		$data['token'] = $token;
		//echo "<pre>";print_r($havij);die();
		//---------
		$this->load->view('main/home' , $data);
	}
	//----------------------------------
	function time_elapsed_string($post_time, $full = false)
	{
		$seconds = time() - strtotime($post_time);
		$year = floor($seconds /31556926);
		$months = floor($seconds /2629743);
		$week=floor($seconds /604800);
		$day = floor($seconds /86400);
		$hours = floor($seconds / 3600);
		$mins = floor(($seconds - ($hours*3600)) / 60);
		$secs = floor($seconds % 60);
		if($seconds < 60) $time = $secs." ثانیه پیش";
		else if($seconds < 3600 ) $time =($mins==1)?$mins." الان":$mins." دقیقه پیش";
		else if($seconds < 86400) $time = ($hours==1)?$hours." ساعت پیش":$hours." ساعت پیش";
		else if($seconds < 604800) $time = ($day==1)?$day." روز پیش":$day." روز پیش";
		else if($seconds < 2629743) $time = ($week==1)?$week." هفته گذشته":$week." هفته گذشته";
		else if($seconds < 31556926) $time =($months==1)? $months." ماه گذشته":$months." ماه گذشته";
		else $time = ($year==1)? $year." سال گذشته":$year." سال گذشته";
		return $time;
	}
	//----------------------------------
	function profile($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['user_data'][0]['poistion'] = $this->ios_model->get_user_position($data['user_data'][0]['id']);
		$data['user_data'][0]['all'] = $this->ios_model->get_count_all_user();
		$leage_pos = $this->ios_model->my_leauge($data['user_data'][0]['id']);
		$game = $this->ios_model->user_leauge($data['user_data'][0]['id']);
		$ret = array();
		if($game[0]['level'] == 4)
		{
			$ret['level'] = "لیگ دسته چهارم";
			$ret['rate'] = 4;
		}
		if($game[0]['level'] == 3)
		{
			$ret['level'] = "لیگ دسته سوم";
			$ret['rate'] = 3;
		}
		if($game[0]['level'] == 2)
		{
			$ret['level'] = "لیگ دسته دوم";
			$ret['rate'] = 2;
		}
		if($game[0]['level'] == 1)
		{
			$ret['level'] = "لیگ دسته اول";
			$ret['rate'] = 1;
		}
		$mylevel = $this->ios_model->mylevelInLeauge($data['user_data'][0]['id'] , $game[0]['level']);
		$data['user_data'][0]['mylevel'] = $mylevel;
		$data['user_data'][0]['leageData'] = $ret;
		$mypos = 0;
		for($i=0;$i<count($leage_pos);$i++)
		{
			if($leage_pos[$i]['id'] == $data['user_data'][0]['id'])
			{
				$mypos = $i + 1;
			}
		}
		$data['user_data'][0]['leage_pos'] = $mypos;
		$data['token'] = $token;
		//---------
		$this->load->view('main/profile' , $data);
	}
	//----------------------------------
	function wallet($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['list'] = $this->ios_model->moneyReqestList($data['user_data'][0]['id']);
		$data['token'] = $token;
		for($i=0;$i<count($data['list']);$i++)
		{
			if($data['list'][$i]['status'] == 0)
				$data['list'][$i]['status'] = 'درحال رسیدگی';
			else {
				$data['list'][$i]['status'] = 'پرداخت';
			}
		}
		//---------
		$this->load->view('main/wallet' , $data);
	}
	//----------------------------------
	function setting($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		//---------
		$this->load->view('main/setting' , $data);
	}
	//----------------------------------
	function editprofile($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		//---------
		$this->load->view('main/editprofile' , $data);
	}
	//----------------------------------
	function support($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		//---------
		$this->load->view('main/support' , $data);
	}
	//----------------------------------
	function shop($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		//---------
		$this->load->view('main/shop' , $data);
	}
	//----------------------------------
	function leader($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		$data['leader'] = $this->ios_model->leauge($data['user_data'][0]['id']);
		$this->ios_model->check_change_leauge($data['user_data'][0]['id'] , $data['user_data'][0]['score']);
		$game = $this->ios_model->user_leauge($data['user_data'][0]['id']);
		if($game[0]['level'] == 4)
		{
			$data['level'] = "لیگ دسته چهارم";
			$data['rate'] = 4;
		}
		if($game[0]['level'] == 3)
		{
			$data['level'] = "لیگ دسته سوم";
			$data['rate'] = 3;
		}
		if($game[0]['level'] == 2)
		{
			$data['level'] = "لیگ دسته دوم";
			$data['rate'] = 2;
		}
		if($game[0]['level'] == 1)
		{
			$data['level'] = "لیگ دسته اول";
			$data['rate'] = 1;
		}
		$data['leage3'] = $this->ios_model->my_leauge_take(3);
		$data['leage2'] = $this->ios_model->my_leauge_take(2);
		$data['leage1'] = $this->ios_model->my_leauge_take(1);
		$data['mylevel'] = $this->ios_model->mylevelInLeauge($data['user_data'][0]['id'] , $game[0]['level']);
		//---------
		$this->load->view('main/leader' , $data);
	}
	//----------------------------------
	function play($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		$data['friends'] = $this->ios_model->my_friends($data['user_data'][0]['id']);
		for($i=0;$i<count($data['friends']);$i++)
		{
			if($data['friends'][$i]['level'] == 4)
			{
				$data['friends'][$i]['level'] = "لیگ دسته چهارم";
			}
			if($data['friends'][$i]['level'] == 3)
			{
				$data['friends'][$i]['level'] = "لیگ دسته سوم";
			}
			if($data['friends'][$i]['level'] == 2)
			{
				$data['friends'][$i]['level'] = "لیگ دسته دوم";
			}
			if($data['friends'][$i]['level'] == 1)
			{
				$data['friends'][$i]['level'] = "لیگ دسته اول";
			}
		}
		//---------
		$this->load->view('main/play' , $data);
	}
	//----------------------------------
	function supportMsg($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		//---------
		$this->load->view('main/supportMsg' , $data);
	}
	//----------------------------------
	function friends($token = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		$data['friends'] = $this->ios_model->my_friends($data['user_data'][0]['id']);
		for($i=0;$i<count($data['friends']);$i++)
		{
			if($data['friends'][$i]['level'] == 4)
			{
				$data['friends'][$i]['level'] = "لیگ دسته چهارم";
			}
			if($data['friends'][$i]['level'] == 3)
			{
				$data['friends'][$i]['level'] = "لیگ دسته سوم";
			}
			if($data['friends'][$i]['level'] == 2)
			{
				$data['friends'][$i]['level'] = "لیگ دسته دوم";
			}
			if($data['friends'][$i]['level'] == 1)
			{
				$data['friends'][$i]['level'] = "لیگ دسته اول";
			}
		}
		//---------
		$this->load->view('main/friends' , $data);
	}
	//----------------------------------
	function pre($token = "" , $game_id = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		if(@$game_id == null)
			redirect(base_url()."index.php/main/home/".$token , 'refresh');
		$data['game_id'] = $game_id;
		//---------
		$this->load->view('main/pre' , $data);
	}
	//----------------------------------
	function gameboard($token = "" , $game_id = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		if(@$game_id == null)
			redirect(base_url()."index.php/main/home/".$token , 'refresh');
		$data['game_id'] = $game_id;
		$this->ios_model->check_game($data['user_data'][0]['id']);
		$this->ios_model->get_game_info($game_id);
		$game = $this->ios_model->get_game_infos($game_id);
		if($game[0]['round'] == 5)
		{
			$havij = $this->ios_model->check_round_five($game_id);
			if($havij == 6)
				$this->ios_model->get_score($game_id);
		}
		$user_a = $this->ios_model->get_user_data_by_id($game[0]['user_a']);
		if($game[0]['user_b'] != 0)
		{
			$user_b = $this->ios_model->get_user_data_by_id($game[0]['user_b']);
			if($game[0]['user_a'] == $data['user_data'][0]['id'])
			{
				$ret = array(
					'user_a_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
					'user_a_image' => $user_a[0]['image'],
					'user_a_score' => $user_a[0]['score'],
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_name' => $user_b[0]['fname']." ".$user_b[0]['lname'],
					'user_b_image' => $user_b[0]['image'],
					'user_b_score' => $user_b[0]['score'],
					'user_b_ponit' => $game[0]['ponit_b'],
					'round' => $game[0]['round'],
					'game' => 1,
				);
				if($game[0]['round'] == 5 and $game[0]['status'] == 1)
				{
					$ret['over'] = 1;
					if($game[0]['ponit_a'] > $game[0]['ponit_b'])
					{
						$ret['state'] = "بردی";
					}
					if($game[0]['ponit_a'] < $game[0]['ponit_b'])
					{
						$ret['state'] = "باختی";
					}
					if($game[0]['ponit_a'] == $game[0]['ponit_b'])
					{
						$ret['state'] = "مساوی";
					}
				}
				elseif($game[0]['round'] == 5 and $game[0]['status'] == 0){
					$ret['over'] = 0;
					if($result[0]['id'] == $game[0]['queue'])
					{
						$ret['state'] = 'نوبت شماست';
					}
					else {
						$ret['state'] = 'نوبت حریف';
					}
				}
			}
			else {
				$ret = array(
					'user_a_name' => $user_b[0]['fname']." ".$user_b[0]['lname'],
					'user_a_image' => $user_b[0]['image'],
					'user_a_score' => $user_b[0]['score'],
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
					'user_b_image' => $user_a[0]['image'],
					'user_b_score' => $user_a[0]['score'],
					'user_b_ponit' => $game[0]['ponit_b'],
					'round' => $game[0]['round'],
					'game' => 1
				);
				if($game[0]['round'] == 5 and $game[0]['status'] == 1)
				{
					$ret['over'] = 1;
					if($game[0]['ponit_b'] > $game[0]['ponit_a'])
					{
						$ret['state'] = "بردی";
					}
					if($game[0]['ponit_b'] < $game[0]['ponit_a'])
					{
						$ret['state'] = "باختی";
					}
					if($game[0]['ponit_b'] == $game[0]['ponit_a'])
					{
						$ret['state'] = "مساوی";
					}
				}
				elseif($game[0]['round'] == 5 and $game[0]['status'] == 0){
					$ret['over'] = 0;
					if($data['user_data'][0]['id'] == $game[0]['queue'])
					{
						$ret['state'] = 'نوبت شماست';
					}
					else {
						$ret['state'] = 'نوبت حریف';
					}
				}
			}
		}
		else {
			$ret = array(
				'user_a_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
				'user_a_image' => $user_a[0]['image'],
				'user_a_score' => $user_a[0]['score'],
				'user_b_name' => 'حریف تصادفی',
				'user_b_image' => 'image.png',
				'user_b_score' => 0,
				'user_a_ponit' => $game[0]['ponit_a'],
				'user_b_ponit' => 0,
				'round' => $game[0]['round'],
				'game' => 0
			);
		}
		if($data['user_data'][0]['id'] == $game[0]['queue'])
		{
			$ret['turn'] = 1;
		}
		else {
			$ret['turn'] = 2;
		}
		$data['game_data'] = $ret;

		$ret = array();
		$turn = 'نوبت شماست';
		for($i=0;$i<5;$i++)
		{
			$ret[$i]['round'] = $i+1;
			$ret[$i]['round_category'] = $this->ios_model->get_categroy_round_name($game_id , $i);
			$ret[0]['round_name'] = 'راند اول';
			$ret[1]['round_name'] = 'راند دوم';
			$ret[2]['round_name'] = 'راند سوم';
			$ret[3]['round_name'] = 'راند چهارم';
			$ret[4]['round_name'] = 'راند پنجم';
			$mine = $this->ios_model->get_round_score($game_id , $i+1 , $data['user_data'][0]['id']);
			if(count($mine) == 0)
			{
				$ret[$i]['star1'] = "";
				$ret[$i]['star2'] = "";
				$ret[$i]['star3'] = "";
			}
			else {
				$y = 0;
				for($k=0;$k<count($mine);$k++)
				{
					$y = $y + 1;
					if($mine[$k]['status'] == 1)
						$ret[$i]['star'.$y] = "goldStar";
					else {
						$ret[$i]['star'.$y] = "grayStar";
					}
				}
			}

			$yours = $this->ios_model->get_round_score_y($game_id , $i+1 , $data['user_data'][0]['id']);
			if(count($yours) == 0)
			{
				$ret[$i]['stary1'] = "";
				$ret[$i]['stary2'] = "";
				$ret[$i]['stary3'] = "";
			}
			else {
				$y = 0;
				for($k=0;$k<count($yours);$k++)
				{
					$y = $y + 1;
					if($yours[$k]['status'] == 1)
						$ret[$i]['stary'.$y] = "goldStar";
					else {
						$ret[$i]['stary'.$y] = "grayStar";
					}
				}
			}
		}
		$data['borad'] = $ret;
		//echo "<pre>";print_r($ret);die();
		//---------
		$this->load->view('main/gameboard' , $data);
	}
	//----------------------------------
	function category($token = "" , $game_id = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		if(@$game_id == null)
			redirect(base_url()."index.php/main/home/".$token , 'refresh');
		$data['game_id'] = $game_id;
		$data['category'] = $this->ios_model->get_category();
		//---------
		$this->load->view('main/category' , $data);
	}
	//----------------------------------
	function game($token = "" , $game_id = "" , $round = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		if(@$game_id == null)
			redirect(base_url()."index.php/main/home/".$token , 'refresh');
		if(@$round == null)
				redirect(base_url()."index.php/main/home/".$token , 'refresh');
		$data['game_id'] = $game_id;
		$data['star'] = $this->ios_model->get_match_star($data['user_data'][0]['id'] , $game_id);
		$game = $this->ios_model->get_game_infos($game_id);
		if($game[0]['round'] == 5)
		{
			$havij = $this->ios_model->check_round_five($game_id);
			if($havij == 6)
				$this->ios_model->get_score($game_id);
		}
		$user_a = $this->ios_model->get_user_data_by_id($game[0]['user_a']);
		if($game[0]['user_b'] != 0)
		{
			$user_b = $this->ios_model->get_user_data_by_id($game[0]['user_b']);
			if($game[0]['user_a'] == $data['user_data'][0]['id'])
			{
				$ret = array(
					'user_a_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
					'user_a_image' => $user_a[0]['image'],
					'user_a_score' => $user_a[0]['score'],
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_name' => $user_b[0]['fname']." ".$user_b[0]['lname'],
					'user_b_image' => $user_b[0]['image'],
					'user_b_score' => $user_b[0]['score'],
					'user_b_ponit' => $game[0]['ponit_b'],
					'round' => $game[0]['round'],
					'game' => 1,
				);
				if($game[0]['round'] == 5 and $game[0]['status'] == 1)
				{
					$ret['over'] = 1;
					if($game[0]['ponit_a'] > $game[0]['ponit_b'])
					{
						$ret['state'] = "بردی";
					}
					if($game[0]['ponit_a'] < $game[0]['ponit_b'])
					{
						$ret['state'] = "باختی";
					}
					if($game[0]['ponit_a'] == $game[0]['ponit_b'])
					{
						$ret['state'] = "مساوی";
					}
				}
				elseif($game[0]['round'] == 5 and $game[0]['status'] == 0){
					$ret['over'] = 0;
					if($result[0]['id'] == $game[0]['queue'])
					{
						$ret['state'] = 'نوبت شماست';
					}
					else {
						$ret['state'] = 'نوبت حریف';
					}
				}
			}
			else {
				$ret = array(
					'user_a_name' => $user_b[0]['fname']." ".$user_b[0]['lname'],
					'user_a_image' => $user_b[0]['image'],
					'user_a_score' => $user_b[0]['score'],
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
					'user_b_image' => $user_a[0]['image'],
					'user_b_score' => $user_a[0]['score'],
					'user_b_ponit' => $game[0]['ponit_b'],
					'round' => $game[0]['round'],
					'game' => 1
				);
				if($game[0]['round'] == 5 and $game[0]['status'] == 1)
				{
					$ret['over'] = 1;
					if($game[0]['ponit_b'] > $game[0]['ponit_a'])
					{
						$ret['state'] = "بردی";
					}
					if($game[0]['ponit_b'] < $game[0]['ponit_a'])
					{
						$ret['state'] = "باختی";
					}
					if($game[0]['ponit_b'] == $game[0]['ponit_a'])
					{
						$ret['state'] = "مساوی";
					}
				}
				elseif($game[0]['round'] == 5 and $game[0]['status'] == 0){
					$ret['over'] = 0;
					if($data['user_data'][0]['id'] == $game[0]['queue'])
					{
						$ret['state'] = 'نوبت شماست';
					}
					else {
						$ret['state'] = 'نوبت حریف';
					}
				}
			}
		}
		else {
			$ret = array(
				'user_a_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
				'user_a_image' => $user_a[0]['image'],
				'user_a_score' => $user_a[0]['score'],
				'user_b_name' => 'حریف تصادفی',
				'user_b_image' => 'image.png',
				'user_b_score' => 0,
				'user_a_ponit' => $game[0]['ponit_a'],
				'user_b_ponit' => 0,
				'round' => $game[0]['round'],
				'game' => 0
			);
		}
		if($data['user_data'][0]['id'] == $game[0]['queue'])
		{
			$ret['turn'] = 1;
		}
		else {
			$ret['turn'] = 2;
		}
		$data['game_data'] = $ret;
		$data['quiz'] = $this->ios_model->get_quiz_game($data['user_data'][0]['id'] , $game_id);
		$data['round'] = $round;
		$data['count'] = $round -1;
		$data['awnsers'] = $this->ios_model->get_quiz_awnsers($data['quiz'][$data['count']]['id']);
		//echo "<pre>";print_r($data['awnsers']);die();
		//---------
		$this->load->view('main/game' , $data);
	}
	//----------------------------------
	function round($token = "" , $game_id = "" , $round = "")
	{
		if(@$token == null)
			redirect(base_url() , 'refresh');
		//---------
		$data['user_data'] = $this->ios_model->get_user_data($token);
		if($data['user_data'] == 1)
			redirect(base_url() , 'refresh');
		$data['token'] = $token;
		if(@$game_id == null)
			redirect(base_url()."index.php/main/home/".$token , 'refresh');
		$data['game_id'] = $game_id;
		if(@$round == null)
				redirect(base_url()."index.php/main/home/".$token , 'refresh');
		$data['star'] = $this->ios_model->get_match_star($data['user_data'][0]['id'] , $game_id);
		$data['quiz'] = $this->ios_model->get_quiz_game($data['user_data'][0]['id'] , $game_id);
		$data['round'] = $round;
		$data['count'] = $round -1;
		$game = $this->ios_model->get_game_infos($game_id);
		if($game[0]['round'] == 5)
		{
			$havij = $this->ios_model->check_round_five($game_id);
			if($havij == 6)
				$this->ios_model->get_score($game_id);
		}
		$user_a = $this->ios_model->get_user_data_by_id($game[0]['user_a']);
		if($game[0]['user_b'] != 0)
		{
			$user_b = $this->ios_model->get_user_data_by_id($game[0]['user_b']);
			if($game[0]['user_a'] == $data['user_data'][0]['id'])
			{
				$ret = array(
					'user_a_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
					'user_a_image' => $user_a[0]['image'],
					'user_a_score' => $user_a[0]['score'],
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_name' => $user_b[0]['fname']." ".$user_b[0]['lname'],
					'user_b_image' => $user_b[0]['image'],
					'user_b_score' => $user_b[0]['score'],
					'user_b_ponit' => $game[0]['ponit_b'],
					'round' => $game[0]['round'],
					'game' => 1,
				);
				if($game[0]['round'] == 5 and $game[0]['status'] == 1)
				{
					$ret['over'] = 1;
					if($game[0]['ponit_a'] > $game[0]['ponit_b'])
					{
						$ret['state'] = "بردی";
					}
					if($game[0]['ponit_a'] < $game[0]['ponit_b'])
					{
						$ret['state'] = "باختی";
					}
					if($game[0]['ponit_a'] == $game[0]['ponit_b'])
					{
						$ret['state'] = "مساوی";
					}
				}
				elseif($game[0]['round'] == 5 and $game[0]['status'] == 0){
					$ret['over'] = 0;
					if($result[0]['id'] == $game[0]['queue'])
					{
						$ret['state'] = 'نوبت شماست';
					}
					else {
						$ret['state'] = 'نوبت حریف';
					}
				}
			}
			else {
				$ret = array(
					'user_a_name' => $user_b[0]['fname']." ".$user_b[0]['lname'],
					'user_a_image' => $user_b[0]['image'],
					'user_a_score' => $user_b[0]['score'],
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
					'user_b_image' => $user_a[0]['image'],
					'user_b_score' => $user_a[0]['score'],
					'user_b_ponit' => $game[0]['ponit_b'],
					'round' => $game[0]['round'],
					'game' => 1
				);
				if($game[0]['round'] == 5 and $game[0]['status'] == 1)
				{
					$ret['over'] = 1;
					if($game[0]['ponit_b'] > $game[0]['ponit_a'])
					{
						$ret['state'] = "بردی";
					}
					if($game[0]['ponit_b'] < $game[0]['ponit_a'])
					{
						$ret['state'] = "باختی";
					}
					if($game[0]['ponit_b'] == $game[0]['ponit_a'])
					{
						$ret['state'] = "مساوی";
					}
				}
				elseif($game[0]['round'] == 5 and $game[0]['status'] == 0){
					$ret['over'] = 0;
					if($data['user_data'][0]['id'] == $game[0]['queue'])
					{
						$ret['state'] = 'نوبت شماست';
					}
					else {
						$ret['state'] = 'نوبت حریف';
					}
				}
			}
		}
		else {
			$ret = array(
				'user_a_name' => $user_a[0]['fname']." ".$user_a[0]['lname'],
				'user_a_image' => $user_a[0]['image'],
				'user_a_score' => $user_a[0]['score'],
				'user_b_name' => 'حریف تصادفی',
				'user_b_image' => 'image.png',
				'user_b_score' => 0,
				'user_a_ponit' => $game[0]['ponit_a'],
				'user_b_ponit' => 0,
				'round' => $game[0]['round'],
				'game' => 0
			);
		}
		if($data['user_data'][0]['id'] == $game[0]['queue'])
		{
			$ret['turn'] = 1;
		}
		else {
			$ret['turn'] = 2;
		}
		$data['game_data'] = $ret;
		//---------
		$this->load->view('main/round' , $data);
	}
	//----------------------------------
}
?>
