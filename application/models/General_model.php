<?php
class general_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
		    $this->db = $this->load->database('default', TRUE);
    }
	//------------------
  function get_lang()
  {
    $this->db->select();
    $this->db->from('lang');
    $this->db->where('id' , 1);
    $query = $this->db->get();
    $row = $query->row();
    return $row->name;
  }
  //------------------
  function login($username , $password)
  {
    if($username === 'admin')
    {
      if($password === 'ghorob')
      {
        return 1;
      }
      else {
        return -1;
      }
    }
    else {
      return -1;
    }
  }
  //------------------
  function get_categories()
  {
    $this->db->select();
    $this->db->from('category');
    $this->db->order_by('id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function add_new_category($name)
  {
    $data = array('name' => $name);
    $this->db->insert('category' , $data);
    return TRUE;
  }
  //------------------
  function get_category_by_id($id)
  {
    $this->db->select();
    $this->db->from('category');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function edit_category($name , $id)
  {
    $data = array('name' => $name);
    $this->db->where('id' , $id);
    $this->db->update('category' , $data);
    return TRUE;
  }
  //------------------
  function delete_category($id)
  {
    $this->db->where('id' , $id);
    $this->db->delete('category');
    return TRUE;
  }
  //------------------
  function get_think_quiz()
  {
    $this->db->select();
    $this->db->from('think_quiz');
    $this->db->order_by('think_quiz.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_quiz()
  {
    $this->db->select('questions.id , questions.name , questions.cate_id , questions.positive , questions.negative');
    $this->db->select('category.name cate_name');
    $this->db->from('questions');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->order_by('questions.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_think_quiz_search($name)
  {
    $this->db->select();
    $this->db->from('think_quiz');
    $this->db->order_by('think_quiz.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
	  $this->db->like('think_quiz.title' , $name);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_quiz_search($name)
  {
    $this->db->select('questions.id , questions.name , questions.cate_id , questions.positive , questions.negative');
    $this->db->select('category.name cate_name');
    $this->db->from('questions');
    $this->db->join('category' , 'category.id = questions.cate_id');
    $this->db->order_by('questions.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
	  $this->db->like('questions.name' , $name);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function add_quiz($data)
  {
    $this->db->insert('questions' , $data);
    $last_id = $this->db->insert_id();
    return $last_id;
  }
  //------------------
  function add_think_quiz($data)
  {
    $this->db->insert('think_quiz' , $data);
    $last_id = $this->db->insert_id();
    return $last_id;
  }
  //------------------
  function set_new_awsner_think($data)
  {
    $this->db->insert('think_aw' , $data);
    return TRUE;
  }
  //------------------
  function set_new_awsner($data)
  {
    $this->db->insert('awsners' , $data);
    return TRUE;
  }
  //------------------
  function get_quiz_by_id($id)
  {
    $this->db->select();
    $this->db->from('questions');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_quiz_think_by_id($id)
  {
    $this->db->select();
    $this->db->from('think_quiz');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_awsners_by_quiz_id($id)
  {
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('ques_id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_awsners_by_think_quiz_id($id)
  {
    $this->db->select();
    $this->db->from('think_aw');
    $this->db->where('quiz_id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function update_think_quiz($data , $id)
  {
    $this->db->where('id' , $id);
    $this->db->update('think_quiz' , $data);
    return TRUE;
  }
  //------------------
  function update_quiz($data , $id)
  {
    $this->db->where('id' , $id);
    $this->db->update('questions' , $data);
    return TRUE;
  }
  //------------------
  function delete_awnsers_by_quiz_think_id($id)
  {
    $this->db->where('quiz_id' , $id);
    $this->db->delete('think_aw');
    return TRUE;
  }
  //------------------
  function delete_awnsers_by_quiz_id($id)
  {
    $this->db->where('ques_id' , $id);
    $this->db->delete('awsners');
    return TRUE;
  }
  //------------------
  function delete_quiz_think($id)
  {
    $this->db->where('id' , $id);
    $this->db->delete('think_quiz');
    return TRUE;
  }
  //------------------
  function delete_quiz($id)
  {
    $this->db->where('id' , $id);
    $this->db->delete('questions');
    return TRUE;
  }
  //------------------
  function get_live_quiz($id)
  {
    $this->db->select();
    $this->db->from('live_quiz');
    $this->db->where('level' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function delete_live_quiz($id)
  {
    $this->db->where('level' , $id);
    $this->db->delete('live_quiz');
    return TRUE;
  }
  //------------------
  function set_new_live_quiz($data)
  {
    $this->db->insert('live_quiz' , $data);
    return TRUE;
  }
  //------------------
  function get_count_users()
  {
    return $this->db->count_all_results('users');
  }
  //------------------
  function get_all_users()
  {
    $this->db->select('users.id , users.fname , users.lname , users.score , users.heart , users.coin , users.ban');
    $this->db->select('leauge.level');
    $this->db->from('users');
    $this->db->join('leauge' , 'leauge.user_id = users.id');
    $this->db->order_by('users.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_user_by_id($id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function update_user($data , $id)
  {
    $this->db->where('id' , $id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //------------------
  function get_count_user_quiz()
  {
    return $this->db->count_all_results('quiz_user');
  }
  //------------------
  function get_count_quiz()
  {
    return $this->db->count_all_results('questions');
  }
  //------------------
  function get_count_think_quiz()
  {
    return $this->db->count_all_results('think_quiz');
  }
  //------------------
  function get_count_think_quiz_search($name)
  {
    $this->db->select();
	  $this->db->from('think_quiz');
	  $this->db->like('title' , $name);
	  $query = $this->db->get();
	  return $query->num_rows();
  }
  //------------------
  function get_count_quiz_search($name)
  {
	  $this->db->select();
	  $this->db->from('questions');
	  $this->db->like('name' , $name);
	  $query = $this->db->get();
	  return $query->num_rows();
  }
  //------------------
  function get_all_user_quiz()
  {
    $this->db->select('quiz_user.id , quiz_user.name , quiz_user.status , quiz_user.user_id');
    $this->db->select('users.fname , users.lname');
    $this->db->from('quiz_user');
    $this->db->join('users' , 'users.id = quiz_user.user_id');
    $this->db->order_by('quiz_user.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_user_awnser($id)
  {
    $this->db->select();
    $this->db->from('awsners_user');
    $this->db->where('quiz_id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_count_active_user()
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('fan !=' , 0);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function get_team_fan_count($fan)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('fan' , $fan);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function get_count_games()
  {
    return $this->db->count_all_results('games');
  }
  //------------------
  function get_count_open_games()
  {
    $this->db->select();
    $this->db->from('games');
    $this->db->where('status' , 0);
    $query = $this->db->get();
    return $query->num_rows();
  }
  //------------------
  function ban_user($id)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->ban == 1)
    {
      $data = array('ban' => 0);
    }
    else {
      $data = array('ban' => 1);
    }
    $this->db->where('id' , $id);
    $this->db->update('users' , $data);
    return TRUE;
  }
  //------------------
  function get_bank()
  {
    $this->db->select('bank.price , bank.coin , bank.heart , bank.status , bank.id , bank.time');
    $this->db->select('users.fname , users.lname');
    $this->db->from('bank');
    $this->db->join('users' , 'users.id = bank.user_id');
    $this->db->order_by('bank.id' , 'DESC');
    $this->db->where('bank.status' , 1);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_bank_over()
  {
    $this->db->select('bank.price , bank.coin , bank.heart , bank.status , bank.id , bank.time');
    $this->db->select('users.fname , users.lname');
    $this->db->from('bank');
    $this->db->join('users' , 'users.id = bank.user_id');
    $this->db->order_by('bank.id' , 'DESC');
    $this->db->where('bank.status' , 0);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_live_status()
  {
    $this->db->select();
    $this->db->from('live_status');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function change_live_status($id)
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->status == 0)
    {
      $data = array('status' => 1);
    }
    else {
      $data = array('status' => 0);
    }
    $this->db->where('id' , $id);
    $this->db->update('live_status' , $data);
    return TRUE;
  }
  //------------------
  function change_live_aw($id)
  {
    $this->db->select();
    $this->db->from('live_status');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    $row = $query->row();
    if($row->show == 0)
    {
      $data = array('show' => 1);
    }
    else {
      $data = array('show' => 0);
    }
    $this->db->where('id' , $id);
    $this->db->update('live_status' , $data);
    return TRUE;
  }
  //------------------
  function get_live_user_score()
  {
    $this->db->select('live_score.score');
    $this->db->select('users.fname , users.lname , users.mobile');
    $this->db->from('live_score');
    $this->db->join('users' , 'users.id = live_score.user_id');
    $this->db->order_by('live_score.score' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function trancate_live()
  {
    $this->db->empty_table('live_score');
    return TRUE;
  }
  //------------------
  function get_true_think_awsner($quiz_id)
  {
    $this->db->select();
    $this->db->from('think_aw');
    $this->db->where('quiz_id' , $quiz_id);
    $this->db->where('status' , 1);
    $query = $this->db->get();
    $row = $query->row();
    return $row->title;
  }
  //------------------
  function get_true_awsner($quiz_id)
  {
    $this->db->select();
    $this->db->from('awsners');
    $this->db->where('ques_id' , $quiz_id);
    $this->db->where('status' , 1);
    $query = $this->db->get();
    $row = $query->row();
    return $row->title;
  }
  //------------------
  function get_support_message()
  {
    $this->db->select('message.id , message.time , message.user_id , message.message , message.category , message.time , message.status');
    $this->db->select('users.fname , users.lname , users.id user_id');
    $this->db->from('message');
    $this->db->join('users' , 'users.id = message.user_id');
    $this->db->order_by('message.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function set_report($username , $message)
  {
    $data = array(
      'username' => $username,
      'message' => $message
    );
    $this->db->insert('report' , $data);
    return TRUE;
  }
  //------------------
  function get_report_message()
  {
    $this->db->select();
    $this->db->from('report');
    $this->db->order_by('id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_wallet()
  {
    $this->db->select('moneyRequest.time , moneyRequest.user_id , moneyRequest.price  , moneyRequest.status , moneyRequest.id');
    $this->db->select('users.fname , users.lname');
    $this->db->from('moneyRequest');
    $this->db->join('users' , 'users.id = moneyRequest.user_id');
    $this->db->order_by('moneyRequest.id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function change_wallet($id)
  {
    $data = array('status' => 1);
    $this->db->where('id' , $id);
    $this->db->update('moneyRequest' , $data);
    return TRUE;
  }
  //------------------
  function get_live_time()
  {
    $this->db->select();
    $this->db->from('live');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function update_live($live)
  {
    $data = array('time' => $live);
    $this->db->where('id' , 2);
    $this->db->update('live' , $data);

    return TRUE;
  }
  //------------------
	function get_count_users_search($name)
	{
		$this->db->select();
		$this->db->from('users');
		$this->db->like('fname', $name);
    $this->db->or_like('lname', $name);
		$query = $this->db->get();
		return $query->num_rows();
	}
  //------------------
  function get_count_users_mobile($name)
  {
    $this->db->select();
    $this->db->from('users');
    $this->db->like('mobile', $name);
    $query = $this->db->get();
    return $query->num_rows();
  }
	//------------------
	function get_all_users_search($name)
	{
    $this->db->select('users.id , users.fname , users.lname , users.score , users.heart , users.coin , users.ban');
    $this->db->select('leauge.level');
    $this->db->from('users');
    $this->db->join('leauge' , 'leauge.user_id = users.id');
    $this->db->order_by('users.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
		$this->db->like('fname', $name);
    $this->db->or_like('lname' , $name);
		$query = $this->db->get();
		return $query->result_array();
	}
  //------------------
  function get_all_users_mobile($name)
  {
    $this->db->select('users.id , users.fname , users.lname , users.score , users.heart , users.coin , users.ban');
    $this->db->select('leauge.level');
    $this->db->from('users');
    $this->db->join('leauge' , 'leauge.user_id = users.id');
    $this->db->order_by('users.id' , 'DESC');
    $this->db->limit(20,$this->uri->segment(3));
    $this->db->like('mobile', $name);
    $query = $this->db->get();
    return $query->result_array();
  }
	//------------------
  function get_tips()
  {
    $this->db->select();
    $this->db->from('tips');
    $this->db->order_by('id' , 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function delete_tips($id)
  {
    $this->db->where('id' , $id);
    $this->db->delete('tips');
    return TRUE;
  }
  //------------------
  function add_tips($text)
  {
    $data = array(
      'text' => $text
    );
    $this->db->insert('tips' , $data);
    return TRUE;
  }
  //------------------
  function get_live_ask()
  {
    $this->db->select();
    $this->db->from('live_ask');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_live_ask_by_id($id)
  {
    $this->db->select();
    $this->db->from('live_ask');
    $this->db->where('id' , $id);
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function get_leuages()
  {
    $this->db->select();
    $this->db->from('teams_league');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function delete_leuage_by_id($id)
  {
    $this->db->where('id' , $id);
    $this->db->delete('teams_league');
    return TRUE;
  }
  //------------------
  function add_new_leauge($data)
  {
    $this->db->insert('teams_league' , $data);
    return TRUE;
  }
  //------------------
  function get_teams()
  {
    $this->db->select('leuage_image.id , leuage_image.image , leuage_image.team_id');
    $this->db->select('teams_league.name');
    $this->db->from('leuage_image');
    $this->db->join('teams_league' , 'teams_league.id = leuage_image.team_id');
    $query = $this->db->get();
    return $query->result_array();
  }
  //------------------
  function add_new_team($data)
  {
    $this->db->insert('leuage_image' , $data);
    return TRUE;
  }
  //------------------
  function delete_teams_by_id($id)
  {
    $this->db->where('id' , $id);
    $this->db->delete('leuage_image');
    return TRUE;
  }
  //------------------
}
?>
