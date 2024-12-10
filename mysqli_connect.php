<?php
$dbcon = @mysqli_connect('localhost', 'jenyannesalapantan', 'VfVoE-@/QRS!6)Gu', 'members_salapantan')
OR die('Could not connect to MySQL. Error in '.mysqli_connect_error());
mysqli_set_charset($dbcon, 'utf8');

