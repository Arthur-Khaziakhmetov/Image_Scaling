<?php
//getResizedImagePath(string $sourceFilename, int $width, int $height) : string.
//
//    $sourceFilename - имя оригинального файла (без пути);
//    $width - новая длина картинки в пикселях;
//    $height - новая высота картинки в пикселях.
//Результатом выполнения функции является путь к новому файлу (включая имя).
//Имя нового файла должно совпадать с именем заданного файла. Относительно скрипта старые файлы лежат в папке images.
//Новые файлы должны быть созданы в папке images/resized

function getResizedImagePath(
    string $sourceFilename,
    int $width,
    int $height
): string
{
    $imageSize = getImageSize('images/'.$sourceFilename);
    $ext = $imageSize['mime'];
    switch ($ext){
      case 'image/jpg':
      case 'image/jpeg':
        $image = ImageCreateFromJPEG('images/'.$sourceFilename);
        break;
      case 'image/png':
        $image = ImageCreateFromPNG('images/'.$sourceFilename);
        break;
      default:
  	    throw new Exception("Invalid image type.\n", 1);
    }
    $imageWidth = $imageSize[0];
    $imageHeight = $imageSize[1];
    if ($width/$imageWidth < $height/$imageHeight){
      $proportion = $width/$imageWidth;
    } else {
      $proportion = $height/$imageHeight;
    }
    $newimageWidth = (int)$imageWidth*$proportion;
    $newimageHeight = (int)$imageHeight*$proportion;

    $new_image=imagecreatetruecolor($width,$height);
    $white=imagecolorallocate($new_image,255,255,255);
    //$new_image=imagecreatetruecolor($width,$height); 
    imagefilledrectangle($new_image,0,0,$width,$height,$white);
    $pastex = floor(($width - $newimageWidth) / 2);
    $pastey = floor(($height - $newimageHeight) / 2);
    imagecopyresampled($new_image,$image,$pastex,$pastey,0,0,$newimageWidth,$newimageHeight,$imageWidth,$imageHeight);
    switch ($ext){
      case 'image/jpg':
      case 'image/jpeg':
        imagejpeg($new_image,__DIR__."/images/resized/".$sourceFilename);
        break;
      case 'image/png':
        imagepng($new_image,__DIR__."/images/resized/".$sourceFilename);
        break;
      default:
  	    throw new Exception("Invalid image type.\n", 1);
    }
    $resizedFilename ="resized/".$sourceFilename;
    imagedestroy($image);
    imagedestroy($new_image);
    return $resizedFilename;
}
