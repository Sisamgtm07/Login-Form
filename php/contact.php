<?php

        $fname=$_POST['firstName'];
        $lname=$_POST['lastName'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $pass=$_POST['password'];
        $gender=$_POST['gender'];

    
        if(!empty($fnname) || !empty($lname) || !empty($address) || !empty($phone) || !empty($email) || !empty($pass) || !empty($gender))
        {
            $server="localhost";
            $username="root";
            $password="";
            $dbname="db_projectform";

            //Create connection
            $conn=new mysqli($server, $username, $password, $dbname);
            if(mysqli_connect_error()){
                die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
            }

            else{
                
                $SELECT="SELECT Email From form Where Email = ? Limit 1";
                $INSERT="INSERT Into form(Firstname,Lastname,Address,Phone, Email,Password,Gender)
                         values(? , ?, ?, ?, ?, ?, ?)";

                //Prepare Statement
                $stmt=$conn->prepare($SELECT);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($email);
                $stmt->store_result();
                $rnum=$stmt->num_rows;

                if($rnum==0)
                {
                    $stmt->close();
                    $stmt= $conn->prepare($INSERT);
                    $stmt->bind_param("sssisss",$fname,$lname,$address,$phone,$email,$pass,$gender);
                    $stmt->execute();
                    echo"New record inserted successfully";
                }else{
                    echo"You have already send the mail";
                }
                $stmt->close();
                $conn->close();

            }
        }
        else{
            echo"All field are required";
            die();
        }

?>