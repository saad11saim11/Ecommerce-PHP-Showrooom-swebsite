<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file(base_app.$path)){
			if(unlink(base_app.$path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$order_qry = $this->conn->query("SELECT COALESCE(`order`, 0) from `category_list` where delete_flag = 0 order by `order` desc limit 1");
		if($order_qry->num_rows > 0){
			$order = $order_qry->fetch_array()[0] + 1 ;
		}else{
			$order = 0;
		}
		$data .= ", `order`= '{$order}' ";
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `category_list` set {$data} ";
		}else{
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Category successfully saved.";
			else
				$resp['msg'] = " Category successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_order_category(){
		extract($_POST);
		if(isset($cid)){
			foreach($cid as $k=>$v){
				$this->conn->query("UPDATE `category_list` set `order` = '{$k}' where id = '{$v}' ");
			}
		}
		$resp['status'] = 'success';
		$this->settings->set_flashdata('success', "Category Orders has been updated successfully.");
		return json_encode($resp);
	}
	function save_field(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$order_qry = $this->conn->query("SELECT COALESCE(`order`, 0) from `field_list` where delete_flag = 0 and category_id = '{$category_id}' order by `order` desc limit 1");
		if($order_qry->num_rows > 0){
			$order = $order_qry->fetch_array()[0] + 1 ;
		}else{
			$order = 0;
		}
		$data .= ", `order`= '{$order}' ";
		$check = $this->conn->query("SELECT * FROM `field_list` where `name` = '{$name}' and `category_id` = '{$category_id}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Field already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `field_list` set {$data} ";
		}else{
			$sql = "UPDATE `field_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$fid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['fid'] = $fid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Field successfully saved.";
			else
				$resp['msg'] = " Field successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		// if($resp['status'] == 'success')
		// 	$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_field(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `field_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Field successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_order_field(){
		extract($_POST);
		if(isset($fid)){
			foreach($fid as $k=>$v){
				$this->conn->query("UPDATE `field_list` set `order` = '{$k}' where id = '{$v}' ");
			}
		}
		$resp['status'] = 'success';
		$resp['msg'] = "Category's Field Orders has been updated successfully.";
		return json_encode($resp);
	}
	function save_product(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `product_list` where `code` = '{$code}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Product Code already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `product_list` set {$data} ";
		}else{
			$sql = "UPDATE `product_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['pid'] = $pid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Product successfully saved.";
			else
				$resp['msg'] = " Product successfully updated.";
			$data = "";
			$this->conn->query("DELETE FROM `product_meta` where product_id = '{$pid}'");
			if(isset($field) && count($field) > 0){
				foreach($field as $k=>$v){
					if(!empty($data)) $data .= ", ";
					$v = addslashes(htmlspecialchars($this->conn->real_escape_string($v)));
					$data .= "('{$pid}', '{$k}', '{$v}')";
				}
			}
			if(!empty($data)){
				$sql2 = "INSERT INTO `product_meta` (`product_id`, `field_id`, `meta_value`) VALUES {$data}";
				$save2 = $this->conn->query($sql2);
				if(!$save2){
					$resp['status'] ='failed';
					$resp['msg'] = $this->conn->error;
					$resp['sql'] = $sql2;
					if(empty($id)){
						$this->conn->query("DELETE FROM `product_list` where id = '{$pid}'");
					}
				}
			}
			if($resp['status'] == 'success'){
				if(!empty($_FILES['img']['tmp_name'])){
					$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
					$dir = "uploads/thumbnails/";
					if(!is_dir(base_app.$dir)){
						mkdir(base_app.$dir);
					}
					$fname = $dir."product_$pid.png";
					$accept = array('image/jpeg','image/png');
					if(!in_array($_FILES['img']['type'],$accept)){
						$resp['msg'] = " Thumbnail Image file type is invalid";
					}
					if($_FILES['img']['type'] == 'image/jpeg')
						$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
					elseif($_FILES['img']['type'] == 'image/png')
						$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
					if(!$uploadfile){
						$resp['msg'] = " Thumbnail Image is invalid";
					}
					list($width, $height) =getimagesize($_FILES['img']['tmp_name']);
					if($width > 480 || $height > 240){
						$cheight = 240;
						$cwidth = 480;
						if($width > $height){
							$cheight = 240;
							$cwidth = 480;
						}else if($width < $height){
							$cheight = 480;
							$cwidth = 240;
						}
						if($width > $height){
							$perc = ($width - $cwidth) / $width;
							$width = $cwidth;
							$height = $height - ($height * $perc);
						}else{
							$perc = ($height - $cheight) / $height;
							$height = $cheight;
							$width = $width - ($width * $perc);
						}
					}
					$temp = imagescale($uploadfile,$width,$height);
					if(is_file(base_app.$fname))
					unlink(base_app.$fname);
					$upload =imagepng($temp,base_app.$fname);
					if($upload){
						$this->conn->query("UPDATE product_list set thumbnail_path = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$pid}' ");
					}
					imagedestroy($temp);
				}
				if(isset($_FILES['imgs']) && count($_FILES['imgs']['tmp_name']) > 0){
					foreach($_FILES['imgs']['tmp_name'] as $k => $v){
						if(!empty($_FILES['imgs']['tmp_name'][$k])){
							$ext = pathinfo($_FILES['imgs']['name'][$k], PATHINFO_EXTENSION);
							$dir = "uploads/products/$pid/";
							if(!is_dir(base_app.$dir)){
								if(!is_dir(base_app.'uploads/products/'))
								mkdir(base_app.'uploads/products/');
								mkdir(base_app.$dir);
							}
							$fname = $_FILES['imgs']['name'][$k];
							$accept = array('image/jpeg','image/png');
							if(!in_array($_FILES['imgs']['type'][$k],$accept)){
								$resp['msg'] = " Image file type is invalid";
							}
							if($_FILES['imgs']['type'][$k] == 'image/jpeg')
								$uploadfile = imagecreatefromjpeg($_FILES['imgs']['tmp_name'][$k]);
							elseif($_FILES['imgs']['type'][$k] == 'image/png')
								$uploadfile = imagecreatefrompng($_FILES['imgs']['tmp_name'][$k]);
							if(!$uploadfile){
								$resp['msg'] = " Image is invalid";
							}
							list($width, $height) =getimagesize($_FILES['imgs']['tmp_name'][$k]);
							if($width > 640 || $height > 480){
								$cheight = 480;
								$cwidth = 640;
								if($width > $height){
									$cheight = 480;
									$cwidth = 640;
								}else if($width < $height){
									$cheight = 640;
									$cwidth = 480;
								}
								if($width > $height){
									$perc = ($width - $cwidth) / $width;
									$width = $cwidth;
									$height = $height - ($height * $perc);
								}else{
									$perc = ($height - $cheight) / $height;
									$height = $cheight;
									$width = $width - ($width * $perc);
								}
							}
							$temp = imagescale($uploadfile,$width,$height);
							if(is_file(base_app.$fname)){
								$i = 1;
								$tname = $fname;
								while(true){
									if(is_file(base_app.$dir.$tname)){
										$tname = $i."_".$fname;
									}else{
										break;
									}
								}
								$fname = $dir.$tname;
							}else{
								$fname = $dir.$fname;
							}
							$upload =imagepng($temp,base_app.$fname);
							imagedestroy($temp);
						}
					}
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `product_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_inquiry(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `inquiry_list` set {$data} ";
		}else{
			$sql = "UPDATE `inquiry_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success'," Your Inquiry has been sent successfully. Thank you!");
			else
				$this->settings->set_flashdata('success'," Inquiry successfully updated");
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_inquiry(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inquiry_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Inquiry has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_order_category':
		echo $Master->save_order_category();
	break;
	case 'save_field':
		echo $Master->save_field();
	break;
	case 'delete_field':
		echo $Master->delete_field();
	break;
	case 'save_order_field':
		echo $Master->save_order_field();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'save_inquiry':
		echo $Master->save_inquiry();
	break;
	case 'delete_inquiry':
		echo $Master->delete_inquiry();
	break;
	default:
		// echo $sysset->index();
		break;
}