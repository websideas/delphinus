<?php

$dir_uploads = dirname(__FILE__).DIRECTORY_SEPARATOR.'wp-content'.DIRECTORY_SEPARATOR.'uploads';


$files = find_all_files($dir_uploads);
$files2 = array();


$image_size = array();
for ($i = 100; $i< 1200; $i++) {
    $image_size[$i] = $i;
}


foreach($files as $key => $file) {
    foreach($image_size as $size){
        $preg_match_jpg = '#'.$size.'x\d+\.jpg$#';
        if(1 == preg_match($preg_match_jpg, $file)) {
            $files2[] = $file;
        }
        $preg_match_png = '#'.$size.'x\d+\.png$#';
        if(1 == preg_match($preg_match_png, $file)) {
            $files2[] = $file;
        }
    }
}

if(count($files2)){
    echo '<pre>';
    print_r($files2);
    echo '</pre>';
    foreach($files2 as $file){
        @unlink($file);
    }
}

$all = get_all_dirs($dir_uploads);
foreach($all as $item){
    RemoveEmptySubFolders($item);
}

$all = get_all_dirs($dir_uploads);

echo '<pre>';
print_r($all);
echo '</pre>';


function find_all_files($dir)
{
    $root = scandir($dir);
    $result = array();
    foreach($root as $value)
    {
        if($value === '.' || $value === '..') {continue;}
        if(is_file("$dir/$value")) {
            $result[]="$dir/$value";
            continue;
        }
        foreach(find_all_files($dir.DIRECTORY_SEPARATOR.$value) as $value)
        {
            $result[]=$value;
        }
    }
    return $result;
}

function get_all_dirs($dir){
    $dirs = array_filter(glob($dir.DIRECTORY_SEPARATOR."*"), 'is_dir');
    foreach($dirs as $ndir)
    {
        $dirs_sub = array_filter(glob($ndir.DIRECTORY_SEPARATOR."*"), 'is_dir');
        if(count($dirs_sub)){
            $dirs = array_merge($dirs_sub, $dirs );
        }
    }
    return $dirs;
}


function RemoveEmptySubFolders($path)
{
    $empty=true;
    foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file)
    {
        $empty &= is_dir($file) && RemoveEmptySubFolders($file);
    }
    return $empty && rmdir($path);
}