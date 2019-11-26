<?php

session_start();

unset($_SESSION['email']);
unset($_SESSION['fname']);
unset($_SESSION['lname']);

session_destroy();

header("Location: ./");
die;