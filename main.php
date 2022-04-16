<?php

setlocale(LC_ALL,'en_US.UTF-8');
$CONFIG['input-file']['path'] = "input/input.srt";      // set input file path
$CONFIG['output-file']['path'] = "output/";             // set output directory
//===================================================
$CONFIG['input-file']['name'] = pathinfo($CONFIG['input-file']['path'], PATHINFO_FILENAME);
$CONFIG['input-file']['extension'] = pathinfo($CONFIG['input-file']['path'], PATHINFO_EXTENSION);

$pattern = "/[0-9]+(\n|\r\n)+([0-9]{2,}:[0-9]{2,}:[0-9]{2,},[0-9]*)\s-->\s([0-9]{2,}:[0-9]{2,}:[0-9]{2,},[0-9]*)(\n|\r\n)+(.*?)(\n|\r\n)+/is";
$content = file_get_contents($CONFIG['input-file']['path']);
preg_match_all($pattern, $content, $matches);

$rowCounter = 1;
$outString = "";
if(!empty($matches) && !empty($matches[0])){
    for($i=0; $i<count($matches[0]); $i=$i+2){
        if(array_key_exists($i+1, $matches[3])){
            $outString .= $rowCounter."\r\n".$matches[2][$i]." --> ".$matches[3][$i+1]."\r\n".$matches[5][$i]."\r\n".$matches[5][$i+1]."\r\n\r\n";
        }
        else{
            $outString .= $rowCounter."\r\n".$matches[2][$i]." --> ".$matches[3][$i]."\r\n".$matches[5][$i]."\r\n\r\n";
        }
        $rowCounter++;

    }
}
//file_put_contents("temp.srt", $outString);
$pattern = "/[0-9]+(\n|\r\n)+([0-9]{2,}:[0-9]{2,}:[0-9]{2,},[0-9]*)\s-->\s([0-9]{2,}:[0-9]{2,}:[0-9]{2,},[0-9]*)(\n|\r\n)+(.*?)(\n|\r\n){2}/is";
preg_match_all($pattern, $outString, $matches);

$rowCounter = 1;
$finalOutString = "";
if(!empty($matches) && !empty($matches[0])){
    for($i=0; $i<count($matches[0]); $i=$i+1){
        if(array_key_exists($i+1, $matches[3])){
            $finalOutString .= $rowCounter."\r\n".$matches[2][$i]." --> ".$matches[2][$i+1]."\r\n".$matches[5][$i]."\r\n\r\n";
        }
        else{
            $finalOutString .= $rowCounter."\r\n".$matches[2][$i]." --> ".$matches[3][$i]."\r\n".$matches[5][$i]."\r\n\r\n";
        }
        $rowCounter++;

    }
}

file_put_contents($CONFIG['output-file']['path'].$CONFIG['input-file']['name'].".".$CONFIG['input-file']['extension'],$finalOutString);

echo "Done !";


