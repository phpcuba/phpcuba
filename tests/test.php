<?php

include "../classes/Atomic.php";
include "../classes/Number.php";

use PHPCuba\Number;

echo (new Number(12))->sum(3)->get();
