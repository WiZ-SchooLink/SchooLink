<?php
/*!
@file contents_db.php
@brief 
@copyright Copyright (c) 2021 Yamanoi Yasushi.
*/
//PDO接続初期化

use chandout as GlobalChandout;
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
	@return	配列（2次元配列になる）空の場合はfalse
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
	@brief	学校からアカウントクラスの配列を得る
	@param[in]	$id		スクールID
	@return	配列（2次元配列になる）空の場合はfalse
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
	//--------------------------------------------------------------------------------------
	/*!
	@brief	学校からクラスクラスにあるクラスIDとクラスネームの配列を得る
	@param[in]	$id		スクールID
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_school_class($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"DISTINCT class.class_id,class.grade,class.class_name",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"school.school_id=class.school_id AND school.school_id=". $id	//条件
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
	@return	配列（2次元配列になる）空の場合はfalse
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
	@brief	クラスidからクラスネームの配列を得る
	@param[in]	$id		ID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_class_info($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"class_id,grade,class_name",			//取得するカラム
			"class",	//取得するテーブル
			"class_id=".$id,	//条件
			"class_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;

	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントidからクラスID得る
	@param[in]	$id		アカウントID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_class_accoid($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"class.class_id",			//取得するカラム
			"account,class",	//取得するテーブル
			"account.class_id=class.class_id AND account.account_id=".$id,	//条件
			"class.class_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;

	}
//インサート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルのクラスID以外の属性に値を追加する関数
	@param[in]	$school_id	学校ID
	@param[in]	$grade 		学年
	@param[in]	$class_name	クラス名（年組）
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function insert_class($school_id,$grade,$class_name){
		$obj = new cchange_ex();
		$dataarr = array();
		$dataarr['school_id'] = (int)$school_id;
		$dataarr['grade'] = (string)$grade;
		$dataarr['class_name'] = (string)$class_name;
		$obj->insert(false,'class',$dataarr);
	}
//アップデート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルの更新を行う関数
	@param[in]	$id		アカウントid
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function updata_class($class_id,$school_id,$grade,$class_name){
		$obj = new cchange_ex();
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id;
		$dataarr['school_id'] = (int)$school_id;
		$dataarr['grade'] = (string)$grade;
		$dataarr['class_name'] = (string)$class_name;
		$obj->update(false,'class',$dataarr,'class_id=' . $class_id );

	}
//デリート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラスIDでクラステーブルのレコードを削除　また、それに紐づく配布物レコードも削除する
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_class($id){
		$obj = new cchange_ex();
		$handobj = new chandout();
		$accobj = new caccount();
		$accobj->delete_classaccount($id);
		$handobj->delete_classhandout($id);
		$obj->delete(false,'class','class_id=' . $id);
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
	@brief	account_idの配列を得る
	@param[in]	$name		ユーザーネーム
	@param[in]	$pass		パスワード
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_tgt($name,$pass){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"account_id,login_pass",			//取得するカラム
			"account",	//取得するテーブル
			"account.login_name='$name' ",
			"account.account_id asc"	//条件	
		);
		$arr = [];
		//順次取り出す
		while($row = $this->fetch_assoc()){

			$arr[] = $row;
		}
		if(empty($arr)){
			return null;
		}
		$stored_seed = substr($arr[0]['login_pass'],32,8);
		if(hash("md5",$stored_seed . $pass) . $stored_seed == $arr[0]['login_pass']){
			return $arr;//取得した配列を返す	 
		}
		else{
			return null;
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから管理者/生徒のフラッグを取得してくる
	@param[in]	$id		アカウントid
	@return	配列（2次元配列になる）空の場合はfalse
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
	@return	配列（2次元配列になる）空の場合はfalse
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
	@brief	アカウントIDからログインネーム、ユーザーネーム、ユーザーフラッグを取得
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_testinfo($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		 $this->select(
			false,			//デバッグ表示するかどうか
			"login_name,user_name,user_flag",			//取得するカラム
			"account",	//取得するテーブル
			"account.account_id='$id'",
			"account.account_id asc"	//条件			
		);
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから配布物テーブルの情報を取得
	@param[in]	$id		アカウントid
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_handout($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handout.*",			//取得するカラム
			"account,class,handout",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=handout.class_id AND account.account_id = $id",
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
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		$obj = new cschool();
		$rows = $obj->get_school_user($arr[0]["school_id"]);		
		//取得した配列を返す
		return $rows;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから各学校にあるクラスIDとクラスネームを取得
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_school_id($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"school.school_id",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"account.class_id=class.class_id AND class.school_id=school.school_id AND account.account_id='$id'",
			"account.class_id asc"	//条件			
		);
		$row = $this->fetch_assoc();		
		//取得した配列を返す
		return $row;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDから各学校にある学校IDを取得
	@param[in]	$id		アカウントid
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_school_classinfo($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"school.*",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"account.class_id=class.class_id AND class.school_id=school.school_id AND account.account_id='$id'",
			"account.class_id asc"	//条件			
		);
		$arr = [];
		
		//順次取り出す
		while($row = $this->fetch_assoc()){
			$arr[] = $row;
		}
		$obj = new cschool();
		$rows = $obj->get_school_class($arr[0]["school_id"]);
		//取得した配列を返す
		return $rows;
	}	
	//--------------------------------------------------------------------------------------
	/*!
	@brief	ログインネームから該当するアカウントテーブルの配列を得る
	@param[in]	$id		ログインネーム
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_accinfo($id){
		
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"account",	//取得するテーブル
			"login_name='$id' ",
			"account.account_id asc"	//条件		
		);	
		//レコード1行分を1次元配列に格納
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントidから配布物テーブルの配列を得る
	@param[in]	$id		アカウントID
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_account_handinfo($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handout.*",			//取得するカラム
			"account,class,handout",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=handout.class_id AND account.account_id=".$id,	//条件
			"handout.handout_id asc"
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
	@brief	アカウントIDからファイルパスだけを取得する
	@param[in]	$debug	デバッグ出力をするかどうか
	@param[in]	$from	抽出開始行
	@param[in]	$limit	抽出数
	@return	配列（1次元配列になる）
	*/
	//--------------------------------------------------------------------------------------
	public function get_filepath($id){
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"filepath",		//取得するカラム
			"account,class,lunch",			//取得するテーブル
			"account.class_id = class.class_id AND class.class_id = lunch.class_id AND account.account_id =".$id,		//条件
			"lunch.lunch_id asc" //並び替え
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDでスケジュールテーブルにあるスケジュールのファイルパスを取得
	@param[in]	$id		アカウントID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_schedule_file($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"schedule.contents_filepath",			//取得するカラム
			"account,class,schedule",	//取得するテーブル
			"account.class_id = class.class_id AND class.class_id = schedule.class_id AND account.account_id=".$id,	//条件
			"schedule_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}	
//インサート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントテーブルのアカウントID以外の属性に値を追加する関数
	@param[in]	$login_name		ログインネーム
	@param[in]	$login_pass		ログインパス
	@param[in]	$class_id		クラスID（外部キー）
	@param[in]	$user_name		ユーザーネーム
	@param[in]	$user_flag		ユーザーレベル
	@return		無し
	*/
	//--------------------------------------------------------------------------------------
	public function insert_account($login_name,$login_pass,$class_id,$user_name,$user_flag){
		$obj = new cchange_ex();
		$seed = null;
		$hash_pass = null;
		for ($i = 1; $i <= 8; $i++){
			$seed .= substr('0123456789abcdef',rand(0,15),1);
		}
		$hash_pass = hash("md5",$seed . $login_pass) . $seed;
		$dataarr = array();
		$dataarr['login_name'] = (string)$login_name;
		$dataarr['login_pass'] = (string)$hash_pass;
		$dataarr['class_id'] = (int)$class_id;
		$dataarr['user_name'] = (string)$user_name;
		$dataarr['user_flag'] = (int)$user_flag;
		$obj->insert(false,'account',$dataarr);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントテーブルのアカウントID以外の属性に値を追加する関数
	@param[in]	$id		アカウントID
	@param[in]	$upfile	filename
	@return		無し
	*/
	//--------------------------------------------------------------------------------------
	public function insert_lunch($id,$upfile){
		
		# 拡張子を取得する
		$file_ext = pathinfo($upfile["name"], PATHINFO_EXTENSION);
		# 現在の時間を取得する
		$time_now = ceil(microtime(true)*1000);
		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
		$file_name_new = "../../updata/" . $time_now . "." . $file_ext;
		# ファイルの移動を行う
		move_uploaded_file ($upfile["tmp_name"], $file_name_new);

		$obj = new cclass();
		$row = $obj->get_class_accoid($id);		
		$dataarr = array();
		$dataarr['class_id'] = (int)$row['class_id'];
		$dataarr['filepath'] = (string)$file_name_new;

		$ins_obj = new cchange_ex();
		$account_obj = new caccount();
		$fileCheck = $account_obj->get_filepath($id);
		if(empty($fileCheck)){
			$ins_obj->insert(false,'lunch',$dataarr);
		}else{
			unlink($fileCheck['filepath']);
			$ins_obj->update(false,'lunch',$dataarr,'class_id='.$row['class_id']);
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	スケジュールテーブルのスケジュールID以外の属性に値を追加する関数
	@param[in]	$id		アカウントID
	@param[in]	$upfile	ファイルパス
	@return		無し
	*/
	//--------------------------------------------------------------------------------------
	public function insert_schedule($id,$upfile){
		
		# 拡張子を取得する
		$file_ext = pathinfo($upfile["name"], PATHINFO_EXTENSION);
		# 現在の時間を取得する
		$time_now = ceil(microtime(true)*1000);
		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
		$file_name_new = "../../updata/" . $time_now . "." . $file_ext;
		# ファイルの移動を行う
		move_uploaded_file ($upfile["tmp_name"], $file_name_new);

		$obj = new cclass();
		$row = $obj->get_class_accoid($id);		
		$dataarr = array();
		$dataarr['class_id'] = (int)$row['class_id'];
		$dataarr['schedule_filepath'] = (string)$file_name_new;

		$ins_obj = new cchange_ex();
		$account_obj = new caccount();
		$fileCheck = $account_obj->get_schedule_file($id);
		if(empty($fileCheck)){
			$ins_obj->insert(false,'schedule',$dataarr);
		}else{
			unlink($fileCheck['filepath']);
			$ins_obj->update(false,'schedule',$dataarr,'class_id='.$row['class_id']);
		}
	}
//アップデート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントテーブルの更新を行う関数
	@param[in]	$id		アカウントid
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function updata_account($account_id,$login_name,$login_pass,$class_id,$user_name,$user_flag){
		$obj = new cchange_ex();
		if(!empty($login_pass)){
			$seed = null;
			$hash_pass = null;
			for ($i = 1; $i <= 8; $i++){
				$seed .= substr('0123456789abcdef',rand(0,15),1);
			}
			$hash_pass = hash("md5",$seed . $login_pass) . $seed;
			$dataarr = array();
			$dataarr['account_id'] = (int)$account_id;
			$dataarr['login_name'] = (string)$login_name;
			$dataarr['login_pass'] = (string)$hash_pass;
			$dataarr['class_id'] = (int)$class_id;
			$dataarr['user_name'] = (string)$user_name;
			$dataarr['user_flag'] = (int)$user_flag;
		}else{
			$dataarr = array();
			$dataarr['account_id'] = (int)$account_id;
			$dataarr['login_name'] = (string)$login_name;
			$dataarr['class_id'] = (int)$class_id;
			$dataarr['user_name'] = (string)$user_name;
			$dataarr['user_flag'] = (int)$user_flag;
		}
		$obj->update(false,'account',$dataarr,'account_id=' . $account_id );
	}
//デリート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDで指定したアカウントレコードを削除
	@param[in]	$id	アカウントID
	@return 無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_account($id){
		$obj = new cchange_ex();
		$obj->delete(false,'account','account_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラスIDでアカウントレコード内の該当するアカウント削除
	@param[in]	$id	クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_classaccount($id){
		$obj = new cchange_ex();
		$obj->delete(false,'account','class_id=' . $id);
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
		//親クラスのselect()
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
	@return	配列（2次元配列になる）空の場合はfalse
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
	@brief	配布物IDから内容だけを得る
	@param[in]	$id		配布物ID
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_handout_constents($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"title,contents_handout",			//取得するカラム
			"handout",	//取得するテーブル
			"handout.handout_id=".$id,	//条件
			"handout.handout_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;

	}	
//インサート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	配布物テーブルのhandout_idとdate以外の属性に値を追加する関数
	@param[in]	$class_id		クラスID
	@param[in]	$date		日付（yyyy-mm-dd hh:mm:ss）
	@param[in]	$title		タイトルネーム
	@param[in]	$constents_handout		配布物内容
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function insert_handout($class_id,$title,$contents_handout){
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (string)$class_id;
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_handout'] = (string)$contents_handout;
		$obj->insert(false,'handout',$dataarr);
	}
//アップデート記述枠
//デリート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルを削除する際に外部キーにしている配布物レコードを削除
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_classhandout($id){
		$obj = new cchange_ex();
		$obj->delete(false,'handout','class_id=' . $id);
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
//配布物ファイルクラス
class chandfile extends crecord{
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
	@brief	配布物IDから配布物ファイルテーブルのファイルパスを取得
	@param[in]	$id		配布物ID（配布物テーブル）
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_handfile($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handfile.filepath",			//取得するカラム
			"handout,handfile",	//取得するテーブル
			"handout.handout_id=handfile.handout_id AND handfile.handout_id=".$id,	//条件
			"handfile_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}	
//インサート
	public function insert_handfile($handarr){
		$dataarr = array();
		$obj = new cchange_ex();
		
		foreach($handarr as  $arr){
			# 拡張子を取得する
			$file_ext = pathinfo($arr['name'], PATHINFO_EXTENSION);
			# 現在の時間を取得する
			$time_now = ceil(microtime(true)*1000);
			# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;
			# ファイルの移動を行う
			move_uploaded_file ($arr["tmp_name"], $file_name_new);
			
			$dataarr['handout_id'] = (int)$arr['handout_id'];
			$dataarr['filepath']   = (string)$file_name_new;
			$obj->insert(false,'handfile',$dataarr);
 		}
	}
//アップデート
}
//献立クラス
class clunch extends crecord {
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
	@brief	クラスIDからランチテーブルのファイルパスを取得
	@param[in]	$id		クラスID
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_lunch_filepath($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"filepath",			//取得するカラム
			"lunch",	//取得するテーブル
			"class_id=".$id,	//条件
			"lunch_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}	
//インサート
//アップデート
}
//スケジュールクラス
class cschedule extends crecord {
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct() {
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	
//インサート
	
//アップデート
}
//ブログクラス
class cweblog extends crecord {
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
	@brief	アカウントIDからweblogテーブルのID、日付、タイトルを取得
	@param[in]	$id		アカウントID
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_weblog_data($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"weblog.weblog_id,weblog.date,weblog.title,weblog.contents_weblog",			//取得するカラム
			"account,class,weblog",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=weblog.class_id AND account.account_id=".$id,	//条件
			"weblog.weblog_id asc"
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
	@brief	weblog_idからweblogfileテーブルのpathリストを取得
	@param[in]	$id weblog_id
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_weblog_filepath_list($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"weblogfile.filepath",			//取得するカラム
			"weblog,weblogfile",	//取得するテーブル
			"weblog.weblog_id = weblogfile.weblog_id AND weblog.weblog_id = ". $id,	//条件
			"weblogfile.weblogfile_id asc"
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
	@brief	weblog_idから内容を取得
	@param[in]	$id weblog_id
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_weblog_content($id){
		if(!cutil::is_number($id)
		||  $id < 1){
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"weblog",	//取得するテーブル
			"weblog_id = ". $id,	//条件
			"weblog_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}		

//インサート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblogテーブルに挿入する情報追加、ファイルはパスをweblogfileテーブルに追加する関数
	@param[in]	$account_id		アカウントID
	@param[in]	$date		日付（yyyy-mm-dd hh:mm:ss）
	@param[in]	$title		タイトルネーム
	@param[in]	$constents_weblog		ブログ内容
	@param[in]	$weblogarr		ファイルの名前が入ってる配列
	*/
	//--------------------------------------------------------------------------------------
	public function insert_weblog($account_id,$title,$contents_weblog,$weblogarr){
		$acc_obj = new cclass();
		$class_id = $acc_obj->get_class_accoid($account_id);
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id;
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_weblog'] = (string)$contents_weblog;
		$weblog_id = $obj->insert(false,'weblog',$dataarr);
		if(!empty($weblogarr)){
			$weblog_obj = new cweblog();
			$weblog_obj->insert_weblogfile($weblog_id,$weblogarr);
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblogfileにパスとかを追加する関数
	@param[in]	$id		weblog_id
	@param[in]	$blogfile	ブログのパス
	*/
	//--------------------------------------------------------------------------------------
	public function insert_weblogfile($id,$blogfile){
		$obj = new cchange_ex();
		for($i = 0;$i<count($blogfile["name"]);$i++){
			# 拡張子を取得する
			$file_ext = pathinfo($blogfile["name"][$i], PATHINFO_EXTENSION);
			# 現在の時間を取得する
			$time_now = ceil(microtime(true)*1000);
			# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;
			# ファイルの移動を行う
			move_uploaded_file ($blogfile["tmp_name"][$i], $file_name_new);
			
			$dataarr['weblog_id'] = (int)$id;
			$dataarr['filepath'] = (string)$file_name_new;
			$obj->insert(false,'weblogfile',$dataarr);
 		}
	}
//アップデート
//デリート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルを削除する際に外部キーにしている配布物レコードを削除
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_classweblog($id){
		$obj = new cchange_ex();
		$obj->delete(false,'weblog','class_id=' . $id);
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
