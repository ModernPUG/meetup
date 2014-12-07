<?php
$file_path = $argv[1];

$data = file_get_contents($file_path);

preg_match_all("/'[^']'+/m", $data, $matches);

foreach ($matches[0] as $str) {
    $short_str = '~'.~trim($str, "'");
    $data = str_replace($str, $short_str, $data);
}

$short_file_path = preg_replace('/(\.[^.]+)$/', '_short$1', $file_path);

$fp = fopen($short_file_path, 'w');
fwrite($fp, $data);
fclose($fp);

echo $data . "\n";

