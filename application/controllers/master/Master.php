<?php

class Master extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function upload_dropzone()
    {
        $output = 'json';

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }
        if ($output=='json') {
            header('Content-Type: application/json');
        }

        $date = $this->input->post('date');
        // cek_array($_FILES);die();

        if (!is_dir('./assets/upload/tmp/'.$date)) {
            mkdir('./assets/upload/tmp/'.$date, 0777, TRUE);
        }
        
        $config['upload_path']          = './assets/upload/tmp/'.$date;
        $config['allowed_types']        = '*';
        $config['max_size']             = 6000;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file')){
            $data = $this->upload->display_errors();
            $status = 0;
            $msg = 'error';
        }else{
            $data = $this->upload->data();
            $status = 1;
            $msg = 'success';
        }

        $data = array(
            'status' => $status,
            'message' => $msg,
            'data' => $data
        );
        echo json_encode($data);
    }
}
