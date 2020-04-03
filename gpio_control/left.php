<?php
include('stop.php');

shell_exec("gpio -g mode 13 OUT");
shell_exec("gpio -g write 13 1");
?>