<?php

require_once('Cool/BaseController.php');

class FileController extends BaseController
{
    public function uploadAction() {
        session_start();
        require_once('Model/FileManager.php');

        $file_manager = new FileManager();
        $users_data = [
            'user' => $_SESSION,
            'files' => $file_manager->getFilesInDb(),
        ];

        $errors = [];

        if (isset($_POST['upload-btn'])) {
            $name = $_FILES['user_file']['name'];
            $type = $_FILES['user_file']['type'];
            $size = $_FILES['user_file']['size'];
            $tmp_name = $_FILES['user_file']['tmp_name'];
            $user_dir = $users_data['user']['user_dir'];
            $file_data = ['dir' => $user_dir, 'name' => $name, 'type' => $type, 'size' => $size, 'tmp_name' => $tmp_name];
            $upload_errors = $file_manager->upload($file_data);

            $users_data = [
                'errors' => $upload_errors,
                'user'   => $_SESSION,
                'files'  => $file_manager->getFilesInDb(),
            ];
        }

        if (isset($_POST['delete-btn'])) {
            $file_manager->delete($_POST['delete-btn']);
        }

        if (isset($_POST['edit-btn'])) {
            $file_manager->edit($_POST['edit-btn']);
        }

        if (isset($_POST['download-btn'])) {
            $file_manager->download($_POST['download-btn']);
        }

        if (isset($_POST['show-btn'])) {
            $file_manager->show($_POST['show-btn']);
        }

        return $this->render('upload.html.twig', $users_data);
    }
}