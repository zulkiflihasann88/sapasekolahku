<?php
namespace App\Controllers;

class User extends BaseController
{
    public function index()
    {
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();
        // mapping agar tampilan tetap pakai field 'nama', 'email', dst
        foreach ($users as $user) {
            $user->nama = $user->name_user ?? '';
            $user->email = $user->email_user ?? '';
            $user->role = $user->role ?? '';
        }
        return view('user', ['users' => $users]);
    }

    public function update()
    {
        $userModel = new \App\Models\UserModel();
        $id = $this->request->getPost('id');
        $data = [
            'name_user'   => $this->request->getPost('nama'),
            'username'    => $this->request->getPost('username'),
            'email_user'  => $this->request->getPost('email'),
            'role'        => $this->request->getPost('role'),
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password_user'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $userModel->updateUser($id, $data);
        return redirect()->to('/user')->with('success', 'User berhasil diupdate');
    }

    public function tambah()
    {
        $userModel = new \App\Models\UserModel();
        $data = [
            'name_user'   => $this->request->getPost('nama'),
            'username'    => $this->request->getPost('username'),
            'email_user'  => $this->request->getPost('email'),
            'role'        => $this->request->getPost('role'),
        ];
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password_user'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $userModel->insert($data);
        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan');
    }

    public function generateGuru()
    {
        $pendidikModel = new \App\Models\PendidikModel();
        $userModel = new \App\Models\UserModel();

        // Ambil semua guru (pendidik) yang punya NIP dan belum ada di tabel users
        $gurus = $pendidikModel->where('nip !=', '')->findAll();
        $created = 0;
        foreach ($gurus as $guru) {
            // Cek apakah sudah ada user dengan username = NIP
            $existing = $userModel->where('username', $guru->nip)->first();
            if (!$existing) {
                $userModel->insert([
                    'name_user' => $guru->nama,
                    'username' => $guru->nip,
                    'email_user' => $guru->email ?? '',
                    'password_user' => password_hash('erapor12345', PASSWORD_DEFAULT),
                    'role' => 'guru_mapel', // atau 'guru_kelas', sesuaikan kebutuhan
                ]);
                $created++;
            }
        }
        return $this->response->setJSON([
            'status' => 'ok',
            'created' => $created
        ]);
    }
}
