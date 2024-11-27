<?php

@include 'Conexion.php';

session_start();
session_unset();
session_destroy();

header('location:Login.php');

?>