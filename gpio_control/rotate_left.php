<?php
include('stop.php');

shell_exec("gpio -g mode 5 OUT");
shell_exec("gpio -g write 5 1");
?>