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

		$checkin_date=0;
		$checkout_date=0;
		$status_arr = '';
		$status_end = '';

        foreach ($list as $value) {
			if($value->CHECKIN_DATE == null){
				$checkin_date = ".. : ..";
				$status_arr = "<span class='text-white bg-gradient-danger p-2'>TIDAK ABSEN</span>";
			}else{
				$checkin_date = '<span>'.date("H:i", strtotime($value->CHECKIN_DATE)).'</span>';
				if($value->STATUS_ARR == 'E'){
					$status_arr = "<span class='text-white bg-gradient-success p-2'>EARLY</span>";
				}else if ($value->STATUS_ARR == 'O'){
					$status_arr = "<span class='text-white bg-gradient-success p-2'>ONTIME</span>";
				}else if($value->STATUS_ARR == "L"){
					$status_arr = "<span class='text-white bg-gradient-warning p-2'>LATE</span>";
				}else{
					$status_arr = "UNDEFINIED";
				}
			}

			if($value->CHECKOUT_DATE == null){
				$checkout_date = ".. : ..";
				$status_end = "<span class='text-white bg-gradient-danger p-2'>TIDAK ABSEN</span>";
			}else{
				$checkout_date = '<span>'.date("H:i", strtotime($value->CHECKOUT_DATE)).'</span>';
				if($value->STATUS_END == 'E'){
					$status_end = "<span class='text-white bg-gradient-success p-2'>EARLY</span>";
				}else if ($value->STATUS_END == 'O'){
					$status_end = "<span class='text-white bg-gradient-success p-2'>ONTIME</span>";
				}else{
					$status_end = "UNDEFINIED";
				}
			}
            $no++;
			$row = array();
            $row[] = $no;
			$row[] = date("Y-m-d", strtotime($value->CREATED_DATE));
            $row[] = $checkin_date.' | '.$status_arr;
			$row[] = $checkout_date.' | '.$status_end;
			$row[] = $status_end;
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





			// if($cekExisiting){
			// 	if($getTime->TIME_ARR_DIFF < 0 && $getTime->TIME_ARR_DIFF >= -$getIntervalLate){
			// 		if($cekExisiting->CHECKIN_DATE != null){
			// 			$this->session->set_flashdata('notif', $this->notify_warning('Anda Sudah Melakukan Absensi Kedatangan'));								
			// 		}
			// 	}else if($getTime->TIME_ARR_DIFF <= -$getIntervalLate && $getTime->TIME_END_DIFF > 0){
			// 		// ABSEN PULANG EARLY 
			// 		if($cekExisiting->STATUS_END == 'END_EARLY' || $cekExisiting->CHECKOUT_DATE == null){
			// 			$data = array(
			// 				'CHECKOUT_DATE' => $getTime->TIME_NOW,
			// 				'UPDATE_BY' => $this->session->userdata('session_meeting')->USERNAME,
			// 				'UPDATE_DATE' =>  $getTime->TIME_NOW,
			// 				'STATUS_END' => 'END_EARLY'
			// 			);
			// 			$this->Magang_Model->update($data,$this->session->userdata('session_meeting')->USERNAME);
			// 			$this->session->set_flashdata('notif', $this->notify_success('Anda Berhasil Melakukan Absensi Pulang'));		
			// 		}							
			// 	}else if($getTime->TIME_END_DIFF <= 0 && $getTime->TIME_END_DIFF > -$getIntervalEnd){
			// 		// ABSEN SETELAH JAM PULANG - INTERVAL
			// 		if($cekExisiting->STATUS_END == 'END_EARLY' || $cekExisiting->CHECKOUT_DATE == null){
			// 			//MERUBAH STATUS KE ONTIME
			// 			$data = array(
			// 				'CHECKOUT_DATE' => $getTime->TIME_NOW,
			// 				'UPDATE_BY' => $this->session->userdata('session_meeting')->USERNAME,
			// 				'UPDATE_DATE' =>  $getTime->TIME_NOW,
			// 				'STATUS_END' => 'PULANG'
			// 			);
			// 			$this->Magang_Model->update($data,$this->session->userdata('session_meeting')->USERNAME);
			// 			$this->session->set_flashdata('notif', $this->notify_success('Anda Berhasil Melakukan Absensi Pulang'));		
			// 		}			
			// 		else{
			// 			$this->session->set_flashdata('notif', $this->notify_warning('Anda Sudah Melakukan Absensi Pulang'));		
			// 		}						
			// 	}
			// 	else{
			// 		$this->session->set_flashdata('notif', $this->notify_danger('Anda Melebihi Batas Absen Pulang'));								
			// 	}
			// }else{
			// 	$data = array(
			// 		'NIPP' => $this->session->userdata('session_meeting')->USERNAME,
			// 		'NAMA' => $this->session->userdata('session_meeting')->NAMA,	
			// 		'NAJAB' => $this->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA,
			// 		// 'NAMA_SUB' =>
			// 		'LAT' => $lat,
			// 		'LON' => $long,
			// 		'JARAK' => $jarak,
			// 		'CHECKIN_DATE' => $getTime->TIME_NOW,
			// 		'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
			// 	);

			// 	if($getTime->TIME_ARR_DIFF > $getIntervalArr){
			// 		$this->session->set_flashdata('notif', $this->notify_danger('Belum Memasuki Waktu Absensi Kedatangan'));								
			// 	}else if($getTime->TIME_ARR_DIFF > (int)$getIntervalArr/2 && $getTime->TIME_ARR_DIFF < $getIntervalArr){
			// 		$data['STATUS_ARR'] = 'EARLY';
			// 		$this->Magang_Model->insert($data);
			// 		$this->session->set_flashdata('notif', $this->notify_success('Anda Berhasil Melakukan Absensi Kedatangan , Kedatangan Anda EARLY'));		

			// 	}else if($getTime->TIME_ARR_DIFF <= (int)$getIntervalArr/2 && $getTime->TIME_ARR_DIFF >= 0){
			// 		$data['STATUS_ARR'] = 'ONTIME';
			// 		$this->Magang_Model->insert($data);
			// 		$this->session->set_flashdata('notif', $this->notify_success('Anda Berhasil Melakukan Absensi Kedatangan , Kedatangan Anda ON-TIME'));		

			// 	}else if($getTime->TIME_ARR_DIFF < 0 && $getTime->TIME_ARR_DIFF >= -$getIntervalLate){
			// 		$data['STATUS_ARR'] = 'TERLAMBAT';
			// 		$this->Magang_Model->insert($data);
			// 		$this->session->set_flashdata('notif', $this->notify_warning('Anda Berhasil Melakukan Absensi Kedatangan , Kedatangan Anda Telambat'));	
	
			// 	}else{
			// 		$data['STATUS_ARR'] = 'TERLAMBAT';
			// 		$this->Magang_Model->insert($data);
			// 		$this->session->set_flashdata('notif', $this->notify_danger('Anda Melebihi Batas Absen Kedatangan (Jam '.$time_arr.')'));								
			// 	}
			// }