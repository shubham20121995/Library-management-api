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

    public function issue_book($registration_no,$book_id,$date_of_issue,$return_date)
    {
        $query1 = "Select * from users where registration_no ='$registration_no'";
		$result1 = mysqli_query($this->connection,$query1);
		if(mysqli_num_rows($result1)>0)
		{
			
		$query = "Select * from all_books where book_id ='$book_id'";
        $result = mysqli_query($this->connection,$query);
		$row =mysqli_fetch_assoc($result);
        if($result && ($row['no_of_copies']>0))
		{
			$no_of_copies=$row['no_of_copies']-1;
			$query2 = "update all_books set no_of_copies ='$no_of_copies' where book_id ='$book_id'";
			$book_name=$row['book_name'];
			$query3 = "insert into books_issued values('$registration_no','$book_id','$book_name','$date_of_issue','$return_date','','')";
			$result2 = mysqli_query($this->connection,$query2);
			$result3 = mysqli_query($this->connection,$query3);
			if($result2 && $result3)
			{
			  	$json['success'] = '1'; // book issued
			}
			else if (!($result2) && $result3){
				$query4 = "delete from books_issued where registration_no ='$registration_no' and book_id='$book_id'";
			    $result4 = mysqli_query($this->connection,$query4);
				$json['success'] = '4'; //only for testing
			}
			else if ($result2 && !($result3)){
				$no_of_copies2=$row['no_of_copies'];
				$query5 = "update all_books set no_of_copies ='$no_of_copies2' where book_id ='$book_id'";
			    $result5 = mysqli_query($this->connection,$query5);
				$json['success'] = '6'; //book already issued
			}
			else{
				$json['success'] = '7'; //only for testing
			}
		}
					
		else{
			$json['success'] = '0'; // book not available
		}
		}else{
			$json['success'] = '5'; // invalid registration number
		}
		
            echo json_encode($json);
            mysqli_close($this -> connection);
        

    }

}


$user = new User();
if(isset($_POST['registration_no'],$_POST['book_id'],$_POST['date_of_issue'],$_POST['return_date'])){
    $registration_no = $_POST['registration_no'];
	$book_id = $_POST['book_id'];
    $date_of_issue = $_POST['date_of_issue'];
	$return_date = $_POST['return_date'];
	     
    if(!empty($registration_no) && !empty($book_id) && !empty($date_of_issue) && !empty($return_date)){
 
        $user->issue_book($registration_no,$book_id,$date_of_issue,$return_date);

    }else{
        $json['success'] = '3'; // empty parameter
		echo json_encode($json);
    }

}
?>
