<?php
require APPPATH . '/libraries/Master_Controller.php';

class Booth extends Master_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->table        = 'BOOTH';
        $this->title        = 'BOOTH';
        $this->pk           = 'ID';
        $this->qr           = 'QR_CODE';
        $this->order_by     = 'NAME';
        $this->order_sort   = 'ASC';
        $this->delete       = true;
        $this->manual       = true;

        $this->col[] = array('name' => 'NAME', 'label' => "NAME");
        $this->col[] = array('name' => 'DESCR', 'label' => "DESCRIPTION");
        $this->col[] = array('name' => 'CONTACT_NAME', 'label' => "CONTACT NAME");
        $this->col[] = array('name' => 'CONTACT_PHONE', 'label' => "CONTACT PHONE");
        $this->col[] = array('name' => 'QR_CODE', 'label' => "QR Code");
        $this->col[] = array('name' => 'URL_QR', 'label' => "URL QR");
        // $this->col[] = array('label' => "QR Code");
        // $this->col[] = array('value' => "<a href='https://www.youtube.com/watch?v=lj8TV9q59P4&ab_channel=%EB%AA%A8%EC%8A%A4%ED%8A%B8%EC%BD%98%ED%85%90%EC%B8%A0MOSTCONTENTS'>Edit</a>", 'label' => "<a href='https://www.youtube.com/watch?v=lj8TV9q59P4&ab_channel=%EB%AA%A8%EC%8A%A4%ED%8A%B8%EC%BD%98%ED%85%90%EC%B8%A0MOSTCONTENTS'>huhu</a>", 'action' => "<a href='https://www.youtube.com/watch?v=lj8TV9q59P4&ab_channel=%EB%AA%A8%EC%8A%A4%ED%8A%B8%EC%BD%98%ED%85%90%EC%B8%A0MOSTCONTENTS'>Edit</a>");

        $this->form[] = array('name' => 'NAME', 'label' => "Name", 'type' => 'text', 'required' => true, 'strToUpper' => true);
        $this->form[] = array('name' => 'DESCR', 'label' => 'Description', 'type' => 'text', 'required' => true, 'strToUpper' => true);
        $this->form[] = array('name' => 'ADDRESS', 'label' => 'Address', 'type' => 'text', 'required' => true, 'strToUpper' => true);
        $this->form[] = array('name' => 'HOUR_OPEN', 'label' => 'Hour Open', 'type' => 'time', 'value' => '08:00:00', 'required' => true);
        $this->form[] = array('name' => 'HOUR_CLOSE', 'label' => 'Hour Open', 'type' => 'time', 'value' => '17:00:00', 'required' => true);
        $this->form[] = array('name' => 'CONTACT_NAME', 'label' => 'Contact Name', 'type' => 'text', 'required' => true, 'strToUpper' => true);
        $this->form[] = array('name' => 'CONTACT_PHONE', 'label' => 'Contact Phone', 'type' => 'text', 'required' => true, 'strToUpper' => true);
    }


    function insertValidation()
    {
        $this->form_validation->set_rules('NAME', 'NAME', "required|callback_cek_id_unique");
        $this->form_validation->set_rules('DESCR', "DESCRIPTION", "required");

        return $this->form_validation->run();
    }

    public function cek_id_unique($str)
    {
        $data = $this->db->get_where($this->table, ['NAME' => $_POST['NAME']])->num_rows();

        if ($data > 0) {
            $this->form_validation->set_message('cek_id_unique', 'Name already exist');
            return false;
        }

        return true;
    }

    public function beforeInsert(&$data)
    {
        $data['KD_REGIONAL'] = getAuth('KD_TERMINAL');
        $data['KD_TERMINAL'] = getAuth('KD_TERMINAL');
        $data['QR_CODE']     = date('His', time()).substr(md5(rand()),0,20);
        $qr = $data['QR_CODE'];
        $data['URL_QR']     = "http://qrmeet.test/kantin/$qr";
    }

    function editValidation()
    {
        $data = $this->db->get_where($this->table, ['ROWID' => $_POST['ID']])->row();

        $id_unique = $data->NAME != $_POST['NAME'] ? "|callback_cek_id_unique" : '';

        $this->form_validation->set_rules('NAME', 'NAME', 'required' . $id_unique);
        $this->form_validation->set_rules('DESCR', "DESCRIPTION", "required");

        return $this->form_validation->run();
    }

    public function beforeEdit(&$data, &$id)
    {
    }

    public function deleteValidation($id)
    {
        if (!$this->delete) {
            header('Content-Type: application/json');
            echo json_encode(array("status" => 0, "msg" => "Data tidak boleh dihapus, mohon hubungi admin"));
            return false;
        }

        // $exist_tb = array();
        // $foreign_tb = $this->db->select('DISTINCT(TABLE_NAME)')->from('ALL_TAB_COLUMNS')->where(array(
        //     'OWNER' => 'MEETING',
        //     'COLUMN_NAME' => $this->pk,
        //     'GLOBAL_STATS' => 'YES',
        // ))->where("TABLE_NAME <> '$this->table'", NULL, false)->get()->result();

        // foreach ($foreign_tb as $tb) {
        //     $exist = $this->db->get_where($tb->TABLE_NAME, array($this->pk => $id))->num_rows();
        //     if ($exist > 0) {
        //         array_push($exist_tb, $tb->TABLE_NAME);
        //     }
        // }

        // if (count($exist_tb) > 0) {
        //     header('Content-Type: application/json');
        //     echo json_encode(array("status" => 0, "msg" => "Terdapat Data tersebut pada tabel " . implode(" ", $exist_tb)));
        //     return false;
        // }

        return true;
    }

    public function disable_edit($str)
    {
        $this->form_validation->set_message('disable_edit', '{field} tidak boleh diganti, harap hubungi admin');
        return false;
    }
}
