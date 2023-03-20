<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('captcha', 'form'));
        // $this->load->library('session');
    }

    public function index()
    {
        // redirectIfLoggedIn();

        $this->session->unset_userdata('session_meeting_temp');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data = array('img' => $this->i_create_captcha());
            $this->load->view('login', $data);
            // $this->load->view('login_mahasiswa', $data);
        } else {
            if ($this->session->userdata("captchaword") == $this->input->post('captcha')) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');

                $url = "http://sittl.teluklamong.co.id/wsouth.asmx?wsdl";
                $client = new SoapClient($url);

                $p = $client->valLoginAkun([
                    "xIDAPLIKASI" => "66",
                    "xUsername" => $username,
                    "xPassword" => $password
                ]);

                $response = $p->valLoginAkunResult;

                // echo json_encode($response);
                // die();

                if ($response->responType == 'S') {
                    $this->session->set_userdata('session_meeting_temp', $response);
                    redirect('login/chooserole');
                } else {
                    // check database mahasiswaa
                    $this->session->set_flashdata('message', "<div class='alert alert-danger'>" . $response->responText . "</div>");
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', "<div class='alert alert-danger'>Captcha yang anda masukkan salah</div>");
                redirect('login');
            }
        }
    }

    public function chooserole()
    {
        // redirectIfLoggedIn();

        if ($this->session->userdata('session_meeting')) {
            $this->session->set_userdata('session_meeting_temp', $this->session->userdata('session_meeting'));
        }

        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        if (!$this->form_validation->run()) {
            $hakakses               = $this->session->userdata('session_meeting_temp')->HAKAKSES;
            $hakakses_desc          = $this->session->userdata('session_meeting_temp')->HAKAKSES_DESC;
            $data['hakakses']       = explode(",", $hakakses);
            $data['hakakses_desc']  = explode(",", $hakakses_desc);
            $this->load->view('login/chooserole', $data);
        } else {
            $session = (array) $this->session->userdata('session_meeting_temp');
            $this->load->model('Model_App_Roles');

            $role = $this->Model_App_Roles->getBySittlRoleId($this->input->post('role'));

            if (count($role) > 0) {
                $this->session->unset_userdata('session_meeting_temp');

                $session['HAKAKSES_ACTIVE'] = (object) $role[0];
                $session = json_decode(json_encode($session));
                $this->session->set_userdata('session_meeting', $session);
                
                if($this->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA == 'MAGANG'){
                    redirect('/magang');
                }else{
                    redirect('/');
                }
            }
        }
    }


    public function i_create_captcha()
    {
        $folder = './capimg/';
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $options = array(
            'img_path'      => $folder,
            'img_url'       => base_url() . 'capimg/',
            // 'img_width'     => 100,
            // 'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 4,
            'pool'          => 'abcdefghijklmnopqrstuvwxyz',
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border'    => array(255, 255, 255),
                'text'      => array(0, 0, 0),
                'grid'      => array(255, 100, 100),
            )
            //'expiration' => 7200
        );
        $cap = create_captcha($options);
        $image = $cap['image'] ?? null;

        $image = str_replace("height: 30px;", "height: 70px;", $image);
        $image = str_replace("width: 150px;", "width: 220px;", $image);


        $this->session->set_userdata('captchaword', $cap['word'] ?? null);

        return $image;
    }

    public function check_captcha()
    {
        if ($this->input->post('captcha') == $this->session->userdata('captchaword')) {
            echo json_encode(['is_true' => true]);
        } else {
            echo json_encode(['is_true' => false]);
            // return false;
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('session_meeting');
        $this->session->unset_userdata('session_meeting_temp');
        redirect('login');
    }

    public function recaptcha()
    {
        echo json_encode(['data' => $this->i_create_captcha()]);
    }


    public function login_direction()
    {
        redirectIfLoggedIn();

        $url = "http://sittl.teluklamong.co.id/wsouth.asmx?wsdl";
        $client = new SoapClient($url);

        $p = $client->verifySESSION([
            'keysid'    => $this->input->get('keysid')
        ]);

        $response = $p->verifySESSIONResult;

        if ($response->responType == 'S') {
            $this->session->set_userdata('session_meeting_temp', $response);
            redirect('login/chooserole');
        } else {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>" . $response->responText . "</div>");
            redirect('login');
        }
    }
}
