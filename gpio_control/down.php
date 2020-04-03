<?php
include('stop.php');

shell_exec("gpio -g mode 19 OUT");
shell_exec("gpio -g write 19 1");
?>