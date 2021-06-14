<?php
$text = $_POST['textContent'];
$fp = fopen('ext_camp_entrance.txt', 'a');
fwrite($fp, $text . PHP_EOL);
fclose($fp);
