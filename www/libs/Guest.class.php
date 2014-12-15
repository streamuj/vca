<?php 

class Guest {

	/**
	 * Connection
	 * @param user login
	 * @param user password
	 * @return user id
	 */
	static function connect($login, $password) {
		$sql = 'SELECT user_id, user_password
		        FROM user
		        WHERE user_name= :user_name';
		$link = Db::link();
		$req = $link->prepare($sql);
		$req->execute(array('user_name' => $login));
		$do = $req->fetch(PDO::FETCH_OBJ);

		//If user does not exist or the passwords missmatch
		if(!empty($do) && hash('sha512', $do->user_id.$password) == $do->user_password) {
			return $do->user_id;
		}
		else {
			return 0;
		}
	}
	
	/**
	 * Generate a new token
	 * @param user id
	 * @return new token
	 */
	static function newToken($id) {
		$newToken = hash('sha512', $id.mt_rand());
	
		//Update token
		$sql = 'UPDATE user
		        SET user_token= :user_token
		        WHERE user_id= :user_id';
		$link = Db::link();
		$req = $link->prepare($sql);
		$req->execute(array(
				'user_token' => $newToken,
				'user_id'    => $id
		));
	
		return $newToken;
	}
	
	/**
	 * Load user information
	 * @param user token
	 * @return user (NULL, User, Admin, SuperAdmin)
	 */
	static function loadUser($token) {
		$sql = 'SELECT user_id, user_rank, user_language
		        FROM user
		        WHERE user_token= :user_token';
		$link = Db::link();
		$req = $link->prepare($sql);
		$req->execute(array('user_token' => $token));
		$do = $req->fetch(PDO::FETCH_OBJ);
	
		if(empty($do)) {
			$user = null;
		}
		elseif($do->user_rank == 0) {
			$user = new User($do->user_id);
			$user->setRank($do->user_rank);
			$user->setLanguage($do->user_language);
		}
		elseif($do->user_rank == 1) {
			$user = new Admin($do->user_id);
			$user->setRank($do->user_rank);
			$user->setLanguage($do->user_language);
		}
		else {
			exit();
		}
		
		return $user;
	}
}

?>
