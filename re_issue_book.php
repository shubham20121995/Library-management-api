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

    public function re_issue_book($registration_no,$book_id,$return_date)
    {
        $query1 = "Select * from users where registration_no ='$registration_no'";
		$result1 = mysqli_query($this->connection,$query1);
		if(mysqli_num_rows($result1)>0)
		{
			
		$query = "Select * from all_books where book_id ='$book_id'";
        $result = mysqli_query($this->connection,$query);
		
        if(mysqli_num_rows($result)>0)
		{
			
			$query2 = "update books_issued set return_date ='$return_date',notification ='0' where book_id ='$book_id' and registration_no ='$registration_no'";
			
			$result2 = mysqli_query($this->connection,$query2);
			
			if($result2)
			{
			  	$json['success'] = '1'; // book re-issued
			}
			else {
				
				$json['success'] = '0'; //book not re-issued
			}
			
		}
					
		else{
			$json['success'] = '4'; // Wrong book id
		}
		}else{
			$json['success'] = '5'; // invalid registration number
		}
		
            echo json_encode($json);
            mysqli_close($this -> connection);
        

    }

}


$user = new User();
if(isset($_POST['registration_no'],$_POST['book_id'],$_POST['return_date'])){
    $registration_no = $_POST['registration_no'];
	$book_id = $_POST['book_id'];
    
	$return_date = $_POST['return_date'];
	     
    if(!empty($registration_no) && !empty($book_id) && !empty($return_date)){
 
        $user->re_issue_book($registration_no,$book_id,$return_date);

    }else{
        $json['success'] = '3'; // empty parameter
		echo json_encode($json);
    }

}
?>
