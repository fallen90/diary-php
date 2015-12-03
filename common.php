<?php
define('AVATARS_LOCATION', 'assets/avatars/');
define('DB_NAME','diary');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');

class User {

	private $db;
	private $id;
	public function __construct($id){
		$this->db = new Database();
		$this->id = $id;

		return $this->get($id);
	}
	public function get($id =''){
		if($id == ''){
			return $this->db->select('users','*',['user_id' => $this->id]);
		} else {
			return $this->db->select('users','*',['user_id' => $id]);
		}
	}
}
class Post {

	private $db;

	public function __construct(){
		$this->db = new Database();
	}
	public function create($user, $body){
		if(!$this->check_duplicate($body)){
			return $this->db->insert('posts',[
				"user_id" => $user,
				"post_body" => $body
			]);
		} else {
			return false;
		}
	}
	public function get_all(){
		$sql  ='SELECT p.post_id, p.post_body, p.post_timestamp, u.user_id, u.user_name, u.user_fullname FROM posts as p JOIN users as u ON p.user_id=u.user_id ORDER BY p.post_timestamp DESC';
		// return $this->db->select('posts','*','ORDER BY post_timestamp DESC',true);
		return $this->db->query($sql);
	}
	public function get_all_with_comments(){
		$sql = 'SELECT p.post_id, p.post_body, p.post_timestamp, c.comment_id, c.comment_body, c.comment_timestamp, u.user_fullname, u.user_name FROM posts as p JOIN comments as c ON c.post_id=p.post_id JOIN users as u ON p.user_id=u.user_id AND c.user_id=u.user_id ORDER BY p.post_timestamp DESC, c.comment_timestamp DESC';
		$records = $this->db->query($sql);
		$return_records = [];
		foreach($records as $record){
			$return_records[] = $record;
		}
		return $return_records;
	}
	public function check_duplicate($body){
		$results = $this->db->select('posts',['post_body'],['post_body' => $body], true);
		return $results;
	}
}
class Comment {
	private $db;
	private $post_id;
	public function __construct($post_id){
		$this->db = new Database();
		$this->post_id = $post_id;
	}
	public function get_all(){
		$sql = "SELECT c.comment_id, c.comment_body, c.comment_timestamp, u.user_name, u.user_fullname FROM comments as c JOIN users as u ON c.user_id=u.user_id WHERE c.post_id='$this->post_id' ORDER BY c.comment_timestamp ASC;";
		$records = $this->db->query($sql);
		return $records;
		// $this->db->select("comments","*",);
	}
	public function create($user, $post_id, $body){
		if(!$this->check_duplicate($body, $post_id)){
			return $this->db->insert('comments',[
				"user_id" => $user,
				"post_id" => $post_id,
				"comment_body" => $body
			]);
		} else {
			return false;
		}
	}
	public function check_duplicate($body, $post_id){
		$results = $this->db->select('comments',['comment_body'],['comment_body' => $body, 'post_id' => $post_id], true);
		return $results;
	}
}
class Database {
	private $link;

	public function __construct(){
		$this->link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}

	public function query($sql){
		$activity = "INSERT INTO activity (`activity_type`, `activity_row_id`,`activity_sql`) VALUES('query','NULL','" . mysql_real_escape_string($sql) . "')";
		$this->link->query($activity);
		$result = $this->link->query($sql);
		if (!$this->link->connect_errno) {
            return $result;
        } else {
            return false;
        }
	}
	public function select($tbl, $fields ='*', $where = "", $multi = false){
		if($fields != "*"){
            $fields = "`" . implode("`,`",$fields) . "`";
        }

        if(is_array($where)){
        	$where_arr = [];
        	foreach ($where as $key => $value) {
        		$where_arr[] = "`$key`='$value'";
        	}
        	$where = "WHERE " . implode($where_arr, " AND ");
        }

        $sql = "SELECT $fields from `$tbl` $where";

        if($multi){
            $data = [];
            foreach ($this->query($sql) as $value) {
                $data[] = $value;
            }
            return $data;
        } else {
            return $this->query($sql)->fetch_assoc();
        }
	}

	public function insert($tbl, $data){
			$sql = "INSERT INTO `$tbl` " . $this->create_insert_data($data);
			$this->link->query($sql);
			return mysqli_insert_id($this->link);
	}
	private function create_insert_data($data){
		$fields = array_keys($data);
		$values = array_values($data);

		foreach($values as $key=>$value){
			$values[$key] = mysqli_escape_string($this->link, $value);
		}

		$fields_str = "(`" . implode($fields,"`,`") . "`)";
		$values_str = "('" . implode($values, "','") . "')";
		return $fields_str . " VALUES" . $values_str;
	}
}

class Template {
	private $file_contents ="";
	public function __construct($file_contents){
		$this->file_contents = $file_contents;
	}
	public function inject($data){
		foreach($data as $key=>$value){
			$this->file_contents = preg_replace("~@\[" . $key . "\]~", $value, $this->file_contents);
		}
		return $this->file_contents;
	}
}

function get_post_tpl(){
	return file_get_contents('tpl/post.tpl');
}

function get_comment_tpl(){
	return file_get_contents('tpl/comment_list.tpl');
}

function get_all_posts(){
	global $user;
	$tpl = get_post_tpl();
	$tpl_posts = "";
	$pst = new Post();
	$posts = $pst->get_all();
	if(count($posts) >= 1){
		foreach($posts as $key=>$post){
			$tmpl_posts = new Template(get_post_tpl());

			$cmts = new Comment($post['post_id']);
			$comments = $cmts->get_all();
			
			if($comments->num_rows >=1){
				$tpl_comments = "";
				foreach($comments as $comment){
					$comment['comment_timestamp'] = date('h:i A, F d, o', strtotime($comment['comment_timestamp']));

					$tmpl_comments = new Template(get_comment_tpl());
					$tpl_comments .= $tmpl_comments->inject($comment);
				}
				
				$post['comment_list'] = $tpl_comments;
				$post['comment_count'] = $comments->num_rows;

			} else {
				$post['comment_count'] = 0;
				$post['comment_list'] = '';
			}
			$post['current_user_id'] = $user['user_id'];
			$post['current_user_name'] = $user['user_name'];
			$post['post_timestamp'] = date('h:i A, F d, o', strtotime($post['post_timestamp']));
			$tpl_posts .= $tmpl_posts->inject($post);
			//\$tpl_posts .= sprintf($tpl, $user['user_name'],$user['user_fullname'],date('h:i A, F d, o', strtotime($post['post_timestamp'])),$post['post_body'], $post['post_id']);
		}
	}
	echo $tpl_posts;
}

function get_all_comments($post_id){

}
function placeholder(){
	$list = [
		"What's going on?",
		"Sad? Let me have it. I'll listen.",
		"Happy? Please do share. I'll be glad to listen.",
		"Gloomy? Release it all. Let it go.",
		"Angry? Rant here, I don't mind.",
		"What's on your mind?",
		"Anything to share?"
	];

	return $list[array_rand($list)];
}

function random_header(){
	$list = [
		"english|Diary",
		"spanish|Diario",
		"arabic|مذكرات",
		"czech|deník",
		"dutch|dagboek",
		"japanese|日記"
	];
	$r = explode("|", $list[array_rand($list)]);
	return [ucwords($r[0]),ucwords($r[1])];
}
