<?php
    function go($url) {
        header('Location: '.$url);
        exit();
    }
    
    function post($par, $st = true) {
        if (isset($_POST[$par])) {
            if ($st) {
                return htmlspecialchars(addslashes(trim(strip_tags($_POST[$par]))));
            }
            else {
                return addslashes(trim(strip_tags($_POST[$par])));
            }
        }
        else {
            return false;
        }
    }