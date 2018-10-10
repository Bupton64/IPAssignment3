<?php
namespace agilman\a2\model;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class AccountModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountModel extends Model
{
    /**
     * @var integer Account ID
     */
    private $id;
    /**
     * @var string Account Name
     */
    private $name;
    /**
     * @var
     */
    private $username;
    /**
     * @var
     */
    private $email;
    /**
     * @var
     */
    private $password;

    /**
     * @return int Account ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string Account Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name Account name
     *
     * @return $this AccountModel
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Loads account information from the database
     *
     * @param int $id Account ID
     *
     * @return $this AccountModel
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
     * Currently only occurs on account creation
     *
     * @return $this AccountModel
     */
    public function save()
    {
        // NO Sql protection
        $name = $this->name ?? "NULL";
        $username = $this->username ?? "NULL";
        $email= $this->email ?? "NULL";
        $password = $this->username ?? "NULL";
        if (!isset($this->id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$name','$username','$email','$password');")) {
                throw new \mysqli_sql_exception($this->db->error, $this->db->errno);
            }
            $this->id = $this->db->insert_id;
        }
        return $this;
    }


    /**
     * This function sends a confirmation to users email  when account has been created.
     * To be completed
     */
    public function sendConfirmationEmail(){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'user@example.com';                 // SMTP username
            $mail->Password = 'secret';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Account Creation';
            $mail->Body    = 'Welcome to ToolStocker, Your Account has been <b>Created!</b>.';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }


    /**
     * Deletes account from the database

     * @return $this AccountModel
     */
    public function delete()
    {
        if (!$result = $this->db->query("DELETE FROM `account` WHERE `account`.`id` = $this->id;")) {
            //throw new ...
        }
        return $this;
    }
}
