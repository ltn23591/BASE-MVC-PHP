<?php

class HomeController extends BaseController
{
    public function index()
    {
        return $this->view(
            'frontend.home',
        );
    }
}
