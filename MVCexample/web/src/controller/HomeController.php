<?php
namespace agilman\a2\controller;

use agilman\a2\view\View;
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
        $view = new View('userHome');
        echo $view->render();
    }

     /**
     * Link to Browse
     */
    public function browseIndexAction()
    {
        $view = new View('browsePage');
        echo $view->render();
    }


     /**
     * Link to Search
     */
    public function searchIndexAction()
    {
        $view = new View('searchPage');
        echo $view->render();
    }
}
