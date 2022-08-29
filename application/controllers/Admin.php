<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
    $this->load->model('general_model');
		$this->load->library("pagination");
	}
	//----------------------------------
  function index()
  {
		if($this->input->post('username'))
		{
			$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				echo 1;
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$result = $this->general_model->login($username , $password);
				if($result < 0)
				{
					$_SESSION['admin'] = $result;
					redirect(base_url()."admin/dashboard","refresh");
				}
				else
				{
					$this->session->set_flashdata('error', "نام کاربری و رمز عبور شما اشتباه است");
					redirect(base_url()."admin","refresh");
				}
			}
		}
    $this->load->view('index');
  }
  //------------------
	function dashboard()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$this->load->view('dashborad');
	}
	//------------------
	function category()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['category'] = $this->general_model->get_categories();
		$this->load->view('categroy' , $data);
	}
	//------------------
	function new_category()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if($this->input->post('name'))
		{
			$name = $this->input->post('name');
			$this->general_model->add_new_category($name);
			$this->session->set_flashdata('success', "دسته بندی مورد نظر با موفقیت به سیستم اضافه گردید.");
			redirect(base_url()."admin/category","refresh");
		}
		$this->load->view('new_category');
	}
	//------------------
	function edit_category($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/category","refresh");
		//-----
		if($this->input->post('name'))
		{
			$name = $this->input->post('name');
			$this->general_model->edit_category($name , $id);
			$this->session->set_flashdata('success', "دسته بندی مورد نظر با موفقیت در سیستم ویرایش گردید");
			redirect(base_url()."admin/category","refresh");
		}
		$data['category'] = $this->general_model->get_category_by_id($id);
		$this->load->view('edit_category' , $data);
	}
	//------------------
	function delete_category($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/category","refresh");
		//-----
		$this->general_model->delete_category($id);
		$this->session->set_flashdata('success', "دسته بندی مورد نظر با موفقیت از سیستم حذف گردید.");
		redirect(base_url()."admin/category","refresh");
	}
	//------------------
	function quiz()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----

		$config["base_url"] = base_url() . "admin/quiz/";
		if($this->input->post('name'))
		{
			$config["total_rows"] = $this->general_model->get_count_quiz_search($this->input->post('name'));
		}
		else
		{
			$config["total_rows"] = $this->general_model->get_count_quiz();
		}
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		if($this->input->post('name'))
		{
			$data['quiz'] = $this->general_model->get_quiz_search($this->input->post('name'));
		}
		else
		{
			$data['quiz'] = $this->general_model->get_quiz();
		}
		for($i=0;$i<count($data['quiz']);$i++)
		{
			$data['quiz'][$i]['trueaw'] = $this->general_model->get_true_awsner($data['quiz'][$i]['id']);
		}
		$this->load->view('quiz' , $data);
	}
	//------------------
	function new_quiz()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['category'] = $this->general_model->get_categories();
		if($this->input->post('name'))
		{
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cate_id', 'cate_id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_1', 'aw_1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_2', 'aw_2', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_3', 'aw_3', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_4', 'aw_4', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correct', 'correct', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				if(@$_FILES['userfile']['name'] != null)
				{
					$config['upload_path'] = './assets/quiz/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 5000;
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('userfile'))
					{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect(base_url()."admin/new_think_quiz","refresh");
					}
					else {
						$image = $this->upload->data();
						$data = array(
							'name' => $this->input->post('name'),
							'cate_id' => $this->input->post('cate_id'),
							'vote' => 0,
							'positive' => 0,
							'negative' => 0,
							'images' => $image['file_name']
						);
					}
				}
				else {
					$data = array(
						'name' => $this->input->post('name'),
						'cate_id' => $this->input->post('cate_id'),
						'vote' => 0,
						'positive' => 0,
						'negative' => 0
					);
				}
				$quiz_id = $this->general_model->add_quiz($data);
				for($i=1;$i<5;$i++)
				{
					if($this->input->post('correct') == $i)
					{
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'ques_id' => $quiz_id,
							'status' => 1
						);
					}
					else {
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'ques_id' => $quiz_id,
							'status' => 0
						);
					}
					$this->general_model->set_new_awsner($data);
				}
				$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت به سیستم افزوده گردید.");
				redirect(base_url()."admin/quiz","refresh");
			}
		}
		$this->load->view('new_quiz' , $data);
	}
	//------------------
	function edit_quiz($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/quiz","refresh");
		//-----
		if($this->input->post('name'))
		{
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cate_id', 'cate_id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_1', 'aw_1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_2', 'aw_2', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_3', 'aw_3', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_4', 'aw_4', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correct', 'correct', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				if(@$_FILES['userfile']['name'] != null)
				{
					$config['upload_path'] = './assets/quiz/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 5000;
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('userfile'))
					{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect(base_url()."admin/new_think_quiz","refresh");
					}
					else {
						$image = $this->upload->data();
						$data = array(
							'name' => $this->input->post('name'),
							'cate_id' => $this->input->post('cate_id'),
							'images' => $image['file_name']
						);
					}
				}
				else {
					$data = array(
						'name' => $this->input->post('name'),
						'cate_id' => $this->input->post('cate_id'),
					);
				}
				$this->general_model->update_quiz($data , $id);
				$this->general_model->delete_awnsers_by_quiz_id($id);
				for($i=1;$i<5;$i++)
				{
					if($this->input->post('correct') == $i)
					{
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'ques_id' => $id,
							'status' => 1
						);
					}
					else {
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'ques_id' => $id,
							'status' => 0
						);
					}
					$this->general_model->set_new_awsner($data);
				}
				$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت در سیستم ویرایش گردید.");
				redirect(base_url()."admin/quiz","refresh");
			}
		}
		$data['quiz'] = $this->general_model->get_quiz_by_id($id);
		$data['awsners'] = $this->general_model->get_awsners_by_quiz_id($id);
		$data['category'] = $this->general_model->get_categories();
		$this->load->view('edit_quiz' , $data);
	}
	//------------------
	function delete_quiz($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/quiz","refresh");
		//-----
		$this->general_model->delete_quiz($id);
		$this->general_model->delete_awnsers_by_quiz_id($id);
		$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت از سیستم حذف گردید.");
		redirect(base_url()."admin/quiz","refresh");
	}
	//------------------
	function live()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$this->load->view('live');
	}
	//------------------
	function edit_live($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/live","refresh");
		//-----
		if($this->input->post('aw_1'))
		{
			$this->form_validation->set_rules('aw_1', 'aw_1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_2', 'aw_2', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_3', 'aw_3', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correct', 'correct', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$this->general_model->delete_live_quiz($id);
				for($i=1;$i<4;$i++)
				{
					if($i == $this->input->post('correct'))
					{
						$data = array(
							'name' => $this->input->post('aw_'.$i),
							'status' => 1,
							'correct' => 1,
							'level' => $id
						);
					}
					else {
						$data = array(
							'name' => $this->input->post('aw_'.$i),
							'status' => 1,
							'correct' => 0,
							'level' => $id
						);
					}
					$this->general_model->set_new_live_quiz($data);
				}
				$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت در سیستم درج گردید.");
				redirect(base_url()."admin/live","refresh");
			}
		}
		$data['live'] = $this->general_model->get_live_quiz($id);
		$this->load->view('edit_live' , $data);
	}
	//------------------
	function users()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if($this->input->post('name'))
		{
			$config["total_rows"] = $this->general_model->get_count_users_search($this->input->post('name'));
		}
		elseif($this->input->post('mobile'))
		{
			$config["total_rows"] = $this->general_model->get_count_users_mobile($this->input->post('mobile'));
		}
		else {
			$config["total_rows"] = $this->general_model->get_count_users();
		}
		$config["base_url"] = base_url() . "admin/users/";

		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		//print_r($_POST);die();
		if($this->input->post('name'))
		{
			$data['users'] = $this->general_model->get_all_users_search($this->input->post('name'));
		}
		elseif($this->input->post('mobile'))
		{
			$data['users'] = $this->general_model->get_all_users_mobile($this->input->post('mobile'));
		}
		else {
			$data['users'] = $this->general_model->get_all_users();
		}
		//--------
		$this->load->view('users' , $data);
	}
	//------------------
	function edit_user($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/users","refresh");
		//-----
		if($this->input->post('fname'))
		{
			$this->form_validation->set_rules('fname', 'fname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lname', 'lname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('coin', 'coin', 'trim|required|xss_clean');
			$this->form_validation->set_rules('heart', 'heart', 'trim|required|xss_clean');
			$this->form_validation->set_rules('score', 'score', 'trim|required|xss_clean');
			$this->form_validation->set_rules('corremobilect', 'corremobilect', 'trim|required|xss_clean');
			$this->form_validation->set_rules('money', 'money', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$data = array(
					'fname' => $this->input->post('fname'),
					'lname' => $this->input->post('lname'),
					'coin' => $this->input->post('coin'),
					'heart' => $this->input->post('heart'),
					'mobile' => $this->input->post('corremobilect'),
					'money' => $this->input->post('money')
				);
				$this->general_model->update_user($data , $id);
				$this->session->set_flashdata('success', "اطلاعات کاربر مورد نظر با موفقیت به روز رسانی گردید");
				redirect(base_url()."admin/users","refresh");
			}
		}
		$data['user'] = $this->general_model->get_user_by_id($id);
		$this->load->view('edit_user' , $data);
	}
	//------------------
	function ban_user($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/users","refresh");
		//-----
		$this->general_model->ban_user($id);
		$this->session->set_flashdata('success', "وضعیت کاربر مورد نظر شما با موفقیت تغییر یافت.");
		redirect(base_url()."admin/users","refresh");
	}
	//------------------
	function user_quiz()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$config["base_url"] = base_url() . "admin/user_quiz/";
		$config["total_rows"] = $this->general_model->get_count_user_quiz();
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data['quiz'] = $this->general_model->get_all_user_quiz();
		for($i=0;$i<count($data['quiz']);$i++)
		{
			$data['quiz'][$i]['awnser'] = $this->general_model->get_user_awnser($data['quiz'][$i]['id']);
		}
		//--------
		$this->load->view('user_quiz' , $data);
	}
	//------------------
	function statictics()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['users'] = $this->general_model->get_count_users();
		$data['active_user'] = $this->general_model->get_count_active_user();
		$data['perisplois'] = $this->general_model->get_team_fan_count(2);
		$data['esteghlal'] = $this->general_model->get_team_fan_count(1);
		$data['games'] = $this->general_model->get_count_games();
		$data['opengames'] = $this->general_model->get_count_open_games();
		$this->load->view('statictics' , $data);
	}
	//------------------
	function bank()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['bank'] = $this->general_model->get_bank();
		$this->load->view('bank' , $data);
	}
	//------------------
	function bankover()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['bank'] = $this->general_model->get_bank_over();
		$this->load->view('bank' , $data);
	}
	//------------------
	function live_status()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['live'] = $this->general_model->get_live_status();
		$this->load->view('live_status' , $data);
	}
	//------------------
	function change_live_aw($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/live_status","refresh");
		//-----
		$this->general_model->change_live_aw($id);
		$this->session->set_flashdata('success', "وضعیت جواب مورد نظر با موفقیت تغییر یافت");
		redirect(base_url()."admin/live_status","refresh");
	}
	//------------------
	function change_live_status($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/live_status","refresh");
		//-----
		$this->general_model->change_live_status($id);
		$this->session->set_flashdata('success', "وضعیت سوال مورد نظر شما با موفقیت تغییر یافت");
		redirect(base_url()."admin/live_status","refresh");
	}
	//------------------
	function live_score()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['score'] = $this->general_model->get_live_user_score();
		$this->load->view('live_score' , $data);
	}
	//------------------
	function live_reset()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$this->general_model->trancate_live();
		$this->session->set_flashdata('success', "امتیازات ریست شدند");
		redirect(base_url()."admin/live_score","refresh");
	}
	//------------------
	function support()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['message'] = $this->general_model->get_support_message();
		$this->load->view('support' , $data);
	}
	//------------------
	function support_message($user_id = "" , $id = "")
	{
		if(@$user_id == null or @$id == null)
			redirect(base_url()."admin","refresh");
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['user'] = $this->general_model->get_user_by_id($user_id);
		if($this->input->post('message'))
		{
			$message = $this->input->post('message');
			$admin_name = $this->input->post('admin_name');
			$new = str_replace(' ', '%20', $message);

			$ch = curl_init();
			$url = "https://dribbl.app/live/sms.php?mobile=".$data['user'][0]['mobile']."&message=".$new;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			print_r($ch);
			$data = array('status' => 1  , 'admin_name' => $admin_name);
			$this->db->where('id' , $id);
			$this->db->update('message' , $data);
			$this->session->set_flashdata('success', "پیام شما با موفقیت از طریق پیامک ارسال گردید.");
			redirect(base_url()."admin/support","refresh");
		}
		$this->load->view('support_message' , $data);
	}
	//------------------
	function reportingservice()
	{
		if($this->input->post('message') and $this->input->post('username'))
		{
			$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('message', 'usemessagername', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$username = $this->input->post('username');
				$message = $this->input->post('message');
				$this->general_model->set_report($username , $message);
				return TRUE;
			}
		}
	}
	//------------------
	function report()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['message'] = $this->general_model->get_report_message();
		$this->load->view('report' , $data);
	}
	//------------------
	function wallet()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		$data['message'] = $this->general_model->get_wallet();
		$this->load->view('wallet' , $data);
	}
	//------------------
	function change_wallet($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/wallet","refresh");
		//-----
		$this->general_model->change_wallet($id);
		$this->session->set_flashdata('success', "وضعیت با موفقیت تغییر یافت");
		redirect(base_url()."admin/wallet","refresh");
	}
	//------------------
	function live_time()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if($this->input->post('live'))
		{
			$live = $this->input->post('live');
			$this->general_model->update_live($live);
			$this->session->set_flashdata('success', "وضعیت شروع بازی زنده تغییر یافت");
			redirect(base_url()."admin/live_time","refresh");
		}
		$data['live'] = $this->general_model->get_live_time();
		$this->load->view('livetime' , $data);
	}
	//------------------
	function tips()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		$data['tips'] = $this->general_model->get_tips();
		$this->load->view('tips' , $data);
	}
	//------------------
	function delete_tips($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if(@$id == null)
			redirect(base_url()."admin/tips","refresh");
		$this->general_model->delete_tips($id);
		$this->session->set_flashdata('success', "متن مورد نظر با موفقیت از سیستم حذف گردید");
		redirect(base_url()."admin/tips","refresh");
	}
	//------------------
	function new_tips()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if($this->input->post('text'))
		{
			$text = $this->input->post('text');
			$this->general_model->add_tips($text);
		}
		$this->load->view('new_tips' , $data);
	}
	//------------------
	function live_ask()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		$data['ask'] = $this->general_model->get_live_ask();
		$this->load->view('live_ask' , $data);
	}
	//------------------
	function edit_ask($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if($this->input->post('title'))
		{
			$data = array(
				'title' => $this->input->post('title')
			);
			$this->db->where('id' , $id);
			$this->db->update('live_ask' , $data);
			$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت ویرایش یافت");
			redirect(base_url()."admin/live_ask","refresh");
		}
		$data['ask'] = $this->general_model->get_live_ask_by_id($id);
		$this->load->view('edit_live_ask' , $data);
	}
	//------------------
	function leauge()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		$data['leauge'] = $this->general_model->get_leuages();
		$this->load->view('leauge' , $data);
	}
	//------------------
	function delete_leauge($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if(@$id == null)
			redirect(base_url()."admin","refresh");
		//--------
		$this->general_model->delete_leuage_by_id($id);
		$this->session->set_flashdata('success', "لیگ مورد نظر شما با موفقیت حذف گردید.");
		redirect(base_url()."admin/leauge","refresh");
	}
	//------------------
	function new_leauge()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if($this->input->post('name'))
		{
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './assets/leauge/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = 5000;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('userfile'))
				{
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect(base_url()."admin/new_leauge","refresh");
				}
				else {
					$image = $this->upload->data();
					$ret = array(
						'name' => $this->input->post('name'),
						'image' => $image['file_name']
					);
					$this->general_model->add_new_leauge($ret);
					$this->session->set_flashdata('success', "لیگ مورد نظر شما با موفقیت به سیستم افزوده گردید.");
					redirect(base_url()."admin/leauge","refresh");
				}
			}
		}
		$this->load->view('new_leauge' , $data);
	}
	//------------------
	function teams()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		$data['teams'] = $this->general_model->get_teams();
		$this->load->view('teams' , $data);
	}
	//------------------
	function add_team()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if($this->input->post('team_id'))
		{
			$this->form_validation->set_rules('team_id', 'team_id', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				$config['upload_path'] = './assets/teams/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = 5000;
				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('userfile'))
				{
					$this->session->set_flashdata('error', $this->upload->display_errors());
					redirect(base_url()."admin/add_team","refresh");
				}
				else {
					$image = $this->upload->data();
					$ret = array(
						'team_id' => $this->input->post('team_id'),
						'image' => $image['file_name']
					);
					//print_r($ret);die();
					$this->general_model->add_new_team($ret);
					$this->session->set_flashdata('success', "تیم جدید به سیستم افزوده گردید.");
					redirect(base_url()."admin/teams","refresh");
				}
			}
		}
		$data['leuage'] = $this->general_model->get_leuages();
		$this->load->view('add_team' , $data);
	}
	//------------------
	function delete_teams($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//--------
		if(@$id == null)
			redirect(base_url()."admin","refresh");
		//--------
		$this->general_model->delete_teams_by_id($id);
		$this->session->set_flashdata('success', "تیم مورد نظر با موفقیت حذف گردید.");
		redirect(base_url()."admin/teams","refresh");
	}
	//------------------
	function think_quiz()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----

		$config["base_url"] = base_url() . "admin/think_quiz/";
		if($this->input->post('name'))
		{
			$config["total_rows"] = $this->general_model->get_count_think_quiz_search($this->input->post('name'));
		}
		else
		{
			$config["total_rows"] = $this->general_model->get_count_think_quiz();
		}
		$config["per_page"] = 20;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		if($this->input->post('name'))
		{
			$data['quiz'] = $this->general_model->get_think_quiz_search($this->input->post('name'));
		}
		else
		{
			$data['quiz'] = $this->general_model->get_think_quiz();
		}
		for($i=0;$i<count($data['quiz']);$i++)
		{
			$data['quiz'][$i]['trueaw'] = $this->general_model->get_true_think_awsner($data['quiz'][$i]['id']);
		}
		$this->load->view('think_quiz' , $data);
	}
	//------------------
	function new_think_quiz()
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if($this->input->post('name'))
		{
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cate_id', 'cate_id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_1', 'aw_1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_2', 'aw_2', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_3', 'aw_3', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_4', 'aw_4', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correct', 'correct', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				if(@$_FILES['userfile']['name'] != null)
				{
					$config['upload_path'] = './assets/quiz/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 5000;
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('userfile'))
					{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect(base_url()."admin/new_think_quiz","refresh");
					}
					else {
						$image = $this->upload->data();
						$data = array(
							'title' => $this->input->post('name'),
							'level' => $this->input->post('cate_id'),
							'image' => $image['file_name']
						);
					}
				}
				else {
					$data = array(
						'title' => $this->input->post('name'),
						'level' => $this->input->post('cate_id'),
					);
				}
				$quiz_id = $this->general_model->add_think_quiz($data);
				for($i=1;$i<5;$i++)
				{
					if($this->input->post('correct') == $i)
					{
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'quiz_id' => $quiz_id,
							'status' => 1
						);
					}
					else {
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'quiz_id' => $quiz_id,
							'status' => 0
						);
					}
					$this->general_model->set_new_awsner_think($data);
				}
				$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت به سیستم افزوده گردید.");
				redirect(base_url()."admin/think_quiz","refresh");
			}
		}
		$data['title'] = "Dribbl Admin";
		$this->load->view('new_thin_quiz' , $data);
	}
	//------------------
	function edit_think_quiz($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/think_quiz","refresh");
		//-----
		if($this->input->post('name'))
		{
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('cate_id', 'cate_id', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_1', 'aw_1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_2', 'aw_2', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_3', 'aw_3', 'trim|required|xss_clean');
			$this->form_validation->set_rules('aw_4', 'aw_4', 'trim|required|xss_clean');
			$this->form_validation->set_rules('correct', 'correct', 'trim|required|xss_clean');
			if ($this->form_validation->run() == TRUE)
			{
				if(@$_FILES['userfile']['name'] != null)
				{
					$config['upload_path'] = './assets/quiz/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size'] = 5000;
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('userfile'))
					{
						$this->session->set_flashdata('error', $this->upload->display_errors());
						redirect(base_url()."admin/edit_think_quiz/".$id,"refresh");
					}
					else {
						$image = $this->upload->data();
						$data = array(
							'title' => $this->input->post('name'),
							'level' => $this->input->post('cate_id'),
							'image' => $image['file_name']
						);
					}
				}
				else {
					$data = array(
						'title' => $this->input->post('name'),
						'level' => $this->input->post('cate_id'),
					);
				}

				$this->general_model->update_think_quiz($data , $id);
				$this->general_model->delete_awnsers_by_quiz_think_id($id);
				for($i=1;$i<5;$i++)
				{
					if($this->input->post('correct') == $i)
					{
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'quiz_id' => $id,
							'status' => 1
						);
					}
					else {
						$data = array(
							'title' => $this->input->post('aw_'.$i),
							'quiz_id' => $id,
							'status' => 0
						);
					}
					$this->general_model->set_new_awsner_think($data);
				}
				$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت در سیستم ویرایش گردید.");
				redirect(base_url()."admin/think_quiz","refresh");
			}
		}
		$data['quiz'] = $this->general_model->get_quiz_think_by_id($id);
		$data['awsners'] = $this->general_model->get_awsners_by_think_quiz_id($id);
		$this->load->view('edit_think_quiz' , $data);
	}
	//------------------
	function delete_think_quiz($id = "")
	{
		if(@$_SESSION['admin'] != 1)
			redirect(base_url()."admin","refresh");
		//-----
		if(@$id == null)
			redirect(base_url()."admin/think_quiz","refresh");
		//-----
		$this->general_model->delete_quiz_think($id);
		$this->general_model->delete_awnsers_by_quiz_think_id($id);
		$this->session->set_flashdata('success', "سوال مورد نظر با موفقیت از سیستم حذف گردید.");
		redirect(base_url()."admin/think_quiz","refresh");
	}
	//------------------
}
?>
