<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$conn = include(dirname(__DIR__)."/android/config.php");

//global $conn;

if(isset($_REQUEST['task'])){
	
	 $task = $_REQUEST['task'];
	
	if($task == 'staff_login'){
		staff_login();
	}
	elseif($task == 'signup'){
		signup();
	}
	elseif($task == 'update_profile'){
		update_profile();
	}
	elseif($task == 'user_detail'){
		user_detail();
	}
	elseif($task == 'food_detail'){
		food_detail();
	}
	elseif($task == 'add_food'){
		add_food();
	}
	elseif($task == 'buy_food'){
		buy_food();
	}
	elseif($task == 'food_list'){
		food_list();
	}
	elseif($task == 'vehicle_list'){
		vehicle_list();
	}
	elseif($task == 'service_category'){
		service_category();
	}
	elseif($task == 'report'){
		reports();
	}
	elseif($task == 'history'){
		history_list();
	}
	elseif($task == 'order_completed'){
		order_completed();
	}
	elseif($task == 'daily_work'){
		daily_work();
	}
	elseif($task == 'daily_work_update'){
		daily_work_update();
	}

}
// login staff function
function staff_login(){
	include(dirname(__DIR__)."/android/config.php");
	
	if (isset($_REQUEST['phone']) && $_REQUEST['phone']!="" && isset($_REQUEST['password']) && $_REQUEST['password']!='') {
	
		$phone = $_REQUEST['phone']; 
		$password = $_REQUEST['password'];
		
		$select = "SELECT * FROM staff_table WHERE phone = '$phone' and password = '$password'"; 
		$result = mysqli_query($conn,$select);
		
		$data = array();
		if(mysqli_num_rows($result)>0){
			 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			 $id = $row['id'];
			 $phone = $row['phone'];
			// $location = $row['location'];
			// $password = $row['password'];
			// staff_login_response($id, $phone, $password);
			$responce =array("id"=>$id,"phone"=>$phone/*,"location"=>$location*/);
			
			$data[] = $responce;
			
			header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		    header('Content-type: application/json');
		    header('Access-Control-Allow-Origin: *');
		
		    $responce1['error_code']=0;
	     	$responce1['message']="Login Successfully.";
			$responce1['data'] = $data;
			$jason_data= json_encode($responce1);
			print($jason_data);
			exit();
			
		}
		else{
			
			$data['error_code']=1;
			$data['message']="User Not found.";
			echo json_encode($data);
			exit();
		}
    }
	else if (isset($_REQUEST['email']) && $_REQUEST['email']!="" && isset($_REQUEST['password']) && $_REQUEST['password']!='') {
	
		$email = $_REQUEST['email']; 
		$password = $_REQUEST['password'];
		
		$select = "SELECT * FROM staff_table WHERE email = '$email' and password = '$password'"; 
		$result = mysqli_query($conn,$select);
		
		if(mysqli_num_rows($result)>0){
			$responce1['error_code']=0;
			$responce1['message']="Login Successfully.";
			 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			 $id = $row['id'];
			 $email = $row['email'];
			// $location = $row['location'];
			// $password = $row['password'];
			// staff_login_response($id, $email, $password);
			$responce1['data'] =array("id"=>$id,"email"=>$email/*,"location"=>$location*/);
			
			
			header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		    header('Content-type: application/json');
		    header('Access-Control-Allow-Origin: *');
		
			$jason_data= json_encode($responce1);
			print($jason_data);
			exit();
			
		}
		else{
			
			$data['error_code']=1;
			$data['message']="User Not found.";
			echo json_encode($data);
			exit();
		}
    }
	else{
		$data['error_code']=1;
		$data['message']="Invalid Request.";
		echo json_encode($data);
		exit();
	}
	
}

