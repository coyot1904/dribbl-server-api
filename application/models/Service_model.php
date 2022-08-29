<?php
class service_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		    $this->db = $this->load->database('default', TRUE);
    }
	//------------------
  function aut($mobile)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('mobile' , $mobile);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 0)
    {
      $password = $this->generateRandomString();
      $data = array(
        'mobile' => $mobile,
        'password' => hashing($password),
		    'fname' => 'کاربر',
        'lname' => 'جدید',
        'coin' => 200,
        'heart' => 2
      );
      $this->db->insert('users' , $data);
	  $last_id =  $this->db->insert_id();
		$data = array('level' => 4 , 'user_id' => $last_id);
		$this->db->insert('leauge' , $data);
      return $password; // successfully user created

    }
    else
    {
      $password = $this->generateRandomString();
      $data = array(
        'password' => hashing($password),
      );
      $this->db->where('mobile' , $mobile);
      $this->db->update('users' , $data);
      return $password; // successfully user created
    }
  }
  //------------------
  function generateRandomString($length = 4)
  {
      $characters = '0123456789';
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $randomString;
  }
  //------------------
  function login($mobile , $password)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('mobile' , $mobile);
    $this->db->where('ban' , 0);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 1)
    {
      if($row->password === hashing($password))
      {
        $token = $this->generateRandomToken().$row->id;
        $data = array('token' => $token);
        $this->db->where('id' , $row->id);
        $this->db->update('users' , $data);
        return $token;
      }
      else
      {
        return 1; // password not match
      }
    }
    else
    {
      return 1; // tel is not find
    }
  }
  //------------------
  function get_user_fan($result)
  {

    $this->db->select();
    $this->db->from('users');
    $this->db->where('token' , $result);
    $query = $this->db->get();
    $row = $query->row();
    return $row->fan;
  }
  //------------------
  function set_user_fan($id , $team_id , $name)
  {
    $data = array(
      'fan' => $team_id,
      'fname' => $name
    );
    $this->db->where('id' , $id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //------------------
  function generateRandomToken($length = 8)
  {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ';
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, strlen($characters) - 1)];
      }
      return $randomString;
  }
  //------------------
  function forget_password($mobile)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('mobile' , $mobile);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 1)
    {
      $password = $this->generateRandomString();
      $data = array(
        'password' => hashing($password),
      );
      $this->db->where('id' , $row->id);
      $this->db->update('users' , $data);
      return $password;
    }
    else
      return 1; // mobile is not exit
  }
  //------------------
  function register($mobile)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('mobile' , $mobile);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 0)
    {
      $password = $this->generateRandomString();
      $data = array(
        'mobile' => $mobile,
        'password' => hashing($password),
        'fname' => 'کاربر',
        'lname' => 'جدید',
        'coin' => 200,
        'heart' => 2
      );
      $this->db->insert('users' , $data);
      $last_id =  $this->db->insert_id();
      $data = array(
        'user_id' => $last_id,
        'level' => 4
      );
      $this->db->insert('leauge' , $data);
      return $password; // successfully user created*/
    }
    else
      return 1;
  }
  //------------------
  function change_fan($token , $team)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('token' , $token);
    $query = $this->db->get();
    $row = $query->row();
    $data = array(
      'fan' => $team
    );
    $this->db->where('id' , $row->id);
    $this->db->update('users' , $data);
    return true;
  }
  //------------------
  function user_data($token)
  {
    $this->db->select('users.id , users.fname , users.lname , users.mobile , users.token , users.ban , users.fan , users.image , users.score , users.coin , users.card , users.money , users.heart');
    $this->db->select('leuage_image.image fan_image');
    $this->db->from('users');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan' , 'left');
    $this->db->where('users.token' , $token);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 1)
    {
      return $query->result_array();
    }
    else {
      return 1; // invalid token
    }
  }
  //------------------
  function new_game_video($user_id)
  {
    $this->check_game_time();
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id );
    $this->db->or_where('user_b' , $user_id);
    $query = $this->db->get();
    $count = 0;
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      if($result[$i]['status'] == 0)
        $count = $count + 1;
    }
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a !=' , $user_id );
    $this->db->where('status' , 0);
    $query = $this->db->get();
    if($query->num_rows() >= 1)
    {
      $result = $query->result_array();
      $status = 0;
      for($i=0;$i<count($result);$i++)
      {
        if($result[$i]['user_a'] != $result[$i]['queue'] and $result[$i]['user_b'] == 0)
        {
          $status = 1;
          $data = array(
            'user_b' => $user_id,
            'queue' => $user_id,
          );
          $this->db->where('id' , $result[$i]['id']);
          $this->db->update('games' , $data);
          $ret = array(
            'status' => 1,
            'game_id' => $result[$i]['id']
          );
          return $ret; // game on old game
        }
      }
      //---------
      if($status == 0)
      {
        $data = array(
          'user_a' => $user_id,
          'user_b' => 0,
          'status' => 0,
          'ponit_a' => 0,
          'ponit_b' => 0,
          'queue' => $user_id
        );
        $this->db->insert('games' , $data);
        $last_id =  $this->db->insert_id();
        $ret = array(
          'status' => 0,
          'game_id' => $last_id
        );
        return $ret; //new game
      }
    }
    else {
      $data = array(
        'user_a' => $user_id,
        'user_b' => 0,
        'status' => 0,
        'ponit_a' => 0,
        'ponit_b' => 0,
        'queue' => $user_id
      );
      $this->db->insert('games' , $data);
      $last_id =  $this->db->insert_id();
      $ret = array(
        'status' => 0,
        'game_id' => $last_id
      );
      return $ret; //new game
    }
  }
  //------------------
  function new_game($user_id)
  {
    $this->check_game_time();
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id );
    $this->db->or_where('user_b' , $user_id);
    $query = $this->db->get();
    $count = 0;
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      if($result[$i]['status'] == 0)
        $count = $count + 1;
    }
    if($count <= 6)
    {
      $this->db->select();
      $this->db->from('games');
      $this->db->where('user_a !=' , $user_id );
      $this->db->where('status' , 0);
      $query = $this->db->get();
      if($query->num_rows() >= 1)
      {
        $result = $query->result_array();
        $status = 0;
        for($i=0;$i<count($result);$i++)
        {
          if($result[$i]['user_a'] != $result[$i]['queue'] and $result[$i]['user_b'] == 0)
          {
            $status = 1;
            $data = array(
              'user_b' => $user_id,
              'queue' => $user_id,
            );
            $this->db->where('id' , $result[$i]['id']);
            $this->db->update('games' , $data);
            $ret = array(
              'status' => 1,
              'game_id' => $result[$i]['id']
            );
            return $ret; // game on old game
          }
        }
        //---------
        if($status == 0)
        {
          $data = array(
            'user_a' => $user_id,
            'user_b' => 0,
            'status' => 0,
            'ponit_a' => 0,
            'ponit_b' => 0,
            'queue' => $user_id
          );
          $this->db->insert('games' , $data);
          $last_id =  $this->db->insert_id();
          $ret = array(
            'status' => 0,
            'game_id' => $last_id
          );
          return $ret; //new game
        }
      }
      else {
        $data = array(
          'user_a' => $user_id,
          'user_b' => 0,
          'status' => 0,
          'ponit_a' => 0,
          'ponit_b' => 0,
          'queue' => $user_id
        );
        $this->db->insert('games' , $data);
        $last_id =  $this->db->insert_id();
        $ret = array(
          'status' => 0,
          'game_id' => $last_id
        );
        return $ret; //new game
      }
    }
    else {
      return -1;
    }
  }
  //------------------
  function get_game_info($game_id , $user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $this->db->select();
    $this->db->from('game_quiz');
    $this->db->where('round_id' , $result[0]['round']);
    $this->db->where('game_id' , $game_id);
    $this->db->where('user_id' , $user_id);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    if($query->num_rows() != 0)
    {
      $data = array(
        'status' => 2
      );
      $this->db->where('round_id' , $result[0]['round']);
      $this->db->where('game_id' , $game_id);
      $this->db->where('user_id' , $result[0]['queue']);
      $this->db->where('status' , 0);
      $this->db->update('game_quiz' , $data);
      //-------
      if($result[0]['queue'] == $result[0]['user_a'])
      {
        $data = array(
          'queue' => $result[0]['user_b'],
        );
      }
      else {
        $data = array(
          'queue' => $result[0]['user_a'],
        );
      }
      $this->db->where('id' , $game_id);
      $this->db->update('games' , $data);
    }
    //------
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_game_infos($game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //--------------
  function get_user_data_by_id($user_id)
  {
    $this->db->select('users.id , users.fname , users.image , users.score , leuage_image.image fan_image , users.mobile');
    $this->db->from('users');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
    $this->db->where('users.id' , $user_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_category()
  {
    $this->db->select();
    $this->db->from('category');
    $this->db->order_by('rand()');
    $this->db->limit(3,0);
    $query = $this->db->get();
    //print_r($this->db->last_query());
    return $query->result_array();
  }
  //------------------
  function randomGen($min, $max, $quantity)
  {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
  }
  //------------------
  function get_coin($count , $user_id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->coin >= $count)
    {
      $coin = $row->coin - $count;
      $data = array(
        'coin' => $coin
      );
      $this->db->where('id' , $row->id);
      $this->db->update('users' , $data);
      return 1;
    }
    else {
      return 2; // coin is not enough
    }
  }
  //------------------
  function set_category_game($game_id , $category_id , $user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round = $row->round+1;
    $data = array(
      'round' => $round
    );
    $this->db->where('id' , $row->id);
    $this->db->update('games' , $data);
    $ret = array(
      'game_id' => $game_id,
      'cate_id' => $category_id,
    );
    $this->db->insert('game_round' , $ret);
    //------------
    $this->db->select();
    $this->db->from('questions');
    $this->db->where('cate_id' , $category_id);
    $this->db->order_by('id', 'RANDOM');
    $this->db->limit(3,0);
    $query = $this->db->get();
    $result = $query->result_array();
    //------------
    for($i=0;$i<3;$i++)
    {
      $data = array(
        'queue' => $i+1,
        'game_id' => $game_id,
        'round_id' => $round,
        'quiz_id' => $result[$i]['id'],
        'user_id' => $user_id
      );
      $this->db->insert('game_quiz' , $data);
    }
    return true;
  }
  //------------------
  function get_categroy_round_name($game_id , $i)
  {
    $this->db->select('category.name');
    $this->db->from('game_round');
    $this->db->where('game_round.game_id' , $game_id);
    $this->db->join('category' , 'category.id = game_round.cate_id');
    $this->db->limit(1,$i);
    $query = $this->db->get();
    $row = $query->row();
    if(@$row->name == null)
    {
      $name = '';
    }
    else {
      $name = $row->name;
    }
    return $name;
  }
  //------------------
  function get_round_score($game_id , $round_id , $user_id)
  {
    $this->db->select();
    $this->db->from('game_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function get_round_score_y($game_id , $round_id , $user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->user_a == $user_id)
    {
      $id = $row->user_b;
    }
    else {
      $id = $row->user_a;
    }
    $this->db->select();
    $this->db->from('game_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function my_friends($user_id)
  {
    $this->db->select('users.id , users.fname , users.lname , users.score , users.image');
    $this->db->select('leauge.level');
    $this->db->from('friends');
    $this->db->join('users' , 'users.id = friends.friend_id');
    $this->db->join('leauge' , 'leauge.user_id = friends.friend_id');
    $this->db->where('friends.user_id' , $user_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_quiz_game($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round_id = $row->round;
    //--------
    $this->db->select('questions.id , questions.name , category.name cate_name , game_quiz.id quiz_id , questions.images');
    $this->db->from('game_quiz');
    $this->db->join('questions' , 'questions.id = game_quiz.quiz_id');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('seen' , 0);
    $this->db->order_by('game_quiz.id' , 'DESC');
    $this->db->limit(1,0);
    $query = $this->db->get();
    $result = $query->result_array();
    if(count($result) == 1)
    {
      $data = array('seen' => 1);
      $this->db->where('id' , $result[0]['quiz_id']);
      $this->db->update('game_quiz' , $data);
    }
    return $result;
  }
  //------------------
  function get_quiz_game_round($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round_id = $row->round;
    //--------
    $this->db->select('questions.id , questions.name , category.name cate_name , game_quiz.id quiz_id , questions.images');
    $this->db->from('game_quiz');
    $this->db->join('questions' , 'questions.id = game_quiz.quiz_id');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $this->db->where('seen' , 1);
    $this->db->limit(1,0);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function get_quiz_awnsers($quiz_id)
  {
    $this->db->select('id , title , ques_id');
    $this->db->from('awsners');
    $this->db->where('ques_id' , $quiz_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function set_awnser($quiz_id , $user_id , $game_id , $awnser_id)
  {

    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('id' , $awnser_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->status == 1)
    {
      $this->db->select();
      $this->db->from('games');
      $this->db->where('id' , $game_id);
      $query = $this->db->get();
      $row2 = $query->row();
      $this->db->select();
      $this->db->from('game_quiz');
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $query = $this->db->get();
      $row3 = $query->row();
      if($row3->status == 0)
      {
        if($row2->user_a == $user_id)
        {
          $data = array(
            'ponit_a' => $row2->ponit_a+1
          );
        }
        else {
          $data = array(
            'ponit_b' => $row2->ponit_b+1
          );
        }
        $this->db->where('id' , $game_id);
        $this->db->update('games' , $data);
        //---------
        $data = array('status' => 1);
        $this->db->where('game_id' , $game_id);
        $this->db->where('quiz_id' , $quiz_id);
        $this->db->where('user_id' , $user_id);
        $this->db->update('game_quiz' , $data);
      }
      $this->db->select();
      $this->db->from('awsners');
      $this->db->where('ques_id' , $quiz_id);
      $query = $this->db->get();
      $result = $query->result_array();
      $result[0]['correct_aw'] = 1;
      return $result;
    }
    else {
      $data = array('status' => 2);
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $this->db->update('game_quiz' , $data);
      //---------
      $this->db->select();
      $this->db->from('awsners');
      $this->db->where('ques_id' , $quiz_id);
      $query = $this->db->get();
      $result = $query->result_array();
      $result[0]['correct_aw'] = 2;
      return $result;
    }
  }
  //------------------
  function dont_awnser($quiz_id , $user_id , $game_id)
  {
    $data = array('status' => 2);
    $this->db->where('game_id' , $game_id);
    $this->db->where('quiz_id' , $quiz_id);
    $this->db->where('user_id' , $user_id);
    $this->db->update('game_quiz' , $data);
    //---------
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('ques_id' , $quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $result[0]['correct_aw'] = 2;
    return $result;
  }
  //------------------
  function get_true_aw($quiz_id , $user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('ques_id' , $quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $result[0]['correct_aw'] = 2;
    return $result;
  }
  //------------------
  function change_queue($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $result = $query->result_array();

      if($row->queue == $row->user_a)
      {
        $turn = $row->user_b;
        //echo 1;
        $data = array('queue' => $row->user_b);
        $this->db->where('id' , $game_id);
        $this->db->update('games' , $data);
      }
      elseif($row->queue == $row->user_b) {
        $turn = $row->user_a;
        //echo 2;
        $data = array('queue' => $row->user_a);
        $this->db->where('id' , $game_id);
        $this->db->update('games' , $data);
      }
    return $turn;
  }
  //------------------
  function game_history($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->limit(20 , 0);
    $this->db->order_by('games.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function game_history_turn($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('status' , 0);
    $this->db->where('queue' , $user_id);
    $this->db->group_start();
    $this->db->or_where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->group_end();
    $this->db->limit(20 , 0);
    $this->db->order_by('games.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function game_history_wait($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('status' , 0);
    $this->db->where('queue !=' , $user_id);
    $this->db->group_start();
    $this->db->or_where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->group_end();
    $this->db->limit(20 , 0);
    $this->db->order_by('games.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function game_history_ready($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('status' , 0);
    $this->db->group_start();
    $this->db->or_where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->group_end();
    $this->db->limit(20 , 0);
    $this->db->order_by('games.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function time_elapsed_string($datetime, $full = false)
  {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
  }
  //------------------
  function set_new_quiz($user_id , $quiz , $aw_1 , $aw_2 , $aw_3 , $aw_4 , $trueAw)
  {
    $data = array(
      'user_id' => $user_id,
      'status' => 0,
      'name' => $quiz
    );
    $this->db->insert('quiz_user' , $data);
    $last_id =  $this->db->insert_id();
    $aw[1] = $aw_1;
    $aw[2] = $aw_2;
    $aw[3] = $aw_3;
    $aw[4] = $aw_4;
    for($i=1;$i<5;$i++)
    {
      if($trueAw == $i)
      {
        $data = array(
          'quiz_id' => $last_id,
          'title' => $aw[$i],
          'status' => 1
        );
      }
      else {
        $data = array(
          'quiz_id' => $last_id,
          'title' => $aw[$i],
          'status' => 0
        );
      }
      $this->db->insert('awsners_user' , $data);
    }
    return true;
  }
  //------------------
  function fnameChange($user_id , $fname)
  {
    $data = array('fname' => $fname);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //------------------
  function lnameChange($user_id , $lname)
  {
    $data = array('lname' => $lname);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //------------------
  function cardChange($user_id , $card , $fname , $lname)
  {
    $data = array('card' => $card , 'fname' => $fname , 'lname' => $lname);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //------------------
  function imageChange($user_id , $count , $image_name)
  {
    $this->db->select();
    $this->db->from('avatar');
    $this->db->where('user_id' , $user_id);
    $this->db->where('avatar' , $image_name);
    $query = $this->db->get();
    $ret = $query->num_rows();
    if($ret == 0)
    {
      $data1 = array(
        'avatar' => $image_name,
        'user_id' => $user_id
      );
      $this->db->insert('avatar' , $data1);
      //----
      $this->db->select();
      $this->db->from('users');
      $this->db->where('id' , $user_id);
      $query = $this->db->get();
      $row = $query->row();
      if($count == 1)
      {
        $data = array(
          'image' => $image_name
        );
        $this->db->where('id' , $row->id);
        $this->db->update('users' , $data);
        return 2;
      }
      else {
        if($row->coin >= $count)
        {
          $coin = $row->coin - $count;
          $data = array(
            'coin' => $coin,
            'image' => $image_name
          );
          $this->db->where('id' , $row->id);
          $this->db->update('users' , $data);
          return 2;
        }
        else {
          return 1; // not enougth coin
        }
      }
    }
    else {
      $data = array(
        'image' => $image_name
      );
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
      return 2;
    }
  }
  //------------------
  function user_quiz($user_id)
  {
    $this->db->select();
    $this->db->from('quiz_user');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function user_games($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function user_games_win($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $ret = 0;
    for($i=0;$i<count($result);$i++)
    {
      if($result[$i]['status'] == 1)
      {
        if($user_id == $result[$i]['user_a'] and $result[$i]['ponit_a'] > $result[$i]['ponit_b'])
          $ret = $ret + 1;

        if($user_id == $result[$i]['user_b'] and $result[$i]['ponit_b'] > $result[$i]['ponit_a'])
          $ret = $ret + 1;
      }
    }
    return $ret;
  }
  //------------------
  function set_message($user_id , $message , $category)
  {
    $data = array(
      'user_id' => $user_id,
      'message' => $message,
      'category' => $category
    );
    $this->db->insert('message' , $data);
    return TRUE;
  }
  //------------------
  function friend_game($user_id , $friend_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id );
    $this->db->or_where('user_b' , $user_id);
    $query = $this->db->get();
    $count = 0;
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      if($result[$i]['status'] == 0)
        $count = $count + 1;
    }
    if($count <= 4)
    {
      $data = array(
        'user_a' => $user_id,
        'user_b' => $friend_id,
        'status' => 0,
        'ponit_a' => 0,
        'ponit_b' => 0,
        'queue' => $user_id
      );
      $this->db->insert('games' , $data);
      $last_id =  $this->db->insert_id();
      return $last_id; //new game
    }
    else {
      return -1;
    }

  }
  //------------------
  function vote_quiz($user_id , $quiz_id , $vote)
  {
    $this->db->select();
    $this->db->from('questions');
    $this->db->where('id' , $quiz_id);
    $query = $this->db->get();
    $row = $query->row();
    if($vote == 1)
    {
      $data = array(
        'vote' => $row->vote+1,
        'positive' => $row->positive+1
      );
    }
    else
    {
      $data = array(
        'vote' => $row->vote+1,
        'positive' => $row->negative+1
      );
    }
    $this->db->where('id' , $quiz_id);
    $this->db->update('questions' , $data);
    return TRUE;
  }
  //------------------
  function giveMyMoney($user_id , $money)
  {
    $data = array('money' => 0);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $data);
    $ret = array(
      'user_id' => $user_id,
      'price' => $money,
      'status' => 0
    );
    $this->db->insert('moneyRequest' , $ret);
    return TRUE;
  }
  //------------------
  function moneyReqestList($user_id)
  {

    $this->db->select();
    $this->db->from('moneyRequest');
    $this->db->where('user_id' , $user_id);
    $this->db->order_by('id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function user_leauge($user_id)
  {

    $this->db->select();
    $this->db->from('leauge');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function mylevelInLeauge($user_id , $level)
  {

    $this->db->select();
    $this->db->from('leauge');
    $this->db->where('level' , $level);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function get_user_position($user_id)
  {

    $this->db->select();
    $this->db->from('users');
    $this->db->order_by('score' , 'DESC');
    $query = $this->db->get();
    $result = $query->result_array();
    $position = 0;
    for($i=0;$i<count($result);$i++)
    {
      if($result[$i]['id'] == $user_id)
      {
        $poistion = $i + 1;
      }
    }
    return $poistion;
  }
  //------------------
  function get_count_all_user()
  {
    return $this->db->count_all_results('users');
  }
  //------------------
  function leauge($user_id)
  {

    $this->db->select();
    $this->db->from('leauge');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select('users.id , users.fname , users.lname , users.score , users.fan , users.image');
    $this->db->select('leuage_image.image fan_image');
    $this->db->from('leauge');
    $this->db->join('users' , 'users.id = leauge.user_id');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
    $this->db->order_by('users.score' , 'DESC');
    $this->db->limit(20,0);
    $this->db->where('level' , $row->level);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function my_leauge_take($level)
  {

    $this->db->select();
    $this->db->from('leauge');
    $this->db->join('users' , 'users.id = leauge.user_id');
    $this->db->order_by('users.score' , 'DESC');
    $this->db->limit(20,0);
    $this->db->where('level' , $level);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function my_leauge($user_id)
  {
    $this->db->select();
    $this->db->from('leauge');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select('leauge.id , leauge.user_id , users.score');
    $this->db->from('leauge');
    $this->db->join('users' , 'users.id = leauge.user_id' , 'left');
    $this->db->order_by('users.score' , 'DESC');
    $this->db->where('leauge.level' , @$row->level);
    $query = $this->db->get();
    return @$query->result_array();
  }
  //------------------
  function qet_live_quiz($limit)
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('status' , 1);
    $query = $this->db->get();
    $row = $query->row();
    //----
    if(@$row->level != null)
    {
      $this->db->select();
      $this->db->from('live_quiz');
      $this->db->where('level' , $row->level);
      $query = $this->db->get();
      return $query->result_array();
    }
    else {
      $data = array();
      return $data;
    }
  }
  //------------------
  function get_live_ask($limit)
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('status' , 1);
    $query = $this->db->get();
    $row = $query->row();
    //----
    if(@$row->level != null)
    {
      $this->db->select();
      $this->db->from('live_ask');
      $this->db->where('level' , $row->level);
      $query = $this->db->get();
      return $query->result_array();
    }
    else {
      $data = array();
      return $data;
    }
  }
  //------------------
  function heart_check($user_id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->heart != 0)
    {
      $heart = $row->heart - 1;
      $data = array(
        'heart' => $heart
      );
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
    }
    if($row->heart == 0)
    {
      return 1; // jon tamam kard
    }
    else {
      return 2;
    }
  }
  //------------------
  function user_live_score($user_id)
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('status' , 1);
    $this->db->where('show' , 0);
    $query = $this->db->get();
    $row = $query->row();
    $level = $row->level;
    //------------
    $this->db->select();
    $this->db->from('live_user_aw');
    $this->db->where('user_id' , $user_id);
    $this->db->where('aw_id' , $level);
    $query = $this->db->get();
    if($query->num_rows() == 0 and @$level != null)
    {
      $havij = array(
        'user_id' => $user_id,
        'aw_id' => $level
      );
      $this->db->insert('live_user_aw' , $havij);
      //------
      $this->db->select();
      $this->db->from('live_score');
      $this->db->where('user_id' , $user_id);
      $query = $this->db->get();
      if($query->num_rows() == 0)
      {
        $data = array(
          'user_id' => $user_id,
          'score' => 1
        );
        $this->db->insert('live_score' , $data);
      }
      else {
        $row = $query->row();
        $data = array(
          'user_id' => $user_id,
          'score' => $row->score+1
        );
        $this->db->where('user_id' , $user_id);
        $this->db->update('live_score' , $data);
      }
    }
    return TRUE;
  }
  //------------------
  function increateCoin($user_id , $amount)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->coin > $amount)
    {
      $coin = $row->coin - $amount;
      $data = array('coin' => $coin);
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
      return 1;
    }
    else {
      return 2;
    }
  }
  //------------------
  function check_game($user_id , $score)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games' , $data);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);*/
        //------
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 6;
        $data = array('score' => $score);
        $this->db->where('id' , $result[$i]['user_b']);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'score' => 6,
          'game_id' => $result[$i]['id'],
          'reason' => 'times',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);*/
        //------
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();*/
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 6;
        $data = array('score' => $score);
        $this->db->where('id' , $result[$i]['user_a']);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => 6,
          'game_id' => $result[$i]['id'],
          'reason' => 'times',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
      }
      /*if($result[$i]['ponit_a'] > $result[$i]['ponit_b'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);
      }
      if($result[$i]['ponit_b'] > $result[$i]['ponit_a'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);
      }*/
    }
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_b' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    //print_r($result);
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games' , $data);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data); */
        //------
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 6;
        $data = array('score' => $score);
        $this->db->where('id' , $result[$i]['user_b']);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'score' => 6,
          'game_id' => $result[$i]['id'],
          'reason' => 'times',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);*/
        //------
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();*/
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 6;
        $data = array('score' => $score);
        $this->db->where('id' , $result[$i]['user_a']);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => 6,
          'game_id' => $result[$i]['id'],
          'reason' => 'times',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
      }
      /*if($result[$i]['ponit_a'] > $result[$i]['ponit_b'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);
      }
      if($result[$i]['ponit_b'] > $result[$i]['ponit_a'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);
      }*/
    }
    return TRUE;
  }
  //------------------
  function get_score($game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('status' , 0);
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    //--------
    if($query->num_rows() == 1)
    {
      $this->db->select();
      $this->db->from('game_quiz');
      $this->db->where('user_id' , $row->user_b);
      $this->db->where('round_id' , 5);
      $this->db->where('game_id' , $game_id);
      $this->db->where('status !=' , 0);
      $query = $this->db->get();
      if($query->num_rows() == 3)
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $row->user_a);
        $query = $this->db->get();
        $row2 = $query->row();
        $score = $row2->score + $row->ponit_a;
        $data = array('score' => $score);
        $this->db->where('id' , $row->user_a);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $row->user_a,
          'score' => $row->ponit_a,
          'game_id' => $game_id,
          'reason' => 'end-game',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
        //-------
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $row->user_b);
        $query = $this->db->get();
        $row2 = $query->row();
        $score = $row2->score + $row->ponit_b;
        $data = array('score' => $score);
        $this->db->where('id' , $row->user_b);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $row->user_b,
          'score' => $row->ponit_b,
          'game_id' => $game_id,
          'reason' => 'end-game',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
        /*if($row->ponit_a !=  $row->ponit_b)
        {
          if($row->ponit_a > $row->ponit_b)
          {
            $user = $row->user_a;
            //$user2 = $row->user_b;
          }
          else{
            $user = $row->user_b;
            //$user2 = $row->user_a;
          }
          if(@$user != null)
          {
            $this->db->select();
            $this->db->from('users');
            $this->db->where('id' , $user);
            $query = $this->db->get();
            $row2 = $query->row();
            $score = $row2->score + 10;
            $data = array('score' => $score);
            $this->db->where('id' , $user);
            $this->db->update('users' , $data);
            $havij = array(
              'user_id' => $user,
              'score' => 10,
              'game_id' => $game_id,
              'reason' => 'win',
              'last' => $score
            );
            $this->db->insert('logs' , $havij);
            //-----------
            $this->db->select();
            $this->db->from('users');
            $this->db->where('id' , $user2);
            $query = $this->db->get();
            $row2 = $query->row();
            $score = $row2->score - 9;
            if($score < 0)
              $score = 0;
            $data = array('score' => $score);
            $this->db->where('id' , $user2);
            $this->db->update('users' , $data);
          }
        }
        */
        //-------------
        $data = array('status' => 1);
        $this->db->where('id' , $game_id);
        $this->db->update('games' , $data);
        return TRUE;
      }
    }
  }
  //------------------
  function check_round_game($user_id , $game_id , $round)
  {
    $this->db->select();
    $this->db->from('game_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id	' , $round);
    $query = $this->db->get();
    if($query->num_rows() != 0)
    {
      return 1; // boro gamecategory
    }
    else {
      $this->db->select();
      $this->db->from('game_round');
      $this->db->where('game_id' , $game_id);
      $this->db->order_by('id' , 'DESC');
      $this->db->limit(1,0);
      $query = $this->db->get();
      $row = $query->row();


      $this->db->select();
      $this->db->from('questions');
      $this->db->where('cate_id' , $row->cate_id);
      $this->db->order_by('id', 'RANDOM');
      $this->db->limit(3,0);
      $query = $this->db->get();
      $result = $query->result_array();
      //------------
      for($i=0;$i<3;$i++)
      {
        $data = array(
          'queue' => $i+1,
          'game_id' => $game_id,
          'round_id' => $round,
          'quiz_id' => $result[$i]['id'],
          'user_id' => $user_id
        );
        $this->db->insert('game_quiz' , $data);
      }
      return 2;
    }
  }
  //------------------
  function get_match_star($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('game_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('round_id' , $row->round);
    $this->db->where('game_id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $data = array();
    if($result[0]['status'] == 1)
    {
      $data['star1'] = 'ystar.png';
    }
    else {
      $data['star1'] = 'zstar.png';
    }
    if($result[1]['status'] == 1)
    {
      $data['star2'] = 'ystar.png';
    }
    else {
      $data['star2'] = 'zstar.png';
    }
    if($result[2]['status'] == 1)
    {
      $data['star3'] = 'ystar.png';
    }
    else {
      $data['star3'] = 'zstar.png';
    }
    return $data;
  }
  //------------------
  function check_change_leauge($user_id , $score)
  {

    /*if($score < 100)
    {
      $data = array('level' => 4);
      $this->db->where('user_id' , $user_id);
      $this->db->update('leauge' , $data);
    }
    elseif($score < 1000 )
    {
      $data = array('level' => 3);
      $this->db->where('user_id' , $user_id);
      $this->db->update('leauge' , $data);
    }
    elseif($score < 15000 )
    {
      $data = array('level' => 2);
      $this->db->where('user_id' , $user_id);
      $this->db->update('leauge' , $data);
    }*/
  }
  //------------------
  function levelup($user_id , $score , $coin)
  {

    if($score >= 1000)
    {
      if($coin >= 1000)
      {
        $money = $coin - 1000;
        $data = array('coin' => $money);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
        //------
        $data = array('level' => 3);
        $this->db->where('user_id' , $user_id);
        $this->db->update('leauge' , $data);
      }
      else {
        return -1; // not enouth coin
      }
    }
    if($score >= 25000 )
    {
      if($coin >= 10000)
      {
        $money = $coin - 10000;
        $data = array('coin' => $money);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
        //------
        $data = array('level' => 2);
        $this->db->where('user_id' , $user_id);
        $this->db->update('leauge' , $data);
      }
      else {
        return -1;
      }
    }
    if($score >= 50000 )
    {
      if($coin >= 25000)
      {
        $money = $coin - 25000;
        $data = array('coin' => $money);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
        //------
        $data = array('level' => 1);
        $this->db->where('user_id' , $user_id);
        $this->db->update('leauge' , $data);
      }
      else {
        return -1;
      }
    }
  }
  //------------------
  function search_user($keyword , $user_id)
  {
    $this->db->select('users.id , users.fname , users.lname , users.score , users.image');
    $this->db->select('leauge.level');
    $this->db->from('users');
    $this->db->join('leauge' , 'leauge.user_id = users.id');
    $this->db->like('users.token' , $keyword);
    $this->db->limit(20 , 0);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function request_friend($user_id , $friend_id)
  {
    $this->db->select();
    $this->db->from('friends');
    $this->db->where('user_id' , $user_id);
    $this->db->where('friend_id' , $friend_id);
    $query = $this->db->get();
    if($query->num_rows() == 0)
    {
      $data = array('user_id' => $user_id , 'friend_id' => $friend_id);
      $this->db->insert('friends' , $data);
      return 1;
    }
    else {
      return 2; // ghablan dos shodan dige
    }
  }
  //------------------
  function dead_time()
  {
    $this->db->select();
    $this->db->from('live');
    $this->db->where('id' , 2);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function dead_time_signle()
  {
    $this->db->select();
    $this->db->from('live');
    $this->db->where('id' , 3);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_inv_code($user_id)
  {
    $code = $this->generateRandomToken();
    $data = array(
      'code' => $code,
      'user_id' => $user_id,
      'status' => 0
    );
    $this->db->insert('code' , $data);
    return $code;
  }
  //------------------
  function check_version($version)
  {
    $this->db->select();
    $this->db->from('version');
    $this->db->where('id' , 1);
    $this->db->where('version' , $version);
    $query = $this->db->get();
    if($query->num_rows() == 0)
    {
      return 1; // version changed
    }
    else {
      return 2; // no new thing
    }
  }
  //------------------
  function new_game_coin($user_id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->coin > 50)
    {
      $coin = $row->coin - 50;
      $data = array('coin' => $coin);
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
      $this->db->select();
      $this->db->from('games');
      $this->db->where('user_a !=' , $user_id );
      $this->db->where('status' , 0);
      $query = $this->db->get();
      if($query->num_rows() >= 1)
      {
        $result = $query->result_array();
        $status = 0;
        for($i=0;$i<count($result);$i++)
        {
          if($result[$i]['user_a'] != $result[$i]['queue'] and $result[$i]['user_b'] == 0)
          {
            $status = 1;
            $data = array(
              'user_b' => $user_id,
              'queue' => $user_id,
            );
            $this->db->where('id' , $result[$i]['id']);
            $this->db->update('games' , $data);
            $ret = array(
              'status' => 1,
              'game_id' => $result[$i]['id']
            );
            return $ret; // game on old game
          }
        }
        //---------
        if($status == 0)
        {
          $data = array(
            'user_a' => $user_id,
            'user_b' => 0,
            'status' => 0,
            'ponit_a' => 0,
            'ponit_b' => 0,
            'queue' => $user_id
          );
          $this->db->insert('games' , $data);
          $last_id =  $this->db->insert_id();
          $ret = array(
            'status' => 0,
            'game_id' => $last_id
          );
          return $ret; //new game
        }
      }
      else {
        $data = array(
          'user_a' => $user_id,
          'user_b' => 0,
          'status' => 0,
          'ponit_a' => 0,
          'ponit_b' => 0,
          'queue' => $user_id
        );
        $this->db->insert('games' , $data);
        $last_id =  $this->db->insert_id();
        $ret = array(
          'status' => 0,
          'game_id' => $last_id
        );
        return $ret; //new game
      }
    }
    else {
      return -1;
    }
  }
  //------------------
  function new_game_coin_friend($user_id , $friend_id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->coin > 50)
    {
      $coin = $row->coin - 50;
      $data = array('coin' => $coin);
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
      $data = array(
        'user_a' => $user_id,
        'user_b' => $friend_id,
        'status' => 0,
        'ponit_a' => 0,
        'ponit_b' => 0,
        'queue' => $user_id
      );
      $this->db->insert('games' , $data);
      $last_id =  $this->db->insert_id();
      return $last_id; //new game
    }
    else {
      return -1;
    }
  }
  //------------------
  function check_round_five($game_id)
  {
    $this->db->select();
    $this->db->from('game_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , 5);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function qet_live_status($limit)
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('level' , $limit);
    $query = $this->db->get();
    $row = $query->row();
    return $row->status;
  }
  //------------------
  function check_avatar($user_id , $avatar)
  {
    $this->db->select();
    $this->db->from('avatar');
    $this->db->where('user_id' , $user_id);
    $this->db->where('avatar' , $avatar);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function check_active_avatar($user_id , $avatar)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $this->db->where('image' , $avatar);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function check_live_start()
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('id' , 1);
    $this->db->where('status' , 1);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function get_live_count_user()
  {
    $this->db->select();
    $this->db->from('live_score');
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function close_game($game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('status' , 0);
    $this->db->where('round >=' , 5);
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 1)
    {
      if($row->ponit_a > $row->ponit_b)
      {
        $user = $row->user_a;
      }
      else{
        $user = $row->user_b;
      }
      if(@$user != null)
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user);
        $query = $this->db->get();
        $row2 = $query->row();
        $score = $row2->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $user);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $user,
          'score' => 10,
          'game_id' => $game_id,
          'reason' => 'win-borke',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
        //-----------
      }
    }
    $data = array('status' => 1 , 'round' => 5);
    $this->db->where('id' , $game_id);
    $this->db->update('games' , $data);
    return true;
  }
  //------------------
  function check_game_time()
  {
    $this->db->select();
    $this->db->from('games');
    //$this->db->where('user_a' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games' , $data);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);*/
        //------
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 6;
        $data = array('score' => $score);
        $this->db->where('id' , $result[$i]['user_b']);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'score' => 6,
          'game_id' => $result[$i]['id'],
          'reason' => 'times',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        /*$this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);*/
        //------
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 6;
        $data = array('score' => $score);
        $this->db->where('id' , $result[$i]['user_a']);
        $this->db->update('users' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => 6,
          'game_id' => $result[$i]['id'],
          'reason' => 'times',
          'last' => $score
        );
        $this->db->insert('logs' , $havij);
      }
      /*if($result[$i]['ponit_a'] > $result[$i]['ponit_b'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_a']);
        $this->db->update('users' , $data);
      }
      if($result[$i]['ponit_b'] > $result[$i]['ponit_a'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $result[0]['user_b']);
        $this->db->update('users' , $data);
      }*/
    }
    return TRUE;
  }
  //----------
  function get_tips()
  {
    $this->db->select();
    $this->db->from('tips');
    $query = $this->db->get();
    $top = $query->num_rows();
    $top = $top - 1;
    $result = $query->result_array();
    $rand = rand(0,$top);
    return $result[$rand]['text'];
  }
  //----------
  function get_chat()
  {
    $this->db->select('chat.id , chat.message');
    $this->db->select('users.fname , users.lname , users.image');
    $this->db->from('chat');
    $this->db->join('users' , 'users.id = chat.user_id');
    $this->db->order_by('chat.id' , 'DESC');
    $this->db->limit(10,0);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function get_chat_last()
  {
    $this->db->select();
    $this->db->from('chat');
    $this->db->limit(1,0);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function get_new_message($last_id)
  {
    $this->db->select('chat.id , chat.message');
    $this->db->select('users.fname , users.lname , users.image');
    $this->db->from('chat');
    $this->db->join('users' , 'users.id = chat.user_id');
    $this->db->order_by('chat.id' , 'DESC');
    $this->db->where('chat.id <',$last_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function send_message_new($user_id , $message)
  {
    $data = array(
      'user_id' => $user_id,
      'message' => $message
    );
    $this->db->insert('chat' , $data);
    return TRUE;
  }
  //----------
  function get_live_state()
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('status' , 1);
    $query = $this->db->get();
    $row = $query->row();
    return @$row->level;
  }
  //----------
  function get_user_teams($user_id)
  {
    $this->db->select('user_teams.id , user_teams.user_id , user_teams.image , user_teams.name , user_teams.count');
    $this->db->select('users.fname , users.lname');
    $this->db->from('user_teams');
    $this->db->join('users' , 'users.id = user_teams.user_id');
    $this->db->join('user_teams_members' , 'user_teams_members.team_id = user_teams.id');
    $this->db->where('user_teams_members.user_id' , $user_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function add_teams($user_id , $coin , $name , $image)
  {
    if($coin >= 100)
    {
      $coin = $coin - 100;
      $data = array(
        'coin' => $coin
      );
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
      //-------
      $ret = array(
        'name' => $name,
        'image' => $image,
        'user_id' => $user_id,
        'count' => 1,
        'status' => 0,
        'rival' => 0
      );
      $this->db->insert('user_teams' , $ret);
      $last_id = $this->db->insert_id();
      $havij = array(
        'user_id' => $user_id,
        'team_id' => $last_id,
        'role' => 1
      );
      $this->db->insert('user_teams_members' , $havij);
      return 1;
    }
    else {
      return 2; // not enough coin
    }
  }
  //----------
  function get_user_teams_search($name)
  {
    $this->db->select('user_teams.id , user_teams.user_id , user_teams.image , user_teams.name , user_teams.count');
    $this->db->select('users.fname , users.lname');
    $this->db->from('user_teams');
    $this->db->join('users' , 'users.id = user_teams.user_id');
    $this->db->like('user_teams.name' , $name);
    $this->db->where('user_teams.status' , 0);
    $query = $this->db->get();
    //print_r($this->db->last_query());
    return $query->result_array();
  }
  //----------
  function join_team($id , $user_id , $coin)
  {
    if($coin >= 5)
    {
      $this->db->select();
      $this->db->from('user_teams');
      $this->db->where('status' , 0);
      $this->db->where('id' , $id);
      $query = $this->db->get();
      $row = $query->row();
      if($query->num_rows() == 1)
      {
        $this->db->select();
        $this->db->from('user_teams_members');
        $this->db->where('user_id' , $user_id);
        $this->db->where('team_id' , $id);
        $query = $this->db->get();
        if($query->num_rows() == 0)
        {
          $this->db->select();
          $this->db->from('user_teams_members');
          $this->db->where('team_id' , $id);
          $query = $this->db->get();
          if($query->num_rows() < 5)
          {
            $this->db->select();
            $this->db->from('user_teams_members');
            $this->db->where('team_id' , $id);
            $this->db->order_by('id' , 'DESC');
            $query = $this->db->get();
            $role = $query->num_rows() + 1;
            //------
            $data = array(
              'user_id' => $user_id,
              'team_id' => $id,
              'role' => $role
            );
            $this->db->insert('user_teams_members' , $data);

            $havij = array(
              'count' => $row->count + 1
            );
            $this->db->where('id' , $id);
            $this->db->update('user_teams' , $havij);
            //------
            $coin = $coin - 50;
            $ret = array('coin' => $coin);
            $this->db->where('id' , $user_id);
            $this->db->update('users' , $ret);
            //------
            return 1; // joined !
          }
          return 5; // capicity is fulled
        }
        else {
          return 3; // user was joined into teams
        }
      }
      else {
        return 2; // teams played game
      }
    }
    else {
      return 4; // not enougth coin
    }
  }
  //----------
  function get_team_info($id)
  {
    $this->db->select('user_teams.id , user_teams.user_id , user_teams.image , user_teams.name , user_teams.count , user_teams.status');
    $this->db->select('users.fname , users.lname');
    $this->db->from('user_teams');
    $this->db->join('users' , 'users.id = user_teams.user_id');
    $this->db->where('user_teams.id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function get_team_members($id)
  {
    $this->db->select('user_teams_members.id');
    $this->db->select('users.lname , users.fname , users.image , users.id user_id');
    $this->db->from('user_teams_members');
    $this->db->join('users' , 'users.id = user_teams_members.user_id');
    $this->db->where('user_teams_members.team_id' , $id);
    $query = $this->db->get();
    $result = $query->result_array();
    //---------
    $this->db->select();
    $this->db->from('user_teams');
    $this->db->where('id' , $id);
    $this->db->where('rival !=' , 0);
    $query = $this->db->get();
    $team_score = 0;
    $y_team_score = 0;
    if($query->num_rows() == 1)
    {
      $row = $query->row();
      $this->db->select('user_teams_members.id');
      $this->db->select('users.lname , users.fname , users.image , users.id user_id');
      $this->db->from('user_teams_members');
      $this->db->join('users' , 'users.id = user_teams_members.user_id');
      $this->db->where('user_teams_members.team_id' , $row->rival);
      $query = $this->db->get();
      $havij = $query->result_array();
    }
    for($i=0;$i<count($result);$i++)
    {
      if(count(@$havij) != 0)
      {
        $ret[$i]['m_name'] = $result[$i]['fname'];
        $ret[$i]['m_image'] = $result[$i]['image'];
        $this->db->select();
        $this->db->from('user_teams_games');

        $this->db->group_start();

        $this->db->or_where('user_a' , $result[$i]['user_id']);
        $this->db->or_where('user_b' , $result[$i]['user_id']);
        $this->db->group_end();

        $this->db->group_start();
        $this->db->or_where('team_id' , $row->rival);
        $this->db->or_where('team_id' , $id);
        $this->db->group_end();

        $query = $this->db->get();
        $games = $query->result_array();

        if($games[0]['user_a'] == $result[$i]['user_id'])
          $ret[$i]['m_score'] = $games[0]['ponit_a'];
        else {
          $ret[$i]['m_score'] = $games[0]['ponit_b'];
        }
        if($ret[$i]['m_score'] == null)
          $ret[$i]['m_score'] = 0;
        else {
          $team_score = $team_score + $ret[$i]['m_score'];
        }
        $ret[$i]['m_team_score'] = $team_score;
        //--------
        $ret[$i]['y_name'] = $havij[$i]['fname'];
        $ret[$i]['y_image'] = $havij[$i]['image'];
        $this->db->select();
        $this->db->from('user_teams_games');

        $this->db->group_start();
        $this->db->or_where('user_a' , $havij[$i]['user_id']);
        $this->db->or_where('user_b' , $havij[$i]['user_id']);
        $this->db->group_end();
        $this->db->group_start();
        $this->db->or_where('team_id' , $row->rival);
        $this->db->or_where('team_id' , $id);
        $this->db->group_end();
        $query = $this->db->get();
        //print_r($this->db->last_query());

        $games = $query->result_array();
        if($games[0]['user_a'] == $havij[$i]['user_id'])
          $ret[$i]['y_score'] = $games[0]['ponit_a'];
        else {
          $ret[$i]['y_score'] = $games[0]['ponit_b'];
        }
        if($ret[$i]['y_score'] == null)
          $ret[$i]['y_score'] = 0;
        else {
          $y_team_score = $y_team_score + $ret[$i]['y_score'];
        }
          $ret[$i]['y_team_score'] = $y_team_score;
      }
      else {
        $ret[$i]['m_name'] = $result[$i]['fname'];
        $ret[$i]['m_image'] = $result[$i]['image'];
        $ret[$i]['m_score'] = 0;
        $ret[$i]['y_name'] = '';
        $ret[$i]['y_image'] = '';
        $ret[$i]['y_score'] = 0;
        $ret[$i]['m_team_score'] = 0;
        $ret[$i]['y_team_score'] = 0;
      }
    }
    $ret[0]['m_team_score'] = $team_score;
    $ret[0]['y_team_score'] = $y_team_score;
    return $ret;
  }
  //----------
  function find_team($id , $user_id)
  {
    $this->db->select();
    $this->db->from('user_teams');
    $this->db->where('user_id' , $user_id);
    $this->db->where('id' , $id);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    if($query->num_rows() == 1)
    {
      $this->db->select();
      $this->db->from('user_teams_members');
      $this->db->where('team_id' , $id);
      $query = $this->db->get();
      if($query->num_rows() == 5)
      {
        $data = array('status' => 3);
        $this->db->where('id' , $id);
        $this->db->update('user_teams' , $data);
        //-------
        $this->db->select();
        $this->db->from('user_teams');
        $this->db->where('id !=' , $id);
        $this->db->where('status' , 3);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
          $row = $query->row();
          $rival = array('rival' => $row->id , 'status' => 1);
          $this->db->where('id' , $id);
          $this->db->update('user_teams' , $rival);
          //-----
          $team = array('rival' => $id , 'status' => 1);
          $this->db->where('id' , $row->id);
          $this->db->update('user_teams' , $team);
          return 2; // leauge playing is ready
        }
        else {
          return 1; // wait for another team will be ready to play
        }
      }
      else {
        return 4; // must have 5 memeber to play
      }
    }
    else {
      return 3; // not leader
    }
  }
  //----------
  function check_team_game($id , $user_id)
  {
    $this->db->select();
    $this->db->from('user_teams');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    $rival = $query->row();
    //------
    $this->check_team_game_time();
    $this->db->select();
    $this->db->from('user_teams_games');

    $this->db->group_start();
    $this->db->or_where('user_a' , $user_id );
    $this->db->or_where('user_b' , $user_id);
    $this->db->group_end();

    $this->db->group_start();
    $this->db->or_where('team_id' , $rival->rival);
    $this->db->or_where('team_id' , $id);
    $this->db->group_end();
    $query = $this->db->get();
    $game = $query->row();
    //print_r($this->db->last_query());die();
    if($query->num_rows() == 0)
    {

      //-----
      $this->db->select();
      $this->db->from('user_teams_members');
      $this->db->where('user_id' , $user_id);
      $this->db->where('team_id' , $id);
      $query = $this->db->get();
      $role = $query->row();
      //-----
      $this->db->select();
      $this->db->from('user_teams_members');
      $this->db->where('team_id' , $rival->rival);
      $this->db->where('role' , $role->role);
      $query = $this->db->get();
      $user = $query->row();
      $data = array(
        'user_a' => $user_id,
        'user_b' => $user->user_id,
        'status' => 0,
        'ponit_a' => 0,
        'ponit_b' => 0,
        'queue' => $user_id,
        'team_id' => $id
      );
      $this->db->insert('user_teams_games' , $data);
      $last_id =  $this->db->insert_id();
      $ret = array(
        'status' => 1,
        'game_id' => $last_id
      );
      return $ret; //new game
    }
    else {
      $ret = array(
        'status' => 0,
        'game_id' => $game->id
      );
      return $ret; //old game
    }
  }
  //----------
  function check_team_game_time()
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {
        $data = array(
          'status' => 1 ,
          'round' => 5,
          'ponit_a' => 0,
          'ponit_b' => 3,
          'game_time' => 1
        );
        $this->db->where('id' , $result[$i]['id']);
        $this->db->update('user_teams_games' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'score' => 1,
          'game_id' => $result[$i]['id'],
          'reason' => 'group_game'
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        $data = array(
          'status' => 1 ,
          'round' => 5,
          'ponit_a' => 3,
          'ponit_b' => 0,
          'game_time' => 1
        );
        $this->db->where('id' , $result[$i]['id']);
        $this->db->update('user_teams_games' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => 1,
          'game_id' => $result[$i]['id'],
          'reason' => 'group_game'
        );
        $this->db->insert('logs' , $havij);
      }
    }
    return TRUE;
  }
  //----------
  function set_category_game_team($game_id , $category_id , $user_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round = $row->round+1;
    $data = array(
      'round' => $round
    );
    $this->db->where('id' , $row->id);
    $this->db->update('user_teams_games' , $data);
    $ret = array(
      'game_id' => $game_id,
      'cate_id' => $category_id,
    );
    $this->db->insert('user_teams_round' , $ret);
    //------------
    $this->db->select();
    $this->db->from('questions');
    $this->db->where('cate_id' , $category_id);
    $this->db->order_by('id', 'RANDOM');
    $this->db->limit(3,0);
    $query = $this->db->get();
    $result = $query->result_array();
    //------------
    for($i=0;$i<3;$i++)
    {
      $data = array(
        'queue' => $i+1,
        'game_id' => $game_id,
        'round_id' => $round,
        'quiz_id' => $result[$i]['id'],
        'user_id' => $user_id
      );
      $this->db->insert('user_teams_quiz' , $data);
    }
    return true;
  }
  //----------
  function get_match_star_team($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('user_teams_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('round_id' , $row->round);
    $this->db->where('game_id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $data = array();
    if($result[0]['status'] == 1)
    {
      $data['star1'] = 'ystar.png';
    }
    else {
      $data['star1'] = 'zstar.png';
    }
    if($result[1]['status'] == 1)
    {
      $data['star2'] = 'ystar.png';
    }
    else {
      $data['star2'] = 'zstar.png';
    }
    if($result[2]['status'] == 1)
    {
      $data['star3'] = 'ystar.png';
    }
    else {
      $data['star3'] = 'zstar.png';
    }
    return $data;
  }
  //----------
  function get_game_infos_team($game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function check_round_five_team($game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , 5);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //----------
  function get_score_team($game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('status' , 0);
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    //--------
    if($query->num_rows() == 1)
    {
      $this->db->select();
      $this->db->from('user_teams_quiz');
      $this->db->where('user_id' , $row->user_b);
      $this->db->where('round_id' , 5);
      $this->db->where('game_id' , $game_id);
      $this->db->where('status !=' , 0);
      $query = $this->db->get();
      if($query->num_rows() == 3)
      {
        if($row->ponit_a !=  $row->ponit_b)
        {
          if($row->ponit_a > $row->ponit_b)
          {
            $user = $row->user_a;
            //$user2 = $row->user_b;
          }
          else{
            $user = $row->user_b;
            //$user2 = $row->user_a;
          }
          if(@$user != null)
          {
            $havij = array(
              'user_id' => $user,
              'score' => 1,
              'game_id' => $game_id,
              'reason' => 'win-team'
            );
            $this->db->insert('logs' , $havij);
          }
        }
        //-------------
        $data = array('status' => 1);
        $this->db->where('id' , $game_id);
        $this->db->update('user_teams_games' , $data);
        return TRUE;
      }
    }
  }
  //----------
  function get_quiz_game_round_team($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round_id = $row->round;
    //--------
    $this->db->select('questions.id , questions.name , category.name cate_name , user_teams_quiz.id quiz_id');
    $this->db->from('user_teams_quiz');
    $this->db->join('questions' , 'questions.id = user_teams_quiz.quiz_id');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $this->db->where('status' , 0);
    //$this->db->where('seen' , 0);
    $this->db->order_by('user_teams_quiz.id' , 'DESC');
    $this->db->limit(1,0);
    $query = $this->db->get();
    $result = $query->result_array();
    if(count($result) == 1)
    {
      $data = array('seen' => 1);
      $this->db->where('id' , $result[0]['quiz_id']);
      $this->db->update('user_teams_quiz' , $data);
    }
    return $result;
  }
  //----------
  function set_awnser_team($quiz_id , $user_id , $game_id , $awnser_id)
  {
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('id' , $awnser_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->status == 1)
    {
      $this->db->select();
      $this->db->from('user_teams_games');
      $this->db->where('id' , $game_id);
      $query = $this->db->get();
      $row2 = $query->row();
      $this->db->select();
      $this->db->from('user_teams_quiz');
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $query = $this->db->get();
      $row3 = $query->row();
      if($row3->status == 0)
      {
        if($row2->user_a == $user_id)
        {
          $data = array(
            'ponit_a' => $row2->ponit_a+1
          );
        }
        else {
          $data = array(
            'ponit_b' => $row2->ponit_b+1
          );
        }
        $this->db->where('id' , $game_id);
        $this->db->update('user_teams_games' , $data);
        //---------
        $data = array('status' => 1);
        $this->db->where('game_id' , $game_id);
        $this->db->where('quiz_id' , $quiz_id);
        $this->db->where('user_id' , $user_id);
        $this->db->update('user_teams_quiz' , $data);
      }
      $this->db->select();
      $this->db->from('awsners');
      $this->db->where('ques_id' , $quiz_id);
      $query = $this->db->get();
      $result = $query->result_array();
      $result[0]['correct_aw'] = 1;
      return $result;
    }
    else {
      $data = array('status' => 2);
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $this->db->update('user_teams_quiz' , $data);
      //---------
      $this->db->select();
      $this->db->from('awsners');
      $this->db->where('ques_id' , $quiz_id);
      $query = $this->db->get();
      $result = $query->result_array();
      $result[0]['correct_aw'] = 2;
      return $result;
    }
  }
  //----------
  function dont_awnser_team($quiz_id , $user_id , $game_id)
  {
    $data = array('status' => 2);
    $this->db->where('game_id' , $game_id);
    $this->db->where('quiz_id' , $quiz_id);
    $this->db->where('user_id' , $user_id);
    $this->db->update('user_teams_quiz' , $data);
    //---------
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('ques_id' , $quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $result[0]['correct_aw'] = 2;
    return $result;
  }
  //----------
  function change_queue_team($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $result = $query->result_array();

      if($row->queue == $row->user_a)
      {
        $turn = $row->user_b;
        //echo 1;
        $data = array('queue' => $row->user_b);
        $this->db->where('id' , $game_id);
        $this->db->update('user_teams_games' , $data);
      }
      elseif($row->queue == $row->user_b) {
        $turn = $row->user_a;
        //echo 2;
        $data = array('queue' => $row->user_a);
        $this->db->where('id' , $game_id);
        $this->db->update('user_teams_games' , $data);
      }
    return $turn;
  }
  //----------
  function check_game_team($user_id , $score)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('user_a' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('user_teams_games' , $data);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {
        $data = array(
          'status' => 1 ,
          'round' => 5,
          'ponit_a' => 0,
          'ponit_b' => 3,
          'game_time' => 1
        );
        $this->db->where('id' , $result[$i]['id']);
        $this->db->update('user_teams_games' , $data);

        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'score' => 1,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-team'
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        $data = array(
          'status' => 1 ,
          'round' => 5,
          'ponit_a' => 3,
          'ponit_b' => 0,
          'game_time' => 1
        );
        $this->db->where('id' , $result[$i]['id']);
        $this->db->update('user_teams_games' , $data);
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => 1,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-team'
        );
        $this->db->insert('logs' , $havij);
      }
    }
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('user_b' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    //print_r($result);
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('user_teams_games' , $data);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'score' => 1,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-team'
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => 1,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-team'
        );
        $this->db->insert('logs' , $havij);
      }
    }
    return TRUE;
  }
  //----------
  function get_game_info_team($game_id)
  {
    /*$this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $this->db->select();
    $this->db->from('user_teams_quiz');
    $this->db->where('round_id' , $result[0]['round']);
    $this->db->where('game_id' , $game_id);
    $this->db->where('user_id' , $result[0]['queue']);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    if($query->num_rows() != 0)
    {
      $data = array(
        'status' => 2
      );
      $this->db->where('round_id' , $result[0]['round']);
      $this->db->where('game_id' , $game_id);
      $this->db->where('user_id' , $result[0]['queue']);
      $this->db->where('status' , 0);
      $this->db->update('user_teams_quiz' , $data);
      //-------
      if($result[0]['queue'] == $result[0]['user_a'])
      {
        $data = array(
          'queue' => $result[0]['user_b'],
        );
      }
      else {
        $data = array(
          'queue' => $result[0]['user_a'],
        );
      }
      $this->db->where('id' , $game_id);
      $this->db->update('user_teams_games' , $data);
    }*/
    //------
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //----------
  function get_categroy_round_name_team($game_id , $i)
  {
    $this->db->select('category.name');
    $this->db->from('user_teams_round');
    $this->db->where('user_teams_round.game_id' , $game_id);
    $this->db->join('category' , 'category.id = user_teams_round.cate_id');
    $this->db->limit(1,$i);
    $query = $this->db->get();
    $row = $query->row();
    if(@$row->name == null)
    {
      $name = '';
    }
    else {
      $name = $row->name;
    }
    return $name;
  }
  //----------
  function get_round_score_team($game_id , $round_id , $user_id)
  {
    $this->db->select();
    $this->db->from('user_teams_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function get_round_score_y_team($game_id , $round_id , $user_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->user_a == $user_id)
    {
      $id = $row->user_b;
    }
    else {
      $id = $row->user_a;
    }
    $this->db->select();
    $this->db->from('user_teams_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function close_game_team($game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('status' , 0);
    $this->db->where('round' , 5);
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    if($query->num_rows() == 1)
    {
      if($row->ponit_a > $row->ponit_b)
      {
        $user = $row->user_a;
      }
      else{
        $user = $row->user_b;
      }
      if(@$user != null)
      {
        $havij = array(
          'user_id' => $user,
          'score' => 1,
          'game_id' => $game_id,
          'reason' => 'win-borke-team'
        );
        $this->db->insert('logs' , $havij);
        //-----------
      }
    }
    $data = array('status' => 1 , 'round' => 5);
    $this->db->where('id' , $game_id);
    $this->db->update('user_teams_games' , $data);
    return true;
  }
  //------------------
  function check_round_game_team($user_id , $game_id , $round)
  {
    $this->db->select();
    $this->db->from('user_teams_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id	' , $round);
    $query = $this->db->get();
    if($query->num_rows() != 0)
    {
      return 1; // boro gamecategory
    }
    else {
      $this->db->select();
      $this->db->from('user_teams_round');
      $this->db->where('game_id' , $game_id);
      $this->db->order_by('id' , 'DESC');
      $this->db->limit(1,0);
      $query = $this->db->get();
      $row = $query->row();
      //print_r($this->db->last_query());

      $this->db->select();
      $this->db->from('questions');
      $this->db->where('cate_id' , $row->cate_id);
      $this->db->order_by('id', 'RANDOM');
      $this->db->limit(3,0);
      $query = $this->db->get();
      $result = $query->result_array();
      //------------
      for($i=0;$i<3;$i++)
      {
        $data = array(
          'queue' => $i+1,
          'game_id' => $game_id,
          'round_id' => $round,
          'quiz_id' => $result[$i]['id'],
          'user_id' => $user_id
        );
        $this->db->insert('user_teams_quiz' , $data);
      }
      return 2;
    }
  }
  //------------------
  function get_live_ask_active($game)
  {
    $this->db->select();
    $this->db->from('live_ask');
    $this->db->where('level' , $game);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_live_quiz_active($game)
  {
    $this->db->select();
    $this->db->from('live_quiz');
    $this->db->where('level' , $game);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_team_id($game_id)
  {
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    return $row->team_id;
  }
  //------------------
  function check_team_game_end($team_id)
  {
    $this->db->select();
    $this->db->from('user_teams');
    $this->db->where('id' , $team_id);
    $query = $this->db->get();
    $rival = $query->row();
    //---------
    $this->db->select();
    $this->db->from('user_teams_games');
    $this->db->where('status' , 1);
    $this->db->group_start();
    $this->db->or_where('team_id' , $rival->rival);
    $this->db->or_where('team_id' , $team_id);
    $this->db->group_end();
    $query = $this->db->get();
    $result = $query->result_array();
    //echo $this->db->last_query();die();
    if(count($result) == 5)
    {
      $this->db->select();
      $this->db->from('user_teams');
      $this->db->where('id' , $team_id);
      $this->db->where('status' , 1);
      $query = $this->db->get();
      if($query->num_rows() == 1)
      {
        //echo 2;die();
        $this->db->select('users.id , users.score , user_teams_members.role');
        $this->db->from('user_teams_members');
        $this->db->join('users' , 'users.id = user_teams_members.user_id');
        $this->db->where('user_teams_members.team_id' , $team_id);
        $query = $this->db->get();
        $members = $query->result_array();
        //echo $this->db->last_query();die();
        //echo 3;die();
        $score = 0;
        $yscore = 0;
        for($i=0;$i<count($result);$i++)
        {
          if($result[$i]['user_a'] == $members[$i]['id'])
          {
            $score = $score + $result[$i]['ponit_a'];
            $yscore = $yscore + $result[$i]['ponit_b'];
          }
          else if($result[$i]['user_b'] == $members[$i]['id']){
            $score = $score + $result[$i]['ponit_b'];
            $yscore = $yscore + $result[$i]['ponit_a'];
          }
        }
        if($score > $yscore)
        {
          for($i=0;$i<count($members);$i++)
          {
            if($members[$i]['role'] == 1)
            {
              $score = $result[$i]['score'] + 300;
            }
            else {
              $score = $result[$i]['score'] + 100;
            }
            $data = array('score' => $score);
            $this->db->where('id' , $members[$i]['id']);
            $this->db->update('users' , $data); // get score
          }
          $ret = array('status' => 2);
          $this->db->where('id' , $team_id);
          $this->db->update('user_teams' , $ret);
          //------
          $ret = array('status' => 2);
          $this->db->where('id' , $rival->rival);
          $this->db->update('user_teams' , $ret);
          return 3; // done leauge
        }
        else if($score < $yscore)
        {
          $this->db->select('users.id , users.score , user_teams_members.role');
          $this->db->from('user_teams_members');
          $this->db->join('users' , 'users.id = user_teams_members.user_id');
          $this->db->where('user_teams_members.team_id' , $rival->rival);
          $query = $this->db->get();
          $members = $query->result_array();
          for($i=0;$i<count($members);$i++)
          {
            if($members[$i]['role'] == 1)
            {
              $score = $result[$i]['score'] + 300;
            }
            else {
              $score = $result[$i]['score'] + 100;
            }
            $data = array('score' => $score);
            $this->db->where('id' , $members[$i]['id']);
            $this->db->update('users' , $data); // get score
          }
          $ret = array('status' => 2);
          $this->db->where('id' , $team_id);
          $this->db->update('user_teams' , $ret);
          //------
          $ret = array('status' => 2);
          $this->db->where('id' , $rival->rival);
          $this->db->update('user_teams' , $ret);
          return 3; // done leauge
        }
        else {
          return 4; // team lose match
        }
      }
      else {
        return 2; // teams not acitve on play mode
      }
    }
    else {
      return 1; // all players not played yet
    }
  }
  //------------------
  function user_avatar_game($game_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('games.id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    //---------
    $this->db->select('leuage_image.image , users.fan , users.image user_image , users.score , users.fname');
    $this->db->from('users');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
    $this->db->where('users.id' , $result[0]['user_a']);
    $query = $this->db->get();
    $user_a = $query->row();
    //---------
    $this->db->select();
    $this->db->from('users');
    $this->db->where('score >' , $user_a->score);
    $this->db->order_by('score' , 'DESC');
    $query = $this->db->get();
    $score_a = $query->num_rows()+1;
    //---------
    if($result[0]['user_b'] == 0)
    {
      $data = array(
        'user_a' => $user_a->image,
        'user_b' => 'dribbl.png',
        'user_b_name' => 'حریف تصادفی',
        'user_a_name' => $user_a->fname,
        'user_b_score' => 0,
        'user_a_score' => $user_a->score,
        'user_a_level' => $score_a,
        'user_b_level' => 0,
        'user_a_image' => $user_a->user_image,
        'user_b_image' => 'dribbl.png',
      );
    }
    else {
      $this->db->select('leuage_image.image , users.fan , users.image user_image , users.score , users.fname');
      $this->db->from('users');
      $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
      $this->db->where('users.id' , $result[0]['user_b']);
      $query = $this->db->get();
      $user_b = $query->row();
      //---------
      $this->db->select();
      $this->db->from('users');
      $this->db->where('score >' , $user_b->score);
      $this->db->order_by('score' , 'DESC');
      $query = $this->db->get();
      $score_b = $query->num_rows()+1;
      //---------
      $data = array(
        'user_a' => $user_a->image,
        'user_b' => $user_b->image,
        'user_b_name' => $user_b->fname,
        'user_a_name' => $user_a->fname,
        'user_b_score' => $user_b->score,
        'user_a_score' => $user_a->score,
        'user_a_level' => $score_a,
        'user_b_level' => $score_b,
        'user_a_image' => $user_a->user_image,
        'user_b_image' => $user_b->user_image,
      );
    }
    return $data;
  }
  //------------------
  function get_leauges()
  {
    $this->db->select();
    $this->db->from('teams_league');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_teams_by_leauges($leauge_id)
  {
    $this->db->select();
    $this->db->from('leuage_image');
    $this->db->where('team_id' , $leauge_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function show_live_awsner()
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('show' , 1);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_think_level($id)
  {
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $id);
    $query = $this->db->get();
    if($query->num_rows() == 1)
    {
      $row = $query->row();
      $ret = array();
      for($i=0;$i<200;$i++)
      {
        $ret[$i]['level'] = $i + 1;
        if($row->level > $i+1)
        {
          $ret[$i]['status'] = 1;
          $this->db->select();
          $this->db->from('think_history');
          $this->db->where('level' , $i+1);
          $this->db->where('user_id' , $id);
          $query = $this->db->get();
          //print_r($this->db->last_query());
          @$star = @$query->row();
          if(@$star->star != null)
            $ret[$i]['star'] = @$star->star;
          else {
            $ret[$i]['star'] = 0;
          }
        }
        elseif($row->level == $i+1)
        {
          $ret[$i]['status'] = 2;
          $this->db->select();
          $this->db->from('think_history');
          $this->db->where('level' , $i+1);
          $this->db->where('user_id' , $id);
          $query = $this->db->get();
          //print_r($this->db->last_query());
          @$star = @$query->row();
          if(@$star->star != null)
            $ret[$i]['star'] = @$star->star;
          else {
            $ret[$i]['star'] = 4;
          }
        }
        else {
          $ret[$i]['status'] = 0;
          $ret[$i]['star'] = 5;
        }

      }
      $ret[0]['active'] = $row->level;
      return $ret;
    }
    else {
      $data = array(
        'user_id' => $id,
        'level' => 1
      );
      $this->db->insert('think_level' , $data);
      $ret = array();
      for($i=0;$i<200;$i++)
      {
        $ret[$i]['level'] = $i + 1;
        if($i == 0)
        {
          $ret[$i]['status'] = 1;
        }
        else {
          $ret[$i]['status'] = 0;
        }

      }
      $ret[0]['active'] = 1;
      return $ret;
    }
  }
  //------------------
  function get_think_star($user_id)
  {
    $this->db->select();
    $this->db->from('think_history');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $ret = 0;
    for($i=0;$i<count($result);$i++)
    {
      $ret = $ret + $result[$i]['star'];
    }
    return $ret;
  }
  //------------------
  function get_think_quiz_help($id , $coin)
  {
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $id);
    $query = $this->db->get();
    $row = $query->row();
    //----------------
    $this->db->select();
    $this->db->from('think_quiz');
    $this->db->where('level' , $row->level);
    $this->db->order_by('id', 'RANDOM');
    $this->db->limit(1,0);
    $query = $this->db->get();
    $result = $query->result_array();
    //-----------------
    $this->db->select();
    $this->db->from('think_user_quiz');
    $this->db->where('user_id' , $id);
    $this->db->where('level' , $row->level);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    $quiz_user = $query->row();
    if($query->num_rows() == 1)
    {
      $data = array('status' => 3);
      $this->db->where('id' , $quiz_user->id);
      $this->db->update('think_user_quiz' , $data);
      //-------
      $coin = $coin - 100;
      if($coin <= 0)
      {
        $coin = 0;
      }
      $havij = array('coin' => $coin);
      $this->db->where('id' , $id);
      $this->db->update('users' , $havij);
    }
    $ret = array(
      'user_id' => $id,
      'level' => $row->level,
      'status' => 0,
      'quiz_id' => $result[0]['id'],
    );
    $this->db->insert('think_user_quiz' , $ret);
    return $result;
  }
  //------------------
  function get_think_quiz($id , $heart)
  {
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $id);
    $query = $this->db->get();
    $row = $query->row();
    //----------------
    $this->db->select();
    $this->db->from('think_quiz');
    $this->db->where('level' , $row->level);
    $this->db->order_by('id', 'RANDOM');
    $this->db->limit(1,0);
    $query = $this->db->get();
    $result = $query->result_array();
    //-----------------
    $this->db->select();
    $this->db->from('think_user_quiz');
    $this->db->where('user_id' , $id);
    $this->db->where('level' , $row->level);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    $quiz_user = $query->row();
    if($query->num_rows() == 1)
    {
      $data = array('status' => 3);
      $this->db->where('id' , $quiz_user->id);
      $this->db->update('think_user_quiz' , $data);
      //-------
      $heart = $heart - 1;
      if($heart <= 0)
      {
        $heart = 0;
      }
      $havij = array('heart' => $heart);
      $this->db->where('id' , $id);
      $this->db->update('users' , $havij);
    }
    $ret = array(
      'user_id' => $id,
      'level' => $row->level,
      'status' => 0,
      'quiz_id' => $result[0]['id'],
    );
    $this->db->insert('think_user_quiz' , $ret);
    return $result;
  }
  //------------------
  function get_think_ask($id)
  {
    $this->db->select('think_aw.id , think_aw.title');
    $this->db->from('think_aw');
    $this->db->where('quiz_id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function set_think_aw($user_id , $id , $heart , $star)
  {
    $this->db->select();
    $this->db->from('think_aw');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    $row = $query->row();
    //print_r($row);die();
    //------
    if($row->status == 1)
    {
      $data = array(
        'status' => 1
      );
      $this->db->where('user_id' , $user_id);
      $this->db->where('quiz_id' , $row->quiz_id);
      $this->db->where('status' , 0);
      $this->db->update('think_user_quiz' , $data);
      //------
      $this->db->select();
      $this->db->from('think_level');
      $this->db->where('user_id' , $user_id);
      $query = $this->db->get();
      $row = $query->row();
      $level = $row->level + 1;
      //------
      $ret = array('level' => $level);
      $this->db->where('user_id' , $user_id);
      $this->db->update('think_level' , $ret);
      $aw = array(
        'status' => 1,
        'aw_id' => $id
      );
      if($star < 33)
      {
        $star = 3;
      }
      elseif($star >= 33)
      {
        $star = 2;
      }
      elseif($star >= 66)
      {
        $star = 1;
      }
      $levelData = array(
        'user_id' => $user_id,
        'level' => $row->level,
        'star' => $star,
      );
      $this->db->insert('think_history' , $levelData);
      return $aw;
    }
    else {
      $data = array(
        'status' => 2
      );
      $this->db->where('user_id' , $user_id);
      $this->db->where('quiz_id' , $row->quiz_id);
      $this->db->where('status' , 0);
      $this->db->update('think_user_quiz' , $data);
      //------
      $heart = $heart - 1;
      if($heart <= 0)
      {
        $heart = 0;
      }
      $ret = array('heart' => $heart);
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $ret);
      //----------
      $this->db->select();
      $this->db->from('think_aw');
      $this->db->where('quiz_id' , $row->quiz_id);
      $this->db->where('status' , 1);
      $query = $this->db->get();
      $aw_data = $query->row();
      //----------
      $aw = array(
        'status' => 0,
        'aw_id' => $aw_data->id,
        'heart' => $heart
      );
      return $aw;
    }
  }
  //------------------
  function thinks_times_up($user_id , $heart)
  {
    $heart = $heart - 1;
    if($heart <= 0)
    {
      $heart = 0;
    }
    $ret = array('heart' => $heart);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $ret);
    //------
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('think_user_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('level' , $row->level);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    $quiz_user = $query->row();
    //--------
    $data = array('status' => 4);
    $this->db->where('id' , $quiz_user->id);
    $this->db->update('think_user_quiz' , $data);
    //--------
    $this->db->select();
    $this->db->from('think_aw');
    $this->db->where('quiz_id' , $quiz_user->quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    //print_r($this->db->last_query());
    return $result;
  }
  //------------------
  function thinks_help($user_id , $heart)
  {
    $heart = $heart - 1;
    if($heart <= 0)
    {
      $heart = 0;
    }
    $ret = array('heart' => $heart);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $ret);
    //------
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('think_user_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('level' , $row->level);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    $quiz_user = $query->row();
    //--------
    $data = array('status' => 4);
    $this->db->where('id' , $quiz_user->id);
    $this->db->update('think_user_quiz' , $data);
    //--------
    $this->db->select();
    $this->db->from('think_aw');
    $this->db->where('quiz_id' , $quiz_user->quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function thinks_bomb($user_id , $coin)
  {
    $coin = $coin - 200;
    if($coin <= 0)
    {
      $coin = 0;
    }
    $ret = array('coin' => $coin);
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $ret);
    //------
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('think_user_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('level' , $row->level);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    $quiz_user = $query->row();
    //--------
    $data = array('status' => 4);
    $this->db->where('id' , $quiz_user->id);
    $this->db->update('think_user_quiz' , $data);
    //--------
    $this->db->select();
    $this->db->from('think_aw');
    $this->db->where('quiz_id' , $quiz_user->quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //------------------
  function leaugeViewSingle()
  {
    $this->db->select('users.fname , users.image , users.fan');
    $this->db->select('leuage_image.image fan_image');
    $this->db->select('think_level.level score');
    $this->db->from('think_level');
    $this->db->join('users' , 'users.id = think_level.user_id');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
    $this->db->order_by('think_level.level' , 'DESC');
    $this->db->limit(20,0);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_solo_rate($user_id)
  {
    $this->db->select();
    $this->db->from('think_level');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if(@$row->level != null)
    {
      $this->db->select();
      $this->db->from('think_level');
      $this->db->where('level >' , $row->level);
      $query = $this->db->get();
      return $query->num_rows();
    }
    else {
      return 0;
    }
  }
  //------------------
  function new_game_coin_bet($user_id , $coin , $amount)
  {
    $this->check_game_time_coin();
    if($coin <= $amount)
    {
      $newAmount = $amount - $coin;
      $havij = array('coin' => $newAmount);
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $havij);
      //-------
      $this->db->select();
      $this->db->from('games_coin');
      $this->db->where('user_a !=' , $user_id );
      $this->db->where('coin' , $coin);
      $this->db->where('status' , 0);
      $query = $this->db->get();
      if($query->num_rows() >= 1)
      {
        $result = $query->result_array();
        $status = 0;
        for($i=0;$i<count($result);$i++)
        {
          if($result[$i]['user_a'] != $result[$i]['queue'] and $result[$i]['user_b'] == 0)
          {
            $status = 1;
            $data = array(
              'user_b' => $user_id,
              'queue' => $user_id,
            );
            $this->db->where('id' , $result[$i]['id']);
            $this->db->update('games_coin' , $data);
            $ret = array(
              'status' => 1,
              'game_id' => $result[$i]['id']
            );
            return $ret; // game on old game
          }
        }
        //---------
        if($status == 0)
        {
          $data = array(
            'user_a' => $user_id,
            'user_b' => 0,
            'status' => 0,
            'ponit_a' => 0,
            'ponit_b' => 0,
            'queue' => $user_id,
            'coin' => $coin
          );
          $this->db->insert('games_coin' , $data);
          $last_id =  $this->db->insert_id();
          $ret = array(
            'status' => 0,
            'game_id' => $last_id
          );
          return $ret; //new game
        }
      }
      else {
        $data = array(
          'user_a' => $user_id,
          'user_b' => 0,
          'status' => 0,
          'ponit_a' => 0,
          'ponit_b' => 0,
          'queue' => $user_id,
          'coin' => $coin
        );
        $this->db->insert('games_coin' , $data);
        $last_id =  $this->db->insert_id();
        $ret = array(
          'status' => 0,
          'game_id' => $last_id
        );
        return $ret; //new game
      }
    }
    else {
      return -1; // not enouth gold
    }
  }
  //------------------
  function check_game_time_coin()
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games_coin' , $data);
      $cost = (30 / 100) * $result[$i]['coin'];
      $cost = ceil($cost);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {

        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $coin = $row->coin + $cost + $result[$i]['coin'];
        $data = array('coin' => $coin);
        $this->db->where('id' , $result[$i]['user_b']);
        $this->db->update('users' , $data);
        //---------
        $this->db->select();
        $this->db->from('coin_leauge');
        $this->db->where('user_id', $result[$i]['user_b']);
        $query = $this->db->get();
        $row3 = $query->row();

        $havij2 = array(
          'coin' => $cost + $row3->coin
        );
        $this->db->where('user_id' , $result[$i]['user_b']);
        $this->db->update('coin_leauge' , $havij2);
        //---------
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'coin' => $cost,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-coin-game',
          'last' => $coin
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $coin = $row->coin + $cost + $result[$i]['coin'];
        $data = array('coin' => $coin);
        $this->db->where('id' , $result[$i]['user_a']);
        $this->db->update('users' , $data);
        //---------
        $this->db->select();
        $this->db->from('coin_leauge');
        $this->db->where('user_id', $result[$i]['user_a']);
        $query = $this->db->get();
        $row3 = $query->row();

        $havij2 = array(
          'coin' => $cost + $row3->coin
        );
        $this->db->where('user_id' , $result[$i]['user_a']);
        $this->db->update('coin_leauge' , $havij2);
        //---------
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => $cost,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-coin-game',
          'last' => $coin
        );
        $this->db->insert('logs' , $havij);
      }
    }
    return TRUE;
  }
  //-------------------
  function user_avatar_game_coin($game_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    //---------
    $this->db->select('leuage_image.image , users.fan , users.image user_image , users.score , users.fname , users.coin');
    $this->db->from('users');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
    $this->db->where('users.id' , $result[0]['user_a']);
    $query = $this->db->get();
    $user_a = $query->row();
    //---------
    $this->db->select();
    $this->db->from('coin_leauge');
    $this->db->where('user_id' , $result[0]['user_a']);
    $query = $this->db->get();
    $coinData = $query->row();
    if(@$coinData->coin == null)
    {
      $billy = array(
        'user_id' => $result[0]['user_a'],
        'coin' => 0
      );
      $this->db->insert('coin_leauge' , $billy);
    }
    $this->db->select();
    $this->db->from('coin_leauge');
    $this->db->where('coin >' , $coinData->coin);
    $this->db->order_by('coin' , 'DESC');
    $query = $this->db->get();
    $score_a = $query->num_rows()+1;
    //---------
    if($result[0]['user_b'] == 0)
    {
      $data = array(
        'user_a' => $user_a->image,
        'user_b' => 'dribbl.png',
        'user_b_name' => 'حریف تصادفی',
        'user_a_name' => $user_a->fname,
        'user_b_score' => 0,
        'user_a_score' => $score_a,
        'user_a_level' => $result[0]['coin'],
        'user_b_level' => $result[0]['coin'],
        'user_a_image' => $user_a->user_image,
        'user_b_image' => 'dribbl.png',
      );
    }
    else {
      $this->db->select('leuage_image.image , users.fan , users.image user_image , users.score , users.fname');
      $this->db->from('users');
      $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
      $this->db->where('users.id' , $result[0]['user_b']);
      $query = $this->db->get();
      $user_b = $query->row();
      //---------
      $this->db->select();
      $this->db->from('coin_leauge');
      $this->db->where('user_id' , $result[0]['user_b']);
      $query = $this->db->get();
      $coinData = $query->row();
      if(@$coinData->coin == null)
      {
        $billy = array(
          'user_id' => $result[0]['user_b'],
          'coin' => 0
        );
        $this->db->insert('coin_leauge' , $billy);
      }
      $this->db->select();
      $this->db->from('coin_leauge');
      $this->db->where('coin >' , $coinData->coin);
      $this->db->order_by('coin' , 'DESC');
      $query = $this->db->get();
      $score_b = $query->num_rows()+1;
      //---------
      $data = array(
        'user_a' => $user_a->image,
        'user_b' => $user_b->image,
        'user_b_name' => $user_b->fname,
        'user_a_name' => $user_a->fname,
        'user_b_score' => $score_b,
        'user_a_score' => $score_a,
        'user_a_level' => $result[0]['coin'],
        'user_b_level' => $result[0]['coin'],
        'user_a_image' => $user_a->user_image,
        'user_b_image' => $user_b->user_image,
      );
    }
    return $data;
  }
  //-------------------
  function set_category_game_coin($game_id , $category_id , $user_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round = $row->round+1;
    $data = array(
      'round' => $round
    );
    $this->db->where('id' , $row->id);
    $this->db->update('games_coin' , $data);
    $ret = array(
      'game_id' => $game_id,
      'cate_id' => $category_id,
    );
    $this->db->insert('game_coin_round' , $ret);
    //------------
    $this->db->select();
    $this->db->from('questions');
    $this->db->where('cate_id' , $category_id);
    $this->db->order_by('id', 'RANDOM');
    $this->db->limit(3,0);
    $query = $this->db->get();
    $result = $query->result_array();
    //------------
    for($i=0;$i<3;$i++)
    {
      $data = array(
        'queue' => $i+1,
        'game_id' => $game_id,
        'round_id' => $round,
        'quiz_id' => $result[$i]['id'],
        'user_id' => $user_id
      );
      $this->db->insert('game_coin_quiz' , $data);
    }
    return true;
  }
  //-------------------
  function get_game_infos_coin($game_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //-------------------
  function check_round_five_coin($game_id)
  {
    $this->db->select();
    $this->db->from('game_coin_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , 5);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //-------------------
  function get_score_coin($game_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('status' , 0);
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $cost = (30 / 100) * $row->coin;
    $cost = ceil($cost);
    //--------
    if($query->num_rows() == 1)
    {
      $this->db->select();
      $this->db->from('game_coin_quiz');
      $this->db->where('user_id' , $row->user_b);
      $this->db->where('round_id' , 5);
      $this->db->where('game_id' , $game_id);
      $this->db->where('status !=' , 0);
      $query = $this->db->get();
      if($query->num_rows() == 3)
      {
        if($row->ponit_a > $row->ponit_b)
        {
          $this->db->select();
          $this->db->from('users');
          $this->db->where('id' , $row->user_b);
          $query = $this->db->get();
          $row2 = $query->row();
          $newCoin = $row2->coin + $row->coin + $cost;
          $data = array('coin' => $newCoin);
          $this->db->where('id' , $row->user_b);
          $this->db->update('users' , $data);
          //---------
          $this->db->select();
          $this->db->from('coin_leauge');
          $this->db->where('user_id', $row->user_b);
          $query = $this->db->get();
          $row3 = $query->row();

          $havij2 = array(
            'coin' => $cost + $row3->coin
          );
          $this->db->where('user_id' , $row->user_b);
          $this->db->update('coin_leauge' , $havij2);
          //---------
          $havij = array(
            'user_id' => $row->user_b,
            'score' => $cost,
            'game_id' => $game_id,
            'reason' => 'end-game-coin',
            'last' => $newCoin
          );
          $this->db->insert('logs' , $havij);
        }
        else {
          $this->db->select();
          $this->db->from('users');
          $this->db->where('id' , $row->user_a);
          $query = $this->db->get();
          $row2 = $query->row();
          $newCoin = $row2->coin + $row->coin + $cost;
          $data = array('coin' => $newCoin);
          $this->db->where('id' , $row->user_a);
          $this->db->update('users' , $data);
          //---------
          $this->db->select();
          $this->db->from('coin_leauge');
          $this->db->where('user_id', $row->user_a);
          $query = $this->db->get();
          $row3 = $query->row();

          $havij2 = array(
            'coin' => $cost + $row3->coin
          );
          $this->db->where('user_id' , $row->user_a);
          $this->db->update('coin_leauge' , $havij2);
          //---------
          $havij = array(
            'user_id' => $row->user_a,
            'score' => $cost,
            'game_id' => $game_id,
            'reason' => 'end-game-coin',
            'last' => $newCoin
          );
          $this->db->insert('logs' , $havij);
        }
        //-------------
        $data = array('status' => 1);
        $this->db->where('id' , $game_id);
        $this->db->update('games_coin' , $data);
        return TRUE;
      }
    }
  }
  //-------------------
  function get_quiz_coin($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $round_id = $row->round;
    //--------
    $this->db->select('questions.id , questions.name , category.name cate_name , game_coin_quiz.id quiz_id');
    $this->db->from('game_coin_quiz');
    $this->db->join('questions' , 'questions.id = game_coin_quiz.quiz_id');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('seen' , 0);
    $this->db->order_by('game_coin_quiz.id' , 'DESC');
    $this->db->limit(1,0);
    $query = $this->db->get();
    $result = $query->result_array();
    if(count($result) == 1)
    {
      $data = array('seen' => 1);
      $this->db->where('id' , $result[0]['quiz_id']);
      $this->db->update('game_coin_quiz' , $data);
    }
    return $result;
  }
  //-------------------
  function set_awnser_coin($quiz_id , $user_id , $game_id , $awnser_id)
  {

    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('id' , $awnser_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->status == 1)
    {
      $this->db->select();
      $this->db->from('games_coin');
      $this->db->where('id' , $game_id);
      $query = $this->db->get();
      $row2 = $query->row();
      $this->db->select();
      $this->db->from('game_coin_quiz');
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $query = $this->db->get();
      $row3 = $query->row();
      if($row3->status == 0)
      {
        if($row2->user_a == $user_id)
        {
          $data = array(
            'ponit_a' => $row2->ponit_a+1
          );
        }
        else {
          $data = array(
            'ponit_b' => $row2->ponit_b+1
          );
        }
        $this->db->where('id' , $game_id);
        $this->db->update('games_coin' , $data);
        //---------
        $data = array('status' => 1);
        $this->db->where('game_id' , $game_id);
        $this->db->where('quiz_id' , $quiz_id);
        $this->db->where('user_id' , $user_id);
        $this->db->update('game_coin_quiz' , $data);
      }
      $this->db->select();
      $this->db->from('awsners');
      $this->db->where('ques_id' , $quiz_id);
      $query = $this->db->get();
      $result = $query->result_array();
      $result[0]['correct_aw'] = 1;
      return $result;
    }
    else {
      $data = array('status' => 2);
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $this->db->update('game_coin_quiz' , $data);
      //---------
      $this->db->select();
      $this->db->from('awsners');
      $this->db->where('ques_id' , $quiz_id);
      $query = $this->db->get();
      $result = $query->result_array();
      $result[0]['correct_aw'] = 2;
      return $result;
    }
  }
  //-------------------
  function dont_awnser_coin($quiz_id , $user_id , $game_id)
  {
    $data = array('status' => 2);
    $this->db->where('game_id' , $game_id);
    $this->db->where('quiz_id' , $quiz_id);
    $this->db->where('user_id' , $user_id);
    $this->db->update('game_coin_quiz' , $data);
    //---------
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('ques_id' , $quiz_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $result[0]['correct_aw'] = 2;
    return $result;
  }
  //-------------------
  function change_queue_coin($user_id , $game_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $result = $query->result_array();

      if($row->queue == $row->user_a)
      {
        $turn = $row->user_b;
        //echo 1;
        $data = array('queue' => $row->user_b);
        $this->db->where('id' , $game_id);
        $this->db->update('games_coin' , $data);
      }
      elseif($row->queue == $row->user_b) {
        $turn = $row->user_a;
        //echo 2;
        $data = array('queue' => $row->user_a);
        $this->db->where('id' , $game_id);
        $this->db->update('games_coin' , $data);
      }
    return $turn;
  }
  //-------------------
  function check_game_coin($user_id , $score)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('user_a' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games_coin' , $data);
      $cost = (30 / 100) * $result[$i]['coin'];
      $cost = ceil($cost);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {

        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $coin = $row->coin + $cost + $result[$i]['coin'];
        $data = array('coin' => $coin);
        $this->db->where('id' , $result[$i]['user_b']);
        $this->db->update('users' , $data);
        //---------
        $this->db->select();
        $this->db->from('coin_leauge');
        $this->db->where('user_id', $result[$i]['user_b']);
        $query = $this->db->get();
        $row3 = $query->row();

        $havij2 = array(
          'coin' => $cost + $row3->coin
        );
        $this->db->where('user_id' , $result[$i]['user_b']);
        $this->db->update('coin_leauge' , $havij2);
        //---------
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'coin' => $cost,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-coin-game',
          'last' => $coin
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $coin = $row->coin + $cost + $result[$i]['coin'];
        $data = array('coin' => $coin);
        $this->db->where('id' , $result[$i]['user_a']);
        $this->db->update('users' , $data);
        //---------
        $this->db->select();
        $this->db->from('coin_leauge');
        $this->db->where('user_id', $result[$i]['user_a']);
        $query = $this->db->get();
        $row3 = $query->row();

        $havij2 = array(
          'coin' => $cost + $row3->coin
        );
        $this->db->where('user_id' , $result[$i]['user_a']);
        $this->db->update('coin_leauge' , $havij2);
        //---------
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => $cost,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-coin-game',
          'last' => $coin
        );
        $this->db->insert('logs' , $havij);
      }
    }
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('user_b' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d H:i:s', strtotime('-4 hour')));
    $query = $this->db->get();
    $result = $query->result_array();
    //print_r($result);
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games_coin' , $data);
      $cost = (30 / 100) * $result[$i]['coin'];
      $cost = ceil($cost);
      if($result[$i]['queue'] == $result[$i]['user_a'])
      {

        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_b']);
        $query = $this->db->get();
        $row = $query->row();
        $coin = $row->coin + $cost + $result[$i]['coin'];
        $data = array('coin' => $coin);
        $this->db->where('id' , $result[$i]['user_b']);
        $this->db->update('users' , $data);
        //---------
        $this->db->select();
        $this->db->from('coin_leauge');
        $this->db->where('user_id', $result[$i]['user_b']);
        $query = $this->db->get();
        $row3 = $query->row();

        $havij2 = array(
          'coin' => $cost + $row3->coin
        );
        $this->db->where('user_id' , $result[$i]['user_b']);
        $this->db->update('coin_leauge' , $havij2);
        //---------
        $havij = array(
          'user_id' => $result[$i]['user_b'],
          'coin' => $cost,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-coin-game',
          'last' => $coin
        );
        $this->db->insert('logs' , $havij);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $result[$i]['user_a']);
        $query = $this->db->get();
        $row = $query->row();
        $coin = $row->coin + $cost + $result[$i]['coin'];
        $data = array('coin' => $coin);
        $this->db->where('id' , $result[$i]['user_a']);
        $this->db->update('users' , $data);
        //---------
        $this->db->select();
        $this->db->from('coin_leauge');
        $this->db->where('user_id', $result[$i]['user_a']);
        $query = $this->db->get();
        $row3 = $query->row();

        $havij2 = array(
          'coin' => $cost + $row3->coin
        );
        $this->db->where('user_id' , $result[$i]['user_a']);
        $this->db->update('coin_leauge' , $havij2);
        //---------
        $havij = array(
          'user_id' => $result[$i]['user_a'],
          'score' => $cost,
          'game_id' => $result[$i]['id'],
          'reason' => 'times-coin-game',
          'last' => $coin
        );
        $this->db->insert('logs' , $havij);
      }
    }
    return TRUE;
  }
  //-------------------
  function get_game_info_coin($game_id , $user_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $result = $query->result_array();
    $this->db->select();
    $this->db->from('game_coin_quiz');
    $this->db->where('round_id' , $result[0]['round']);
    $this->db->where('game_id' , $game_id);
    $this->db->where('user_id' , $user_id);
    $this->db->where('status' , 0);
    $query = $this->db->get();
    if($query->num_rows() != 0)
    {
      $data = array(
        'status' => 2
      );
      $this->db->where('round_id' , $result[0]['round']);
      $this->db->where('game_id' , $game_id);
      $this->db->where('user_id' , $result[0]['queue']);
      $this->db->where('status' , 0);
      $this->db->update('game_coin_quiz' , $data);
      //-------
      if($result[0]['queue'] == $result[0]['user_a'])
      {
        $data = array(
          'queue' => $result[0]['user_b'],
        );
      }
      else {
        $data = array(
          'queue' => $result[0]['user_a'],
        );
      }
      $this->db->where('id' , $game_id);
      $this->db->update('games_coin' , $data);
    }
    //------
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //-------------------
  function get_categroy_round_name_coin($game_id , $i)
  {
    $this->db->select('category.name');
    $this->db->from('game_coin_round');
    $this->db->where('game_coin_round.game_id' , $game_id);
    $this->db->join('category' , 'category.id = game_coin_round.cate_id');
    $this->db->limit(1,$i);
    $query = $this->db->get();
    $row = $query->row();
    if(@$row->name == null)
    {
      $name = '';
    }
    else {
      $name = $row->name;
    }
    return $name;
  }
  //-------------------
  function get_round_score_coin($game_id , $round_id , $user_id)
  {
    $this->db->select();
    $this->db->from('game_coin_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //-------------------
  function get_round_score_y_coin($game_id , $round_id , $user_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->user_a == $user_id)
    {
      $id = $row->user_b;
    }
    else {
      $id = $row->user_a;
    }
    $this->db->select();
    $this->db->from('game_coin_quiz');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $id);
    $query = $this->db->get();
    $result = $query->result_array();
    return $result;
  }
  //-------------------
  function close_game_coin($game_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('status' , 0);
    $this->db->where('round >=' , 5);
    $this->db->where('id' , $game_id);
    $query = $this->db->get();
    $row = $query->row();
    $data = array('status' => 1 , 'round' => 5);
    $this->db->where('id' , $game_id);
    $this->db->update('games_coin' , $data);
    return true;
  }
  //---------------------
  function check_round_game_coin($user_id , $game_id , $round)
  {
    $this->db->select();
    $this->db->from('game_coin_quiz');
    $this->db->where('user_id' , $user_id);
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id	' , $round);
    $query = $this->db->get();
    if($query->num_rows() != 0)
    {
      return 1; // boro gamecategory
    }
    else {
      $this->db->select();
      $this->db->from('game_coin_round');
      $this->db->where('game_id' , $game_id);
      $this->db->order_by('id' , 'DESC');
      $this->db->limit(1,0);
      $query = $this->db->get();
      $row = $query->row();


      $this->db->select();
      $this->db->from('questions');
      $this->db->where('cate_id' , $row->cate_id);
      $this->db->order_by('id', 'RANDOM');
      $this->db->limit(3,0);
      $query = $this->db->get();
      $result = $query->result_array();
      //------------
      for($i=0;$i<3;$i++)
      {
        $data = array(
          'queue' => $i+1,
          'game_id' => $game_id,
          'round_id' => $round,
          'quiz_id' => $result[$i]['id'],
          'user_id' => $user_id
        );
        $this->db->insert('game_coin_quiz' , $data);
      }
      return 2;
    }
  }
  //---------------------
  function game_coin_history_turn($user_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('status' , 0);
    $this->db->where('queue' , $user_id);
    $this->db->group_start();
    $this->db->or_where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->group_end();
    $this->db->limit(20 , 0);
    $this->db->order_by('games_coin.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //---------------------
  function game_coin_history_wait($user_id)
  {
    $this->db->select();
    $this->db->from('games_coin');
    $this->db->where('status' , 0);
    $this->db->where('queue !=' , $user_id);
    $this->db->group_start();
    $this->db->or_where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->group_end();
    $this->db->limit(20 , 0);
    $this->db->order_by('games_coin.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //---------------------
  function increase_heart($user_id , $amount)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->heart > $amount)
    {
      $heart = $row->heart - $amount;
      $data = array('heart' => $heart);
      $this->db->where('id' , $user_id);
      $this->db->update('users' , $data);
      return 1;
    }
    else {
      return 2;
    }
  }
  //---------------------
  function leaugeViewCoin()
  {
    $this->db->select('users.fname , users.image , users.fan');
    $this->db->select('leuage_image.image fan_image');
    $this->db->select('coin_leauge.coin score');
    $this->db->from('coin_leauge');
    $this->db->join('users' , 'users.id = coin_leauge.user_id');
    $this->db->join('leuage_image' , 'leuage_image.id = users.fan');
    $this->db->order_by('coin_leauge.coin' , 'DESC');
    $this->db->limit(20,0);
    $query = $this->db->get();
    return $query->result_array();
  }
  //---------------------
  function get_factory($user_id , $heart , $coin)
  {
    $heart = $heart + 1;
    $coin = $coin + 5;
    $data = array(
      'coin' => $coin,
      'heart' => $heart
    );
    $this->db->where('id' , $user_id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //---------------------
}
?>
