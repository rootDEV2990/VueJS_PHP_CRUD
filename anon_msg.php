<?php
    if (isset($_POST['username']) && isset($_POST['message'])) {
        $username = $_POST['username'];
        $message = $_POST['message'];

        include 'model.php';

        $model = new Model();

        if($model->insert($username, $message)) {
            $data = array('res' => 'success');
        }else{
            $data = array('res' => 'error'); 
        }
        echo json_encode($data);
    }
?>