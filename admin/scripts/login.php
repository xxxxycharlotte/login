<?php 

function login($username, $password){
	require_once('connect.php');
	//Check if username exists

	$check_exist_query = 'SELECT COUNT(*) FROM tbl_user';
	$check_exist_query .= ' WHERE user_name = :username';

	//echo $check_exist_query;
	
	$user_set = $pdo->prepare($check_exist_query);
	$user_set->execute(
		array(
			':username'=>$username
		)
	);


	if($user_set->fetchColumn()>0){
		$get_user_query = 'SELECT * FROM tbl_user WHERE user_name = :username AND user_pass = :password';

		$get_user_set = $pdo -> prepare($get_user_query);

		$get_user_set -> execute(
			array(
				':username' => $username,
				':password' => $password
			)
		);

		while($found_user = $get_user_set -> fetch(PDO::FETCH_ASSOC)){
			$id = $found_user['user_id'];
			$_SESSION['user_id'] =$id;
			$_SESSION['user_name'] = $found_user['user_name'];

		}
		if(empty($id)){
			$message = "Login Failed!";
			return $message;
		}
		redirect_to('index.php');
	}else{
		$message = "Login Failed!";
		return $message;
	}

}