// signup function
function signup(){
	include(dirname(__DIR__)."/android/config.php");

	/* header("Access-Control-Allow-Origin: * ");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); */
 
	
	//getting the values 
	$name = $_REQUEST['name']; 
	$email = $_REQUEST['email']; 
	$phone = $_REQUEST['phone'];
	$password = $_REQUEST['password'];
	$address = $_REQUEST['address'];
	$address_type = $_REQUEST['address_type'];
	$gender = $_REQUEST['gender']; 
	$profile_pic ='logo.jpg';
	//checking if the user is already exist with this username or email
	//as the email and username should be unique for every user 
	$select = "SELECT * FROM staff_table WHERE phone = '".$phone."' OR email='".$email."' ";
	$result = mysqli_query($conn,$select);
		
	if(mysqli_num_rows($result)>0){
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		
		$responce1['error_code']=1;
		$responce1['message']="User Already Exist.";
		$jason_data= json_encode($responce1);
		print($jason_data);
		exit();
	}
	else{
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		
		//if user is new creating an insert query 
		$stmt = "INSERT INTO staff_table (name, email,phone,password, address, address_type,profile_pic,gender) 
				VALUES ('".$name."','".$email."','".$phone."','".$password."','".$address."','".$address_type."','".$profile_pic."','".$gender."')";
		$data = array();
		if ($conn->query($stmt) === TRUE) {
			
			$responce['error_code']=0;
			$responce['message']="User Registred Successfully.";
			$select1 = "SELECT * FROM staff_table WHERE email = '$email' and password = '$password'"; 
			$result1 = mysqli_query($conn,$select1);
			
			if(mysqli_num_rows($result1)>0){
				 $row = mysqli_fetch_array($result1,MYSQLI_ASSOC);
				 $id = $row['id'];
				 
				// $location = $row['location'];
				// $password = $row['password'];
				// staff_login_response($id, $email, $password);
				$responce['data'] =array("id"=>$id,"email"=>$email/*,"location"=>$location*/);	
			}
			echo json_encode($responce);
			die();
		}
		else{
			
			$responce['error_code']=1;
			$responce['message']="Invalid Request.";
			echo json_encode($responce);
			exit();
		}	
	}
}

// update_profile function
function update_profile(){
	include(dirname(__DIR__)."/android/config.php");
	
	//getting the values 
	$id=$_REQUEST['id']; 
	$name = $_REQUEST['name']; 
	$address = $_REQUEST['address'];
	$address_type = $_REQUEST['address_type'];
	$gender = $_REQUEST['gender']; 
	//as the email and username should be unique for every user 
	$select = "SELECT * FROM staff_table WHERE id='".$id."' ";
	$result = mysqli_query($conn,$select);
		
	if(mysqli_num_rows($result)>0){
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		$data = array();
		if(isset($_FILES["image"]['name']) &&  $_FILES["image"]['name'] != "")
		{
			$stmt = "UPDATE staff_table SET name = '".$name."', address = '".$address."', address_type = '".$address_type."',profile_pic = '".$_FILES["image"]['name']."',gender = '".$gender."' where id = '".$id."'";
			if ($conn->query($stmt) === TRUE) {
				$target_dir = "../images/";
				
				$target_file = $target_dir . basename($_FILES["image"]["name"]);  // for image

				move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
				
				$responce['error_code']=0;
				$responce['message']="User Updated Successfully.";
				/* $data[] = $responce; */	
				echo json_encode($responce);
				die();
			}
			else{
				$responce['error_code']=1;
				$responce['message']="User not found.";
				echo json_encode($responce);
				exit();
			}
		}
		else{
			$stmt = "UPDATE staff_table SET name = '".$name."', address = '".$address."', address_type = '".$address_type."',gender = '".$gender."' where id = '".$id."'";
			if ($conn->query($stmt) === TRUE) {
				
				$responce['error_code']=0;
				$responce['message']="User Updated Successfully.";
				/* $data[] = $responce; */	
				echo json_encode($responce);
				die();
			}
			else{
				$responce['error_code']=1;
				$responce['message']="User not found.";
				echo json_encode($responce);
				exit();
			}
		}
			
	}
	else{
		$responce1['error_code']=1;
		$responce1['message']="Invalid Request.";
		$jason_data= json_encode($responce1);
		print($jason_data);
		exit();
	}
}

// update_profile function
function user_detail(){
	include(dirname(__DIR__)."/android/config.php");

	/* header("Access-Control-Allow-Origin: * ");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); */
 
	
	//getting the values 
	$id=$_REQUEST['id']; 
	//checking if the user is already exist with this username or email
	//as the email and username should be unique for every user 
	$select = "SELECT * FROM staff_table WHERE id='".$id."' ";
	$result = mysqli_query($conn,$select);
		
	if(mysqli_num_rows($result)>0){
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
				
		$data = array();
		$responce['error_code']=0;
		$responce['message']="User Found.";
		foreach($result as $results){
			 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			 $id = $results['id'];
			 $name = $results['name'];
			 $email = $results['email'];
			 $phone = $results['phone'];
			 $address = $results['address'];
			 $address_type = $results['address_type'];
			 $profile_pic = $results['profile_pic'];
			 $gender = $results['gender'];
			 
			 $array = array("id"=>$id,"name"=>$name,"email"=>$email,"profile_pic"=>"http://".$_SERVER['SERVER_NAME']."/images/".$profile_pic,"phone"=>$phone,"address"=>$address,"address_type"=>$address_type,"gender"=>$gender);
			
			$responce['data'] = $array;
		}
		//$responce['data'] = $data;	
		echo json_encode($responce);
		die();
	}
	else{
		$responce1['error_code']=1;
		$responce1['message']="User not Found.";
		$jason_data= json_encode($responce1);
		print($jason_data);
		exit();
	}
}

