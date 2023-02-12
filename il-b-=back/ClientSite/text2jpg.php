<?


if(isset($_GET['word'])) {
    text2word($_GET['word']);
}

function text2word($text) {
    header("Content-type: image/png");
    $im = imagecreatetruecolor(150, 30);
    $white = imagecolorallocate($im, 255, 255, 255);
    $grey = imagecolorallocate($im, 128, 128, 128);
    $dark_grey = imagecolorallocate($im, 64, 64, 64);
    $black = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, 149, 29, $white);
    imagerectangle ($im, 0, 0, 149, 29, $black);
    $font = 'other/fonts/VeraSe.ttf';
    imagettftext($im, 14, 0, 11, 21, $grey, $font, $text);
    imagettftext($im, 14, 0, 10, 20, $dark_grey, $font, $text);
    imagepng($im);
    imagedestroy($im);
}
?>