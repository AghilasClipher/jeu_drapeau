<?php 

function init_session() : bool {
    if(!session_id()){
        session_start();
        session_regenerate_id();
        return true;
    }
    return false;
}

function clean_session() : void {
    session_unset();
    session_destroy();
}

function is_logged() : bool {
    if(isset($_SESSION['username'])){
        return true; 
    }
    else{
        return false;
    }
    
}

function is_admin() : bool {
    if(is_logged()){
        if(isset($_SESSION['admin']) && $_SESSION['admin']==1){
            return true; 
        }
        else{
            return false; 
        }
    }
}