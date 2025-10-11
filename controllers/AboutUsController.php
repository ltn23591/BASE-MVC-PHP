<?php
class AboutUsController extends BaseController
{
    
    public function index()
    {
        return $this->view('frontend.aboutus.index');
    }
}