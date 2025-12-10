<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['name']) || empty($_POST['course']) || empty($_POST['date'])) {
        die("<center><span style='color:red'>All fields are required. <a href='form.html'>Back</a></span></center>");
    }

    $font = __DIR__ . '/fonts/PlayfairDisplay-Regular.ttf';
    $certification = imagecreatefromjpeg(__DIR__ . '/images/certification_template.jpg');

    if (!$certification || !file_exists($font)) {
        die("Error loading font or template image.");
    }

    $color = imagecolorallocate($certification, 0, 0, 0);
    $shanawaz = imagecolorallocate($certification, 255, 0, 0);
    $center = function ($text, $size) use ($font, $certification) {
        $box = imagettfbbox($size, 0, $font, $text);
        $width = $box[4] - $box[0];
        return (imagesx($certification) / 2) - ($width / 2);
    };

    $name = $_POST['name'];
    imagettftext($certification, 40, 0, $center($name, 40), 600, $color, $font, $name);

    $course = $_POST['course'];
    imagettftext($certification, 36, 0, $center($course, 36), 780, $color, $font, $course);

    $date = $_POST['date'];
    imagettftext($certification, 28, 0, 660, 910, $color, $font, $date);

    $company = "XYZ Training Center";
    imagettftext($certification, 28, 0, 550, 850, $shanawaz, $font, $company);

    $certificate_id = rand(1000, 10000);
    imagettftext($certification, 35, 0, 340, 1090, $color, $font, "#" . $certificate_id);

    $dir = __DIR__ . "/certifications/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $file = $dir . $name . "_" . $certificate_id . ".png";
    imagepng($certification, $file);
    imagedestroy($certification);

    header("Location: certifications/" . $name . "_" . $certificate_id . ".png");
    exit;
}
?>