<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $returnType = 'object';
    protected $allowedFields = [
    'name_user', 'username', 'email_user', 'password_user', 'role' // field sesuai tabel users
];

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }
}
