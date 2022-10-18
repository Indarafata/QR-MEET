<?php

class Model_user extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	function get_meeting_detail()
	{
		$query = $this->db->query("select id_user, id_meeting, email, username, to_char(checkin_date,'dd/mm/yyyy hh24:mi') checkin_date, to_char(checkout_date,'dd/mm/yyyy hh24:mi') checkout_date, status from meeting_detail");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	

	
	/*function get_meeting_detail_list($id)
	{ 
		$query = $this->db->query("SELECT a.id_user,   a.id_meeting,   a.email,   a.username,  TO_CHAR (a.checkin_date, 'dd/mm/yyyy hh24:mi') checkin_date,   TO_CHAR (a.checkout_date, 'dd/mm/yyyy hh24:mi') checkout_date, a.status, b.id_dept, b.company FROM meeting_detail a  join users b on A.EMAIL = b.email where id_meeting='".$id."'");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}*/

	function get_meeting_detail_list($id)
	{ 
		$query = $this->db->query("SELECT upper(a.id_user) id_user,
       a.id_meeting,
      upper( a.email)email,
       a.username,
       TO_CHAR (a.checkin_date, 'dd/mm/yyyy hh24:mi') checkin_date,
       TO_CHAR (a.checkout_date, 'dd/mm/yyyy hh24:mi') checkout_date,
       a.status,
       b.id_dept,
        d.nama_sub,d.nama_sek,
       b.company
  FROM meeting_detail a JOIN vw_user b ON upper(A.EMAIL) = upper(b.email)  left join outh.userlogin c on upper (a.email)=upper(c.email) left join outh.persoeis d on c.nipp = d.nrk
 WHERE id_meeting = '".$id."'");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	// function get_meeting_detail_list($id)
	// {
	// 	$query = $this->db->query("SELECT a.id_user,   a.id_meeting,   a.email,   a.username,  TO_CHAR (a.checkin_date, 'dd/mm/yyyy hh24:mi') checkin_date,   TO_CHAR (a.checkout_date, 'dd/mm/yyyy hh24:mi') checkout_date, a.status, b.id_dept, b.company FROM meeting_detail a  join users b on(upper(a.id_user)=b.user_id) where id_meeting='".$id."'");
	// 	if($query->num_rows() > 0)
	// 	{
	// 		return $query->result();
	// 	}
	// 	else
	// 	{
	// 		return FALSE;
	// 	}
	// }
	function get_user_list()
	{
		$query = $this->db->query("select a.*,b.dept_name, to_char(a.created_date,'dd/mm/yyyy hh24:mi') created_date_f from vw_user a left join departement b on(a.id_dept=b.id_dept) order by username");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_meeting($id)
	{
		$query = $this->db->query("select a.*, to_char(a.start_date,'dd/mm/yyyy hh24:mi') start_date_f, to_char(a.end_date,'dd/mm/yyyy hh24:mi') end_date_f from meeting a where a.id_meeting='".$id."'");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_mst_event()
	{
		$query = $this->db->query("select * from master_event");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_user($values)
	{
		 $query = $this->db->query("select * from vw_user where  ( ((upper(email)=upper(trim('".trim($values['txt_email'])."')) or telp='".$values['txt_telp']."' ))) or (role in ('ADMIN','EDITOR') and ((upper(email)=upper(trim('".trim($values['txt_email'])."')) and password='".$values['txt_password']."'))) ");
		 
		
		//$query = $this->db->query("select * from users where lower(email)=lower('".trim($values['txt_email'])."') or telp='".$values['txt_telp']."'");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function cek_absen_jam($values)
	{
		//$query = $this->db->query("select * from meeting  where (file_qr = '".trim($values['txt_id']).".png' or file_qr_temp='".$values['txt_id'].".png') and  end_date + (1/24 * 4) >= sysdate");
		$query = $this->db->query("select * from meeting  where (file_qr = '".trim($values['txt_id']).".png' or file_qr_temp='".$values['txt_id'].".png') and  end_date >= sysdate");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function cek_absen_qr($values)
	{
		$query = $this->db->query("select * from meeting  where (file_qr = '".trim($values['txt_id']).".png' or file_qr_temp='".$values['txt_id'].".png')");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function cek_absen($values)
	{
		
		$query = $this->db->query("select * from meeting_detail where id_meeting =(SELECT id_meeting
                  FROM meeting
                 WHERE file_qr = '".trim($values['txt_id']).".png' or file_qr_temp='".$values['txt_id'].".png') and email=lower(trim('".trim($values['txt_email'])."'))");
		//$query = $this->db->query("select * from users where lower(email)=lower('".trim($values['txt_email'])."') or telp='".$values['txt_telp']."'");
		if($query->num_rows() > 0)
		{
			
			return $query->result();
			
		}
		else
		{
			return FALSE;
		}
	}
	function get_admin($values)
	{
		$query = $this->db->query("select * from vw_user where lower(email)=lower('".trim($values['txt_email'])."') or telp='".$values['txt_telp']."' ");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function save_user($values)
	{
		
		$val="0";
		if(trim($values['txt_email'])!='')
		{
		$query = $this->db->query("select * from meeting_detail where id_meeting=
			(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png')
			 and id_user=(select user_id from vw_user where lower(email)=lower('".trim($values['txt_email'])."') and rownum = 1)");
		
		if($query->num_rows() > 0)
		{
			$val="1";
		}	
		
		}
		else
		{
		$query = $this->db->query("select * from meeting_detail where id_meeting=(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png') and id_user=(select user_id from vw_user where telp='".$values['txt_telp']."') and rownum = 1");
		if($query->num_rows() > 0)
		{
			$val="1";
		}	
			
		}
		
		$id_meeting = @$this->db->query("select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png'")->row()->ID_MEETING;
		if (!$id_meeting) {
			return false;
		}

		$txt_email = trim($values['txt_email']);
		$txt_telp = trim($values['txt_telp']);

		$this->db->from('VW_USER');
		if ($txt_email != '') {
			$this->db->where("lower(email)=lower('$txt_email')", null, false);
		} else if ($txt_telp != '') {
			$this->db->where("lower(telp)=lower('$txt_telp')", null, false);
		}

		$user = $this->db->get()->row();

		if (!$user) {
			return false;
		}

		// proses simpan / update
		$result = null;
		$this->db->set('checkin_date', 'SYSDATE', false);
		if ($val=='0') {
			$result = $this->db->insert('MEETING_DETAIL', [
				'ID_USER' => strtolower($user->USER_ID),
				'ID_MEETING' => $id_meeting,
				'EMAIL' => strtolower($user->EMAIL),
				'USERNAME' => strtolower($user->EMAIL),
				'STATUS' => '2',
				'TELP' => strtolower($user->TELP),
				'FILE_QR' => $values['txt_id'].".png",
			]);
		} else if ($val=='1') {
			$this->db->where('STATUS IS NULL', null, false);
			$this->db->where('ID_USER', $user->USER_ID);
			$this->db->where('ID_MEETING', $id_meeting);
			$result = $this->db->update('MEETING_DETAIL', [
				'STATUS' => '1',
				'FILE_QR' => $values['txt_id'].".png"
			]);
		}

		return $result ? true : false;



		// --------------------------------------------
		
		
		// if(trim($values['txt_email'])!='' and $val=='0')
		// {
		// $sql = "insert into meeting_detail (id_user, id_meeting, email, username, checkin_date, status, telp, file_qr ) values ((select lower(user_id) from vw_user where lower(email)=lower('".trim($values['txt_email'])."')),(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png'),lower('". trim($values['txt_email'])."'),lower('". trim($values['txt_email'])."'), sysdate,'2',(select telp from vw_user where lower(email)=lower('".trim($values['txt_email'])."')),'".$values['txt_id'].".png')";	
		// }
		// else if($values['txt_telp']!='' and $val=='0')
		// {
		// 	$sql = "insert into meeting_detail (id_user, id_meeting, email, username, checkin_date, status, telp,file_qr ) values ((select lower(user_id) from vw_user where telp='".$values['txt_telp']."'),(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png'),lower('". trim($values['txt_email'])."'),lower('". trim($values['txt_email'])."'), sysdate,'2','".$values['txt_telp']."','".$values['txt_id'].".png')";
		// }
		
		// if(trim($values['txt_email'])!='' and $val=='1')
		// {
		// 	$sql = "update meeting_detail set checkin_date = sysdate, status='1', file_qr= '".$values['txt_id'].".png' where status is null  and  id_user=(select user_id from vw_user where lower(email)=lower('".trim($values['txt_email'])."')) and id_meeting=(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png')";	
		// }
		// else if($values['txt_telp']!='' and $val=='1')
		// {
		// 	$sql = "update meeting_detail set checkin_date = sysdate, status='1', file_qr= '".$values['txt_id'].".png'  where status is null  and id_user=(select user_id from vw_user where telp='".$values['txt_telp']."') and id_meeting=(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png')";	
		// }
		
		// if($this->db->query($sql))
		// {

		// 	return TRUE;
		// }
		// else
		// {

		// 	return FALSE;
		// }
		
	}
	function save_absen_man($values)
	{
		
		$query = $this->db->query("select * from vw_user where username='".$values['txt_user']."'");
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$query = $this->db->query("select * from meeting_detail where id_user='".$values['txt_user']."' and id_meeting = '".$values['txt_id']."'");
				if($query->num_rows() <= 0)
				{
						
						$sql = "insert into meeting_detail (id_user, id_meeting, email, username, checkin_date, telp, company ) values (lower('". $values['txt_user']."'),'".$values['txt_id']."',lower('". $row->EMAIL."'),lower('". $row->USERNAME."'), sysdate,'". $row->TELP."','". $row->COMPANY."')";
						if($this->db->query($sql))
						{
							return 'TRUE';
						}
						else
						{
							return 'FALSE';
						}
				}else{
					return 'FALSE';
				}		
				
			}
			
		}
		
		
		
	}
	function save_user_ext($values)
	{
		
		$query = $this->db->query("select * from vw_user where username='".$values['txt_user']."'");
		if($query->num_rows() == 0)
		{
			$sql = "insert into users (user_id, username, email,  telp, company, created_date, created_by ) values (lower('". $values['txt_user']."'),lower('". $values['txt_user']."'),lower('". trim($values['txt_email'])."'),'". $values['txt_telp']."','". $values['txt_pt']."', sysdate,'". $values['txt_user']."')";
			$this->db->query($sql);
		}
		

		$sql = "insert into meeting_detail (id_user, id_meeting, email, username, checkin_date, telp, company, status ) values (lower('". $values['txt_user']."'),(select id_meeting from meeting where file_qr='".$values['txt_id'].".png' or file_qr_temp='".$values['txt_id'].".png' ),lower('". trim($values['txt_email'])."'),lower('". $values['txt_user']."'), sysdate,'". $values['txt_telp']."','". $values['txt_pt']."','2')";
			if($this->db->query($sql))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
	}
	function save_peserta($values)
	{
		
	
			$sql = "insert into users (user_id, username, email, id_dept, telp, company, created_date, created_by ) values (lower('". $values['txt_user']."'),lower('". $values['txt_user']."'),lower('". trim($values['txt_email'])."'),'". $values['txt_id_dept']."','". $values['txt_telp']."','". $values['txt_pt']."', sysdate,'". $values['txt_user']."')";
			if($this->db->query($sql))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		
	}
	
}