<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

	}	
       
	public function index()
	{
		$this->load->model('model_user','user',TRUE);
		$data['data_sql'] = $this->user->get_meeting_detail();
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$this->load->view('html_head', $data);
		$this->load->view('user', $data);
		$this->load->view('html_foot', $data);
	}
	public function user_list($id)
	{
		$this->load->model('model_user','user',TRUE);
		$data['data_sql'] = $this->user->get_meeting_detail_list($id);
		$data['data_sql_meeting'] = $this->user->get_meeting($id);
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$this->load->view('html_head', $data);
		$this->load->view('user', $data);
		$this->load->view('html_foot', $data);
	}
	public function absen($id)
	{
		$this->load->model('model_user','user',TRUE);
		$data['data_sql'] = $this->user->get_meeting_detail();
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$data['id'] = $id;
		$this->load->view('user_form', $data);
	}
	public function absenx($id)
	{
		$this->load->model('model_user','user',TRUE);
		$email = $this->input->get("email");

		if($email){
			$this->savexapi($id,$email);
		}else{
			$data['data_sql'] = $this->user->get_meeting_detail();
			$data['error'] = '';
			$data['success'] = '';
			$data['base_url'] = $this->config->item('base_url');
			$data['id'] = $id;
			$this->load->view('user_formx', $data);

		}
	}
	public function peserta()
	{
		$this->load->model('model_user','user',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$values = array('txt_email' => $this->input->post("txt_email"),
						'txt_telp' => $this->input->post("txt_telp"),
						'txt_password' => $this->input->post("txt_password")
							);
		$user = $this->user->get_user($values); 
		if($user)
		{
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_password' => $this->input->post("txt_password")
							);
							
			$this->user->save_user($values);
			$data['success']='Absen Success';
			$data['id']=$this->input->post("txt_id");
			$this->load->view('user_formx', $data);
		}	
		else
		{
			
			
			$data['id']=$this->input->post("txt_id");
			$data['txt_email']=$this->input->post("txt_email");
			$data['txt_password']=$this->input->post("txt_password");
			$data['user_sql'] = $this->user->get_user_list();
			
			$this->load->view('html_head', $data);
		$this->load->view('user_form_peserta', $data);
		$this->load->view('html_foot', $data);
		}
	}
		public function peserta_man($id)
	{
		$this->load->model('model_user','user',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$values = array('txt_email' => $this->input->post("txt_email"),
						'txt_telp' => $this->input->post("txt_telp"),
						'txt_password' => $this->input->post("txt_password")
							);
		$user = $this->user->get_user($values); 
		if($user)
		{
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_password' => $this->input->post("txt_password")
							);
							
			$this->user->save_user($values);
			$data['success']='Absen Success';
			$data['id']=$this->input->post("txt_id");
			$this->load->view('user_formx', $data);
		}	
		else
		{
			
			
			$data['id']=$id;
			$data['txt_email']=$this->input->post("txt_email");
			$data['txt_password']=$this->input->post("txt_password");
			$data['user_sql'] = $this->user->get_user_list();
			
			$this->load->view('html_head', $data);
		$this->load->view('user_form_peserta', $data);
		$this->load->view('html_foot', $data);
		}
	}
	public function savex()
	{

		$this->load->model('model_user','user',TRUE);
		$this->load->model('model_meeting','meeting',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$values = array('txt_email' => $this->input->post("txt_email"),
						'txt_telp' => $this->input->post("txt_telp"),
						'txt_password' => $this->input->post("txt_password")
							);
		$user = $this->user->get_user($values); 

		if($user)
		{

			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_telp' => $this->input->post("txt_telp"),
							'txt_password' => $this->input->post("txt_password")
							);
			$cek = $this->user->cek_absen_qr($values); 
			if($cek)
			{
			$cek = $this->user->cek_absen($values); 
			if(!$cek)
			{	
				$cek = $this->user->cek_absen_jam($values); 
				if($cek)
				{				
				$this->user->save_user($values);
				$data['success']='Absen Success';
								//----------------------
								$qr_name = date('His', time()).substr(md5(rand()),0,20);
								$qr_image = $qr_name.'.png';
								$params['data'] = $this->config->item('base_url')."index.php/user/absenx/".$qr_name;
								$params['level'] = 'H';
								$params['size'] = 8;
								$params['savename'] ="temp/qr/".$qr_image;
								
								if($this->ciqrcode->generate($params))
								{
									
									$data['img_url']=$qr_image;	
								
									$values = array('id' =>$this->input->post("txt_id")
													,'file_qr' => $data['img_url']);
									
									
										$this->meeting->update_meeting_qr($values);								
								}
			
				}
				else
				{
					$data['error']='WAKTU ABSEN TELAH HABIS';
				}
			}
			else
			{
				
				$data['error']='USER SUDAH PERNAH ABSEN';

			}
			//--
			}
			else
			{
				
				$data['error']='QRCODE SUDAH DI GUNAKAN SILAHKAN SCAN ULANG';

			}
			$data['id']=$this->input->post("txt_id");
			$this->load->view('user_formx', $data);

		}	
		else
		{
			
			$data['txt_user']='';
			$data['txt_pt']='TP';
			$data['id']=$this->input->post("txt_id");
			$data['txt_email']=$this->input->post("txt_email");
			$data['txt_telp']=$this->input->post("txt_telp");
			$data['txt_password']=$this->input->post("txt_password");
			
			$this->load->view('user_formx_detail', $data);
		}
	}

	public function savexapi($txt_id, $txt_email, $txt_telp=null, $txt_password=null)
	{

		$this->load->model('model_user','user',TRUE);
		$this->load->model('model_meeting','meeting',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$values = array('txt_email' => $txt_email,
						'txt_telp' => $txt_telp,
						'txt_password' => $txt_password
							);
		$user = $this->user->get_user($values); 

		if($user)
		{

			$values = array('txt_id' => $txt_id,
							'txt_email' => $txt_email,
							'txt_telp' => $txt_telp,
							'txt_password' => $txt_password
							);
			$cek = $this->user->cek_absen_qr($values); 
			if($cek)
			{
			$cek = $this->user->cek_absen($values); 
			if(!$cek)
			{	
				$cek = $this->user->cek_absen_jam($values); 
				if($cek)
				{				
				$this->user->save_user($values);
				$data['success']='Absen Success';
				
				
								//----------------------
								$qr_name = date('His', time()).substr(md5(rand()),0,20);
								$qr_image = $qr_name.'.png';
								$params['data'] = $this->config->item('base_url')."index.php/user/absenx/".$qr_name;
								$params['level'] = 'H';
								$params['size'] = 8;
								$params['savename'] ="temp/qr/".$qr_image;
								
								if($this->ciqrcode->generate($params))
								{
									
									$data['img_url']=$qr_image;	
								
									$values = array('id' =>$txt_id
													,'file_qr' => $data['img_url']);
									
									
										$this->meeting->update_meeting_qr($values);
									
									
									
									
									
								}
								//----------------------
				
				
				}
				else
				{
					$data['error']='WAKTU ABSEN TELAH HABIS';
				}
			}
			else
			{
				
				$data['error']='USER SUDAH PERNAH ABSEN';

			}
			//--
			}
			else
			{
				
				$data['error']='QRCODE SUDAH DI GUNAKAN SILAHKAN SCAN ULANG';

			}
			$data['id']=$txt_id;
			$this->load->view('user_formx1', $data);

		}	
		else
		{
			
			$data['txt_user']='';
			$data['txt_pt']='';
			$data['id']=$txt_id;
			$data['txt_email']=$txt_email;
			$data['txt_telp']=$txt_telp;
			$data['txt_password']=$txt_password;
			
			$this->load->view('user_formx_detail', $data);
		}
	}

	public function save_peserta()
	{
		$this->load->model('model_user','user',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_user' => $this->input->post("txt_user"),
							'txt_telp' => $this->input->post("txt_telp"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_pt' => $this->input->post("txt_pt"));
			$this->user->save_peserta($values);
			$data['success']='Insert Success';
			
			$data['id']=$this->input->post("txt_id");
			$data['txt_email']=$this->input->post("txt_email");
			$data['txt_password']=$this->input->post("txt_password");
			$this->load->view('html_head', $data);
		$this->load->view('user_form_peserta', $data);
		$this->load->view('html_foot', $data);
		
	}
	public function save_peserta_man()
	{
		$this->load->model('model_user','user',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_user' => $this->input->post("txt_user"));
			if($this->user->save_absen_man($values) == 'FALSE'){
				$data['user_sql'] = $this->user->get_user_list();
				$data['id']=$this->input->post("txt_id");
				$data['txt_email']=$this->input->post("txt_email");
	
				redirect('/meeting_menu');		
			}else{
				$data['user_sql'] = $this->user->get_user_list();
				$data['id']=$this->input->post("txt_id");
				$data['txt_email']=$this->input->post("txt_email");
	
				redirect('/meeting_menu');		
			}
	}
	public function savexd()
	{
		$this->load->model('model_user','user',TRUE);
		$data['success'] = '';
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_user' => $this->input->post("txt_user"),
							'txt_telp' => $this->input->post("txt_telp"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_pt' => $this->input->post("txt_pt"));
			$this->user->save_user_ext($values);
			$data['success']='Absen Success';
			
			$data['id']=$this->input->post("txt_id");
			$data['txt_email']=$this->input->post("txt_email");
			$data['txt_telp']=$this->input->post("txt_telp");
			$data['txt_pt']=$this->input->post("txt_pt");
			$data['txt_user']=$this->input->post("txt_user");
			$data['txt_password']=$this->input->post("txt_password");
			$this->load->view('user_formx', $data);
			
			
			
			
			
		
	}
	public function save()
	{
		$this->load->model('model_user','user',TRUE);
		$data['data_sql'] = $this->user->get_meeting_detail();
		$data['error'] = '';
		$data['base_url'] = $this->config->item('base_url');
		$data['id'] = $this->input->post("txt_id");
		if($this->input->post("txt_ket")!='1')
		{
			try {
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_password' => $this->input->post("txt_password")
							);
							
			$this->user->save_user($values);
			
			} catch( Exception $e ) { 
			echo "error";
			}
		}
		else
		{
			$values = array('txt_id' => $this->input->post("txt_id"),
							'txt_user' => $this->input->post("txt_user"),
							'txt_telp' => $this->input->post("txt_telp"),
							'txt_email' => $this->input->post("txt_email"),
							'txt_pt' => $this->input->post("txt_pt"));
			$this->user->save_user_ext($values);
		}	
		$this->load->view('user_form', $data);
	}
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */