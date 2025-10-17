<?php
class ProfileController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->loadModel('UserModel');
        $this->userModel = new UserModel();
    }
    public function index()
    {
        $id = $_SESSION['user_id'];

        $getInfor = $this->userModel->findById($id);

        return $this->view('frontend.profile.index', ['getInfor' =>  $getInfor]);
    }
}