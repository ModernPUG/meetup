<?php
function display_percent($file)
{
    $percent = (int)($file->ftell() / $file->getSize() * 100);

    echo "\033[5D";
    echo str_pad($percent, 3, ' ', STR_PAD_LEFT) . "%";
}

function compress_file($file_comp, $file_target)
{
    $prev_byte = null;
    $count = 0;
    while (!$file_target->eof()) {
        $byte = $file_target->fread(1);

        display_percent($file_target);

        if ($prev_byte != $byte || $file_target->eof() || $count == 255) {
            if (!is_null($prev_byte)) {
                $file_comp->fwrite(pack('C', ord($prev_byte)));
                $file_comp->fwrite(pack('C', $count));

                // $s = bin2hex($prev_byte);
                // echo "{$s}:{$count}\n";
            }

            $prev_byte = $byte;
            $count = 1;
        } else {
            ++$count;
        }
    }
}

function extract_file($file_comp, $file_target)
{
    while (!$file_comp->eof()) {
        $byte = $file_comp->fread(1);
        $count = $file_comp->fread(1);

        display_percent($file_comp);

        if ($file_comp->eof()) {
            break;
        }

        $count = unpack('C', $count);
        $count = array_shift($count);

        // $s = bin2hex($byte);
        // echo "{$s}:{$count}\n";

        for ($i = 0; $i < $count; $i++) {
            $file_target->fwrite($byte);
        }
    }
}

$mode = $argv[1]; // c, x
$comp_file = $argv[2];
$target_file = $argv[3];

if ($mode == 'c') {
    $file_comp = new SplFileObject($comp_file, 'w');
    $file_target = new SplFileObject($target_file);
    compress_file($file_comp, $file_target);
} elseif ($mode == 'x') {
    $file_comp = new SplFileObject($comp_file);
    $file_target = new SplFileObject($target_file, 'w');
    extract_file($file_comp, $file_target);
}

echo "\n";