// update_profile function
function food_detail(){
	include(dirname(__DIR__)."/android/config.php");

	/* header("Access-Control-Allow-Origin: * ");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); */
 
	
	//getting the values 
	$id=$_REQUEST['id']; 
	//checking if the user is already exist with this username or email
	//as the email and username should be unique for every user 
	$select = "SELECT * FROM food_table WHERE id='".$id."' ";
	$result = mysqli_query($conn,$select);
		
	if(mysqli_num_rows($result)>0){
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
				
		$data = array();
			
		$responce['error_code']=0;
		$responce['message']="Show Data Successfully.";
		foreach($result as $results){
		
			 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			 $id = $results['id'];
			 $title = $results['title'];
			 $image = $results['image'];
			 $price = $results['price'];
			 $made_time = $results['made_time'];
			 $best_before = $results['best_before'];
			 $note = $results['note'];
			 $status = $results['status'];
			 $array = array("id"=>$id,"title"=>$title,"image"=>"http://".$_SERVER['SERVER_NAME']."/android/rest/upload_images/".$image,"price"=>$price,"made_time"=>$made_time,"best_before"=>$best_before,"note"=>$note,"status"=>$status);
			 $data[] = $array;
		}
		$responce['data'] = $data;
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		print $jason_data = json_encode($responce);
		die();
	}
	else{
		$responce1['error_code']=1;
		$responce1['message']="Food not Found.";
		$jason_data= json_encode($responce1);
		print($jason_data);
		exit();
	}
}


// post_food function
function add_food(){
	include(dirname(__DIR__)."/android/config.php");

	/* header("Access-Control-Allow-Origin: * ");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); */
 
	
	header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
	header('Content-type: application/json');
	header('Access-Control-Allow-Origin: *');
	if($_REQUEST['title']!='' && $_REQUEST['price']!='' && $_REQUEST['seller_id']!='' && $_REQUEST['made_time']!='' && $_REQUEST['best_before']!='' && $_REQUEST['note']!=''){
	//getting the values 
	$title = $_REQUEST['title']; 
	$image = $_FILES["image"]['name']; 
	$price = $_REQUEST['price'];
	$seller_id = $_REQUEST['seller_id'];
	$made_time = $_REQUEST['made_time'];
	$best_before = $_REQUEST['best_before'];
	$note = $_REQUEST['note'];
	//checking if the user is already exist with this username or email
	//as the email and username should be unique for every user 

	/* $select = "SELECT * FROM food_table WHERE title = '".$title."'";
	$result = mysqli_query($conn,$select);*/
		
	if(strtotime($best_before) < strtotime($made_time)){
	
		$responce1['error_code']=1;
		$responce1['message']="Made time can not be greater than Best Before time.";
		$jason_data= json_encode($responce1);
		print($jason_data);
		exit();
	}
	else{ 
		/* header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *'); */
		
		//if user is new creating an insert query 
		$stmt = "INSERT INTO food_table (title,image,price,made_time,best_before,note,seller_id) 
				VALUES ('".$title."','".$image."','".$price."','".$made_time."','".$best_before."','".$note."','".$seller_id."')";
		$data = array();
		if ($conn->query($stmt) === TRUE) {
			$target_dir = "upload_images/";
			
			$target_file = $target_dir . basename($_FILES["image"]["name"]);  // for image
			//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			//$imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image

			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
			$responce['error_code']=0;
			$responce['message']="Food added Successfully.";	
			echo json_encode($responce);
			die();
		}
		else{
			
			$responce['error_code']=1;
			$responce['message']="Something went wrong.";
			echo json_encode($responce);
			exit();
		}	
	}
	}
	else{
		
		$responce['error_code']=1;
		$responce['message']="Invalid Request.";
		echo json_encode($responce);
		exit();
	}
}

