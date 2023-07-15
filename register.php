<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

//change done here...
$rollno="";
$mobileno="";
if ($_SERVER['REQUEST_METHOD'] == "POST"){
   $rollno=$_POST['rollno'];
   $mobileno=$_POST['mobileno'];
//    echo $mobileno;
//    die();
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rollno = $_POST['rollno'];
        $mobileno = $_POST['mobileno'];
        
       

        $sql = "INSERT INTO users (username, password,rollno, mobileno)
        VALUES ('$username','$password','$rollno','$mobileno')";

        if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        }
        echo "data inserted";
        die();
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username/email is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
/*if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}*/


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err))
{
    $sql = "INSERT INTO users (username, password,rollno,mobileno) VALUES (?, ?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        //change done here ss added.
        mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_rollno, $param_mobileno);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_rollno = $rollno;
        $param_mobileno =$mobileno;
        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>



<!DOCTYPE html>
<html>
<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
</head>
<body>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form action="" method ="post">

				<!-- <img src="img/avatar.svg"> -->
				<h2 class="title">Sign-Up</h2>
                <!-- <--edit from here--> 
                <!-- <form action="" method="post"> -->
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
                    <!-- <div class="form-row"> -->
           		   		 <h5>username</h5>
                        <!-- <<label for="inputemail14">username</label> -->
           		   		<input type="text" class="input" name="username">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	 <h5>Password</h5>
                        <!-- <label for="inputPassword14">password</label> -->
           		    	<input type="password" class="input" name="password">
            	   </div>
				</div>
				<div class="input-div pass">
					<div class="i"> 
						 <i class="fas fa-lock"></i>
					</div>
					<div class="div">
						 <h5>Roll Number</h5>
                         <!-- <label for= "inputroll">roll no</label> -->
						 <!-- <input type="number" class="form-control"  name="roll no"id="inputroll"  paceholder="roll no"> -->
                         <input type="number" class="input" name="rollno">
				 </div>
			  </div>

			  <div class="input-div pass">
				<div class="i"> 
					 <i class="fas fa-lock"></i>
				</div>
				<div class="div">
					 <h5>Mobile Number</h5>
                     <!-- <label for="inputmo">mobile no</label> -->
					 <!-- <input type="number" class="form-control" name="mobile no" id="inputmo" paceholder="mobile no"> -->
                     <input type="number" class="input" name="mobileno">
			 </div>
		  </div>
			  
            	<input type="submit" class="btn" value="Sign-Up">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>