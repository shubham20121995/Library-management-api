<?php
include_once 'connection.php';
header('Content-Type: application/json');
$_POST = json_decode(file_get_contents('php://input'), true);
class User {

    private $db;
    private $connection;

    function __construct() {
        $this -> db = new DB_Connection();
        $this -> connection = $this->db->getConnection();
    }

    public function signup($reg_no,$name,$password)
    {
        $query = "insert into users values('$reg_no','$name','$password')";
        $result = mysqli_query($this->connection,$query);
        
		if($result){
		$json['success'] = '1';
		}		
		else{
			$json['success'] = '0';
		}
		
            echo json_encode($json);
            mysqli_close($this -> connection);
        

    }

}


$user = new User();
if(isset($_POST['registration_no'],$_POST['name'],$_POST['password'])){
    $reg_no = $_POST['registration_no'];
	 $name = $_POST['name'];
    $password = $_POST['password'];
     
    if(!empty($reg_no) && !empty($password) && !empty($name)){
 
        $encrypted_password = md5($password);
        $user->signup($reg_no,$name,$password);

    }else{
        $json['success'] = '3';
    }

}
?>