// post_food function
function buy_food(){
include(dirname(__DIR__)."/android/config.php");

	$food_id  = $_REQUEST['food_id']; 
	$buyer_id = $_REQUEST['buyer_id']; 
	$select = "SELECT * FROM food_table WHERE id ='".$food_id."' and status = '1' ";
	$result = mysqli_query($conn,$select);
		
	if(mysqli_num_rows($result)>0){ 
		
		$insert = "INSERT INTO buy_food (food_id,buyer_id) VALUES ('".$food_id."','".$buyer_id."')"; 
		
		if ($conn->query($insert) === TRUE) {
	
		$update = "UPDATE food_table SET status='0' WHERE id='".$food_id."' "; 
		$result1 = mysqli_query($conn,$update);
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
			$responce['error_code']="0";
			$responce['message']="Food has been bought out Successfully.";
			//$responce[] = $data;
			print $jason_data = json_encode($responce);
			die();	
					
		}
		else{
			
			$responce['error_code']="1";
			$responce['message']="Something went wrong.";
			echo  $jason_data =json_encode($responce);
			exit();
		}
	}	
	else{
			$responce['error_code']=1;
			$responce['message']="Sorry!!! This Item is not available.";
			echo json_encode($responce);
			exit();
		}
}


// service list function
function food_list(){
	
	include(dirname(__DIR__)."/android/config.php");
		$select = "SELECT * FROM food_table WHERE best_before >= CURDATE() and status = '1'"; 
		$result = mysqli_query($conn,$select);
		if(mysqli_num_rows($result)>0){
		$data = array();
			
		    $responce['error_code']=0;
			$responce['message']="Show Data Successfully.";
			foreach($result as $results){
			
				 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				 $id = $results['id'];
				 $title = $results['title'];
				 $image = $results['image'];
				 $price = $results['price'];
				 $made_time = $results['made_time'];
				 $best_before = $results['best_before'];
				 $note = $results['note'];
				 
				 $array = array("id"=>$id,"title"=>$title,"image"=>"http://".$_SERVER['SERVER_NAME']."/android/rest/upload_images/".$image,"price"=>$price,"made_time"=>$made_time,"best_before"=>$best_before,"note"=>$note);
				 $data[] = $array;
			}
			$responce['data'] = $data;
			header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
			header('Content-type: application/json');
			header('Access-Control-Allow-Origin: *');
			print $jason_data = json_encode($responce);
			die();	
					
		}
		else{
			
			$responce['error_code']=1;
			$responce['message']="Currently don't have any food.";
			echo json_encode($responce);
			exit();
		}
}
	
// vehicle_list function 	
function vehicle_list(){
	
	include(dirname(__DIR__)."/android/config.php");
	
	
		$select = "SELECT * FROM vehicle_category_table where status ='0'"; 
		$result = mysqli_query($conn,$select);
		if(mysqli_num_rows($result)>0){
			$data = array();
			
			foreach($result as $results){
			
				 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				 $id = $results['id'];
				 $name = $results['name'];
				
				 
				 $array = array("id"=>$id,"name"=>$name);
				
				$data[] = $array;
				
			}
			
			header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		    $responce['error_code']=0;
			$responce['message']="Show Data Successfully.";
			$responce['data'] = $data;
			print $jason_data = json_encode($responce);
			die();	
					
		}
		else{
			
			$responce['error_code']=1;
			$responce['message']="Invalid Request.";
			echo json_encode($responce);
			exit();
		}
}

//food_list function

function service_category(){
include(dirname(__DIR__)."/android/config.php");
	
	$select = "SELECT * FROM service_category_table"; 
	$result = mysqli_query($conn,$select);
	if(mysqli_num_rows($result)>0){
		$data = array();
		
		foreach($result as $results){
		
			 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			 $id = $results['id'];
			 $name = $results['name'];
			 $status = $results['status'];
			
			 
			 $array = array("id"=>$id,"name"=>$name,"status"=>$status);
			
			$data[] = $array;
			
		}
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
	header('Content-type: application/json');
	header('Access-Control-Allow-Origin: *');
		$responce['error_code']=0;
		$responce['message']="Show Data Successfully.";
		$responce['data'] = $data;
		print $jason_data = json_encode($responce);
		die();	
				
	}
	else{
		
		$responce['error_code']=1;
		$responce['message']="Invalid Request.";
		echo json_encode($responce);
		exit();
	}
}

