<?php
return [
    //  Base URL — تقدر تغيره حسب المشروع
    "base_url" => "http://localhost/create_cv/",

    //  Default settings
    "environment" => "development", // or "production"
    "app_name" => "My Cv Builder Project",

    //  API Settings (لو هتستخدمها لاحقاً)
    "api_version" => "v1.0.0",

    //  Security
    "jwt_secret" => "your_super_secret_key_here", // هتحتاجه لو عملت Auth JWT
];
