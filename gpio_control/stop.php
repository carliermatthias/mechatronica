<?php
shell_exec("gpio -g mode 26 OUT");
shell_exec("gpio -g mode 19 OUT");
shell_exec("gpio -g mode 13 OUT");
shell_exec("gpio -g mode 6 OUT");
shell_exec("gpio -g mode 5 OUT");
shell_exec("gpio -g mode 21 OUT");


shell_exec("gpio -g write 26 0");
shell_exec("gpio -g write 19 0");
shell_exec("gpio -g write 13 0");
shell_exec("gpio -g write 6 0");
shell_exec("gpio -g write 5 0");
shell_exec("gpio -g write 21 0");
?>