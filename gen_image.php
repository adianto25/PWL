<?php
$im = imagecreatetruecolor(800, 600);
$bg = imagecolorallocate($im, 240, 240, 240);
$tc = imagecolorallocate($im, 150, 150, 150);
imagefilledrectangle($im, 0, 0, 800, 600, $bg);
$text = "No Photo Available";
// Center the text roughly
$font = 5;
$fw = imagefontwidth($font);
$fh = imagefontheight($font);
$tw = strlen($text) * $fw;
$x = (800 - $tw) / 2;
$y = (600 - $fh) / 2;
imagestring($im, $font, $x, $y, $text, $tc);
imagepng($im, 'public/uploads/default.png');
imagedestroy($im);
echo "Image generated.\n";
