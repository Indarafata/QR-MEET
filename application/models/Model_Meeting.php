<?php

class Model_meeting extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	function get_meeting()
	{
		$query = $this->db->query("select a.*,b.dept_name, replace(replace(to_char(event_date,'dd-month-yyyy@hh24:mi'),' ',''),'@',' ') event_date_f, replace(replace(to_char(start_date,'dd-month-yyyy@hh24:mi'),' ',''),'@',' ') start_date_f, replace(replace(to_char(end_date,'dd-month-yyyy@hh24:mi'),' ',''),'@',' ') end_date_f from meeting a join departement b on(a.id_dept=b.id_dept)  order by a.created_date desc");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_dept()
	{
		$query = $this->db->query("select * from departement order by dept_name ");
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
		$query = $this->db->query("select * from master_event where status='1'");
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function get_meeting_id($values)
	{ $sql= "select a.*, to_char(a.event_date,'dd/mm/yyyy') event_date_f, to_char(a.event_date,'hh24') event_date_hh,to_char(a.event_date,'mi') event_date_mi,to_char(a.start_date,'dd/mm/yyyy') start_date_f, to_char(a.start_date,'hh24') start_date_hh,to_char(a.start_date,'mi') start_date_mi,to_char(a.end_date,'dd/mm/yyyy') end_date_f, to_char(a.end_date,'hh24') end_date_hh,to_char(a.end_date,'mi') end_date_mi from meeting a where id_meeting='".$values['id']."'";
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	function save_meeting($values)
	{
		$sql = "insert into meeting (id_meeting,location, id_event, id_dept, event_date, event, start_date, end_date, file_url, file_qr,  file_qr_temp, url_qr,created_by, created_date ) values ('".$values['txt_id_event']."'||(to_char(seq1.nextval,'fm0009')||to_char(sysdate,'yyyy')),'".$values['txt_meeting_location']."','". $values['txt_id_event']."','". $values['txt_id_dept']."',to_date('". $values['txt_event_date'].$values['txt_event_date_hh'].$values['txt_event_date_mi']."','dd/mm/yyyyhh24mi'),'". $values['txt_meeting_name']."',to_date('". $values['txt_start_date'].$values['txt_start_date_hh'].$values['txt_start_date_mi']."','dd/mm/yyyyhh24mi'),to_date('". $values['txt_end_date'].$values['txt_end_date_hh'].$values['txt_start_date_mi']."','dd/mm/yyyyhh24mi'),'". $values['file_url']."','". $values['file_qr']."','". $values['file_qr']."','".$values['url_qr']."','".$values['user']."',sysdate)";
		if($this->db->query($sql))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	function update_meeting($values)
	{
		$sql = "update  meeting set id_event='". $values['txt_id_event']."',location='". $values['txt_meeting_location']."',id_dept='". $values['txt_id_dept']."', event_date=to_date('". $values['txt_event_date'].$values['txt_event_date_hh'].$values['txt_event_date_mi']."','dd/mm/yyyyhh24mi'), event='". $values['txt_meeting_name']."', start_date=to_date('". $values['txt_start_date'].$values['txt_start_date_hh'].$values['txt_start_date_mi']."','dd/mm/yyyyhh24mi'), end_date=to_date('". $values['txt_end_date'].$values['txt_end_date_hh'].$values['txt_end_date_mi']."','dd/mm/yyyyhh24mi'), file_url='". $values['file_url']."' where id_meeting='".$values['id']."'";
		if($this->db->query($sql))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	function update_meeting_qr($values)
	{
		 $sql = "update meeting set file_qr_temp='". $values['file_qr']."' where id_meeting=(SELECT id_meeting
																							  FROM meeting
																							 WHERE file_qr = '".trim($values['id']).".png' or file_qr_temp = '".trim($values['id']).".png')";
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