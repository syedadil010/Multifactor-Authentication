<?php

class Operation
{

    protected $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function __destruct()
    {
        $this->db = null;
    }

    /*
     * Register New User
     *
     * @param $name, $email, $username, $password, $auth_code
     * @return ID
     * */    public function Register($name, $email, $username, $password, $google_secret_code, $phone_no)
    {
        $query = $this->db->prepare("INSERT INTO users_2fa_sms(name, email, username, password, google_secret_code, phone_no) VALUES (:name,:email,:username,:password,:google_secret_code,:phone_no)");
        $query->bindParam("name", $name, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->bindParam("username", $username, PDO::PARAM_STR);
        // $enc_password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
        $query->bindParam("password", $hash, PDO::PARAM_STR);
        $query->bindParam("google_secret_code", $google_secret_code, PDO::PARAM_STR);
        $query->bindParam("phone_no", $phone_no, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }

    /*
     * Check Username
     *
     * @param $username
     * @return boolean
     * */    public function isUsername($username)
    {
        $query = $this->db->prepare("SELECT id FROM users_2fa_sms WHERE username=:username");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Check Email
     *
     * @param $email
     * @return boolean
     * */    public function isEmail($email)
    {
        $query = $this->db->prepare("SELECT id FROM users_2fa_sms WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Login
     *
     * @param $username, $password
     * @return $mixed
     * */    public function Login($username, $password)
    {
        $query = $this->db->prepare("SELECT id, password FROM users_2fa_sms WHERE username=:username OR email=:email");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("email", $username, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            $enc_password = $result->password;
            if (password_verify($password, $enc_password)) {
                return $result->id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
     * get User Details
     *
     * @param $user_id
     * @return $mixed
     * */    public function UserDetails($user_id)
    {
        $query = $this->db->prepare("SELECT id, name, username, email, google_secret_code,phone_no FROM users_2fa_sms WHERE id=:user_id");
        $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            return $query->fetch(PDO::FETCH_OBJ);
        }
    }
}
?>

