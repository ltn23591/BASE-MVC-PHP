<?php
class TestController extends BaseController
{

    public function index()
    {
        $product = 'nghia';
        $title = 'abc';
        return $this->view('frontend.test', [
            'key' =>  $title,
            'product' => $product
        ]);
    }
}
