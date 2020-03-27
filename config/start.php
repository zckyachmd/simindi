<?php
    session_start();
    require_once 'functions.php';

    // Config Timezone
    date_default_timezone_set('Asia/Jakarta');

    // Config Meta Tag
    define("title", "Si-MINDI!");
    define("description", "Sistem Peminjaman DVD Film | Cimahi, Indonesia. (+62) 8515-5292-779 - E-mail : info@simindi.zacky.id.");
    define("keywords", "SIMINDI, Sistem Peminjaman DVD Film, Peminjaman DVD Film.");
    define("author", "Zacky Achmad");

    // Config Connection Database
    define("db_host", "localhost");
    define("db_user", "root");
    define("db_pass", "");
    define("db_name", "simindi");
    $connect = mysqli_connect(db_host, db_user, db_pass, db_name);

    // Config
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
