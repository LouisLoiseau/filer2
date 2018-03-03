<?php

require_once('Cool/BaseController.php');

class UploadController extends BaseController
{
    public function uploadAction() {
        session_start();
        $users_data = [
            'user' => $_SESSION,
            'files'=> scandir($_SESSION['user_dir']),
        ];

        require_once('Model/FileManager.php');
        $errors = [];

        if (isset($_POST['upload-btn'])) {
            $name = $_FILES['user_file']['name'];
            $type = $_FILES['user_file']['type'];
            $size = $_FILES['user_file']['size'];
            $tmp_name = $_FILES['user_file']['tmp_name'];
            $user_dir = $users_data['user']['user_dir'];
            $file_data = ['dir' => $user_dir, 'name' => $name, 'type' => $type, 'size' => $size, 'tmp_name' => $tmp_name];

            $file_manager = new FileManager();
            $upload_errors = $file_manager->upload($file_data);

            $users_data = [
                'errors' => $upload_errors,
                'user' => $_SESSION,
                'files'=> scandir($_SESSION['user_dir']),
            ];
        }
        return $this->render('upload.html.twig', $users_data);
    }
}