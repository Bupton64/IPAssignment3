<?php
namespace agilman\a2\controller;
session_start();
use agilman\a2\view\View;
use agilman\a2\model\AccountModel;
/**
 * Class HomeController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class HomeController extends Controller
{
    /**
     * Link to Welcome
     */
    public function indexAction()
    {
        if($_SESSION['auth']) {
            $view = new View('userHome');
            echo $view->render();
        }else{
            session_unset();
            $this->redirect('home');
        }
    }

     /**
     * Link to Browse
     */
    public function browseIndexAction()
    {
        if($_SESSION['auth']) {
            $view = new View('browsePage');
            echo $view->render();
        }else{
            session_unset();
            $this->redirect('home');
        }
    }

     /**
     * Link to Search
     */
    public function searchIndexAction()
    {
        if($_SESSION['auth']) {
            $view = new View('searchPage');
            echo $view->render();
        }else{
            session_unset();
            $this->redirect('home');
        }
    }

    public function registrationAction()
    {
        $username = $_GET["q"];
        $a = new AccountModel();
        echo $a->findName($username);


    }
}
