<?php
    function alertBox($message, $icon = "", $type = "")
    {
            return "<div class=\"alert  alert-$type alert-dismissable\">
            $icon
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
            <b>Alert!</b> $message ";
    }
    
    
    function create_slug($string){
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }
?>