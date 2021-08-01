<?php 
    if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['message'])){
         $id = $_POST['id'];
         $username = $_POST['username'];
         $message = $_POST['message'];

         include 'model.php';

         $model = new Model();

         if ($model->update($id, $username, $message)) {
             $data = array('res' => 'success');
         }else{
             $data = array('res' => 'error');
         }

         echo json_encode($data); 
    }

?>