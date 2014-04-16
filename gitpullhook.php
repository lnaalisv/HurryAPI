<?php
        $tulos = shell_exec("whoami");
        if ( !empty($_REQUEST["payload"]) )  {
                $result2 = shell_exec("cd /var/www/HurryAPI/ && sudo sudo git pull");
                echo "payload received";
        }
        echo "hi! oon $tulos";
?>