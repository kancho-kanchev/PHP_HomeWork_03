<?php
session_name('HomeWork03');
session_set_cookie_params(0,'/','',false,true);
session_start();
session_destroy();
header('location: index.php');
exit;
