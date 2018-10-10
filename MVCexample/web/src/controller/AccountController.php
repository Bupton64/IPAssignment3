<?php
namespace agilman\a2\controller;

use agilman\a2\model\{AccountModel, AccountCollectionModel};
use agilman\a2\view\View;

/**
 * Class AccountController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountController extends Controller
{
    /**
     * Account Index action
     */
    public function indexAction()
    {
        try {
            $account = new AccountModel(); // Test statement to create database
        } catch (\Exception $e){
            // Deal with exception
        }
        $view = new View('loginPage');
        echo $view->render();
    }

    /**
     * Account Create action
     */
    public function registerAction()
    {
        $view = new View('registerPage');
        echo $view->render();
    }


    /**
     * Account Create action
     */
    public function createAction()
    {
        try {
            $account = new AccountModel();
        } catch (\Exception $e){
            // Direct to error page?
            error_log("in construct catch", 100);
        }
        if(!isset($_POST["name"])){
            error_log("Post aint set ya fuck");
        }
        $account->setName($_POST['name']);
        $account->setUsername($_POST['username']);
        $account->setEmail($_POST['email']);
        $account->setPassword($_POST['password']);
        error_log("pre save", 100);
        try {
            $account->save();
        } catch (\Exception $e){
            // Do stuff
            error_log("in save catch", 100);
        }
        error_log("post save", 100);
        //$account->sendConfirmationEmail(); // replace to make zon a happy boi
        $view = new View('accountCreated');
        echo $view->addData('account', $account)->render();
    }

    public function loginAction()
    {
        // Test login
        $view = new View('userHome');
        echo $view->render();
    }

    /**
     * Account Delete action
     *
     * @param int $id Account id to be deleted
     */
    public function deleteAction($id)
    {
        (new AccountModel())->load($id)->delete();
        $view = new View('accountDeleted');
        echo $view->addData('accountId', $id)->render();
    }
    /**
     * Account Update action
     *
     * @param int $id Account id to be updated
     */
    public function updateAction($id)
    {
        $account = (new AccountModel())->load($id);
        $account->setName('Joe')->save(); // new name will come from Form data
    }
}
