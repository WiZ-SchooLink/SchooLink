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
class cschool extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
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
	public function get_all($column)
	{
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			$column,			//取得するカラム
			"school",	//取得するテーブル
			"1"			//条件
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_tgt($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
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
		while ($row = $this->fetch_assoc()) {
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
	public function get_school_user($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"account.login_name,account.class_id,account.user_name,account.user_flag",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"school.school_id=class.school_id AND class.class_id=account.class_id AND school.school_id=" . $id	//条件
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_school_class($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"DISTINCT class.class_id,class.grade,class.class_name",			//取得するカラム
			"account,class,school",	//取得するテーブル
			"school.school_id=class.school_id AND school.school_id=" . $id	//条件
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}

//クラスクラス
class cclass extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
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
	public function get_all($column = "class.*")
	{
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
		while ($row = $this->fetch_assoc()) {
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
	public function get_tgt($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"class,school",	//取得するテーブル
			"class.school_id = school.school_id AND class.class_id=" . $id,	//条件
			"class.class_id asc"
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_class_name($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"class_name",			//取得するカラム
			"class",	//取得するテーブル
			"class_id=" . $id,	//条件
			"class_id asc"
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_class_info($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"class_id,grade,class_name",			//取得するカラム
			"class",	//取得するテーブル
			"class_id=" . $id,	//条件
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
	public function get_class_accoid($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"class.class_id",			//取得するカラム
			"account,class",	//取得するテーブル
			"account.class_id=class.class_id AND account.account_id=" . $id,	//条件
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
	public function insert_class($school_id, $grade, $class_name)
	{
		$obj = new cchange_ex();
		$dataarr = array();
		$dataarr['school_id'] = (int)$school_id;
		$dataarr['grade'] = (string)$grade;
		$dataarr['class_name'] = (string)$class_name;
		$obj->insert(false, 'class', $dataarr);
	}
	//アップデート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルの更新を行う関数
	@param[in]	$id		アカウントid
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function updata_class($class_id, $school_id, $grade, $class_name)
	{
		$obj = new cchange_ex();
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id;
		$dataarr['school_id'] = (int)$school_id;
		$dataarr['grade'] = (string)$grade;
		$dataarr['class_name'] = (string)$class_name;
		$obj->update(false, 'class', $dataarr, 'class_id=' . $class_id);
	}
	//デリート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラスIDでクラステーブルのレコードを削除　また、それに紐づく配布物レコードも削除する
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_class($id)
	{
		$obj = new cchange_ex();
		$handobj = new chandout();
		$accobj = new caccount();
		$accobj->delete_classaccount($id);
		$handobj->delete_classhandout($id);
		$obj->delete(false, 'class', 'class_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}

//アカウントクラス
class caccount extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
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
	public function get_all($column = "account.*")
	{
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
		while ($row = $this->fetch_assoc()) {
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
	public function get_tgt($name, $pass)
	{

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
		while ($row = $this->fetch_assoc()) {

			$arr[] = $row;
		}
		if (empty($arr)) {
			return null;
		}
		$stored_seed = substr($arr[0]['login_pass'], 32, 8);
		if (hash("md5", $stored_seed . $pass) . $stored_seed == $arr[0]['login_pass']) {
			return $arr; //取得した配列を返す	 
		} else {
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
	public function get_flg($id)
	{

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
		while ($row = $this->fetch_assoc()) {
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
	public function get_userinfo($id)
	{

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
		while ($row = $this->fetch_assoc()) {
			$arr[] = $row;
		}
		for ($i = 0; $i < 5; $i++) {
			$arr2[$i] = $arr;
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
	public function get_testinfo($id)
	{

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
	public function get_handout($id)
	{

		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handout.*",			//取得するカラム
			"account,class,handout",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=handout.class_id AND account.account_id = $id",
			"handout.date desc"	//条件			
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_school_userinfo($id)
	{

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
		while ($row = $this->fetch_assoc()) {
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
	public function get_school_id($id)
	{

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
	public function get_school_classinfo($id)
	{

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
		while ($row = $this->fetch_assoc()) {
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
	public function get_accinfo($id)
	{

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
	public function get_account_handinfo($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handout.*",			//取得するカラム
			"account,class,handout",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=handout.class_id AND account.account_id=" . $id,	//条件
			"handout.handout_id asc"
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_filepath($id)
	{
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"filepath",		//取得するカラム
			"account,class,lunch",			//取得するテーブル
			"account.class_id = class.class_id AND class.class_id = lunch.class_id AND account.account_id =" . $id,		//条件
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
	public function get_schedule_file($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"schedule.contents_filepath",			//取得するカラム
			"account,class,schedule",	//取得するテーブル
			"account.class_id = class.class_id AND class.class_id = schedule.class_id AND account.account_id=" . $id,	//条件
			"schedule_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDからブログテーブルのファイルパスだけを取得する
	@param[in]	$debug	デバッグ出力をするかどうか
	@param[in]	$from	抽出開始行
	@param[in]	$limit	抽出数
	@return	配列（1次元配列になる）
	*/
	//--------------------------------------------------------------------------------------
	public function get_weblog_filepath($id)
	{
		$arr = array();
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"weblogfile.path",		//取得するカラム
			"account,class,weblog,weblogfile",			//取得するテーブル
			"account.class_id = class.class_id AND class.class_id = weblog.class_id AND weblog.weblog_id = weblogfile.weblog_id AND account.account_id =" . $id,		//条件
			"weblogfile.weblogfile_id asc" //並び替え
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
	public function insert_account($login_name, $login_pass, $class_id, $user_name, $user_flag)
	{
		$obj = new cchange_ex();
		$seed = null;
		$hash_pass = null;
		for ($i = 1; $i <= 8; $i++) {
			$seed .= substr('0123456789abcdef', rand(0, 15), 1);
		}
		$hash_pass = hash("md5", $seed . $login_pass) . $seed;
		$dataarr = array();
		$dataarr['login_name'] = (string)$login_name;
		$dataarr['login_pass'] = (string)$hash_pass;
		$dataarr['class_id'] = (int)$class_id;
		$dataarr['user_name'] = (string)$user_name;
		$dataarr['user_flag'] = (int)$user_flag;
		$obj->insert(false, 'account', $dataarr);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントテーブルのアカウントID以外の属性に値を追加する関数
	@param[in]	$id		アカウントID
	@param[in]	$upfile	filename
	@return		無し
	*/
	//--------------------------------------------------------------------------------------
	public function insert_lunch($id, $upfile)
	{

		# 拡張子を取得する
		$file_ext = pathinfo($upfile["name"], PATHINFO_EXTENSION);
		# 現在の時間を取得する
		$time_now = ceil(microtime(true) * 1000);
		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
		$file_name_new = "../../updata/" . $time_now . "." . $file_ext;
		# ファイルの移動を行う
		move_uploaded_file($upfile["tmp_name"], $file_name_new);

		$obj = new cclass();
		$row = $obj->get_class_accoid($id);
		$dataarr = array();
		$dataarr['class_id'] = (int)$row['class_id'];
		$dataarr['filepath'] = (string)$file_name_new;

		$ins_obj = new cchange_ex();
		$account_obj = new caccount();
		$fileCheck = $account_obj->get_filepath($id);
		if (empty($fileCheck)) {
			$ins_obj->insert(false, 'lunch', $dataarr);
		} else {
			unlink($fileCheck['filepath']);
			$ins_obj->update(false, 'lunch', $dataarr, 'class_id=' . $row['class_id']);
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
	public function insert_schedule($id, $upfile)
	{

		# 拡張子を取得する
		$file_ext = pathinfo($upfile["name"], PATHINFO_EXTENSION);
		# 現在の時間を取得する
		$time_now = ceil(microtime(true) * 1000);
		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
		$file_name_new = "../../updata/" . $time_now . "." . $file_ext;
		# ファイルの移動を行う
		move_uploaded_file($upfile["tmp_name"], $file_name_new);

		$obj = new cclass();
		$row = $obj->get_class_accoid($id);
		$dataarr = array();
		$dataarr['class_id'] = (int)$row['class_id'];
		$dataarr['contents_filepath'] = (string)$file_name_new;

		$ins_obj = new cchange_ex();
		$account_obj = new caccount();
		$fileCheck = $account_obj->get_schedule_file($id);
		if (empty($fileCheck)) {
			$ins_obj->insert(false, 'schedule', $dataarr);
		} else {
			unlink($fileCheck['contents_filepath']);
			$ins_obj->update(false, 'schedule', $dataarr, 'class_id=' . $row['class_id']);
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
	public function updata_account($account_id, $login_name, $login_pass, $class_id, $user_name, $user_flag)
	{
		$obj = new cchange_ex();
		if (!empty($login_pass)) {
			$seed = null;
			$hash_pass = null;
			for ($i = 1; $i <= 8; $i++) {
				$seed .= substr('0123456789abcdef', rand(0, 15), 1);
			}
			$hash_pass = hash("md5", $seed . $login_pass) . $seed;
			$dataarr = array();
			$dataarr['account_id'] = (int)$account_id;
			$dataarr['login_name'] = (string)$login_name;
			$dataarr['login_pass'] = (string)$hash_pass;
			$dataarr['class_id'] = (int)$class_id;
			$dataarr['user_name'] = (string)$user_name;
			$dataarr['user_flag'] = (int)$user_flag;
		} else {
			$dataarr = array();
			$dataarr['account_id'] = (int)$account_id;
			$dataarr['login_name'] = (string)$login_name;
			$dataarr['class_id'] = (int)$class_id;
			$dataarr['user_name'] = (string)$user_name;
			$dataarr['user_flag'] = (int)$user_flag;
		}
		$obj->update(false, 'account', $dataarr, 'account_id=' . $account_id);
	}
	//デリート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDで指定したアカウントレコードを削除
	@param[in]	$id	アカウントID
	@return 無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_account($id)
	{
		$obj = new cchange_ex();
		$obj->delete(false, 'account', 'account_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラスIDでアカウントレコード内の該当するアカウント削除
	@param[in]	$id	クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_classaccount($id)
	{
		$obj = new cchange_ex();
		$obj->delete(false, 'account', 'class_id=' . $id);
	}


	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}
//配布物クラス
class chandout extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
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
	public function get_all($column = "handout.*")
	{
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
		while ($row = $this->fetch_assoc()) {
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
	public function get_tgt($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"handout,class",	//取得するテーブル
			"handout.class_id = class.class_id AND handout.handout_id=" . $id,	//条件
			"handout.handout_id asc"
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_handout_constents($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"handout",	//取得するテーブル
			"handout.handout_id=" . $id,	//条件
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
	public function insert_handout($class_id, $title, $contents_handout, $handoutarr)
	{
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (string)$class_id;
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_handout'] = (string)$contents_handout;
		$handout_id = $obj->insert(false, 'handout', $dataarr);
		if (!empty($handoutarr['name'])) {
			$handfile_obj = new chandfile();
			$handfile_obj->insert_handfile($handout_id, $handoutarr);
		}
	}
	//アップデート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	配布物テーブルレコードの情報を更新する
	@param[in]	$class_id		クラスID
	@param[in]	$date		日付（yyyy-mm-dd hh:mm:ss）
	@param[in]	$title		タイトルネーム
	@param[in]	$constents_handout		配布物内容
	*/
	//--------------------------------------------------------------------------------------
	public function updata_handout($class_id, $handout_id, $title, $contents_handout, $handoutarr = [])
	{
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (string)$class_id;
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_handout'] = (string)$contents_handout;
		$obj->update(false, 'handout', $dataarr, 'handout_id=' . $handout_id);
		if (!empty($handoutarr['name'])) {
			$handfile_obj = new chandfile();
			$handfile_obj->update_handfile($handout_id, $handoutarr);
		}
	}

	//デリート記述枠
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルを削除する際に外部キーにしている配布物レコードを削除
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_classhandout($id)
	{
		$obj = new cchange_ex();
		$obj->delete(false, 'handout', 'class_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	handout_idに対応する配布物レコードを削除
	@param[in]	$id		handout_id
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_handout($id)
	{
		$obj = new cchange_ex();
		$handfile_obj = new chandfile();
		$handfile_list = [];
		$handfile_list = $handfile_obj->get_all_handfile($id);
		foreach ($handfile_list as $arr) {
			unlink($arr['filepath']);
		}
		$obj->delete(false, 'handfile', 'handout_id=' . $id);
		$obj->delete(false, 'handout', 'handout_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}
//配布物ファイルクラス
class chandfile extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	配布物IDから配布物ファイルテーブルのファイルパスを取得
	@param[in]	$id		配布物ID（配布物テーブル）
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_handfile($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handfile.filepath",			//取得するカラム
			"handout,handfile",	//取得するテーブル
			"handout.handout_id=handfile.handout_id AND handfile.handout_id=" . $id,	//条件
			"handfile_id asc"
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	配布物IDから配布物ファイルテーブルのファイルパスを全て取得
	@param[in]	$id		配布物ID（配布物テーブル）
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_all_handfile($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"handfile.filepath",			//取得するカラム
			"handout,handfile",	//取得するテーブル
			"handout.handout_id=handfile.handout_id AND handfile.handout_id=" . $id,	//条件
			"handfile_id asc"
		);
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//インサート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	handfileにパスとかを追加する関数
	@param[in]	$id		handout_id
	@param[in]	$handfile	配布物ファイルのパス
	*/
	//--------------------------------------------------------------------------------------
	public function insert_handfile($id, $handfile)
	{
		$obj = new cchange_ex();
		for ($i = 0; $i < count($handfile["name"]); $i++) {
			$file_ext = pathinfo($handfile["name"][$i], PATHINFO_EXTENSION);	# 拡張子を取得する
			if (mb_strlen($file_ext) == 0) {	//文字数をカウントして0ならこの処理をおわらせる
				break;
			}
			$time_now = ceil(microtime(true) * 1000);								# 現在の時間を取得する
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
			move_uploaded_file($handfile["tmp_name"][$i], $file_name_new);		# ファイルの移動を行う
			$dataarr['handout_id'] = (int)$id;									# 配列に挿入するデータを格納
			$dataarr['filepath'] = (string)$file_name_new;

			$obj->insert(false, 'handfile', $dataarr);							# 挿入処理
		}
	}
	//アップデート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	handfileにパスとかを更新する関数（delete→insert）
	@param[in]	$id		handout_id
	@param[in]	$blogfile	配布物ファイルのパス
	*/
	//--------------------------------------------------------------------------------------
	public function update_handfile($id, $handfile)
	{
		$obj = new cchange_ex();
		$handfile_obj = new chandfile();
		$handfile_list = [];
		$handfile_list = $handfile_obj->get_all_handfile($id);
		foreach ($handfile_list as $arr) {
			unlink($arr['filepath']);
		}
		$obj->delete(false, 'handfile', 'handout_id =' . $id);
		for ($i = 0; $i < count($handfile["name"]); $i++) {
			$file_ext = pathinfo($handfile["name"][$i], PATHINFO_EXTENSION);	# 拡張子を取得する	
			if (mb_strlen($file_ext) == 0) {	//文字数をカウントして0ならこの処理をおわらせる
				break;
			}
			$time_now = ceil(microtime(true) * 1000);								# 現在の時間を取得する			
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）			
			move_uploaded_file($handfile["tmp_name"][$i], $file_name_new);		# ファイルの移動を行う
			$dataarr['handout_id'] = (int)$id;									# 配列に挿入するデータを格納
			$dataarr['filepath'] = (string)$file_name_new;

			$obj->insert(false, 'handfile', $dataarr);							# 挿入処理
		}
	}
	//デリート
}
//献立クラス
class clunch extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
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
	public function get_lunch_filepath($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"filepath",			//取得するカラム
			"lunch",	//取得するテーブル
			"class_id=" . $id,	//条件
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
class cschedule extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}

	//インサート

	//アップデート
}
//ブログクラス
class cweblog extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
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
	public function get_weblog_data($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"weblog.weblog_id,weblog.date,weblog.title,weblog.contents_weblog",			//取得するカラム
			"account,class,weblog",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=weblog.class_id AND account.account_id=" . $id,	//条件
			"weblog.date desc"
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_weblog_filepath_list($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"weblogfile.filepath",			//取得するカラム
			"weblog,weblogfile",	//取得するテーブル
			"weblog.weblog_id = weblogfile.weblog_id AND weblog.weblog_id = " . $id,	//条件
			"weblogfile.weblogfile_id asc"
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
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
	public function get_weblog_content($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"weblog",	//取得するテーブル
			"weblog_id = " . $id,	//条件
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
	public function insert_weblog($account_id, $title, $contents_weblog, $weblogarr)
	{
		$acc_obj = new cclass();
		$class_id [] = $acc_obj->get_class_accoid($account_id);
		$weblog_obj = new cweblog();
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id[0]["class_id"];
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_weblog'] = (string)$contents_weblog;
		$weblog_id = $obj->insert(false, 'weblog', $dataarr);
		if (!empty($weblogarr)) {
			$weblog_obj = new cweblog();
			$weblog_obj->insert_weblogfile($weblog_id, $weblogarr);
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblogfileにパスとかを追加する関数
	@param[in]	$id		weblog_id
	@param[in]	$blogfile	ブログのパス
	*/
	//--------------------------------------------------------------------------------------
	public function insert_weblogfile($id, $blogfile)
	{
		$obj = new cchange_ex();
		for ($i = 0; $i < count($blogfile["name"]); $i++) {
			$file_ext = pathinfo($blogfile["name"][$i], PATHINFO_EXTENSION);	# 拡張子を取得する
			if (mb_strlen($file_ext) == 0) {	//文字数をカウントして0ならこの処理をおわらせる
				break;
			}
			$time_now = ceil(microtime(true) * 1000);								# 現在の時間を取得する
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
			move_uploaded_file($blogfile["tmp_name"][$i], $file_name_new);		# ファイルの移動を行う
			$dataarr['weblog_id'] = (int)$id;									# 配列に挿入するデータを格納
			$dataarr['filepath'] = (string)$file_name_new;

			$obj->insert(false, 'weblogfile', $dataarr);							# 挿入処理
		}
	}
	//アップデート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblogテーブルの情報を更新する関数、weblogfileテーブルのパスは一回消してから挿入するようにする
	@param[in]	$account_id		アカウントID
	@param[in]	$date		日付（yyyy-mm-dd hh:mm:ss）
	@param[in]	$title		タイトルネーム
	@param[in]	$constents_weblog		ブログ内容
	@param[in]	$weblogarr		ファイルの名前が入ってる配列
	*/
	//--------------------------------------------------------------------------------------
	public function update_weblog($account_id, $weblog_id, $title, $contents_weblog, $weblogarr = [])
	{
		$acc_obj = new cclass();
		$class_id [] = $acc_obj->get_class_accoid($account_id);
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id[0]["class_id"];
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_weblog'] = (string)$contents_weblog;
		$obj->update(false, 'weblog', $dataarr, 'weblog_id = ' . $weblog_id);
		if (!empty($weblogarr['name'])) {
			$weblog_obj = new cweblog();
			$weblog_obj->update_weblogfile($weblog_id, $weblogarr);
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblogfileにパスとかを更新する関数（delete→insert）
	@param[in]	$id		weblog_id
	@param[in]	$blogfile	ブログのパス
	*/
	//--------------------------------------------------------------------------------------
	public function update_weblogfile($id, $blogfile)
	{
		$obj = new cchange_ex();
		$weblogfile_obj = new cweblog();
		$weblogfile_list = [];
		$weblogfile_list = $weblogfile_obj->get_weblog_filepath_list($id);
		foreach ($weblogfile_list as $arr) {
			unlink($arr['filepath']);
		}
		$obj->delete(false, 'weblogfile', 'weblog_id =' . $id);
		for ($i = 0; $i < count($blogfile["name"]); $i++) {
			$file_ext = pathinfo($blogfile["name"][$i], PATHINFO_EXTENSION);	# 拡張子を取得する	
			if (mb_strlen($file_ext) == 0) {	//文字数をカウントして0ならこの処理をおわらせる
				break;
			}
			$time_now = ceil(microtime(true) * 1000);								# 現在の時間を取得する			
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）			
			move_uploaded_file($blogfile["tmp_name"][$i], $file_name_new);		# ファイルの移動を行う
			$dataarr['weblog_id'] = (int)$id;									# 配列に挿入するデータを格納
			$dataarr['filepath'] = (string)$file_name_new;

			$obj->insert(false, 'weblogfile', $dataarr);							# 挿入処理
		}
	}
	//デリート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルを削除する際に外部キーにしているブログレコードを削除
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_classweblog($id)
	{
		$obj = new cchange_ex();
		$obj->delete(false, 'weblog', 'class_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblog_idに対応するブログレコードを削除
	@param[in]	$id		ブログID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_weblog($id)
	{
		$obj = new cchange_ex();
		$weblogfile_obj = new cweblog();
		$weblogfile_list = [];
		$weblogfile_list = $weblogfile_obj->get_weblog_filepath_list($id);
		foreach ($weblogfile_list as $arr) {
			unlink($arr['filepath']);
		}
		$obj->delete(false, 'weblogfile', 'weblog_id=' . $id);
		$obj->delete(false, 'weblog', 'weblog_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}
//目安箱クラス
class csuggestion extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	アカウントIDからe_suggestionboxテーブルのID、日付、タイトル、内容を取得
	@param[in]	$id		アカウントID
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_suggestionbox_data($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"e_suggestionbox.suggestion_id,e_suggestionbox.date,e_suggestionbox.title,e_suggestionbox.contents_suggestion",			//取得するカラム
			"account,class,e_suggestionbox",	//取得するテーブル
			"account.class_id=class.class_id AND class.class_id=e_suggestionbox.class_id AND account.account_id=" . $id,	//条件
			"e_suggestionbox.date desc"
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	suggestion_idからe_suggestionfileテーブルのpathリストを取得
	@param[in]	$id suggestion_id
	@return	配列（2次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_suggestion_filepath_list($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"e_suggestionfile.filepath",			//取得するカラム
			"e_suggestionbox,e_suggestionfile",	//取得するテーブル
			"e_suggestionbox.suggestion_id = e_suggestionfile.suggestion_id AND e_suggestionbox.suggestion_id = " . $id,	//条件
			"e_suggestionfile.suggestionfile_id	 asc"
		);
		$arr = [];
		//順次取り出す
		while ($row = $this->fetch_assoc()) {
			$arr[] = $row;
		}
		//取得した配列を返す
		return $arr;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	suggestion_idから内容を取得
	@param[in]	$id suggestion_id
	@return	配列（1次元配列になる）空の場合はfalse
	*/
	//--------------------------------------------------------------------------------------
	public function get_suggestion_content($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"*",			//取得するカラム
			"e_suggestionbox",	//取得するテーブル
			"suggestion_id = " . $id,	//条件
			"suggestion_id asc"
		);
		//順次取り出す
		$row = $this->fetch_assoc();
		//取得した配列を返す
		return $row;
	}

	//インサート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	e_suggestionboxテーブルに挿入する情報追加、ファイルはパスをe_suggestionfileテーブルに追加する関数
	@param[in]	$account_id		アカウントID
	@param[in]	$date		日付（yyyy-mm-dd hh:mm:ss）
	@param[in]	$title		タイトルネーム
	@param[in]	$contents_suggestion		目安箱内容
	@param[in]	$weblogarr		ファイルの名前が入ってる配列
	*/
	//--------------------------------------------------------------------------------------
	public function insert_e_suggestionbox($account_id, $title, $contents_suggestion, $suggestionarr)
	{
		$acc_obj = new cclass();
		$class_id [] = $acc_obj->get_class_accoid($account_id);
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id[0]["class_id"];
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_suggestion'] = (string)$contents_suggestion;
		$suggestion_id = $obj->insert(false, 'e_suggestionbox', $dataarr);
		if (!empty($suggestionarr)) {
			$suggestion_obj = new csuggestion();
			$suggestion_obj->insert_suggestionfile($suggestion_id, $suggestionarr);
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	suggestionfileにパスとかを追加する関数
	@param[in]	$id		weblog_id
	@param[in]	$blogfile	ブログのパス
	*/
	//--------------------------------------------------------------------------------------
	public function insert_suggestionfile($id, $suggestionfile)
	{
		$obj = new cchange_ex();
		for ($i = 0; $i < count($suggestionfile["name"]); $i++) {
			$file_ext = pathinfo($suggestionfile["name"][$i], PATHINFO_EXTENSION);	# 拡張子を取得する
			if (mb_strlen($file_ext) == 0) {	//文字数をカウントして0ならこの処理をおわらせる
				break;
			}
			$time_now = ceil(microtime(true) * 1000);								# 現在の時間を取得する
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）
			move_uploaded_file($suggestionfile["tmp_name"][$i], $file_name_new);		# ファイルの移動を行う
			$dataarr['suggestion_id'] = (int)$id;									# 配列に挿入するデータを格納
			$dataarr['filepath'] = (string)$file_name_new;

			$obj->insert(false, 'e_suggestionfile', $dataarr);							# 挿入処理
		}
	}
	//アップデート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	e_suggestionboxテーブルの情報を更新する関数、suggestionfileテーブルのパスは一回消してから挿入するようにする
	@param[in]	$account_id		アカウントID
	@param[in]	$date		日付（yyyy-mm-dd hh:mm:ss）
	@param[in]	$title		タイトルネーム
	@param[in]	$constents_suggestion		目安箱内容
	@param[in]	$weblogarr		ファイルの名前が入ってる配列
	*/
	//--------------------------------------------------------------------------------------
	public function update_e_suggestionbox($account_id, $suggestion_id, $title, $contents_suggestion, $suggestionarr)
	{
		$acc_obj = new cclass();
		$class_id [] = $acc_obj->get_class_accoid($account_id);
		$obj = new cchange_ex();
		$date = date("Y-m-d H:i:s");
		$dataarr = array();
		$dataarr['class_id'] = (int)$class_id[0]["class_id"];
		$dataarr['date'] = $date;
		$dataarr['title'] = (string)$title;
		$dataarr['contents_suggestion'] = (string)$contents_suggestion;
		$obj->update(false, 'e_suggestionbox', $dataarr, 'suggestion_id = ' . $suggestion_id);
		if (!empty($suggestionarr['name'])) {
			$suggestion_obj = new csuggestion();
			$suggestion_obj->update_suggestionfile($suggestion_id, $suggestionarr);
		}
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblogfileにパスとかを更新する関数（delete→insert）
	@param[in]	$id		suggestion_id
	@param[in]	$blogfile	ブログのパス
	*/
	//--------------------------------------------------------------------------------------
	public function update_suggestionfile($id, $suggestionfile)
	{
		$obj = new cchange_ex();
		$suggestionfile_obj = new csuggestion();
		$suggestionfile_list = [];
		$suggestionfile_list = $suggestionfile_obj->get_suggestion_filepath_list($id);
		foreach ($suggestionfile_list as $arr) {
			unlink($arr['filepath']);
		}
		$obj->delete(false, 'e_suggestionfile', 'suggestion_id =' . $id);
		for ($i = 0; $i < count($suggestionfile["name"]); $i++) {
			$file_ext = pathinfo($suggestionfile["name"][$i], PATHINFO_EXTENSION);	# 拡張子を取得する	
			if (mb_strlen($file_ext) == 0) {	//文字数をカウントして0ならこの処理をおわらせる
				break;
			}
			$time_now = ceil(microtime(true) * 1000);								# 現在の時間を取得する			
			$file_name_new = "../../updata/" . $time_now . "." . $file_ext;		# 保存先のファイルパスを生成する（実戦運用する場合、排他処理を考慮して保存先のファイル名を生成する必要があります）			
			move_uploaded_file($suggestionfile["tmp_name"][$i], $file_name_new);		# ファイルの移動を行う
			$dataarr['suggestion_id'] = (int)$id;									# 配列に挿入するデータを格納
			$dataarr['filepath'] = (string)$file_name_new;

			$obj->insert(false, 'e_suggestionfile', $dataarr);							# 挿入処理
		}
	}
	//デリート
	//--------------------------------------------------------------------------------------
	/*!
	@brief	クラステーブルを削除する際に外部キーにしている目安箱レコードを削除
	@param[in]	$id		クラスID
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_class_suggestionbox($id)
	{
		$obj = new cchange_ex();
		$obj->delete(false, 'e_suggestionbox', 'class_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	weblog_idに対応するブログレコードを削除
	@param[in]	$id		suggestion_id
	@return	無し
	*/
	//--------------------------------------------------------------------------------------
	public function delete_suggestion($id)
	{
		$obj = new cchange_ex();
		$suggestionfile_obj = new csuggestion();
		$suggestionfile_list = [];
		$suggestionfile_list = $suggestionfile_obj->get_suggestion_filepath_list($id);
		foreach ($suggestionfile_list as $arr) {
			unlink($arr['filepath']);
		}
		$obj->delete(false, 'e_suggestionfile', 'suggestion_id=' . $id);
		$obj->delete(false, 'e_suggestionbox', 'suggestion_id=' . $id);
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	デストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __destruct()
	{
		//親クラスのデストラクタを呼ぶ
		parent::__destruct();
	}
}
//いいねクラス
class clikes extends crecord
{
	//--------------------------------------------------------------------------------------
	/*!
	@brief	コンストラクタ
	*/
	//--------------------------------------------------------------------------------------
	public function __construct()
	{
		//親クラスのコンストラクタを呼ぶ
		parent::__construct();
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	いいねの合計を返す関数
	@param[in]	$id		suggestion_id
	@return	1次元
	*/
	//--------------------------------------------------------------------------------------
	public function count_likes($id)
	{
		if (
			!cutil::is_number($id)
			||  $id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"count(*)",			//取得するカラム
			"like_suggestion",	//取得するテーブル
			"suggestion_id=" . $id,	//条件
			"like_id asc"
		);

		//いいねカウント
		$row = $this->fetch_assoc();
		//いいねの合計を返す
		return $row;
	}
	//--------------------------------------------------------------------------------------
	/*!
	@brief	既にいいねがされているかどうかのチェック関数
	@param[in]	$account_id		アカウントID
	@param[in]	$suggestion_id		suggestion_id
	@return	bool true or false
	*/
	//--------------------------------------------------------------------------------------
	public function check_likes($account_id, $suggestion_id)
	{
		if (
			!cutil::is_number($account_id)
			||  $account_id < 1
		) {
			//falseを返す
			return false;
		}
		//親クラスのselect()メンバ関数を呼ぶ
		$this->select(
			false,			//デバッグ表示するかどうか
			"like_id",			//取得するカラム
			"like_suggestion",	//取得するテーブル
			'account_id = ' . $account_id . ' and suggestion_id = ' . $suggestion_id
		);
		$row = $this->fetch_assoc();
		if (empty($row)) {
			return false;
		} else {
			return true;
		}
	}
	//インサート
	//--------------------------------------------------------------------------------------
	/*!
	@brief　いいね実行時にアカウントIDとsuggestion_idを挿入する関数
	@param[in]	$account_id		アカウントID
	@param[in]	$suggestion_id		suggestion_id
	*/
	//--------------------------------------------------------------------------------------
	public function insert_likes($account_id, $suggestion_id)
	{
		if ($this->check_likes($account_id, $suggestion_id)) {
			$this->delete_likes($account_id, $suggestion_id);
		} else {
			$ins_obj = new cchange_ex();
			$dataarr['account_id'] = $account_id;
			$dataarr['suggestion_id'] = $suggestion_id;
			$ins_obj->insert(false, 'like_suggestion', $dataarr);
		}
	}

	//デリート
	//--------------------------------------------------------------------------------------
	/*!
		@brief　いいねを解除する際にアカウントIDとsuggestion_idを削除する関数
		@param[in]	$account_id		アカウントID
		@param[in]	$suggestion_id		suggestion_id
		*/
	//--------------------------------------------------------------------------------------
	public function delete_likes($account_id, $suggestion_id)
	{
		$ins_obj = new cchange_ex();
		$ins_obj->delete(false, 'like_suggestion', 'account_id = ' . $account_id . ' and suggestion_id = ' . $suggestion_id);
	}
}
