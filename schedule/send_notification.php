<?php
$contacts=$_POST['contacts'];
$arrlength = count($contacts);

for($x = 0; $x < $arrlength; $x++)
{
echo $contacts[$x]."<br>";
}


?>