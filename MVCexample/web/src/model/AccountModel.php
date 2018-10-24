<?php
namespace agilman\a2\model;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class AccountModel
 *
 * Contains data and behaviour for the user account.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountModel extends Model
{
    /**
     * @var integer Account ID, holds the unique ID number of the account
     */
    private $id;
    /**
     * @var string Account Name, holds the name of the account holder
     */
    private $name;
    /**
     * @var string Username, holds the username of the account
     */
    private $username;
    /**
     * @var string Email, the email address specified by the account holder
     */
    private $email;
    /**
     * @var string Password, the users password (can only be retrieved in hash form once stored)
     */
    private $password;

    /**
     * @return int Account ID, returns the unique ID number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string Account Name, returns the name of the account holder
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name Account name, the name to set
     *
     * @return $this AccountModel, the modified object
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string $this->username, the username of the account
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string $this->email, the email address of the user
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email, the new email address of a user.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string $this->password, the users password, once saved the users password will always be hashed.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $username, the username to set the account to
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password, the password to assign to the account.
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


    /**
     * Loads account information from the database
     *
     * @param int $id Account ID, the id of the account to load
     *
     * @return $this AccountModel
     *
     * @throws \mysqli_sql_exception, if the SQL query fails
     */
    public function load($id)
    {
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `id` = $id;")) {
            throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
        }
        $result = $result->fetch_assoc();
        $this->name = $result['name'];
        $this->username = $result['username'];
        $this->email = $result['email'];
        $this->password = $result['password'];
        $this->id = $id;
        return $this;
    }

    /**
     * Saves account information to the database
     * Only occurs on account creation, thus no clause for update.
     *
     * @return $this AccountModel
     *
     * @throws \mysqli_sql_exception, if the SQL query fails
     */
    public function save()
    {
        $name = $this->name ?? "NULL";
        $name = mysqli_real_escape_string($this->db, $name);
        $username = $this->username ?? "NULL";
        $username = mysqli_real_escape_string($this->db, $username);
        $email = $this->email ?? "NULL";
        $email = mysqli_real_escape_string($this->db, $email);
        $password = $this->password ?? "NULL";
        $password = mysqli_real_escape_string($this->db, $password);
        if (!isset($this->id)) {
            // New account - Perform INSERT
            $password = password_hash($password, PASSWORD_BCRYPT);
            if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$name','$username','$email','$password');")) {
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
            }
            $this->id = $this->db->insert_id;
        }
        return $this;
    }

    /***
     * Checks to see that the username exists and password matches when a user
     * attempts to log in.
     *
     * @param $user string, the username submitted by the user
     * @param $pass string, the password submitted by the user
     * @return bool, True if the username is found and the password matches. Otherwise false.
     *
     * @throws \mysqli_sql_exception, if the SQL query fails
     */
    public function validateLogin($user, $pass)
    {
        $user = mysqli_real_escape_string($this->db, $user);
        $pass = mysqli_real_escape_string($this->db, $pass);
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `username` = '$user';")) {
            throw new \mysqli_sql_exception('Account select failed on login.', 100);
        }
        if ($result->num_rows == 0) {
            return false;
        }
        $result = $result->fetch_assoc();
        if (password_verify($pass, $result['password'])) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * This function sends a confirmation to users email when account has been created.
     * To be completed
     */
    public function sendConfirmationEmail()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = false;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'Toolstocker@gmail.com';                 // SMTP username
            $mail->Password = 'Bobtool22';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('Toolstocker@gmail.com', 'Toolstocker');
            $mail->addAddress($this->email, $this->name);     // Add a recipient
            $mail->addBCC('Toolstocker@gmail.com');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Toolstocker Account Confirmation';
            $mail->Body = 'Welcome to Toolstocker, ' . $this->username . ' we have confirmed your details and your account has been registered. To begin using Toolstocker, head back to our website and login!';
            $mail->AltBody = 'Welcome to Toolstocker, ' . $this->username . ' we have confirmed your details and your account has been registered. To begin using Toolstocker, head back to our website and login!';

            $mail->send();
            // echo 'Message has been sent';
        } catch (\Exception $e) {
            $this->redirect('error');
        }
    }

    /***
     * Checks whether an account with the submitted username already exists.
     *
     * @param $username string, the username to look for in the database
     * @return string, really a boolean, but read as a string for use in Javascript, Returns true
     *         if there are no existing accounts with the submitted username meaning a user can register
     *         that name.
     *
     * @throws \mysqli_sql_exception, if the SQL query fails
     */
    public function findName($username)
    {
        $username = mysqli_real_escape_string($this->db, $username);
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `account`.`username` = '$username';")) {
            throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
        }
        if ($result->num_rows == 0) {
            return 'true'; // If no other user exists with this username, return true
        } else {
            return 'false';
        }
    }
}
