<?php

require __DIR__ . '/vendor/autoload.php';

// Use the Configuration class 
use Cloudinary\Configuration\Configuration;

// Configure an instance of your Cloudinary cloud
Configuration::instance('cloudinary://my_key:my_secret@my_cloud_name?secure=true');