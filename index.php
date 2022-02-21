<?php
require "Resizer.php";

$sourceFilename = "bottle.jpg";
$resizedFilename = getResizedImagePath($sourceFilename, 300, 300);

echo "Original filename = $sourceFilename\n";
echo "Resized filename = $resizedFilename\n";

print_r(getimagesize("images/".$sourceFilename));
print_r(getimagesize("images/".$resizedFilename));
