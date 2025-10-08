<?php

require __DIR__ . '/../vendor/autoload.php';

// Use the Configuration class 
use Cloudinary\Configuration\Configuration;

// Configure an instance of your Cloudinary cloud
Configuration::instance([
    'cloud' => [
        'cloud_name' => 'djsgdxf5r',
        'api_key'    => '559959742568511',
        'api_secret' => '38Ll5EaZboARNywOk5fIqDtb4Nk'
    ],
    'url' => [
        'secure' => true // Use HTTPS
    ]
]);