// reports function
function reports(){
	
include(dirname(__DIR__)."/android/config.php");
	
	$staff_name       = ''; 
	$owner_name       = '';
	$plate_number     = ''; 
	$status           = '';
	$vehicle_category = ''; 
	$service_category = '';
	$category         = ''; 
	$service_name     = '';
	$service_price    = ''; 
	$image            = '';
	$signature        = ''; 
	$service_location = '';
	$time_date        = '';
	$phone_number     = '';
	
	
	
	 $staff_name       = $_REQUEST['staff_name'];  
	 $owner_name       = $_REQUEST['owner_name'];
	 $phone_number     = $_REQUEST['phone_number'];
	 $plate_number     = $_REQUEST['plate_number']; 
	 $status           = $_REQUEST['status'];
	 $vehicle_category = $_REQUEST['vehicle_category']; 
	 $service_category = $_REQUEST['service_category'];
	 $category         = $_REQUEST['category']; 
	 $service_name     = $_REQUEST['service_name'];
	 $service_price    = $_REQUEST['service_price']; 
	 $image            = $_FILES["image"]['name'];
	 $signature        = $_FILES["signature"]['name']; 
	 $service_location = $_REQUEST['service_location']; 
	 $time_date        = $_REQUEST['time_date'];
	 $seen             = 0;
	
	$insert = "INSERT INTO report_table (staff_name, owner_name, phone_number, plate_number, status, vehicle_category,service_category,category,service_name,service_price,
	image,signature,service_location,time_date,seen)
		    VALUES ('".$staff_name."', '".$owner_name."', '".$phone_number."', '".$plate_number."', '".$status."', '".$vehicle_category."', '".$service_category."', '".$category."', '".$service_name."', '".$service_price."', '".$image."', '".$signature."', '".$service_location."', '".$time_date."', '".$seen."')"; 
	
	$data = array();
	if ($conn->query($insert) === TRUE) {
		
		$target_dir = "upload_images/";
		
		$target_file = $target_dir . basename($_FILES["image"]["name"]);  // for image
		$target_file2 = $target_dir . basename($_FILES["signature"]["name"]);  // for signature
		//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		//$imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image

		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
		move_uploaded_file($_FILES["signature"]["tmp_name"], $target_file2);
		
		$responce['error_code']=0;
		$responce['message']="Data Inserted Successfully.";
		$data[] = $responce;
		
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
	header('Content-type: application/json');
	header('Access-Control-Allow-Origin: *');
		
		echo json_encode($data);
		die();
	}
	else{
		
		$responce['error_code']=1;
		$responce['message']="Invalid Request.";
		echo json_encode($responce);
		exit();
	}	
	
}


// history list

function history_list(){

include(dirname(__DIR__)."/android/config.php");
	
	$select = "SELECT * FROM report_table WHERE status = 'pending' "; 
	$result = mysqli_query($conn,$select);
	if(mysqli_num_rows($result)>0){
		$data = array();
		
		foreach($result as $results){
		
			 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			 $id = $results['id'];
			 $owner_name = $results['owner_name'];
			 $plate_number = $results['plate_number'];
			 $service_category = $results['service_category'];
			 $phone_number = $results['phone_number'];
			
			 
			 $array = array("id"=>$id,"owner_name"=>$owner_name,"plate_number"=>$plate_number,"service_category"=>$service_category,"phone_number"=>$phone_number);
			
			$data[] = $array;
			
		}
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
	header('Content-type: application/json');
	header('Access-Control-Allow-Origin: *');
		$responce['error_code']=0;
		$responce['message']="Show Data Successfully.";
		$responce['data'] = $data;
		print $jason_data = json_encode($responce);
		die();	
				
	}
	else{
		
		$responce['error_code']=1;
		$responce['message']="Invalid Request.";
		echo json_encode($responce);
		exit();
	}

}

// order_completed function
function order_completed(){

include(dirname(__DIR__)."/android/config.php");
	
	if(isset($_REQUEST['order_id'])){
		$order_id        = '';
		$order_id        = $_REQUEST['order_id']; 
		$status          = 'completed';
		
		$update = "UPDATE report_table SET status='".$status."' WHERE id='".$order_id."' "; 
		
		if ($conn->query($update) === TRUE) {
	
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
			$data['status']="completed";
			$data['message']="Update Data Successfully.";
			//$responce[] = $data;
			print $jason_data = json_encode($data);
			die();	
					
		}
		else{
			
			$responce['error_code']=1;
			$responce['message']="Invalid Request.";
			echo json_encode($responce);
			exit();
		}
	}
}

// daily_work function

