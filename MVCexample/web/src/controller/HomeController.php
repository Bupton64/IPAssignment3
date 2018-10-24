<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\AccountModel;
/**
 * Class HomeController
 *
 * Manages general redirection actions in the application.
 *
 * Some actions are protected against unauthorized access.
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class HomeController extends Controller
{
    /**
     * Displays the user welcome page to logged in users
     */
    public function indexAction()
    {
        if ($_SESSION['auth']) {
            $view = new View('userHome');
            echo $view->render();
        } else {
            session_unset();
            $this->redirect('home');
        }
    }

     /**
     * Displays the Browse page to logged in users
     */
    public function browseIndexAction()
    {
        if ($_SESSION['auth']) {
            $view = new View('browsePage');
            echo $view->render();
        } else {
            session_unset();
            $this->redirect('home');
        }
    }

     /**
     * Displays the Search page to logged in users
     */
    public function searchIndexAction()
    {
        if ($_SESSION['auth']) {
            $view = new View('searchPage');
            echo $view->render();
        } else {
            session_unset();
            $this->redirect('home');
        }
    }

    /**
     * Displays the error page.
     */
    public function errorAction()
    {
        $view = new View('errorPage');
        echo $view->render();
    }

    /**
     * Manages a request to register a user, checks if the username already exists in the database.
     */
    public function registrationAction()
    {
        $username = $_GET["q"];
        try {
            $a = new AccountModel();
            echo $a->findName($username);
        } catch (\Exception $e) {
            $this->redirect('error');
        }
    }
}
