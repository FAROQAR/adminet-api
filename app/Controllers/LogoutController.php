<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;

/**
 * Description of LogoutController
 *
 * @author nasywan
 */
class LogoutController extends BaseController{
    //put your code here
    public function index()
    {

        $userData = [
            'name',
            'email',
            'logged_in'
        ];

        session()->remove($userData);

        $response = array(
            'status' => 'true',
            'errCode' => '01',
            'msg' => 'Success'
        );
        return $this->response->setJSON($response);

    }
}
