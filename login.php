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

    public function does_user_exist($reg_no,$password)
    {
        $query = "Select * from users where registration_no='$reg_no' and password = '$password' ";
        $result = mysqli_query($this->connection,$query);
        $row =mysqli_fetch_assoc($result);
		if(mysqli_num_rows($result)>0){
		$json['success'] = 'true';
		$json['name'] = $row['name'];
		$json['registration_no'] = $row['registration_no'];}
		
		else{
			$json['success'] = ' false ';
		}
		
            echo json_encode($json);
            mysqli_close($this -> connection);
        

    }

}


$user = new User();
if(isset($_POST['registration_no'],$_POST['password'])){
    $reg_no = $_POST['registration_no'];
    $password = $_POST['password'];
     
    if(!empty($reg_no) && !empty($password)){
 
        $encrypted_password = md5($password);
        $user->does_user_exist($reg_no,$password);

    }else{
        echo json_encode("you must type both inputs");
    }

}
?>
