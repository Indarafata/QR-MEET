<?php

function getKdAplikasi()
{
    return '66';
}

function base_encrypt_old($text)
{
    return str_replace("=", "", base64_encode($text));
}

function base_decrypt_old($text)
{
    return base64_decode($text);
}

function base_encrypt($string)
{
    $output = false;

    // $security = parse_ini_file('security.ini'); // parsing file security.ini output:array asosiatif
    //Hasil parsing masukkan kedalam variable
    $secret_key     = 'jaFd63sl2398Tve7';
    $secret_iv      = 'xh_+D?!q(SXz-j4n';
    $encrypt_method = 'aes-256-cbc';

    //hash $secret_key dengan algoritma sha256 
    $key = hash("sha256", $secret_key);

    //iv(initialize vector), encrypt iv dengan encrypt method AES-256-CBC (16 bytes)
    $iv     = substr(hash("sha256", $secret_iv), 0, 16);
    $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($result);
    return str_replace('=', '', $output);
}

function base_decrypt($string)
{
    $output = false;

    // $security = parse_ini_file('security.ini'); // parsing file security.ini output:array asosiatif
    //Hasil parsing masukkan kedalam variable
    $secret_key     = 'jaFd63sl2398Tve7';
    $secret_iv      = 'xh_+D?!q(SXz-j4n';
    $encrypt_method = 'aes-256-cbc';

    //hash $secret_key dengan algoritma sha256 
    $key = hash("sha256", $secret_key);

    //iv(initialize vector), encrypt $secret_iv dengan encrypt method AES-256-CBC (16 bytes)
    $iv     = substr(hash("sha256", $secret_iv), 0, 16);
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return str_replace('=', '', $output);
}

function redirectIfLoggedIn()
{
    $ci      = get_instance();
    if ($ci->session->userdata('session_meeting')) {
        redirect('dashboard');
    }
}

function redirectIfNotLoggedIn()
{
    $ci      = get_instance();
    if (!$ci->session->userdata('session_meeting')) {
        redirect('login');
    }
}


function get_menu()
{
    $ci      = get_instance();

    if ($ci->session->userdata('session_meeting')) {
        $ci->load->model('Model_App_Menu');
        $ci->load->model('Model_App_Menu_Roles');

        $hakakses     = $ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE;

        $menu_parent = $ci->Model_App_Menu->getByIdAplikasi($hakakses->ID_APLIKASI, '1', 1);
        $menu_childs = $ci->Model_App_Menu_Roles->getByRoleId($hakakses->ID);
        $menus          = grouping_menu($menu_parent, $menu_childs);
        // echo json_encode($menu_childs);die();//komen
        return $menus;
    } else {
        return [];
        // redirect('login');
    }
}

function grouping_menu($menu_parent, $menu_childs)
{
    foreach ($menu_parent as $p => $parent) {
        foreach ($menu_childs as $c => $child) {
            if ($parent['ID'] == $child['PARENT_ID']) {
                $menu_parent[$p]['CHILDS'][] = $child;
            } else if ($parent['ID'] == $child['MENU_ID'] && $parent['URL'] != '' && $parent['URL'] != '#') {
                $menu_parent[$p]['SINGLE_MENU'] = true;
            }
        }
    }

    return $menu_parent;
}

function is_have_access_name($name = null)
{
    $ci = get_instance();
    $result = false;
    // echo json_encode($ci->session->userdata('session_meeting'));
    // die();

    if (isset($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE)) {
        if ($name) {
            if (strtolower($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA) == strtolower($name)) {
                $result = true;
            }
        }
    }

    return $result;
}

function is_have_access_names($names)
{
    $ci = get_instance();
    $result = false;

    if (isset($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE)) {
        if ($names) {
            $curr_access = strtolower($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA);
            foreach ($names as $key => $value) {
                if ($curr_access == strtolower($value)) {
                    $result = true;
                }
            }
        }
    }

    return $result;
}

function must_have_access_names($names)
{
    $ci = get_instance();
    $result = false;

    if (isset($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE)) {
        if ($names) {
            $curr_access = strtolower($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE->NAMA);
            foreach ($names as $key => $value) {
                if ($curr_access == strtolower($value)) {
                    $result = true;
                }
            }
        }
    }

    if (!$result) {
        echo "Anda Tidak Punya Hak Akses";
        die();
    }
    return true;
}

function check_permission($names = null)
{
    $ci = get_instance();
    // echo json_encode($ci->session->userdata('session_meeting'));
    // die();

    if (isset($ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE)) {

        if ($names) {
            if (is_have_access_names($names)) {
                echo "Anda Tidak Punya Hak Akses";
                die();
            }
        }

        $isAccess = false;

        $role_id = $ci->session->userdata('session_meeting')->HAKAKSES_ACTIVE->ID;

        $ci->load->model('Model_App_Menu_Roles');
        $data = $ci->Model_App_Menu_Roles->getByRoleId($role_id);


        foreach ($data as $i => $val) {

            // $val['URL'] = str_replace('pendingmatter/', '', $val['URL']);

            // $index = strpos($val['URL'], '/');

            // if($index == '')
            //     $index = strpos($val['URL'], '\\');

            // if($index != '')
            //     $controllerUrl = substr($val['URL'], 0, $index);
            // else
            $controllerUrl = $val['URL'];
            // echo json_encode($ci->uri);
            // echo $controllerUrl .'  -  '.strtolower($ci->uri->segment(1)) . '/' . strtolower($ci->uri->segment(2)).'<br/><br/>';
            
            if (strtolower($controllerUrl) == strtolower($ci->uri->segment(1))) {
                // echo $controllerUrl .'  -  '.strtolower($ci->uri->segment(1)) . '/' . strtolower($ci->uri->segment(2)).'<br/><br/>';
                $isAccess = true;
                break;
            }

            if (strtolower($controllerUrl) == strtolower($ci->uri->segment(1)) . '/' . strtolower($ci->uri->segment(2))) {
                $isAccess = true;
                break;
            }

            if (strtolower($ci->uri->segment(1)) == 'dashboard') {
                $isAccess = true;
                break;
            }
        }

        if (!$isAccess) {
            echo "Anda Tidak Punya Hak Akses";
            die();
        }
    }
    // die();
}
