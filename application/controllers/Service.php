<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Tehran");

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
    $this->load->model('service_model');
	}
	//------------------
  function index()
  {
    if($this->input->post('mobile') and $this->input->post('token'))
    {
      $mobile = $this->input->post('mobile');
      $result = $this->service_model->aut($mobile);
			$this->load->helper('sms');
			$message = $result;
			sendSms($message , $mobile);
			$ret = array('status' => 1);
			echo json_encode($ret);
    }
  }
	//--------------------------------------------------
	function turkey()
	{
		if($this->input->post('mobile'))
		{
			$mobile = $this->input->post('mobile');
			$result = $this->service_model->aut($mobile);
			$this->load->helper('sms');
			$message = $result;
			//sendSms($message , $mobile);
			$ret = array('status' => $message);
			echo json_encode($ret);
		}
	}
  //--------------------------------------------------
  function login()
  {
    if($this->input->post('mobile') != null and $this->input->post('password'))
    {
      $mobile = $this->input->post('mobile');
      $password = $this->input->post('password');
      $result = $this->service_model->login($mobile , $password);
			$fan = $this->service_model->get_user_fan($result);
			$ret = array('status' => $result , 'fan' => $fan);
      echo json_encode($ret);
    }
  }
	//------------------------------------------------
	function set_team()
	{
		if($this->input->post('token') != null and $this->input->post('team_id'))
    {
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
			}
			else {
				$team_id = $this->input->post('team_id');
				$name = $this->input->post('name');
				$this->service_model->set_user_fan($result[0]['id'] , $team_id , $name);
				$ret = array('havij' => 1);
				echo json_encode($ret);
			}
    }
	}
  //------------------------------------------------
  function forget()
  {
    if($this->input->post('mobile'))
    {
      $mobile = $this->input->post('mobile');
      $result = $this->service_model->forget_password($mobile);
      if($result != 1)
      {
        $this->load->helper('sms');
        $message = $result;
        sendSms($message , $mobile);
				$ret = array('status' => 2);
				echo json_encode($ret);
      }
      else {
				$ret = array('status' => 1);
				echo json_encode($ret);
      }
    }
  }
  //------------------------------------------------
	function register()
	{
		if($this->input->post('mobile'))
		{
			$mobile = $this->input->post('mobile');
			$result = $this->service_model->register($mobile);
			if($result != 1)
			{
				$this->load->helper('sms');
				$message = $result;
				sendSms($message , $mobile);
				$ret = array('status' => 2);
				echo json_encode($ret);
			}
			else
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
			}
		}
	}
	//------------------------------------------------
	function fan()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$team = $this->input->post('team');
			$result = $this->service_model->change_fan($token , $team);
			$ret = array('status' => 1);
			echo json_encode($ret);
		}
	}
	//------------------------------------------------
	function user_data()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
			}
			else {
				$poistion = $this->service_model->get_user_position($result[0]['id']);
				$all = $this->service_model->get_count_all_user();
				$leage_pos = $this->service_model->my_leauge($result[0]['id'] , $result[0]['score']);
				$mypos = 0;
				for($i=0;$i<count($leage_pos);$i++)
				{
					if($leage_pos[$i]['user_id'] == $result[0]['id'])
					{
						$mypos = $i;
					}
				}
				$result[0]['sologame'] = $this->service_model->get_solo_rate($result[0]['id']);
				$result[0]['postion'] = $poistion;
				$result[0]['count_user'] = $all;
				$result[0]['my_pos'] = $mypos;
				echo json_encode($result);
			}
		}
	}
	//------------------------------------------------
	function new_game_video()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->new_game_video($result[0]['id']);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function new_game()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->new_game($result[0]['id']);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function policy_games()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_game_info($game_id , $result[0]['id']);
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//-----------------------------------------------
	function get_game_data()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_game_infos($game_id);
			if($game[0]['round'] == 5)
			{
				$havij = $this->service_model->check_round_five($game_id);
				if($havij == 6)
				{
					$this->service_model->get_score($game_id);
					$game = $this->service_model->get_game_infos($game_id);
				}
			}
			if($game[0]['round'] > 5)
			{
				$havij = array(
					'status' => 1,
					'round' => 5
				);
				$this->db->where('id' , $game_id);
				$this->db->update('games' , $havij);
				//-----
				$bob = array(
					'user_id' => 0,
					'score' => 0,
					'game_id' => $game_id,
					'reason' => 'error'
				);
				$this->db->insert('logs' , $bob);
			}
			$user_a = $this->service_model->get_user_data_by_id($game[0]['user_a']);
			if($game[0]['user_b'] != 0)
			{
				$user_b = $this->service_model->get_user_data_by_id($game[0]['user_b']);
				if($game[0]['user_b'] == $result[0]['id'])
				{
					$ret = array(
						'user_a_name' => $user_b[0]['fname'],
						'user_b_fan' => $user_b[0]['fan_image'],
						'user_a_image' => $user_b[0]['image'],
						'user_a_score' => $user_b[0]['score'],
						'user_a_ponit' => $game[0]['ponit_b'],
						'user_b_name' => $user_a[0]['fname'],
						'user_a_fan' => $user_a[0]['fan_image'],
						'user_b_image' => $user_a[0]['image'],
						'user_b_score' => $user_a[0]['score'],
						'user_b_ponit' => $game[0]['ponit_a'],
						'round' => $game[0]['round'],
						'game' => 1
					);
				}
				else
				{

					$ret = array(
						'user_a_name' => $user_a[0]['fname'],
						'user_a_fan' => $user_a[0]['fan_image'],
						'user_a_image' => $user_a[0]['image'],
						'user_a_score' => $user_a[0]['score'],
						'user_a_ponit' => $game[0]['ponit_a'],
						'user_b_name' => $user_b[0]['fname'],
						'user_b_fan' => $user_b[0]['fan_image'],
						'user_b_image' => $user_b[0]['image'],
						'user_b_score' => $user_b[0]['score'],
						'user_b_ponit' => $game[0]['ponit_b'],
						'round' => $game[0]['round'],
						'game' => 1
					);
				}

					if($game[0]['round'] >= 5 and $game[0]['status'] == 1)
					{
						$ret['over'] = 1;
						if($game[0]['ponit_b'] > $game[0]['ponit_a'])
						{
							if($game[0]['user_b'] == $result[0]['id'])
								$ret['state'] = "بردی";
							else {
								$ret['state'] = "باختی";
							}
						}
						if($game[0]['ponit_b'] < $game[0]['ponit_a'])
						{
							if($game[0]['user_a'] == $result[0]['id'])
								$ret['state'] = "باختی";
							else {
								$ret['state'] = "بردی";
							}
						}
						if($game[0]['ponit_b'] == $game[0]['ponit_a'])
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
					'user_a_name' => $user_a[0]['fname'],
					'user_a_fan' => $user_a[0]['fan_image'],
					'user_a_image' => $user_a[0]['image'],
					'user_a_score' => $user_a[0]['score'],
					'user_b_name' => 'حریف تصادفی',
					'user_b_fan' => 'logo.png',
					'user_b_image' => 'dribbl.png',
					'user_b_score' => 0,
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_ponit' => 0,
					'round' => $game[0]['round'],
					'game' => 0
				);
			}
			if($game[0]['round'] >= 5 and $game[0]['status'] == 1)
			{
				$ret['over'] = 1;
				if($game[0]['ponit_a'] < $game[0]['ponit_b'])
				{
					if($game[0]['user_b'] == $result[0]['id'])
						$ret['state'] = "بردی";
					else {
						$ret['state'] = "باختی";
					}
				}
				if($game[0]['ponit_a'] > $game[0]['ponit_b'])
				{
					if($game[0]['user_a'] == $result[0]['id'])
						$ret['state'] = "بردی";
					else {
						$ret['state'] = "باختی";
					}
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
			if($result[0]['id'] == $game[0]['queue'])
			{
				$ret['turn'] = 1;
			}
			else {
				$ret['turn'] = 2;
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function category()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->get_category();
			echo json_encode($result);
			die();
		}
	}
	//------------------------------------------------
	function category_change()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->get_coin(50 , $result[0]['id']);
			$ret = array('coin' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function set_category()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('category_id'))
		{
			$token = $this->input->post('token');
			$category_id = $this->input->post('category_id');
			$game_id = $this->input->post('game_id');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->set_category_game($game_id , $category_id , $result[0]['id']);
			$ret = array('goto' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function game_borad()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$game_id = $this->input->post('game_id');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$ret = array();
			$turn = 'نوبت شماست';
			for($i=0;$i<5;$i++)
			{
				$ret[$i]['round'] = $i+1;
				$ret[$i]['round_category'] = $this->service_model->get_categroy_round_name($game_id , $i);
				$ret[0]['round_name'] = 'راند اول';
				$ret[1]['round_name'] = 'راند دوم';
				$ret[2]['round_name'] = 'راند سوم';
				$ret[3]['round_name'] = 'راند چهارم';
				$ret[4]['round_name'] = 'راند پنجم';
				$mine = $this->service_model->get_round_score($game_id , $i+1 , $result[0]['id']);
				if(count($mine) == 0)
				{
					$ret[$i]['star1'] = "none.png";
					$ret[$i]['star2'] = "none.png";
					$ret[$i]['star3'] = "none.png";
				}
				else {
					$y = 0;
					for($k=0;$k<count($mine);$k++)
					{
						$y = $y + 1;
						if($mine[$k]['status'] == 1)
							$ret[$i]['star'.$y] = "ystar.png";
						else {
							$ret[$i]['star'.$y] = "zstar.png";
						}
					}
				}

				$yours = $this->service_model->get_round_score_y($game_id , $i+1 , $result[0]['id']);
				if(count($yours) == 0)
				{
					$ret[$i]['stary1'] = "none.png";
					$ret[$i]['stary2'] = "none.png";
					$ret[$i]['stary3'] = "none.png";
				}
				else {
					$y = 0;
					for($k=0;$k<count($yours);$k++)
					{
						$y = $y + 1;
						if($yours[$k]['status'] == 1)
							$ret[$i]['stary'.$y] = "ystar.png";
						else {
							$ret[$i]['stary'.$y] = "zstar.png";
						}
					}
				}
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function friend_list()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->my_friends($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['level'] == 4)
				{
					$havij[$i]['level'] = "لیگ دسته سوم";
				}
				if($havij[$i]['level'] == 3)
				{
					$havij[$i]['level'] = "لیگ دسته دوم";
				}
				if($havij[$i]['level'] == 2)
				{
					$havij[$i]['level'] = "لیگ دسته اول";
				}
				if($havij[$i]['level'] == 1)
				{
					$havij[$i]['level'] = " دسته برتر";
				}
			}
			$ret = array($havij);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------------------
	function get_quiz_round()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->get_quiz_game_round($result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------------------
	function get_quiz()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->get_quiz_game($result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------------------
	function get_awnsers()
	{
		if($this->input->post('token') and $this->input->post('quiz_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$havij = $this->service_model->get_quiz_awnsers($quiz_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------------------
	function setAwnser()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id') and $this->input->post('awnser_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$awnser_id = $this->input->post('awnser_id');
			$havij = $this->service_model->set_awnser($quiz_id , $result[0]['id'] , $game_id , $awnser_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------------------
	function dontAwnser()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->dont_awnser($quiz_id , $result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------------------
	function change_queue()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->change_queue($result[0]['id'] , $game_id);
			if($havij != 0)
			{
				$user = $this->service_model->get_user_data_by_id($havij);
				$this->push($user[0]['mobile'] , 'حریف شما دست خود را بازی کرده است. حالا نوبت شماست.');
			}
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function game_history_wait()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->game_history_wait($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
				$user_a = $this->service_model->get_user_data_by_id($havij[$i]['user_a']);
				$havij[$i]['user_a_name'] = $user_a[0]['fname'];
				$havij[$i]['user_a_image'] = $user_a[0]['image'];
				if(@$havij[$i]['user_b'] != 0)
				{
					$user_b = $this->service_model->get_user_data_by_id($havij[$i]['user_b']);
					$havij[$i]['user_b_name'] = $user_b[0]['fname'];
					$havij[$i]['user_b_image'] = $user_b[0]['image'];
				}
				else {
					$havij[$i]['user_b_name'] = "حریف تصادفی";
					$havij[$i]['user_b_image'] = 'dribbl.png';
				}
				if($i%2== 0)
				{
					$havij[$i]['active'] = 1;
				}
				if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
				{
					if($havij[$i]['user_a'] == $result[0]['id'])
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
					if($havij[$i]['queue'] == $result[0]['id'])
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
			$sort = 0;
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['status'] == 1)
					$sort = 1;
			}
			if($sort == 1)
			{
				usort($havij, function($a, $b) {
					return $a['status'] - $b['status'];
				});
			}
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function game_history_turn()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->game_history_turn($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
				$user_a = $this->service_model->get_user_data_by_id($havij[$i]['user_a']);
				$havij[$i]['user_a_name'] = $user_a[0]['fname'];
				$havij[$i]['user_a_image'] = $user_a[0]['image'];
				if(@$havij[$i]['user_b'] != 0)
				{
					$user_b = $this->service_model->get_user_data_by_id($havij[$i]['user_b']);
					$havij[$i]['user_b_name'] = $user_b[0]['fname'];
					$havij[$i]['user_b_image'] = $user_b[0]['image'];
				}
				else {
					$havij[$i]['user_b_name'] = "حریف تصادفی";
					$havij[$i]['user_b_image'] = 'dribbl.png';
				}
				if($i%2== 0)
				{
					$havij[$i]['active'] = 1;
				}
				if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
				{
					if($havij[$i]['user_a'] == $result[0]['id'])
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
					if($havij[$i]['queue'] == $result[0]['id'])
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
			$sort = 0;
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['status'] == 1)
					$sort = 1;
			}
			if($sort == 1)
			{
				usort($havij, function($a, $b) {
					return $a['status'] - $b['status'];
				});
			}
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//-------------
	function game_history_ready()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->game_history_ready($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
				$user_a = $this->service_model->get_user_data_by_id($havij[$i]['user_a']);
				$havij[$i]['user_a_name'] = $user_a[0]['fname'];
				$havij[$i]['user_a_image'] = $user_a[0]['image'];
				if(@$havij[$i]['user_b'] != 0)
				{
					$user_b = $this->service_model->get_user_data_by_id($havij[$i]['user_b']);
					$havij[$i]['user_b_name'] = $user_b[0]['fname'];
					$havij[$i]['user_b_image'] = $user_b[0]['image'];
				}
				else {
					$havij[$i]['user_b_name'] = "حریف تصادفی";
					$havij[$i]['user_b_image'] = 'dribbl.png';
				}
				if($i%2== 0)
				{
					$havij[$i]['active'] = 1;
				}
				if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
				{
					if($havij[$i]['user_a'] == $result[0]['id'])
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
					if($havij[$i]['queue'] == $result[0]['id'])
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
			$sort = 0;
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['status'] == 1)
					$sort = 1;
			}
			if($sort == 1)
			{
				usort($havij, function($a, $b) {
					return $a['status'] - $b['status'];
				});
			}
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function game_history()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->game_history($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
				$user_a = $this->service_model->get_user_data_by_id($havij[$i]['user_a']);
				$havij[$i]['user_a_name'] = $user_a[0]['fname'];
				$havij[$i]['user_a_fan'] = $user_a[0]['fan_image'];
				$havij[$i]['user_a_image'] = $user_a[0]['image'];
				if(@$havij[$i]['user_b'] != 0)
				{
					$user_b = $this->service_model->get_user_data_by_id($havij[$i]['user_b']);
					$havij[$i]['user_b_name'] = $user_b[0]['fname'];
					$havij[$i]['user_b_fan'] = $user_b[0]['fan_image'];
					$havij[$i]['user_b_image'] = $user_b[0]['image'];
				}
				else {
					$havij[$i]['user_b_name'] = "حریف تصادفی";
					$havij[$i]['user_b_fan'] = "dribbl.png";
					$havij[$i]['user_b_image'] = 'dribbl.png';
				}
				if($i%2== 0)
				{
					$havij[$i]['active'] = 1;
				}
				if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
				{
					if($havij[$i]['user_a'] == $result[0]['id'])
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
					if($havij[$i]['queue'] == $result[0]['id'])
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
			$sort = 0;
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['status'] == 1)
					$sort = 1;
			}
			if($sort == 1)
			{
				usort($havij, function($a, $b) {
					return $a['status'] - $b['status'];
				});
			}
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------------------
	function time_elapsed_string($post_time, $full = false)
	{
		$time = time() - strtotime($post_time); // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'سال پیش',
        2592000 => 'ماه پیش',
        604800 => 'هفته پیش',
        86400 => 'روز پیش',
        3600 => 'ساعت پیش ',
        60 => 'دقیقه پیش',
        1 => 'ثانیه پیش'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');
    }


		/*$seconds = time() - strtotime($post_time);
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
	  return $time;*/
	}
	//------------------------------------
	function set_quiz()
	{
		if($this->input->post('token') and $this->input->post('quiz') and $this->input->post('aw_1') and $this->input->post('aw_2') and $this->input->post('aw_3') and $this->input->post('aw_4') and $this->input->post('trueAw'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz = $this->input->post('quiz');
			$aw_1 = $this->input->post('aw_1');
			$aw_2 = $this->input->post('aw_2');
			$aw_3 = $this->input->post('aw_3');
			$aw_4 = $this->input->post('aw_4');
			$trueAw = $this->input->post('trueAw');
			$havij = $this->service_model->set_new_quiz($result[0]['id'] , $quiz , $aw_1 , $aw_2 , $aw_3 , $aw_4 , $trueAw);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function fnameChange()
	{
		if($this->input->post('token') and $this->input->post('fname'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$fname = $this->input->post('fname');
			$havij = $this->service_model->fnameChange($result[0]['id'] , $fname);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function lnameChange()
	{
		if($this->input->post('token') and $this->input->post('lname'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$lname = $this->input->post('lname');
			$havij = $this->service_model->lnameChange($result[0]['id'] , $lname);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function cardChange()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$card = $this->input->post('card');
			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$havij = $this->service_model->cardChange($result[0]['id'] , $card , $fname , $lname);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function change_image()
	{
		if($this->input->post('token') and $this->input->post('image_name'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			if($this->input->post('image_name') == 'useri1.png')
				$count = 1000;
			if($this->input->post('image_name') == 'useri2.png')
				$count = 150;
			if($this->input->post('image_name') == 'useri3.png')
				$count = 150;
			if($this->input->post('image_name') == 'useri4.png')
				$count = 500;
			if($this->input->post('image_name') == 'useri5.png')
				$count = 500;
			if($this->input->post('image_name') == 'useri6.png')
				$count = 1000;
			if($this->input->post('image_name') == 'useri7.png')
				$count = 400;
			if($this->input->post('image_name') == 'useri8.png')
				$count = 300;
			if($this->input->post('image_name') == 'useri9.png')
				$count = 800;
			$image_name = $this->input->post('image_name');
			$havij = $this->service_model->imageChange($result[0]['id'] , $count , $image_name);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function user_info()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->user_games($result[0]['id']);
			$sib = $this->service_model->user_games($result[0]['id']);
			$win = $this->service_model->user_games_win($result[0]['id']);
			$ret = array('win' => $win , 'games' => $sib);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function set_message()
	{
		if($this->input->post('token') and $this->input->post('message') and $this->input->post('category'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$message = $this->input->post('message');
			$category = $this->input->post('category');
			$havij = $this->service_model->set_message($result[0]['id'] , $message , $category);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function friend_game()
	{
		if($this->input->post('token') and $this->input->post('friend_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$friend_id = $this->input->post('friend_id');
			$game = $this->service_model->friend_game($result[0]['id'] , $friend_id);
			$ret = array('game' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function vote_quiz()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('vote'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$vote = $this->input->post('vote');
			$game = $this->service_model->vote_quiz($result[0]['id'] , $quiz_id , $vote);
			$ret = array('game' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function giveMyMoney()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			if($result[0]['money'] != 0)
			{
					$game = $this->service_model->giveMyMoney($result[0]['id'] , $result[0]['money']);
					$ret = array('game' => 'درخواست پرداخت شما در سیستم با موفقیت ثبت گردید.');
			}
			else {
				$ret = array('game' => 'موجودی کیف پول شما جهت درخواست تسویه حساب کافی نمی باشد.');
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function moneyReqestList()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->moneyReqestList($result[0]['id']);
			for($i=0;$i<count($game);$i++)
			{
				if($game[$i]['status'] == 0)
					$game[$i]['status'] = 'درحال رسیدگی';
				else {
					$game[$i]['status'] = 'پرداخت';
				}
			}
			$ret = array('game' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function levelup()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->levelup($result[0]['id'] , $result[0]['score'] , $result[0]['coin']);
			if($result == -1)
			{
				$ret = array('result' => 2);
			}
			else {
				$ret = array('result' => 1);
			}
			echo json_encode($ret);
		}
	}
	//------------------------------------
	function user_leauge()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$this->service_model->check_change_leauge($result[0]['id'] , $result[0]['score']);
			$game = $this->service_model->user_leauge($result[0]['id']);
			$leage_pos = $this->service_model->my_leauge($result[0]['id'] , $result[0]['score']);
			$mypos = 0;
			$ret = array();
			for($i=0;$i<count($leage_pos);$i++)
			{
				if($leage_pos[$i]['id'] == $result[0]['id'])
				{
					$mypos = $i + 1;
				}
			}
			$ret['mypos'] = $mypos;
			if($game[0]['level'] == 4)
			{
				if($result[0]['score'] > 1000)
				{
					$ret['levelup'] = 1;
					$ret['coin'] = 1000;
				}
				else {
					$ret['levelup'] = 0;
				}
				$ret['level'] = "لیگ دسته سوم";
				$ret['rate'] = 4;
			}
			if($game[0]['level'] == 3)
			{
				if($result[0]['score'] > 25000)
				{
					$ret['levelup'] = 1;
					$ret['coin'] = 10000;
				}
				else {
					$ret['levelup'] = 0;
				}
				$ret['level'] = "لیگ دسته دوم";
				$ret['rate'] = 3;
			}
			if($game[0]['level'] == 2)
			{
				if($result[0]['score'] > 50000)
				{
					$ret['levelup'] = 1;
					$ret['coin'] = 25000;
				}
				else {
					$ret['levelup'] = 0;
				}
				$ret['level'] = "لیگ دسته اول";
				$ret['rate'] = 2;
			}
			if($game[0]['level'] == 1)
			{
				$ret['level'] = "لیگ برتر";
				$ret['rate'] = 1;
			}
			$mylevel = $this->service_model->mylevelInLeauge($result[0]['id'] , $game[0]['level']);
			$ret['count'] = $mylevel;
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function leauge()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->my_leauge($result[0]['id'] , $result[0]['score']);
			$leage = array();
			$mine = array();
			for($i=0;$i<count($game);$i++)
			{
				if($game[$i]['user_id'] == $result[0]['id'])
				{
					$mine['name'] = $game[$i]['fname']." ".$game[$i]['lname'];
					$mine['id'] = $i+1;
					$mine['score'] = $game[$i]['score'];
				}
			}
			$ret = array('leauge' => $leage , 'mine' => $mine);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function leaugeView()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->leauge($result[0]['id']);
			for($i=0;$i<20;$i++)
			{
				$game[$i]['rate'] = $i+1;
				if(@$game[$i]['id'] == null)
				{
					$game[$i]['id'] = '';
					$game[$i]['fname'] = '';
					$game[$i]['lname'] = '';
					$game[$i]['score'] = '';
				}
				$game[$i]['number'] = $i+1;
				if(@$game[$i]['fan'] == 1)
				{
					$game[$i]['fan'] = "arsenal.png";
				}
				elseif(@$game[$i]['fan'] == 2) {
					$game[$i]['fan'] = "chelsea.png";
				}
				elseif(@$game[$i]['fan'] == 3) {
					$game[$i]['fan'] = "liverpool.png";
				}
				elseif(@$game[$i]['fan'] == 4) {
					$game[$i]['fan'] = "manchester_united.png";
				}
				elseif(@$game[$i]['fan'] == 5) {
					$game[$i]['fan'] = "ac-milan-logo.png";
				}
				elseif(@$game[$i]['fan'] == 6) {
					$game[$i]['fan'] = "intermilan.png";
				}
				elseif(@$game[$i]['fan'] == 7) {
					$game[$i]['fan'] = "juventus.png";
				}
				elseif(@$game[$i]['fan'] == 8) {
					$game[$i]['fan'] = "paris.png";
				}
				elseif(@$game[$i]['fan'] == 9) {
					$game[$i]['fan'] = "dortmund.png";
				}
				elseif(@$game[$i]['fan'] == 10) {
					$game[$i]['fan'] = "bayern.png";
				}
				elseif(@$game[$i]['fan'] == 11) {
					$game[$i]['fan'] = "barcelona.png";
				}
				elseif(@$game[$i]['fan'] == 12) {
					$game[$i]['fan'] = "realmadrid.png";
				}
				elseif(@$game[$i]['fan'] == 13) {
					$game[$i]['fan'] = "sepahan.png";
				}
				elseif(@$game[$i]['fan'] == 14) {
					$game[$i]['fan'] = "tractor.png";
				}
				elseif(@$game[$i]['fan'] == 15) {
					$game[$i]['fan'] = "esteghlal.png";
				}
				elseif(@$game[$i]['fan'] == 16) {
					$game[$i]['fan'] = "perlispolis.png";
				}
			}
			$ret = array('leauge' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function upleuage()
	{
		if($this->input->post('token') and $this->input->post('level'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$level = $this->input->post('level');
			$game = $this->service_model->my_leauge_take($level);
			for($i=0;$i<20;$i++)
			{
				if(@$game[$i]['id'] == null)
				{
					$game[$i]['id'] = '';
					$game[$i]['fname'] = '';
					$game[$i]['lname'] = '';
					$game[$i]['score'] = '';
				}
				$game[$i]['number'] = $i+1;
				if(@$game[$i]['fan'] == 1)
				{
					$game[$i]['fan'] = "arsenal.png";
				}
				elseif(@$game[$i]['fan'] == 2) {
					$game[$i]['fan'] = "chelsea.png";
				}
				elseif(@$game[$i]['fan'] == 3) {
					$game[$i]['fan'] = "liverpool.png";
				}
				elseif(@$game[$i]['fan'] == 4) {
					$game[$i]['fan'] = "manchester_united.png";
				}
				elseif(@$game[$i]['fan'] == 5) {
					$game[$i]['fan'] = "ac-milan-logo.png";
				}
				elseif(@$game[$i]['fan'] == 6) {
					$game[$i]['fan'] = "intermilan.png";
				}
				elseif(@$game[$i]['fan'] == 7) {
					$game[$i]['fan'] = "juventus.png";
				}
				elseif(@$game[$i]['fan'] == 8) {
					$game[$i]['fan'] = "paris.png";
				}
				elseif(@$game[$i]['fan'] == 9) {
					$game[$i]['fan'] = "dortmund.png";
				}
				elseif(@$game[$i]['fan'] == 10) {
					$game[$i]['fan'] = "bayern.png";
				}
				elseif(@$game[$i]['fan'] == 11) {
					$game[$i]['fan'] = "barcelona.png";
				}
				elseif(@$game[$i]['fan'] == 12) {
					$game[$i]['fan'] = "realmadrid.png";
				}
				elseif(@$game[$i]['fan'] == 13) {
					$game[$i]['fan'] = "sepahan.png";
				}
				elseif(@$game[$i]['fan'] == 14) {
					$game[$i]['fan'] = "tractor.png";
				}
				elseif(@$game[$i]['fan'] == 15) {
					$game[$i]['fan'] = "esteghlal.png";
				}
				elseif(@$game[$i]['fan'] == 16) {
					$game[$i]['fan'] = "perlispolis.png";
				}
			}
			$ret = array('leauge' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function qet_live_quiz()
	{
		if($this->input->post('token') and $this->input->post('limit'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$limit = $this->input->post('limit');
			$game = $this->service_model->qet_live_quiz($limit);
			$ask = $this->service_model->get_live_ask($limit);
			$ret = array('quiz' => $game , 'ask' => $ask);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function heart_check()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->heart_check($result[0]['id']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function user_live_score()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->user_live_score($result[0]['id']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function increaseCoinTime()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$amount = 50;
			$game = $this->service_model->increateCoin($result[0]['id'] , $amount);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function increaseCoinHelp()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('quiz_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$amount = 70;
			$game = $this->service_model->increateCoin($result[0]['id'] , $amount);
			if($game == 2)
			{
				$ret = array('result' => $game);
				echo json_encode($ret);
			}
			else {
				$game_id = $this->input->post('game_id');
				$quiz_id = $this->input->post('quiz_id');
				$havij = $this->service_model->get_true_aw($quiz_id , $result[0]['id'] , $game_id);
				$havij['result'] = 1;
				echo json_encode($havij);
			}
			die();
		}
	}
	//------------------------------------
	function check_game()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->check_game($result[0]['id'] , $result[0]['score']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function check_round_game()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('round'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$round = $this->input->post('round');
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->check_round_game($result[0]['id'] , $game_id , $round);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_match_star()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_match_star($result[0]['id'] , $game_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function search_user()
	{
		if($this->input->post('token') and $this->input->post('keyword'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$keyword = $this->input->post('keyword');
			$havij = $this->service_model->search_user($keyword , $result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['level'] == 4)
				{
					$havij[$i]['level'] = "لیگ دسته سوم";
				}
				if($havij[$i]['level'] == 3)
				{
					$havij[$i]['level'] = "لیگ دسته دوم";
				}
				if($havij[$i]['level'] == 2)
				{
					$havij[$i]['level'] = "لیگ دسته اول";
				}
				if($havij[$i]['level'] == 1)
				{
					$havij[$i]['level'] = "لیگ برتر";
				}
			}
			$ret = array($havij);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function request_friend()
	{
		if($this->input->post('token') and $this->input->post('user_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$friend_id = $this->input->post('user_id');
			$game = $this->service_model->request_friend($result[0]['id'] , $friend_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function liveSingle()
	{
		$dead = $this->service_model->dead_time_signle();
		$now = date('m/d/Y H:i:s', time());
		$date = new DateTime( $now );
		$date2 = new DateTime( $dead[0]['time'] );

		$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();
		$ret = array('result' => $diffInSeconds);
		echo json_encode($ret);
		die();
	}
	//------------------------------------
	function liveStearm()
	{
		$dead = $this->service_model->dead_time();
		$now = date('m/d/Y H:i:s', time());
		$date = new DateTime( $now );
		$date2 = new DateTime( $dead[0]['time'] );

		$diffInSeconds = $date2->getTimestamp() - $date->getTimestamp();
		$status = $this->service_model->check_live_start();
		$ret = array('result' => $diffInSeconds , 'liveStatus' => $status);
		echo json_encode($ret);
		die();
	}
	//------------------------------------
	function get_inv_code()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_inv_code($result[0]['id']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function version_change()
	{
		if($this->input->post('version'))
		{
			$version = $this->input->post('version');
			$game = $this->service_model->check_version($version);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function addCoinGame()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->new_game_coin($result[0]['id']);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function addCoinGameFriend()
	{
		if($this->input->post('token') and $this->input->post('friend_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$friend_id = $this->input->post('friend_id');
			$game = $this->service_model->new_game_coin_friend($result[0]['id'] , $friend_id);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_publisher()
	{
		$my_array = array("ACMilan@SS","ManCity","AliKarimi9","EsEsHamid","AliPerlisPolis");
		shuffle($my_array);
		$ret = array('result' => $my_array[0]);
		echo json_encode($ret);
		die();
	}
	//------------------------------------
	function qet_live_status()
	{
		if($this->input->post('token') and $this->input->post('limit'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$limit = $this->input->post('limit');
			$game = $this->service_model->qet_live_status($limit);
			$ret = array('game' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function push($user , $message)
	{
		$data = array(
			'user' => $user,
			'content' => $message,
			'silent' => false,
			'channel' => 'default'
		);
		//print_r($data);
		$payload = json_encode($data);
		$ch = curl_init('https://diribl.push.adpdigital.com/api/push/toUsers?access_token=8c143ee268d868eabee6bbc33b2031bfaa25ce16');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-length: '.strlen($payload)));
		$response = curl_exec($ch);
		curl_close($ch);
		//echo $response;
	}
	//------------------------------------
	function check_push()
	{
		$this->push('09126183138' , 'کاربر فلانی دست خود را بازی کرده است');
	}
	//------------------------------------
	function check_avatar()
	{
		if($this->input->post('token') and $this->input->post('avatar'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$avatar = $this->input->post('avatar');
			$game = $this->service_model->check_avatar($result[0]['id'] , $avatar);
			$active = $this->service_model->check_active_avatar($result[0]['id'] , $avatar);
			$ret = array('game' => $game , 'active' => $active);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_live_count_user()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_live_count_user();
			$game = $game + 1000;
			$ret = array('count' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function close_game()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$this->service_model->close_game($game_id);
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_tips()
	{
		if($this->input->post('token'))
		{
			$result = $this->service_model->get_tips();
			$ret = array('result' => $result);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_chat()
	{
		if($this->input->post('token'))
		{
			$result = $this->service_model->get_chat();
			echo json_encode($result);
			die();
		}
	}
	//------------------------------------
	function get_chat_last()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->get_chat_last();
			$ret = array('result' => $result[0]['id']);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_new_message()
	{
		if($this->input->post('token') and $this->input->post('last_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$last_id = $this->input->post('last_id');
			//$result = $this->service_model->get_new_message($last_id);
			$result = $this->service_model->get_chat();
			echo json_encode($result);
			die();
		}
	}
	//------------------------------------
	function send_message()
	{
		if($this->input->post('token') and $this->input->post('last_id') and $this->input->post('message'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$message = $this->input->post('message');
			$last_id = $this->input->post('last_id');
			$this->service_model->send_message_new($result[0]['id'] , $message);
			//$result = $this->service_model->get_new_message($last_id);
			$result = $this->service_model->get_chat();
			echo json_encode($result);
			die();
		}
	}
	//------------------------------------
	function checkLive()
	{
		$game = $this->service_model->get_live_state();
		if(@$game == null)
		{
			$game = 0;
		}
		$ret = array('result' => $game);
		echo json_encode($ret);
		die();
	}
	//------------------------------------
	function get_teams()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->get_user_teams($result[0]['id']);
			echo json_encode($result);
		}
	}
	//------------------------------------
	function add_team()
	{
		if($this->input->post('token') and $this->input->post('name') and $this->input->post('image'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$name = $this->input->post('name');
			$image = $this->input->post('image');
			$result = $this->service_model->add_teams($result[0]['id'] , $result[0]['coin'] , $name , $image);
			$ret = array('result' => $result);
			echo json_encode($ret);
		}
	}
	//------------------------------------
	function find_team()
	{
		if($this->input->post('token') and $this->input->post('name'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$name = $this->input->post('name');
			$result = $this->service_model->get_user_teams_search($name);
			echo json_encode($result);
		}
	}
	//------------------------------------
	function join_team()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$id = $this->input->post('id');
			$result = $this->service_model->join_team($id , $result[0]['id'] , $result[0]['coin']);
			$ret = array('result' => $result);
			echo json_encode($ret);
		}
	}
	//------------------------------------
	function get_team_info()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$id = $this->input->post('id');
			$result = $this->service_model->get_team_info($id);
			echo json_encode($result);
		}
	}
	//------------------------------------
	function get_team_members()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$id = $this->input->post('id');
			$result = $this->service_model->get_team_members($id);
			echo json_encode($result);
		}
	}
	//------------------------------------
	function find_team_play()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$id = $this->input->post('id');
			$result = $this->service_model->find_team($id , $result[0]['id']);
			$ret = array('result' => $result);
			echo json_encode($ret);
		}
	}
	//------------------------------------
	function check_team_game()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 5);
				echo json_encode($ret);
				die();
			}
			$id = $this->input->post('id');
			$result = $this->service_model->check_team_game($id , $result[0]['id']);
			//$ret = array('result' => $result);
			echo json_encode($result);
		}
	}
	//------------------------------------
	function set_category_team()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('category_id'))
		{
			$token = $this->input->post('token');
			$category_id = $this->input->post('category_id');
			$game_id = $this->input->post('game_id');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->set_category_game_team($game_id , $category_id , $result[0]['id']);
			$ret = array('goto' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_match_star_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_match_star_team($result[0]['id'] , $game_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_game_data_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_game_infos_team($game_id);
			if($game[0]['round'] == 5)
			{
				$havij = $this->service_model->check_round_five_team($game_id);
				if($havij == 6)
				{
					$this->service_model->get_score_team($game_id);
					$game = $this->service_model->get_game_infos_team($game_id);
				}
			}
			$user_a = $this->service_model->get_user_data_by_id($game[0]['user_a']);
			if($game[0]['user_b'] != 0)
			{
				$user_b = $this->service_model->get_user_data_by_id($game[0]['user_b']);
				if($game[0]['user_b'] == $result[0]['id'])
				{
					$ret = array(
						'user_a_name' => $user_b[0]['fname'],
						'user_a_image' => $user_b[0]['image'],
						'user_a_score' => $user_b[0]['score'],
						'user_a_fan' => $user_b[0]['fan_image'],
						'user_a_ponit' => $game[0]['ponit_b'],
						'user_b_name' => $user_a[0]['fname'],
						'user_b_fan' => $user_a[0]['fan_image'],
						'user_b_image' => $user_a[0]['image'],
						'user_b_score' => $user_a[0]['score'],
						'user_b_ponit' => $game[0]['ponit_a'],
						'round' => $game[0]['round'],
						'game' => 1
					);
				}
				else
				{

					$ret = array(
						'user_a_name' => $user_a[0]['fname'],
						'user_a_image' => $user_a[0]['image'],
						'user_a_score' => $user_a[0]['score'],
						'user_a_fan' => $user_a[0]['fan_image'],
						'user_a_ponit' => $game[0]['ponit_a'],
						'user_b_name' => $user_b[0]['fname'],
						'user_b_image' => $user_b[0]['image'],
						'user_b_fan' => $user_b[0]['fan_image'],
						'user_b_score' => $user_b[0]['score'],
						'user_b_ponit' => $game[0]['ponit_b'],
						'round' => $game[0]['round'],
						'game' => 1
					);
				}

					if($game[0]['round'] >= 5 and $game[0]['status'] == 1)
					{
						$ret['over'] = 1;
						if($game[0]['ponit_b'] > $game[0]['ponit_a'])
						{
							if($game[0]['user_b'] == $result[0]['id'])
								$ret['state'] = "بردی";
							else {
								$ret['state'] = "باختی";
							}
						}
						if($game[0]['ponit_b'] < $game[0]['ponit_a'])
						{
							if($game[0]['user_a'] == $result[0]['id'])
								$ret['state'] = "باختی";
							else {
								$ret['state'] = "بردی";
							}
						}
						if($game[0]['ponit_b'] == $game[0]['ponit_a'])
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
			if($game[0]['round'] >= 5 and $game[0]['status'] == 1)
			{
				$ret['over'] = 1;
				if($game[0]['ponit_a'] < $game[0]['ponit_b'])
				{
					if($game[0]['user_b'] == $result[0]['id'])
						$ret['state'] = "بردی";
					else {
						$ret['state'] = "باختی";
					}
				}
				if($game[0]['ponit_a'] > $game[0]['ponit_b'])
				{
					if($game[0]['user_a'] == $result[0]['id'])
						$ret['state'] = "بردی";
					else {
						$ret['state'] = "باختی";
					}
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
			if($result[0]['id'] == $game[0]['queue'])
			{
				$ret['turn'] = 1;
			}
			else {
				$ret['turn'] = 2;
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_quiz_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->get_quiz_game_round_team($result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function setAwnser_team()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id') and $this->input->post('awnser_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$awnser_id = $this->input->post('awnser_id');
			$havij = $this->service_model->set_awnser_team($quiz_id , $result[0]['id'] , $game_id , $awnser_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function dontAwnser_team()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->dont_awnser_team($quiz_id , $result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function change_queue_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->change_queue_team($result[0]['id'] , $game_id);
			if($havij != 0)
			{
				$user = $this->service_model->get_user_data_by_id($havij);
				$this->push($user[0]['mobile'] , 'حریف شما دست خود را بازی کرده است. حالا نوبت شماست.');
			}
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function check_game_team()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->check_game_team($result[0]['id'] , $result[0]['score']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function policy_games_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_game_info_team($game_id);
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function game_borad_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$game_id = $this->input->post('game_id');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$ret = array();
			$turn = 'نوبت شماست';
			for($i=0;$i<5;$i++)
			{
				$ret[$i]['round'] = $i+1;
				$ret[$i]['round_category'] = $this->service_model->get_categroy_round_name_team($game_id , $i);
				$ret[0]['round_name'] = 'راند اول';
				$ret[1]['round_name'] = 'راند دوم';
				$ret[2]['round_name'] = 'راند سوم';
				$ret[3]['round_name'] = 'راند چهارم';
				$ret[4]['round_name'] = 'راند پنجم';
				$mine = $this->service_model->get_round_score_team($game_id , $i+1 , $result[0]['id']);
				if(count($mine) == 0)
				{
					$ret[$i]['star1'] = "none.png";
					$ret[$i]['star2'] = "none.png";
					$ret[$i]['star3'] = "none.png";
				}
				else {
					$y = 0;
					for($k=0;$k<count($mine);$k++)
					{
						$y = $y + 1;
						if($mine[$k]['status'] == 1)
							$ret[$i]['star'.$y] = "ystar.png";
						else {
							$ret[$i]['star'.$y] = "zstar.png";
						}
					}
				}

				$yours = $this->service_model->get_round_score_y_team($game_id , $i+1 , $result[0]['id']);
				if(count($yours) == 0)
				{
					$ret[$i]['stary1'] = "none.png";
					$ret[$i]['stary2'] = "none.png";
					$ret[$i]['stary3'] = "none.png";
				}
				else {
					$y = 0;
					for($k=0;$k<count($yours);$k++)
					{
						$y = $y + 1;
						if($yours[$k]['status'] == 1)
							$ret[$i]['stary'.$y] = "ystar.png";
						else {
							$ret[$i]['stary'.$y] = "zstar.png";
						}
					}
				}
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function close_game_team()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$this->service_model->close_game_team($game_id);
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function check_round_game_team()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('round'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$round = $this->input->post('round');
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->check_round_game_team($result[0]['id'] , $game_id , $round);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function getLiveNew()
	{
		$game = $this->service_model->get_live_state();
		$ask = $this->service_model->get_live_ask_active($game);
		$quiz = $this->service_model->get_live_quiz_active($game);
		$havij = "";
		for($i=0;$i<count($quiz);$i++)
		{
			$havij .= '<input type="hidden" id="status_'.$quiz[$i]['id'].'" value="'.$quiz[$i]['correct'].'"/>"';
			$havij .= '<a href="javascript:void(0)" class="chooseCatBtn setliveAw" id="'.$quiz[$i]['id'].'">'.$quiz[$i]['name'].'</a>';
		}
		$ret = array('ask' => $ask , 'quiz' => $havij);
		echo json_encode($ret);
	}
	//------------------------------------
	function get_team_id()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_team_id($game_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function check_team_game_end()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$team_id = $this->input->post('id');
			$game = $this->service_model->check_team_game_end($team_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function user_avatar_game()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->user_avatar_game($game_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_leauges()
	{
		if($this->input->post('nothing'))
		{
			$game = $this->service_model->get_leauges();
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_teams_by_leauges()
	{
		if($this->input->post('leauge'))
		{
			$leauge_id = $this->input->post('leauge');
			$game = $this->service_model->get_teams_by_leauges($leauge_id);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function show_live_awsner()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->show_live_awsner();
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_think_level()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_think_level($result[0]['id']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_think_quiz()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_think_quiz($result[0]['id'] , $result[0]['heart']);
			$aw = $this->service_model->get_think_ask($game[0]['id']);
			$ret = array('result' => $game , 'aw' => $aw);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function set_think_aw()
	{
		if($this->input->post('token') and $this->input->post('id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$id = $this->input->post('id');
			$star = $this->input->post('star');
			$game = $this->service_model->set_think_aw($result[0]['id'] , $id , $result[0]['heart'] , $star);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function thinks_times_up()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->thinks_times_up($result[0]['id'] , $result[0]['heart']);
			$ret = array('result' => $result);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function thinks_help()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->thinks_help($result[0]['id'] , $result[0]['heart']);
			$ret = array('result' => $result);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function thinks_bomb()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$result = $this->service_model->thinks_bomb($result[0]['id'] , $result[0]['coin']);
			$ret = array('result' => $result);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_think_quiz_help()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_think_quiz_help($result[0]['id'] , $result[0]['coin']);
			$aw = $this->service_model->get_think_ask($game[0]['id']);
			$ret = array('result' => $game , 'aw' => $aw);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function leaugeViewSingle()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->leaugeViewSingle();
			for($i=0;$i<20;$i++)
			{
				$game[$i]['rate'] = $i+1;
				if(@$game[$i]['fname'] == null)
				{
					$game[$i]['id'] = '';
					$game[$i]['fname'] = '';
					$game[$i]['score'] = '';
				}
				$game[$i]['number'] = $i+1;
			}
			$ret = array('leauge' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function new_game_coin()
	{
		if($this->input->post('token') and $this->input->post('coin'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$coin = $this->input->post('coin');
			$game = $this->service_model->new_game_coin_bet($result[0]['id'] , $coin , $result[0]['coin']);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function user_avatar_game_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->user_avatar_game_coin($game_id);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function set_category_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('category_id'))
		{
			$token = $this->input->post('token');
			$category_id = $this->input->post('category_id');
			$game_id = $this->input->post('game_id');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->set_category_game_coin($game_id , $category_id , $result[0]['id']);
			$ret = array('goto' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_game_data_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_game_infos_coin($game_id);
			if($game[0]['round'] == 5)
			{
				$havij = $this->service_model->check_round_five_coin($game_id);
				if($havij == 6)
				{
					$this->service_model->get_score_coin($game_id);
					$game = $this->service_model->get_game_infos_coin($game_id);
				}
			}
			$cost = (30 / 100) * $game[0]['coin'];
			$cost = ceil($cost);
			$cost = $game[0]['coin'] - $cost;
			if($game[0]['round'] > 5)
			{
				$havij = array(
					'status' => 1,
					'round' => 5
				);
				$this->db->where('id' , $game_id);
				$this->db->update('games_coin' , $havij);
				//-----
				$bob = array(
					'user_id' => 0,
					'score' => 0,
					'game_id' => $game_id,
					'reason' => 'error'
				);
				$this->db->insert('logs' , $bob);
			}
			$user_a = $this->service_model->get_user_data_by_id($game[0]['user_a']);
			if($game[0]['user_b'] != 0)
			{
				$user_b = $this->service_model->get_user_data_by_id($game[0]['user_b']);
				if($game[0]['user_b'] == $result[0]['id'])
				{
					$ret = array(
						'user_a_name' => $user_b[0]['fname'],
						'user_b_fan' => $user_b[0]['fan_image'],
						'user_a_image' => $user_b[0]['image'],
						'user_a_score' => $user_b[0]['score'],
						'user_a_ponit' => $game[0]['ponit_b'],
						'user_b_name' => $user_a[0]['fname'],
						'user_a_fan' => $user_a[0]['fan_image'],
						'user_b_image' => $user_a[0]['image'],
						'user_b_score' => $user_a[0]['score'],
						'user_b_ponit' => $game[0]['ponit_a'],
						'round' => $game[0]['round'],
						'game' => 1,
						'coin' => $game[0]['coin'],
						'give' => $cost
					);
				}
				else
				{

					$ret = array(
						'user_a_name' => $user_a[0]['fname'],
						'user_a_fan' => $user_a[0]['fan_image'],
						'user_a_image' => $user_a[0]['image'],
						'user_a_score' => $user_a[0]['score'],
						'user_a_ponit' => $game[0]['ponit_a'],
						'user_b_name' => $user_b[0]['fname'],
						'user_b_fan' => $user_b[0]['fan_image'],
						'user_b_image' => $user_b[0]['image'],
						'user_b_score' => $user_b[0]['score'],
						'user_b_ponit' => $game[0]['ponit_b'],
						'round' => $game[0]['round'],
						'game' => 1,
						'coin' => $game[0]['coin'],
						'give' => $cost
					);
				}

					if($game[0]['round'] >= 5 and $game[0]['status'] == 1)
					{
						$ret['over'] = 1;
						if($game[0]['ponit_b'] > $game[0]['ponit_a'])
						{
							if($game[0]['user_b'] == $result[0]['id'])
								$ret['state'] = "بردی";
							else {
								$ret['state'] = "باختی";
							}
						}
						if($game[0]['ponit_b'] < $game[0]['ponit_a'])
						{
							if($game[0]['user_a'] == $result[0]['id'])
								$ret['state'] = "باختی";
							else {
								$ret['state'] = "بردی";
							}
						}
						if($game[0]['ponit_b'] == $game[0]['ponit_a'])
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
					'user_a_name' => $user_a[0]['fname'],
					'user_a_fan' => $user_a[0]['fan_image'],
					'user_a_image' => $user_a[0]['image'],
					'user_a_score' => $user_a[0]['score'],
					'user_b_name' => 'حریف تصادفی',
					'user_b_fan' => 'logo.png',
					'user_b_image' => 'dribbl.png',
					'user_b_score' => 0,
					'user_a_ponit' => $game[0]['ponit_a'],
					'user_b_ponit' => 0,
					'round' => $game[0]['round'],
					'game' => 0,
					'coin' => $game[0]['coin'],
					'give' => $cost
				);
			}
			if($game[0]['round'] >= 5 and $game[0]['status'] == 1)
			{
				$ret['over'] = 1;
				if($game[0]['ponit_a'] < $game[0]['ponit_b'])
				{
					if($game[0]['user_b'] == $result[0]['id'])
						$ret['state'] = "بردی";
					else {
						$ret['state'] = "باختی";
					}
				}
				if($game[0]['ponit_a'] > $game[0]['ponit_b'])
				{
					if($game[0]['user_a'] == $result[0]['id'])
						$ret['state'] = "بردی";
					else {
						$ret['state'] = "باختی";
					}
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
			if($result[0]['id'] == $game[0]['queue'])
			{
				$ret['turn'] = 1;
			}
			else {
				$ret['turn'] = 2;
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function get_quiz_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->get_quiz_coin($result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function setAwnser_coin()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id') and $this->input->post('awnser_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$awnser_id = $this->input->post('awnser_id');
			$havij = $this->service_model->set_awnser_coin($quiz_id , $result[0]['id'] , $game_id , $awnser_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function dontAwnser_coin()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->dont_awnser_coin($quiz_id , $result[0]['id'] , $game_id);
			echo json_encode($havij);
			die();
		}
	}
	//------------------------------------
	function increaseCoinHelp_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('quiz_id') and $this->input->post('price'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$amount = $this->input->post('price');
			$game = $this->service_model->increateCoin($result[0]['id'] , $amount);
			if($game == 2)
			{
				$ret = array('result' => $game);
				echo json_encode($ret);
			}
			else {
				$game_id = $this->input->post('game_id');
				$quiz_id = $this->input->post('quiz_id');
				$havij = $this->service_model->get_true_aw($quiz_id , $result[0]['id'] , $game_id);
				$havij['result'] = 1;
				echo json_encode($havij);
			}
			die();
		}
	}
	//------------------------------------
	function change_queue_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->service_model->change_queue_coin($result[0]['id'] , $game_id);
			if($havij != 0)
			{
				$user = $this->service_model->get_user_data_by_id($havij);
				$this->push($user[0]['mobile'] , 'حریف شما دست خود را بازی کرده است. حالا نوبت شماست.');
			}
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function check_game_coin()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->check_game_coin($result[0]['id'] , $result[0]['score']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function policy_games_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->get_game_info_coin($game_id , $result[0]['id']);
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function game_borad_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$game_id = $this->input->post('game_id');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$ret = array();
			$turn = 'نوبت شماست';
			for($i=0;$i<5;$i++)
			{
				$ret[$i]['round'] = $i+1;
				$ret[$i]['round_category'] = $this->service_model->get_categroy_round_name_coin($game_id , $i);
				$ret[0]['round_name'] = 'راند اول';
				$ret[1]['round_name'] = 'راند دوم';
				$ret[2]['round_name'] = 'راند سوم';
				$ret[3]['round_name'] = 'راند چهارم';
				$ret[4]['round_name'] = 'راند پنجم';
				$mine = $this->service_model->get_round_score_coin($game_id , $i+1 , $result[0]['id']);
				if(count($mine) == 0)
				{
					$ret[$i]['star1'] = "none.png";
					$ret[$i]['star2'] = "none.png";
					$ret[$i]['star3'] = "none.png";
				}
				else {
					$y = 0;
					for($k=0;$k<count($mine);$k++)
					{
						$y = $y + 1;
						if($mine[$k]['status'] == 1)
							$ret[$i]['star'.$y] = "ystar.png";
						else {
							$ret[$i]['star'.$y] = "zstar.png";
						}
					}
				}

				$yours = $this->service_model->get_round_score_y_coin($game_id , $i+1 , $result[0]['id']);
				if(count($yours) == 0)
				{
					$ret[$i]['stary1'] = "none.png";
					$ret[$i]['stary2'] = "none.png";
					$ret[$i]['stary3'] = "none.png";
				}
				else {
					$y = 0;
					for($k=0;$k<count($yours);$k++)
					{
						$y = $y + 1;
						if($yours[$k]['status'] == 1)
							$ret[$i]['stary'.$y] = "ystar.png";
						else {
							$ret[$i]['stary'.$y] = "zstar.png";
						}
					}
				}
			}
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function close_game_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$this->service_model->close_game_coin($game_id);
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function check_round_game_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('round'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$round = $this->input->post('round');
			$game_id = $this->input->post('game_id');
			$game = $this->service_model->check_round_game_coin($result[0]['id'] , $game_id , $round);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function coin_game_history_turn()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->game_coin_history_turn($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
				$user_a = $this->service_model->get_user_data_by_id($havij[$i]['user_a']);
				$havij[$i]['user_a_name'] = $user_a[0]['fname'];
				$havij[$i]['user_a_image'] = $user_a[0]['image'];
				if(@$havij[$i]['user_b'] != 0)
				{
					$user_b = $this->service_model->get_user_data_by_id($havij[$i]['user_b']);
					$havij[$i]['user_b_name'] = $user_b[0]['fname'];
					$havij[$i]['user_b_image'] = $user_b[0]['image'];
				}
				else {
					$havij[$i]['user_b_name'] = "حریف تصادفی";
					$havij[$i]['user_b_image'] = 'dribbl.png';
				}
				if($i%2== 0)
				{
					$havij[$i]['active'] = 1;
				}
				if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
				{
					if($havij[$i]['user_a'] == $result[0]['id'])
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
					if($havij[$i]['queue'] == $result[0]['id'])
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
			$sort = 0;
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['status'] == 1)
					$sort = 1;
			}
			if($sort == 1)
			{
				usort($havij, function($a, $b) {
					return $a['status'] - $b['status'];
				});
			}
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//------------------------------------
	function game_coin_history_wait()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->service_model->game_coin_history_wait($result[0]['id']);
			for($i=0;$i<count($havij);$i++)
			{
				$havij[$i]['havij'] = $this->time_elapsed_string($havij[$i]['time']);
				$user_a = $this->service_model->get_user_data_by_id($havij[$i]['user_a']);
				$havij[$i]['user_a_name'] = $user_a[0]['fname'];
				$havij[$i]['user_a_image'] = $user_a[0]['image'];
				if(@$havij[$i]['user_b'] != 0)
				{
					$user_b = $this->service_model->get_user_data_by_id($havij[$i]['user_b']);
					$havij[$i]['user_b_name'] = $user_b[0]['fname'];
					$havij[$i]['user_b_image'] = $user_b[0]['image'];
				}
				else {
					$havij[$i]['user_b_name'] = "حریف تصادفی";
					$havij[$i]['user_b_image'] = 'dribbl.png';
				}
				if($i%2== 0)
				{
					$havij[$i]['active'] = 1;
				}
				if($havij[$i]['round'] == 5 and $havij[$i]['status'] == 1)
				{
					if($havij[$i]['user_a'] == $result[0]['id'])
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
					if($havij[$i]['queue'] == $result[0]['id'])
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
			$sort = 0;
			for($i=0;$i<count($havij);$i++)
			{
				if($havij[$i]['status'] == 1)
					$sort = 1;
			}
			if($sort == 1)
			{
				usort($havij, function($a, $b) {
					return $a['status'] - $b['status'];
				});
			}
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------
	function increaseCoinTime_coin()
	{
		if($this->input->post('token') and $this->input->post('price'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$amount = $this->input->post('price');
			$game = $this->service_model->increateCoin($result[0]['id'] , $amount);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------
	function bomb_coin()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('quiz_id') and $this->input->post('price'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$amount = $this->input->post('price');
			$game = $this->service_model->increase_heart($result[0]['id'] , $amount);
			if($game == 2)
			{
				$ret = array('result' => $game);
				echo json_encode($ret);
			}
			else {
				$game_id = $this->input->post('game_id');
				$quiz_id = $this->input->post('quiz_id');
				$havij = $this->service_model->get_true_aw($quiz_id , $result[0]['id'] , $game_id);
				$havij['result'] = 1;
				echo json_encode($havij);
			}
			die();
		}
	}
	//----------------------------
	function leaugeViewCoin()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->leaugeViewCoin();
			for($i=0;$i<20;$i++)
			{
				$game[$i]['rate'] = $i+1;
				if(@$game[$i]['fname'] == null)
				{
					$game[$i]['id'] = '';
					$game[$i]['fname'] = '';
					$game[$i]['score'] = '';
				}
				$game[$i]['number'] = $i+1;
			}
			$ret = array('leauge' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------
	function get_think_star()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_think_star($result[0]['id']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------
	function get_factory()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->service_model->user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->service_model->get_factory($result[0]['id'] , $result[0]['heart'] , $result[0]['coin']);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------
}
?>
