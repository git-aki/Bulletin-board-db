<?php
$post_image = $_FILES['image']['tmp_name'];
$h = 100;
$w = 100;
list($original_w, $original_h, $type) = getimagesize($post_image);
if($original_w > $original_h){
    $diff  = ($original_w - $original_h) * 0.5; 
    $diffW = $original_h;
    $diffH = $original_h;
    $diffY = 0;
    $diffX = $diff;
}elseif($original_w < $original_h){
    $diff  = ($original_h - $original_w) * 0.5; 
    $diffW = $original_w;
    $diffH = $original_w;
    $diffY = $diff;
    $diffX = 0;
}elseif($original_w === $original_h){
    $diffW = $original_w;
    $diffH = $original_h;
    $diffY = 0;
    $diffX = 0;
}

function getImageOf($func_type,$func_image){
    switch ($func_type) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($func_image);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($func_image);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($func_image);
        default:
            throw new RuntimeException('対応していないファイル形式です。: ', $func_type);
    }
}

$original_image = getImageOf($type,$post_image);

$canvas = imagecreatetruecolor($w, $h);
imagecopyresampled($canvas, $original_image, 0, 0, $diffX, $diffY, $w, $h, $diffW, $diffH);
$image = './image/'.$thread['thread_name'].'/'.$id."_".$_FILES['image']['name'];

switch ($type) {
    case IMAGETYPE_JPEG:
        imagejpeg($canvas, $image);
        break;
    case IMAGETYPE_PNG:
        imagepng($canvas, $image, 9);
        break;
    case IMAGETYPE_GIF:
        imagegif($canvas, $image);
        break;
}
imagedestroy($original_image);
imagedestroy($canvas);
?>