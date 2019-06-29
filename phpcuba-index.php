<?php
if (!function_exists('cop'))
include __DIR__."/functions/objects/cop.php";
else phpcuba\error(100, "LOADING: Function cop() already exists");

if (!function_exists('get_object_public_vars'))
include __DIR__."/functions/objects/get_object_public_vars.php";
else phpcuba\error(100, "LOADING: Function get_object_public_vars() already exists");

if (!function_exists('str_clear'))
include __DIR__."/functions/strings/str_clear.php";
else phpcuba\error(100, "LOADING: Function str_clear() already exists");

