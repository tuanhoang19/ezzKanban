<?php
class UserModel extends Database{
    function getUser()
    {
        $query="SELECT * FROM USER";
        $result=mysqli_query($this->con,$query);
        while ($row = mysqli_fetch_assoc($result)){
            var_dump($row);
        }
        mysqli_free_result($result);
    }
    function addUser($email,$password)
    {

    }
}