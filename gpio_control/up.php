<?php
include('stop.php');

shell_exec("gpio -g mode 26 OUT");
shell_exec("gpio -g write 26 1");
?>