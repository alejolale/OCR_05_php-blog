<?php
require('controller/index.php');

if (isset($_GET['action'])) {
    //TODO router navigations and access
    if ($_GET['action']=== 'contact') {
        contact();
    }
    if ($_GET['action']=== 'login') {
        login();
    }
    if ($_GET['action']=== 'users') {
        users();
    }else if ($_GET['action']=== 'user') {
            user($_GET['id']);
    }
}
else {
    index();
}
