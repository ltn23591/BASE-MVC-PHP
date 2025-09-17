<?php
class AboutUsController extends BaseController
{
    
    public function index()
    {
        return $this->view('frontend.aboutus.index', [
            'pageTitle' => 'Về chúng tôi'
        ]);
        return $this->view('frontend.aboutus.index');
    }
}