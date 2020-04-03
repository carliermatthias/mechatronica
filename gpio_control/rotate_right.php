<?php
include('stop.php');

shell_exec("gpio -g mode 21 OUT");
shell_exec("gpio -g write 21 1");
?>