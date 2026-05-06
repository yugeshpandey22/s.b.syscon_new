<?php
// includes/image_helper.php

/**
 * Compresses and resizes an image if necessary.
 * 
 * @param string $source Path to source image
 * @param string $destination Path to save compressed image
 * @param int $quality Compression quality (0-100)
 * @param int $max_width Maximum width for resizing (optional)
 * @return bool Success or failure
 */
function compressImage($source, $destination, $quality = 80, $max_width = 1920) {
    $info = getimagesize($source);
    if ($info === false) return false;

    $mime = $info['mime'];
    
    // Create image from source
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            // Convert PNG transparency to white background for smaller JPEG if preferred,
            // but here we'll keep PNG if it's a PNG. 
            // Actually, for blog images, JPEG is usually better.
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }

    if (!$image) return false;

    // Optional: Resize if too large
    $width = imagesx($image);
    $height = imagesy($image);

    if ($width > $max_width) {
        $new_width = $max_width;
        $new_height = floor($height * ($max_width / $width));
        
        $tmp_img = imagecreatetruecolor($new_width, $new_height);
        
        // Preserve transparency for PNG
        if ($mime == 'image/png') {
            imagealphablending($tmp_img, false);
            imagesavealpha($tmp_img, true);
        }

        imagecopyresampled($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($image);
        $image = $tmp_img;
    }

    // Save compressed image
    // We'll save as JPEG for maximum compression unless it's a PNG we want to keep transparent
    if ($mime == 'image/png' || $mime == 'image/gif') {
        // Keep original format for PNG/GIF
        if ($mime == 'image/png') {
            imagepng($image, $destination, 6); // 0-9 for PNG
        } else {
            imagegif($image, $destination);
        }
    } else {
        imagejpeg($image, $destination, $quality);
    }

    imagedestroy($image);
    return true;
}
?>
