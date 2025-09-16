<?php
class ContactusController extends BaseController
{
    public function index()
    {
        return $this->view('frontend.contactus.index', [
            'pageTitle' => 'Liên hệ'
        ]);
    }
}
?>