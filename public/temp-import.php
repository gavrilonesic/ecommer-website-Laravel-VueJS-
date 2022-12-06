<?php

function csv_to_array($filename = '', $delimiter = ',')
{
    if (! file_exists($filename) || ! is_readable($filename)) return FALSE;
    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            if (! $header) $header = $row;
            else $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

$arr = csv_to_array(public_path() . '/merchant-feed-2.csv');

foreach($arr as $row) {
    $prod = Product::where('name', $row['title'])->first();
    $prod->name = $row['new title'];
    $prod->save();
}