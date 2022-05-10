<?php
use Humanize\Humanize;

include('Humanize.php');
echo Humanize::lang("ru")::days(714)::minutes(327)::calc();
?>