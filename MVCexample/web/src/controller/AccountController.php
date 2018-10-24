<?php
namespace agilman\a2\controller;
session_start();
$_SESSION['auth'] = false;
use agilman\a2\model\{Model, AccountModel, AccountCollectionModel};
use agilman\a2\view\View;

/**
 * Class AccountController
 *
 * Manages all actions related to a user and their account.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountController extends Controller
{
    /**
     * Creates a model to ensure sample database is created.
     *
     * Displays the login page if no errors occur.
     */
    public function indexAction()
    {
        try {
            $model = new Model(); // Statement to test database
        } catch (\Exception $e) {
            $this->redirect('error');
        }
        $view = new View('loginPage');
        echo $view->render();
    }

    /**
     * Directs user to the page required for registration
     */
    public function registerAction()
    {
        $view = new View('registerPage');
        echo $view->render();
    }


    /**
     * Processes a user requests to register a new account
     */
    public function createAction()
    {
        try {
            $account = new AccountModel();
        } catch (\Exception $e) {
            $this->redirect('error');
        }
        $account->setName($_POST['name']);
        $account->setUsername($_POST['username']);
        $account->setEmail($_POST['email']);
        $account->setPassword($_POST['password']);
        try {
            $account->save();
        } catch (\Exception $e) {
            $this->redirect('error');
        }
        //$account->sendConfirmationEmail(); // replace to make zon a happy boi
        $view = new View('accountCreated');
        echo $view->addData('account', $account)->render();
    }

    /**
     *  Processes a user request to log in to the application
     *  Validates the login and redirects to the user welcome page
     *  If successful. Otherwise, returns an error.
     */
    public function loginAction()
    {
        $entered_username = $_POST["username_input"];
        $entered_password = $_POST["password_input"];
        try {
            $account = new AccountModel();
            if ($account->validateLogin($entered_username, $entered_password)) {
                $_SESSION['auth'] = true;
                $this->redirect('welcome');
            } else {
                $error_msg = 'Invalid username or password';
                $_SESSION['error'] = $error_msg;
                $this->redirect('home');
            }
        } catch (\Exception $e) {
            $this->redirect('error');
        }
    }

    /**
     * Processes the users request to log out.
     */
    public function logoutAction()
    {
        session_unset();
        $this->redirect('home');
    }
}
