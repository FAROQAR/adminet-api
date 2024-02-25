<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\MBaseModel;
use CodeIgniter\API\ResponseTrait;
/**
 * Description of LoginController
 *
 * @author nasywan
 */
class LoginController extends BaseController{
    //put your code here
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->helpers = ['form', 'url'];
    }

    public function index()
    {
//        if ($this->isLoggedIn()) {
//            return redirect()->to(base_url('dashboard'));
//        }

        // $data = [
        //     'title' => 'Login | Seri Tutorial CodeIgniter 4: Login dan Register @ qadrlabs.com'
        // ];

        // return view('auth/login', $data);
        return view('auth/login');
    }

//    private function isLoggedIn(): bool
//    {
//        if (session()->get('logged_in')) {
//            return true;
//        }
//
//        return false;
//    }
    
    public function login()
    {
        $email = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $credentials = ['username' => $email];

        $user = $this->model->where($credentials)
            ->first();

        if (! $user) {
            $response = array(
                'status' => 'true',
                'errCode' => '02',
                'msg' => 'Wrong login or inactive account'
            );
            return $this->response->setJSON($response);
        }

        $passwordCheck = password_verify(md5($password), $user['password_hash']);
        if((md5($password))===$user['password_hash'] ){
            $passwordCheck=true;
        }
// $udata=json_encode($user);
        if (! $passwordCheck) {
            
            $response = array(
                'status' => 'true',
                'errCode' => '02',
                'msg' => 'Wrong login or inactive account'
            );
            return $this->response->setJSON($response);
        }


        $response = array(
            'status' => 'true',
            'errCode' => '01',
            'msg' => 'Success'
        );
        return $this->response->setJSON($response);
    }
}
