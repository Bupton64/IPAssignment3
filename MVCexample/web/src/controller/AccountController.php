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
    public function createIndexAction()
    {
        $view = new View('registerPage');
        echo $view->render();
    }


    /**
     * Account Create action
     */
    public function createAction()
    {
        $account = new AccountModel();
        $account->sendConfirmationEmail();
        $view = new View('accountCreated');
        echo $view->render();
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
