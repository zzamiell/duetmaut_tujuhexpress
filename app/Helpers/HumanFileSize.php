<?php
function humanFileSize($size, $precision = 1, $show = "")
{
$b = $size;
$kb = round($size / 1024, $precision);
$mb = round($kb / 1024, $precision);
$gb = round($mb / 1024, $precision);

if($kb == 0 || $show == "B") {
return $b . " bytes";
} else if($mb == 0 || $show == "KB") {
return $kb . "KB";
} else if($gb == 0 || $show == "MB") {
return $mb . "MB";
} else {
return $gb . "GB";
}
}
?>