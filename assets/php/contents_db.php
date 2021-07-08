<?php
/*!
@file contents_db.php
@brief 
@copyright Copyright (c) 2021 Yamanoi Yasushi.
*/
//PDO接続初期化

use cschool as GlobalCschool;

require_once("pdointerface.php");

////////////////////////////////////
//以下、DBクラス使用例


//--------------------------------------------------------------------------------------
///	学校クラス
//--------------------------------------------------------------------------------------
class cschool extends crecord {
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct() {
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	すべての個数を得る
	@param[in]	$debug	デバッグ出力をするかどうか
	@return	個数
	*/
	//--------------------------------------------------------------------------------------
	public function get_all_count($debug=false){
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			$debug,					//デバッグ文字を出力するかどうか
			"count(*)",				//取得するカラム
			"school",			//取得するテーブル
			"1"					//条件
		);
		if($row = $this->fetch_assoc()){
			//取得した個数を返す
			return $row['count(*)'];
		}
		else{
			return 0;
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定された範囲の配列を得る
	@param[in]	$column　取得するデータ
	@return	配列（2次元配列になる）
	*/
	//--------------------------------------------------------------------------------------
	public function get_all($column){
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			$column,			//取得するカラム
			"school",	//取得するテーブル
			"1"			//条件
			);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定されたIDの配列を得る
	@param[in]	$id		ID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_tgt($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"school",	//取得するテーブル
			"school_id=" . $id	//条件
		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;

	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct(){
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	学校からアカウントクラスの配列を得る
	@param[in]	$id		ID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_school_user($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"account.login_name,account.class_id,account.user_name,account.user_flag",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"school.school_id=class.school_id AND class.class_id=account.class_id AND school.school_id=". $id	//条件
		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;

	}
}

//クラスクラス
class cclass extends crecord {
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct() {
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定された範囲の配列を得る
	@param[in]	$debug	デバッグ出力をするかどうか
	@param[in]	$from	抽出開始行
	@param[in]	$limit	抽出数
	@return	配列（2次元配列になる）
	*/
	//--------------------------------------------------------------------------------------
	public function get_all($column="class.*"){
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			$column,		//取得するカラム
			"class,school",			//取得するテーブル
			"class.school_id = school.school_id",		//条件
			"class.class_id asc" //並び替え

		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定されたIDの配列を得る
	@param[in]	$id		ID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_tgt($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"class,school",	//取得するテーブル
			"class.school_id = school.school_id AND class.class_id=".$id,	//条件
			"class.class_id asc"
		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラスidからクラスネームの配列を得る
	@param[in]	$id		ID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_class_name($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"class_name",			//取得するカラム
			"class",	//取得するテーブル
			"class_id=".$id,	//条件
			"class_id asc"
		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct(){
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}

//アカウントクラス
class caccount extends crecord {
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct() {
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定された範囲の配列を得る
	@param[in]	$debug	デバッグ出力をするかどうか
	@param[in]	$from	抽出開始行
	@param[in]	$limit	抽出数
	@return	配列（2次元配列になる）
	*/
	//--------------------------------------------------------------------------------------
	public function get_all($column="account.*"){
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			$column,			//取得するカラム
			"account,class",	//取得するテーブル
			"account.class_id=class.class_id",			//条件
			"account.account_id asc"
		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}	
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct(){
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	account_idの配列を得る
	@param[in]	$name		ユーザーネーム
	@param[in]	$pass		パスワード
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_tgt($name=null,$pass=null){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"account_id",			//取得するカラム
			"account",	//取得するテーブル
			"account.login_name='$name' AND account.login_pass='$pass' ",
			"account.account_id asc"	//条件
			
		);
		$arr = [];
		//順次取り出す
		while($row = $this->fetch_assoc()){

			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから管理者/生徒のフラッグを取得してくる
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_flg($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"user_flag",			//取得するカラム
			"account",	//取得するテーブル
			"account.account_id='$id'",
			"account.account_id asc"	//条件
			
		);
		$arr = [];
		//順次取り出す
		while($row = $this->fetch_assoc()){

			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDからログインネーム、クラスID、ユーザーネーム、ユーザーフラッグを取得
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_userinfo($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"login_name,class_id,user_name,user_flag",			//取得するカラム
			"account",	//取得するテーブル
			"account.account_id='$id'",
			"account.account_id asc"	//条件
			
		);
		$arr = [];
		$arr2 = [];
		//順次取り出す
		while($row = $this->fetch_assoc()){

			$arr[] = $row;

		}
		for($i=0;$i<5;$i++){
			$arr2[$i]=$arr;
		}
		//取得した配列を返す
		return $arr2;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから配布物テーブルの情報を取得
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_handout($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handout.*",			//取得するカラム
			"account,class,handout",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=handout.class_idS",
			"handout.handout_id asc"	//条件
			
		);
		$arr = [];
		//順次取り出す
		while($row = $this->fetch_assoc()){

			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから各学校のクラスを取得
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_school_userinfo($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"school.*",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"account.class_id=class.class_id AND class.school_id=school.school_id AND account.account_id='$id'",
			"account.class_id asc"	//条件
			
		);
		$arr = [];
		$arr2 = [];
		//順次取り出す
		while($row = $this->fetch_assoc()){

			$arr[] = $row;
		}

		//学校クラスでアカウントテーブルの情報をselectして取得する
		$obj = new cschool();
		$rows = $obj->get_school_user($arr[0]["school_id"]);
	
		//取得した配列を返す
		return $rows;
	}
}
//配布物クラス
class chandout extends crecord {
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct() {
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定された範囲の配列を得る
	@param[in]	$debug	デバッグ出力をするかどうか
	@param[in]	$from	抽出開始行
	@param[in]	$limit	抽出数
	@return	配列（2次元配列になる）
	*/
	//--------------------------------------------------------------------------------------
	public function get_all($column="handout.*"){
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			$column,		//取得するカラム
			"handout,class",			//取得するテーブル
			"handout.class_id = class.class_id",		//条件
			"handout.handout_id asc" //並び替え

		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	指定されたIDの配列を得る
	@param[in]	$id		ID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_tgt($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"handout,class",	//取得するテーブル
			"handout.class_id = class.class_id AND handout.handout_id=".$id,	//条件
			"handout.handout_id asc"
		);
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}	
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct(){
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}

