<?php


session_start();



function hasRole($role)
{
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}
