<?php
session_start();
ini_set('display_errors', 1);
class Action
{
	private $db;

	public function __construct()
	{
		ob_start();
		include 'db_connect.php';

		$this->db = $conn;
	}
	function __destruct()
	{
		$this->db->close();
		ob_end_flush();
	}

	// Admin Account
	function login()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT *,concat(last_name,', ',first_name,' ',middle_name) as name FROM tbl_unifast_staff where email = '" . $email . "' and password = '" . md5($password) . "' and type= 1 ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}

	// Staff Account
	function login2()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT *,concat(last_name,', ',first_name,' ',middle_name) as name FROM tbl_unifast_staff where email = '" . $email . "' and password = '" . md5($password) . "'  and type= 2 ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout2()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	// Attendees Account
	function login3()
	{
		extract($_POST);
		$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM tbl_user_accounts where email = '" . $email . "' and password = '" . md5($password) . "'  and type= 3 ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			return 1;
		} else {
			return 3;
		}
	}
	function logout3()
	{
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../attendees/index.php");
	}

	function save_staff_user()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'password')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (!empty($cpass) && !empty($password)) {
			$data .= ", password=md5('$password') ";
		}
		$check = $this->db->query("SELECT * FROM tbl_unifast_staff where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_unifast_staff set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_unifast_staff set $data where id = $id");
		}

		if ($save) {
			return 1;
		}
	}

	function save_user()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'password')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		
		if (!empty($cpass) && !empty($password)) {
			$data .= ", password=md5('$password') ";
		}
		$check = $this->db->query("SELECT * FROM tbl_user_accounts where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_user_accounts set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_user_accounts set $data where id = $id");
		}

		if ($save) {
			return 1;
		}
	}

	function signup()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass')) && !is_numeric($k)) {
				if ($k == 'password') {
					if (empty($v))
						continue;
					$v = md5($v);
				}
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}

		$check = $this->db->query("SELECT * FROM tbl_user_accounts where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_user_accounts set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_user_accounts set $data where id = $id");
		}

		if ($save) {
			if (empty($id))
				$id = $this->db->insert_id;
			foreach ($_POST as $key => $value) {
				if (!in_array($key, array('id', 'cpass', 'password')) && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			$_SESSION['login_id'] = $id;
			return 1;
		}
	}


	function update_staff_stats()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'table')) && !is_numeric($k)) {
				if ($k == 'password')
					$v = md5($v);
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM tbl_unifast_staff where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_unifast_staff set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_unifast_staff set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}



	function update_user()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'cpass', 'table')) && !is_numeric($k)) {
				if ($k == 'password')
					$v = md5($v);
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if ($_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/' . $fname);
			$data .= ", avatar = '$fname' ";
		}
		$check = $this->db->query("SELECT * FROM tbl_user_accounts where email ='$email' " . (!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if ($check > 0) {
			return 2;
			exit;
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_user_accounts set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_user_accounts set $data where id = $id");
		}

		if ($save) {
			foreach ($_POST as $key => $value) {
				if ($key != 'password' && !is_numeric($key))
					$_SESSION['login_' . $key] = $value;
			}
			if ($_FILES['img']['tmp_name'] != '')
				$_SESSION['login_avatar'] = $fname;
			return 1;
		}
	}

	function delete_staff_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM tbl_unifast_staff where id = $id");
		if ($delete) {
			return 1;
		}
	}

	function delete_user()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM tbl_user_accounts where id = " . $id);
		if ($delete)
			return 1;
	}
	function save_event()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_events set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_events set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function update_event_stats()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}

		if (empty($id)) {
			$save = $this->db->query("INSERT INTO tbl_events set $data");
		} else {
			$save = $this->db->query("UPDATE tbl_events set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}
	function delete_event()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM tbl_events where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function save_attendee()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO attendees set $data");
		} else {
			$save = $this->db->query("UPDATE attendees set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}

	function save_attendee_info()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_numeric($k)) {
				if (empty($data)) {
					$data .= " $k='$v' ";
				} else {
					$data .= ", $k='$v' ";
				}
			}
		}
		if (empty($id)) {
			$save = $this->db->query("INSERT INTO attendees_info set $data");
		} else {
			$save = $this->db->query("UPDATE attendees_info set $data where id = $id");
		}
		if ($save) {
			return 1;
		}
	}

	function delete_attendee()
	{
		extract($_POST);
		$delete = $this->db->query("DELETE FROM attendees where id = $id");
		if ($delete) {
			return 1;
		}
	}
	function assign_registrar()
	{
		extract($_POST);
		$uids = array();
		foreach ($user_id as $k => $v) {
			$data = " event_id = $event_id ";
			$data .= ", user_id = $v ";
			$ins = $this->db->query("INSERT INTO assigned_registrar set $data");
			if ($ins) {
				$uids[] = $this->db->insert_id;
			}
		}
		$this->db->query("DELETE FROM assigned_registrar where event_id = $event_id " . (count($uids) > 0 ? " and id not in (" . implode(',', $uids) . ") " : ''));
		return 1;
	}
	function update_attendee_stats()
	{
		extract($_POST);
		$event_id = $this->db->query("SELECT * FROM attendees where id = $id")->fetch_array()['event_id'];
		$chk = $this->db->query("SELECT * FROM tbl_events where id = $event_id")->fetch_array()['status'];
		if ($chk == 2) {
			return 2;
			exit;
		}
		$save = $this->db->query("UPDATE attendees set status = $status where id = $id");
		if ($save)
			return 1;
	}
}
