<?php
include('stop.php');

shell_exec("gpio -g mode 6 OUT");
shell_exec("gpio -g write 6 1");
?>