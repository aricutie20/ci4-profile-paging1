<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        
       
        $search = $this->request->getVar('search');
        
        if ($search) {
            $userModel->like('name', $search)->orLike('email', $search);
        }

        
        $data = [
            'users'  => $userModel->paginate(5),
            'pager'  => $userModel->pager,
            'search' => $search
        ];

        return view('user_view', $data);
    }

    public function upload()
    {
        $userModel = new UserModel();

        
        $validationRule = [
            'avatar' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[avatar]',
                    'is_image[avatar]',
                    'mime_in[avatar,image/jpg,image/jpeg,image/png]',
                    'max_size[avatar,2048]',
                ],
            ],
            'name' => 'required',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        
        $img = $this->request->getFile('avatar');

        if ($img->isValid() && !$img->hasMoved()) {
            
            $newName = $img->getRandomName();
            
            
            $img->move(ROOTPATH . 'public/uploads', $newName);

            
            $userModel->save([
                'name'   => $this->request->getPost('name'),
                'email'  => $this->request->getPost('email'),
                'avatar' => $newName
            ]);

            return redirect()->to('/users')->with('status', 'User created and profile uploaded successfully!');
        }

        return redirect()->back()->with('error', 'The file could not be uploaded.');
    }
}