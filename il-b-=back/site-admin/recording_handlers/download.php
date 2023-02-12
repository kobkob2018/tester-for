<?php

// Download the file
$outputName = "http://62.90.6.141:6560/1331recs/".$_GET['filename'].".mp3";
header('Content-Disposition: attachment; filename="call_recording.mp3"');
header("Content-Type: audio/mpeg3");
header("Content-Length: " . filesize($outputName));
echo (file_get_contents($outputName));
unlink($outputName);

?>