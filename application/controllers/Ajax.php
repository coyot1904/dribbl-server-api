<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ios_model');
	}
	//----------------------------------
  function index()
  {
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->ios_model->new_game($result[0]['id']);
			$_SESSION['game_id'] = $game['game_id'];
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
  }
  //----------------------------------
	function set_category()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('category_id'))
		{
			$token = $this->input->post('token');
			$category_id = $this->input->post('category_id');
			$game_id = $this->input->post('game_id');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$havij = $this->ios_model->set_category_game($game_id , $category_id , $result[0]['id']);
			$ret = array('goto' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
	function setAwnser()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id') and $this->input->post('awnser_id'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$awnser_id = $this->input->post('awnser_id');
			$havij = $this->ios_model->set_awnser($quiz_id , $result[0]['id'] , $game_id , $awnser_id);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
	function dontAwnser()
	{
		if($this->input->post('token') and $this->input->post('quiz_id') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$quiz_id = $this->input->post('quiz_id');
			$game_id = $this->input->post('game_id');
			$havij = $this->ios_model->dont_awnser($quiz_id , $result[0]['id'] , $game_id);
			$ret = array('result' => $havij);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
	function change_queue()
	{
		if($this->input->post('token') and $this->input->post('game_id'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game_id = $this->input->post('game_id');
			$havij = $this->ios_model->change_queue($result[0]['id'] , $game_id);
			if($havij != 0)
			{
				//$user = $this->ios_model->get_user_data_by_id($havij);
				//$this->push($user[0]['mobile'] , 'حریف شما دست خود را بازی کرده است. حالا نوبت شماست.');
			}
			$ret = array('result' => 1);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
	function check_round_game()
	{
		if($this->input->post('token') and $this->input->post('game_id') and $this->input->post('round'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$round = $this->input->post('round');
			$game_id = $this->input->post('game_id');
			$game = $this->ios_model->check_round_game($result[0]['id'] , $game_id , $round);
			$ret = array('result' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
	function addCoinGame()
	{
		if($this->input->post('token'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$game = $this->ios_model->new_game_coin($result[0]['id']);
			$ret = array($game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
	function friend_game()
	{
		if($this->input->post('token') and $this->input->post('friend_id'))
		{
			$token = $this->input->post('token');
			$result = $this->ios_model->get_user_data($token);
			if($result == 1)
			{
				$ret = array('status' => 1);
				echo json_encode($ret);
				die();
			}
			$friend_id = $this->input->post('friend_id');
			$game = $this->ios_model->friend_game($result[0]['id'] , $friend_id);
			$ret = array('game' => $game);
			echo json_encode($ret);
			die();
		}
	}
	//----------------------------------
}
?>
