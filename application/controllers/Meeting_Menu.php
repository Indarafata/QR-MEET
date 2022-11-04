<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class meeting_menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        redirectIfNotLoggedIn();
		check_permission();
        set_time_limit(10000);
        $this->load->model('Meeting_Model');
        $this->load->helper('url');

	}	
	public function index()
	{
        $data['active_menu']    = 'meeting_menu';
		$data['content']		= 'meeting_menu/view';
		$this->load->view('index', $data);
	}
    public function update_page($id)
	{
        $data['active_menu']    = 'meeting_menu';
		$data['content']		= 'meeting_menu/update';
		$this->load->view('index', $data);
	}
    public function create_page()
	{
        $data['active_menu']    = 'meeting_menu';
		$data['content']		= 'meeting_menu/create';
		$this->load->view('index', $data);
	}
    public function list_absen_page()
	{
        $data['active_menu']    = 'meeting_menu';
		$data['content']		= 'meeting_menu/list_absen';
		$this->load->view('index', $data);
	}
    public function add_peserta()
	{
        $data['active_menu']    = 'meeting_menu';
		$data['content']		= 'meeting_menu/add_peserta';
		$this->load->view('index', $data);
	}
    public function qr_code_page($id)
	{
        $data['data'] =  $this->db->query("SELECT * FROM MEETING.VW_MEETING WHERE ID_MEETING = '$id'")->row();
		$this->load->view('meeting_menu/qr_code_page',$data);
	}
    public function text(){
        $data['error']='';
        $data['success']='';
        $data['txt_email']='';
        $data['txt_telp']='';

        $this->load->view('user_formx_detail',$data);
    }
    public function list_print_absen_page($id)
	{
        $data['data'] = $this->db->query("SELECT upper(a.id_user) id_user,
                    a.id_meeting,
             upper(b.username) as name,
       upper( a.email)email,
        a.username,
        TO_CHAR (a.checkin_date, 'dd/mm/yyyy hh24:mi') checkin_date,
        TO_CHAR (a.checkout_date, 'dd/mm/yyyy hh24:mi') checkout_date,
        a.status,
        b.id_dept,
        d.nama_sub,d.nama_sek,
        b.company,
        b.najab,
        b.dept_name,
        c.event
   FROM
         meeting_detail a,  VW_USER b,
         (
             SELECT U.EMAIL, MAX(P.NAMA_SUB) NAMA_SUB, MAX(P.NAMA_SEK) NAMA_SEK FROM OUTH.USERLOGIN U, OUTH.VPERSOEIS P
             WHERE U.NIPP = P.NRK AND U.EMAIL IS NOT NULL GROUP BY U.EMAIL
         ) d,meeting c
     WHERE
         upper(A.EMAIL) = upper(b.email)
         AND UPPER(a.EMAIL) = UPPER(d.EMAIL(+)) AND a.id_meeting = '$id' AND c.id_meeting = '$id' order by id_user asc")->result();

         $data['data2'] = $this->db->query("SELECT * FROM MEETING.MEETING WHERE ID_MEETING = '$id'")->row();
        
		$this->load->view('meeting_menu/list_print', $data);
	}
    function datatable_meeting_menu() 
	{
		$list = $this->Meeting_Model->get_datatables_meeting();
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");


        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<td class="text-right">'.
                        '<div class="dropdown">'.
                        '<a class="btn btn-sm btn-icon-only btn-primary text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.
                            '<i class="fas fa-ellipsis-v"></i>'.
                        '</a>'.
                        '<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">'.
                            '<a class="dropdown-item" href="'.site_url('meeting_menu/update_page/').$value->ID_MEETING.'">Edit Meeting</a>'.
                            '<a class="dropdown-item" href="'.base_url('temp/file/').$value->FILE_URL.'">File</a>'.
                            '<input type="text" class="cpas" value="'.$value->URL_QR.'" id="ct'.$no.'">'.
                            '<button class="dropdown-item" onClick="myFunction('.$no.')">Copy Link</button>'.
                            '<a class="dropdown-item" href="'.site_url('meeting_menu/qr_code_page/').$value->ID_MEETING.'">QR Code</a>'.
                            '<a class="dropdown-item" href="'.site_url('meeting_menu/add_peserta/').$value->ID_MEETING.'">Tambah Peserta</a>'.
                            '<a class="dropdown-item" href="'.site_url('meeting_menu/list_absen_page/'.$value->ID_MEETING).'">List Absensi</a>'.
                        '</div>'.
                        '</div>'.
                    '</td>';
            $row[] = '<span>'.$value->ID_MEETING.'</span>';
            $row[] = $value->EVENT;
            $row[] = $value->USERNAME;
            $row[] = $value->EVENT_DATE;
            $row[] = $value->WAKTU;
            $row[] = $value->ID_DEPT;
            $row[] = $value->LOCATION;
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Meeting_Model->count_all_meeting(),
            "recordsFiltered" => $this->Meeting_Model->count_filtered_meeting(),
            "data" => $data,
        );

        echo json_encode($output);
	}

    function datatable_list_absen($id) 
	{
		$list = $this->Meeting_Model->get_datatables_list_absen($id);
        $data = array();
        $no = $_POST['start'];
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI'");
        $id_dept = '';


        foreach ($list as $value) {

            if($value->ID_DEPT == null) {
                $id_dept = $value->NAMA_SUB;
            }else{
                $id_dept = $value->ID_DEPT;
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $value->ID_USER;
            $row[] = $value->ID_MEETING;
            $row[] = $value->NAME;
            $row[] = $value->EMAIL;
            $row[] = $id_dept;
            $row[] = $value->COMPANY;
            $row[] = $value->CHECKIN_DATE;
            $row[] = '<span class="btn btn-success" style="width:100%;">HADIR</span>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Meeting_Model->count_all_list_absen($id),
            "recordsFiltered" => $this->Meeting_Model->count_filtered_list_absen($id),
            "data" => $data,
        );

        echo json_encode($output);
	}

    function insert(){
        $meeting_name = $this->input->post('meeting_name');
        $meeting_location = $this->input->post('meeting_location');
        $id_departement = $this->input->post('departement');
        $id_event = $this->input->post('event');
        $file = $this->input->post('userfile');
        $event_date_temp = $this->input->post('event_date');
        $start_date_temp = $this->input->post('start_date');
        $end_date_temp = $this->input->post('end_date');

        $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $timeNow = $dt->format('Y-m-d G:i:s');

        $event_date = date("Y-m-d  H:i:s", strtotime($event_date_temp));
        $start_date = date("Y-m-d  H:i:s", strtotime($start_date_temp));
        $end_date = date("Y-m-d  H:i:s", strtotime($end_date_temp));

        $qr_name = date('His', time()).substr(md5(rand()),0,20);
		$qr_image = $qr_name.'.png';
		$params['data'] = $this->config->item('base_url')."index.php/user/absenx/".$qr_name;
		$params['level'] = 'H';
		$params['size'] = 8;
		$params['savename'] ="temp/qr/".$qr_image;

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

		if($this->ciqrcode->generate($params))
		{
			$config['upload_path'] = 'temp/file/';
			$config['allowed_types'] = 'word|gif|jpg|png|pdf';
			$config['max_size']	= '10000';
			$config['max_width']  = '5000';
			$config['max_height']  = '5000';
			$error = array('error' => '');

			$this->load->library('upload', $config);
			$file_yn = "N";
			$file_name = "";
			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				$data['error'] = $this->upload->display_errors();
				
			}
			else
			{
				$data_file = array('upload_data' => $this->upload->data());	
				$file_yn = "Y";
				$file_name = $data_file['upload_data']['file_name'];
			}
			
			$data['img_url']=$qr_image;	
		
			$values = array(
                'ID_EVENT' =>$id_event,
                'EVENT_DATE' => $event_date,
                'EVENT' => $meeting_name,
                'START_DATE' =>$start_date,
                'END_DATE' => $end_date,
                'FILE_QR' => $data['img_url'],
                'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'CREATED_DATE' => $timeNow,
                'ID_DEPT' => $id_departement,
                'LOCATION' => $meeting_location,
                'URL_QR' => $params['data'],
                'FILE_URL' => $file_name
			);
			$this->Meeting_Model->insert($values);
		}

        redirect('/meeting_menu');

    }
    function update(){
        $id_meeting = $this->input->post('id_meeting');
        $meeting_name = $this->input->post('meeting_name');
        $meeting_location = $this->input->post('meeting_location');
        $id_departement = $this->input->post('departement');
        $id_event = $this->input->post('event');
        $file = $this->input->post('userfile');
        $event_date_temp = $this->input->post('event_date');
        $start_date_temp = $this->input->post('start_date');
        $end_date_temp = $this->input->post('end_date');

        $dt = new DateTime("now", new DateTimeZone('Asia/Jakarta'));
        $timeNow = $dt->format('Y-m-d G:i:s');

        $event_date = date("Y-m-d  H:i:s", strtotime($event_date_temp));
        $start_date = date("Y-m-d  H:i:s", strtotime($start_date_temp));
        $end_date = date("Y-m-d  H:i:s", strtotime($end_date_temp));

        // $qr_name = date('His', time()).substr(md5(rand()),0,20);
		// $qr_image = $qr_name.'.png';
		// $params['data'] = $this->config->item('base_url')."index.php/user/absenx/".$qr_name;
		// $params['level'] = 'H';
		// $params['size'] = 8;
		// $params['savename'] ="temp/qr/".$qr_image;

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $this->db->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");

		// if($this->ciqrcode->generate($params))
		// {
			$config['upload_path'] = 'temp/file/';
			$config['allowed_types'] = 'word|gif|jpg|png|pdf';
			$config['max_size']	= '10000';
			$config['max_width']  = '5000';
			$config['max_height']  = '5000';
			$error = array('error' => '');

			$this->load->library('upload', $config);
			$file_yn = "N";
			$file_name = "";
			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				$data['error'] = $this->upload->display_errors();
				
			}
			else
			{
				$data_file = array('upload_data' => $this->upload->data());	
				$file_yn = "Y";
				$file_name = $data_file['upload_data']['file_name'];
			}
			
			// $data['img_url']=$qr_image;	
		
			$values = array(
                'ID_EVENT' =>$id_event,
                'EVENT_DATE' => $event_date,
                'EVENT' => $meeting_name,
                'START_DATE' =>$start_date,
                'END_DATE' => $end_date,
                // 'FILE_QR' => $data['img_url'],
                'CREATED_BY' => $this->session->userdata('session_meeting')->USERNAME,
                'CREATED_DATE' => $timeNow,
                'ID_DEPT' => $id_departement,
                'LOCATION' => $meeting_location,
                // 'URL_QR' => $params['data']
			);
			$this->Meeting_Model->update($values,$id_meeting);
		// }

        redirect('/meeting_menu');

    }

    function insert_peserta(){
        $peserta = $this->input->post('peserta');
        
    }

    public function departement(){
        $data = $this->db->query("SELECT * FROM MEETING.DEPARTEMENT")->result();
        echo json_encode($data);
    }
    public function event(){
        $data = $this->db->query("SELECT * FROM MEETING.MASTER_EVENT WHERE STATUS = 1")->result();
        echo json_encode($data);
    }
    public function meeting_detail($id){
        $data = $this->db->query("SELECT * FROM MEETING.VW_MEETING WHERE ID_MEETING = '$id'")->row();
        echo json_encode($data);
    }
    public function meeting_list_absen($id){
        $data = $this->db->query("  SELECT upper(a.id_user) id_user,
                                    a.id_meeting,
                                    upper( a.email)email,
                                    a.username,
                                    TO_CHAR (a.checkin_date, 'dd/mm/yyyy hh24:mi') checkin_date,
                                    TO_CHAR (a.checkout_date, 'dd/mm/yyyy hh24:mi') checkout_date,
                                    a.status,
                                    b.id_dept,
                                    d.nama_sub,d.nama_sek,
                                    b.company
                                     FROM
                                    meeting_detail a,  users b,
                                    (
                                        SELECT U.EMAIL, MAX(P.NAMA_SUB) NAMA_SUB, MAX(P.NAMA_SEK) NAMA_SEK FROM OUTH.USERLOGIN U, OUTH.VPERSOEIS P
                                        WHERE U.NIPP = P.NRK GROUP BY U.EMAIL
                                    ) d
                                    WHERE
                                    upper(A.EMAIL) = upper(b.email)
                                    AND UPPER(a.EMAIL) = UPPER(d.EMAIL(+)) WHERE a.id_meeting = '$id'")->result();
        echo json_encode($data);
    }
    public function get_user_list(){
        $query = $this->db->query("select a.*,b.dept_name, to_char(a.created_date,'dd/mm/yyyy hh24:mi') created_date_f from users a left join departement b on(a.id_dept=b.id_dept) order by username")->result();
        echo json_encode($query);
    }
}