function daily_work(){

include(dirname(__DIR__)."/android/config.php");
/*$date     = $_REQUEST['date'];
$row_id   =  $_REQUEST['id'];

if(!empty($row_id) && !empty($date)){
	echo $update = "UPDATE `daily_work_table` SET date=".$date." WHERE id=".$row_id."";  
}*/
	$today_date = $_REQUEST['date_time'];
	 $select="select distinct(plate_number),vehicle_name,vehicle_model,vehicle_type,contract_price,id,status from daily_work_table where status='pending'"; 
	//$select = "SELECT * FROM daily_work_table "; 
	$result = mysqli_query($conn,$select);
	if(mysqli_num_rows($result)>0){
		//$data = array();
		//$getdata=array();
		foreach($result as $results){
			
/*			 if($results['date_time'] == $today_date  && $results['status'] == 'completed'){
				 continue;
			 }
			 
			 	
*/	
	 		 $id = $results['id'];
			 $plate_number = $results['plate_number'];
			 $vehicle_name = $results['vehicle_name'];
			 $vehicle_model = $results['vehicle_model'];
			 $vehicle_type = $results['vehicle_type'];
			 $contract_price = $results['contract_price'];
			 

			$selecthwe="select * from daily_work_table where status='completed' and date_time='$today_date' and plate_number='$plate_number'"; 
	//$select = "SELECT * FROM daily_work_table "; 
				$resulsssst = mysqli_query($conn,$selecthwe);
			if(mysqli_num_rows($resulsssst)>0){
			
				continue;	
			}
		
		
		
			 //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			
			 
			
			 
			 $array = array("id"=>$id,"plate_number"=>$plate_number,"vehicle_name"=>$vehicle_name,"vehicle_model"=>$vehicle_model,"vehicle_type"=>$vehicle_type,"contract_price"=>$contract_price);
			
			$data[] = $array;
			
		
			
		}
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
	header('Content-type: application/json');
	header('Access-Control-Allow-Origin: *');
		$responce['error_code']=0;
		$responce['message']="Show Data Successfully.";
		$responce['data'] = $data;
		print $jason_data = json_encode($responce);
		die();	
				
	}
	else{
		
		$responce['error_code']=1;
		$responce['message']="Invalid Request.";
		echo json_encode($responce);
		exit();
	}
	
}

// daily_work_update function
function daily_work_update(){

include(dirname(__DIR__)."/android/config.php");
 $date = $_REQUEST['date_time'];
 $platenumber   =   $_REQUEST['platenumber'];
  
if(isset($_REQUEST['date_time'])){
	$status = 'completed';
	

	 
	
	 $select="select * from daily_work_table WHERE plate_number='".$platenumber."' and date_time = '".$date."'"; 
	//$select = "SELECT * FROM daily_work_table "; 
	$result = mysqli_query($conn,$select);
	if(mysqli_num_rows($result)== 0){
		
		 $select_plate = "select * from daily_work_table WHERE plate_number='".$platenumber."'"; 
		 $result_data = mysqli_query($conn,$select_plate);
		
		while($rowget=mysqli_fetch_array($result_data))
		{
			$vehiclename	=	$rowget['vehicle_name'];	
			$vehicle_model	=	$rowget['vehicle_model'];
			$vehicle_type	=	$rowget['vehicle_type'];
			$contract_price	=	$rowget['contract_price'];
		}
		//pinky
		if($platenumber!=0)
		{
	//end pinky
			$insert = "INSERT INTO daily_work_table (plate_number, vehicle_name, vehicle_model, vehicle_type, contract_price, date_time, status)
		    VALUES ('".$platenumber."','".$vehiclename."','".$vehicle_model."', '".$vehicle_type."', '".$contract_price."', '".$date."', '".$status."')"; 

			if ($conn->query($insert) === TRUE) {
		
			header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
			header('Content-type: application/json');
			header('Access-Control-Allow-Origin: *');
				$data['status']="completed";
				$data['message']="inserted Data Successfully.";
				//$responce[] = $data;
				print $jason_data = json_encode($data);
				die();	
					
			}
		//pinky		
		}
		//end pinky
	
	}
	else if(mysqli_num_rows($result)>0)
	{
		
		$update = "UPDATE daily_work_table SET status='".$status."' WHERE plate_number='".$platenumber."' and date = '".$date."'  "; 
		$conn->query($update); 	
		
		header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
			$data['status']="completed";
			$data['message']="update Data Successfully.";
			//$responce[] = $data;
			print $jason_data = json_encode($data);
			die();	
		
	}
 
		/*else{}*/
		
}
	
}
?>