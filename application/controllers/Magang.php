<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class magang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Magang_Model');
        $this->load->helper('url');
		$this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

	}	
	public function index()
	{
		$data['content']		= 'magang_menu/create';
		$this->load->view('index', $data);
	}
	public function exception(){
		$data['content']		= 'magang_menu/exception';
		$this->load->view('index', $data);
	}
	public function log_absensi()
	{
		$data['content']		= 'magang_menu/view';
		$this->load->view('index', $data);
	}

	function datatable_log_absensi_arr_menu() 
	{
		$list = $this->Magang_Model->get_datatables_log_absensi_arr($this->session->userdata('session_meeting')->USERNAME);
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");
		$type='-';
		$status_arr = '';
		$status_end = '';

        foreach ($list as $value) {
            $no++;
	
			$row = array();
            $row[] = $no;
				if($value->EXCEPTION_DATE == null && $value->STATUS_ARR == null && $value->STATUS_END == null){
					$row[] =  '<span class="text-danger">'.date("d-M", strtotime($value->DAY)).' | '.$value->DAY_NAME.'</span>';
					$row[] =  '<span class="text-danger">'.$value->STATUS_ARR.' - '.$value->CHECKIN_TIME.'</span>';
					$row[] =  '<span class="text-danger">'.$value->STATUS_END.' - '.$value->CHECKOUT_TIME.'</span>';
					$row[] =  '<span class="text-danger">'.$value->TYPE.' - '. $value->REMARK.'</span>';
				}else{
					if($value->EXCEPTION_DATE !=null){
						$row[] = '<span class="bg-danger p-2 text-white">'.date("d-M", strtotime($value->DAY)).' | '.$value->DAY_NAME.'</span>';
					}else{
						$row[] = '<span class="bg-success p-2 text-white">'.date("d-M", strtotime($value->DAY)).' | '.$value->DAY_NAME.'</span>';
					}
					$row[] = '<span class="">'.$value->STATUS_ARR.' - '.$value->CHECKIN_TIME.'</span>';
					$row[] = '<span class="">'.$value->STATUS_END.' - '.$value->CHECKOUT_TIME.'</span>';
					$row[] = '<span class="">'.$value->TYPE.' - '. $value->REMARK.'</span>';
				}
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Magang_Model->count_all_log_absensi_arr($this->session->userdata('session_meeting')->USERNAME),
            "recordsFiltered" => $this->Magang_Model->count_filtered_log_absensi_arr($this->session->userdata('session_meeting')->USERNAME),
            "data" => $data,
        );

        echo json_encode($output);
	}

    public function absen(){
        $lat = $this->input->post("txt_lat");
        $long = $this->input->post("txt_long");
        $jarak = $this->input->post("txt_jarak");

		$getTime = $this->db->query('SELECT * FROM ABS_TIME')->ROW();

		date_default_timezone_set("Asia/Jakarta");
		$notif = array();
		$data = array();

		$notif['status'] = '';
		$notif['msg'] = '';

		$cekExisiting = $this->db->query("SELECT * FROM ABSENSI_MAGANG WHERE NIPP = '".$this->session->userdata('session_meeting')->USERNAME."' AND TO_CHAR(CHECKIN_DATE, 'YYYYMMDD') = TO_CHAR(SYSDATE, 'YYYYMMDD') OR TO_CHAR(CHECKOUT_DATE, 'YYYYMMDD') = TO_CHAR(SYSDATE, 'YYYYMMDD')")->row();
		

		//CEK JARAK
		if($jarak != null && $long != null && $lat !=null){
			if($jarak < $this->db->query("SELECT PARAM1 FROM GEN_REF WHERE CODE_REF = 'ABS_JARAK'")->ROW()->PARAM1){
				//CEK TYPE ABSEN JIKA ABS_TYPE ARR
				if($getTime->ABS_TYPE == 'ARR'){
					// CEK JIKA USER SUDAH ABSEN ATAU BELUM (KEDATANGAN)
					if($cekExisiting->STATUS_ARR != null && $cekExisiting->CHECKIN_DATE != null){
						//JIKA SUDAH (NOTIFIKASI SUDAH)
						$notif['status'] = 'success';
						$notif['msg'] = 'Anda Telah Melakukan Absensi Kedatangan Hari ini';
						// $this->session->set_flashdata('notif', $this->notify_danger('Anda Sudah Melakukan Absensi Kedatangan Hari Ini'));								
					}else{
						//JIKA BELUM (INSERT)
						$data = array(
							'NIPP' => $this->session->userdata('session_meeting')->USERNAME,
							'NAMA' => $this->session->userdata('session_meeting')->NAMA,	
							'NAJAB' => $this->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA,
							// 'NAMA_SUB' =>
							'LAT' => $lat,
							'LON' => $long,
							'JARAK' => $jarak,
							'CHECKIN_DATE' => $getTime->TIME_NOW,
							'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
							'STATUS_ARR' => $getTime->STATUS_ARR,
						);
						$this->Magang_Model->insert($data);
						
						$notif['status'] = 'success';
						$notif['msg'] = 'Anda Berhasil Melakukan Absensi Kedatangan';
						// $this->session->set_flashdata('notif', $this->notify_success('Anda Berhasil Melakukan Absensi Kedatangan'));		
					}
				//CEK TYPE ABSEN JIKA ABS_TYPE END				
				}else{
					//CEK APAKAH DATA USER SUDAH ADA DALAM DATABASE ATAU BELUM (SESUAI TANGGAL SEKARANG)
					if(!$cekExisiting){
						// JIKA BELUM ADA MAKA INSERT DENGAN CHECKOUT EARLY,ONTIME dan CHECKIN KOSONG
						$data = array(
							'NIPP' => $this->session->userdata('session_meeting')->USERNAME,
							'NAMA' => $this->session->userdata('session_meeting')->NAMA,	
							'NAJAB' => $this->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA,
							// 'NAMA_SUB' =>
							'LAT' => $lat,
							'LON' => $long,
							'JARAK' => $jarak,
							'CHECKOUT_DATE' => $getTime->TIME_NOW,
							'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
							'STATUS_END' => $getTime->STATUS_END
						);
						$this->Magang_Model->insert($data);

						$notif['status'] = 'success';
						$notif['msg'] = 'Anda Berhasil Pulang';
						// $this->session->set_flashdata('notif', $this->notify_success('Anda Berhasil Absen Pulang'));		
					//JIKA USER SUDAH ADA					
					}else{
						// JIKA USER SUDAH ADA DAN STATUS O , MAKA NOTIFIKASI SUDAH ABSEN
						if($cekExisiting->STATUS_END == 'O'){
							$notif['status'] = 'success';
							$notif['msg'] = 'Anda Sudah Melakukan Absen Pulang Hari Ini';
							// $this->session->set_flashdata('notif', $this->notify_success('Anda Sudah Melakukan Absen Pulang Hari Ini'));	
						//JIKA USER SUDAH ADA DAN STATUS MASIH E							
						}else{
							$data = array(
								'CHECKOUT_DATE' => $getTime->TIME_NOW,
								'UPDATE_BY' => $this->session->userdata('session_meeting')->USERNAME,
								'UPDATE_DATE' =>  $getTime->TIME_NOW,
								'STATUS_END' => $getTime->STATUS_END
							);

							$this->Magang_Model->update($data,$this->session->userdata('session_meeting')->USERNAME);

							$notif['status'] = 'success';
							$notif['msg'] = 'Anda Berhasil Absen Pulang';
							// $this->session->set_flashdata('notif', $this->notify_warning('Anda Berhasil Absen Pulang'));
						}								
					}
				}
			}else{
				$notif['status'] = 'danger';
				$notif['msg'] = 'Anda Belum Masuk Kawasan PT Terminal Teluk Lamong';
				// $this->session->set_flashdata('notif', $this->notify_danger('Anda Belum Masuk Kawasan PT Terminal Teluk Lamong'));								
			}
		}else{
			$notif['status'] = 'danger';
			$notif['msg'] = 'Lokasi Anda Tidak Terdeteksi';
			// $this->session->set_flashdata('notif', $this->notify_danger('Lokasi Anda Tidak Terdeteksi'));								
		}
		
			if ($this->input->is_ajax_request())
			{
				echo json_encode($notif);
				exit;
			}
		
		redirect('magang');
    }

	public function get_current_absen(){
		echo json_encode($this->db->query("SELECT * FROM ABSENSI_MAGANG WHERE NIPP = '".$this->session->userdata('session_meeting')->USERNAME."' AND TO_CHAR(CHECKIN_DATE, 'YYYYMMDD') = TO_CHAR(SYSDATE, 'YYYYMMDD') OR TO_CHAR(CHECKOUT_DATE, 'YYYYMMDD') = TO_CHAR(SYSDATE, 'YYYYMMDD')")->row());
	}
	public function get_abs_time(){
		echo json_encode($this->db->query("SELECT * FROM ABS_TIME")->row());
	}
	public function get_abs_area(){
		echo json_encode($this->db->query("SELECT * FROM AREA")->result());
	}
	public function get_abs_jarak(){
		echo json_encode($this->db->query("SELECT * FROM GEN_REF WHERE CODE_REF = 'ABS_JARAK'")->row());
	}

	public function exception_absen(){
		$data = array(
			'EXCEPTION_DATE'=>$this->input->post('tanggal'),
			'TYPE' => $this->input->post('type'),
			'NIPP' => $this->session->userdata('session_meeting')->USERNAME,
			'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
			'REMARK' => $this->input->post('remark')
		);
		$this->Magang_Model->save_exception($data);
		redirect('magang/exception');
	}
	


	public function notify_danger($content){
		return '<div data-notify="container" id="notify" class="alert alert-dismissible alert-danger alert-notify animated fadeInDown" 
				role="alert" data-notify-position="top-center" 
				style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
				<span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
				<div class="alert-text" <="" div=""> 
					<span class="alert-title" data-notify="title"> 
						Notifikasi</span> <span data-notify="message">
						'.$content.'
					</span>
				</div>
			</div>';
	}
	public function notify_warning($content){
		return '<div data-notify="container" id="notify" class="alert alert-dismissible alert-warning alert-notify animated fadeInDown" 
				role="alert" data-notify-position="top-center" 
				style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
				<span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
				<div class="alert-text" <="" div=""> 
					<span class="alert-title" data-notify="title"> 
						Notifikasi</span> <span data-notify="message">
						'.$content.'
					</span>
				</div>
			</div>';
	}
	public function notify_success($content){
		return '<div data-notify="container" id="notify" class="alert alert-dismissible alert-success alert-notify animated fadeInDown" 
				role="alert" data-notify-position="top-center" 
				style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1080; top: 15px; left: 0px; right: 0px; animation-iteration-count: 1;">
				<span class="alert-icon ni ni-bell-55" data-notify="icon"></span> 
				<div class="alert-text" <="" div=""> 
					<span class="alert-title" data-notify="title"> 
						Notifikasi</span> <span data-notify="message">
						'.$content.'
					</span>
				</div>
			</div>';
	}
	public function returnMyProductJson() { 
		return $this->output
            ->set_content_type('application/json')
            ->set_status_header(500)
            ->set_output(json_encode(array(
                    'text' => 'danger 500',
                    'type' => 'danger'
            )));
			redirect('magang');
	  } 

}
