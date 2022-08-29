<?php
class ios_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		    $this->db = $this->load->database('default', TRUE);
    }
	//------------------
  function get_user_data($token)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('token' , $token);
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
  function my_leauge($user_id)
  {
    $this->db->select();
    $this->db->from('leauge');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('leauge');
    $this->db->join('users' , 'users.id = leauge.user_id');
    $this->db->order_by('users.score' , 'DESC');
    $this->db->where('level' , $row->level);
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
  function dead_time()
  {
    $this->db->select();
    $this->db->from('live');
    $this->db->where('id' , 2);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function game_history($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->order_by('games.id' , 'DESC');
    $query = $this->db->get();
    $number = $query->num_rows();
    //-----
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    $this->db->or_where('user_b' , $user_id);
    $this->db->limit($number , 0);
    $this->db->order_by('games.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_user_data_by_id($user_id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $user_id);
    $query = $this->db->get();
    return $query->result_array();
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
  function leauge($user_id)
  {
    $this->db->select();
    $this->db->from('leauge');
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    $row = $query->row();
    //-------
    $this->db->select();
    $this->db->from('leauge');
    $this->db->join('users' , 'users.id = leauge.user_id');
    $this->db->order_by('users.score' , 'DESC');
    $this->db->limit(20,0);
    $this->db->where('level' , $row->level);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function check_change_leauge($user_id , $score)
  {
    if($score >= 100 and $score < 1000)
    {
      $data = array('level' => 3);
      $this->db->where('user_id' , $user_id);
      $this->db->update('leauge' , $data);
    }
    if($score >= 1000 and $score < 10000 )
    {
      $data = array('level' => 2);
      $this->db->where('user_id' , $user_id);
      $this->db->update('leauge' , $data);
    }
    if($score >= 10000 )
    {
      $data = array('level' => 1);
      $this->db->where('user_id' , $user_id);
      $this->db->update('leauge' , $data);
    }
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
  function new_game($user_id)
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
  function get_category()
  {
    $this->db->select();
    $this->db->from('category');
    $this->db->order_by('rand()');
    $this->db->limit(3,0);
    $query = $this->db->get();
    return $query->result_array();
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
      'round_key' => 0
    );
    $this->db->insert('game_round' , $ret);
    //------------
    $this->db->select();
    $this->db->from('questions');
    $this->db->where('cate_id' , $category_id);
    $query = $this->db->get();
    $result = $query->result_array();
    //------------
    shuffle($result);
    for($i=0;$i<3;$i++)
    {
      $data = array(
        'queue' => $i+1,
        'game_id' => $game_id,
        'round_id' => $round,
        'quiz_id' => $result[$i]['id'],
        'user_id' => $user_id,
        'status' => 0,
        'seen' => 0
      );
      $this->db->insert('game_quiz' , $data);
    }
    return true;
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
      $data['star1'] = 'goldStar';
    }
    else {
      $data['star1'] = 'grayStar';
    }
    if($result[1]['status'] == 1)
    {
      $data['star2'] = 'goldStar';
    }
    else {
      $data['star2'] = 'grayStar';
    }
    if($result[2]['status'] == 1)
    {
      $data['star3'] = 'goldStar';
    }
    else {
      $data['star3'] = 'grayStar';
    }
    return $data;
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
      $query = $this->db->get();
      if($query->num_rows() != 0)
      {
        if($row->ponit_a > $row->ponit_b)
        {
          $user = $row->user_a;
          $user2 = $row->user_b;
        }
        elseif($row->ponit_b > $row->ponit_a){
          $user = $row->user_b;
          $user2 = $row->user_a;
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
        //-------------
        $data = array('status' => 1);
        $this->db->where('id' , $game_id);
        $this->db->update('games' , $data);
        return TRUE;
      }
    }
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
    $this->db->select('questions.id , questions.name , category.name cate_name');
    $this->db->from('game_quiz');
    $this->db->join('questions' , 'questions.id = game_quiz.quiz_id');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->where('game_id' , $game_id);
    $this->db->where('round_id' , $round_id);
    $this->db->where('user_id' , $user_id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_quiz_awnsers($quiz_id)
  {
    $this->db->select();
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
      return 1;
    }
    else {
      $data = array('status' => 2);
      $this->db->where('game_id' , $game_id);
      $this->db->where('quiz_id' , $quiz_id);
      $this->db->where('user_id' , $user_id);
      $this->db->update('game_quiz' , $data);
      return 2;
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
    return 2;
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
  function check_game($user_id)
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_a' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d', time() - (60 * 60)));
    $query = $this->db->get();
    $result = $query->result_array();
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games' , $data);
      if($result[$i]['user_a'] == $user_id and $result[$i]['ponit_a'] > $result[$i]['ponit_b'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
      if($result[$i]['user_b'] == $user_id and $result[$i]['ponit_b'] > $result[$i]['ponit_a'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
    }
    $this->db->select();
    $this->db->from('games');
    $this->db->where('user_b' , $user_id);
    //$this->db->or_where('user_b' , $user_id);
    $this->db->where('status' , 0);
    $this->db->where('time <=' , date('Y-m-d', time() - (60 * 60)));
    $query = $this->db->get();
    $result = $query->result_array();
    //print_r($result);
    for($i=0;$i<count($result);$i++)
    {
      $data = array('status' => 1 , 'round' => 5);
      $this->db->where('id' , $result[$i]['id']);
      $this->db->update('games' , $data);
      if($result[$i]['user_a'] == $user_id and $result[$i]['ponit_a'] > $result[$i]['ponit_b'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
      if($result[$i]['user_b'] == $user_id and $result[$i]['ponit_b'] > $result[$i]['ponit_a'])
      {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score + 10;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
      else {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('id' , $user_id);
        $query = $this->db->get();
        $row = $query->row();
        $score = $row->score - 9;
        if($score < 0)
          $score = 0;
        $data = array('score' => $score);
        $this->db->where('id' , $user_id);
        $this->db->update('users' , $data);
      }
    }
    return TRUE;
  }
  //------------------
  function get_game_info($game_id)
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
      $query = $this->db->get();
      $result = $query->result_array();
      //------------
      shuffle($result);
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
    if($count <= 6)
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
}
?>
