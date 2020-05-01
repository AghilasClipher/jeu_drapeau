<?php 

function login() : bool 
{
    if(!session_id()){
        session_start();
        session_regenerate_id();
        return true;
    }
    return false;
}