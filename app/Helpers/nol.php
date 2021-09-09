<?php
function flipdate($date)
{
     if ($date = "0000-00-00") return "0000-00-00";
     return date('Y-m-d', strtotime($date));
}
