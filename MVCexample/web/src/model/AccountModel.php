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
     * Loads account information from the database
     *
     * @param int $id Account ID
     *
     * @return $this AccountModel
     */
    public function load($id)
    {
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `id` = $id;")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->name = $result['name'];
        $this->id = $id;

        return $this;
    }

    /**
     * Saves account information to the database
     *
     * @return $this AccountModel
     */
    public function save()
    {
        $name = $this->name ?? "NULL";
        if (!isset($this->id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$name');")) {
                // throw new ...
            }
            $this->id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE `account` SET `name` = '$name' WHERE `id` = $this->id;")) {
                // throw new ...
            }
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
