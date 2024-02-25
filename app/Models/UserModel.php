<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'sys_users';
    protected $allowedFields = ['username','nama','password_hash','email','no_hp','jabatan_id','ttd_code','kode_bma','role_id','is_admin','active'];
    protected $useTimeStamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|is_unique[sys_users.username]',
        'email' => 'required|valid_email|is_unique[sys_users.email]',
        'password_hash' => 'required|min_length[5]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry, That email has already been taken. Please choose another.'
        ],
        'username' => [
            'is_unique' => 'Sorry, That UserName has already been taken. Please choose another.'
        ],

    ];

    protected $skipValidation = false;
    protected $beforeInsert = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }
        // $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        $data['data']['password'] = md5($data['data']['password']);
        return $data;
    }

}

