<?php
include 'action.php';
class adminAction extends Database
{
    public function create($form)
    {
        $email = $form['user_Email'];
        if ($form['user_Password'] !== $form['confirmPass']) {
            echo "Passwords do not match!";
            exit();
        }
        $form['user_Password'] = password_hash($form['user_Password'], PASSWORD_BCRYPT);
        $verifyEmail = $this->verifyEmail($email);
        if ($verifyEmail) {
            echo "Email already exists!";
            exit();
        }
        $user = [];
        $userdata = [];
        foreach ($form as $key => $value) {
            if ($key == 'user_Email' || $key == 'user_Password')
                $user[$key] = $value;
            else if ($key != 'create' && $key != 'confirmPass') {
                $input = preg_replace("#[[:punct:]]#", "", $form[$key]);
                $userdata[$key] = $input;
            }
        }

        $action1 = $this->addRecord($user, 'userlogin');
        $data = $this->showRecords('userlogin', "WHERE user_Email = '$email'");
        $userdata['user_ID'] = $data[0][0];
        $action2 = $this->addRecord($userdata, 'userdata');
        if ($action1 && $action2) {
            echo "success";
        } else {
            echo "ERROR! Something went wrong!";
        }
    }
    public function edit($user_id)
    {
        $verifyEmail = $this->verifyEmail($_POST['user_Email'], $user_id);
        if ($verifyEmail) {
            echo "Email already exists!";
            exit();
        }
        if ($_POST['user_Password'] !== $_POST['confirmPass']) {
            echo "Passwords do not match!";
            exit();
        }
        $userlogin = [];
        $userdata = [];
        foreach ($_POST as $name => $val) {
            if ($_POST['user_Password'] != NULL && $name == 'user_Password')
                $userlogin[$name] = password_hash($val, PASSWORD_BCRYPT);
            else if ($name == 'user_Email')
                $userlogin[$name] = $val;
            else if ($name != 'edit' && $name != 'user_Password' && $name != 'confirmPass')
                $userdata[$name] = $val;
        }
        try {
            $this->updateRecord($userlogin, 'userlogin', ['user_ID' => $user_id]);
            $this->updateRecord($userdata, 'userdata', ['user_ID' => $user_id]);
            echo "success";
        } catch (Exception $e) {
            echo "Error: $e";
        }
    }
    public function delete($user_id)
    {
        $this->deleteRecord('userlogin', ['user_ID' => $user_id]);
        $this->deleteRecord('userdata', ['user_ID' => $user_id]);
        $test = $this->showRecords('userlogin', "WHERE user_ID = $user_id");
        if (count($test) == 0) {
            echo "success";
        } else {
            echo "ERROR! Failed to Delete Record!";
        }
    }
}