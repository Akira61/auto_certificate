<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") :

    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['course']) || empty($_POST['date'])) :
        die("<center><span style='color:red'>All fields are required. <a href='index.html'>Home</a></span></center>");
    endif;

    // Load font and certificate template
    $font = __DIR__ . '/fonts/PlayfairDisplay-Regular.ttf';
    $certification = imagecreatefromjpeg(__DIR__ . '/images/certification_template.jpg');

    if (!$certification || !file_exists($font)) {
        die("Error loading font or template image.");
    }

    $color = imagecolorallocate($certification, 0, 0, 0);

    // function to center the text
    $center_text = function ($text, $size) use ($font, $certification) {
        $bbox = imagettfbbox($size, 0, $font, $text);
        $text_width = $bbox[4] - $bbox[0];
        return (imagesx($certification) / 2) - ($text_width / 2);
    };

    // Write the texts
    $name = $_POST['name'];
    imagettftext($certification, 55, 0, $center_text($name, 55), 650, $color, $font, $name);

    $course = $_POST['course'];
    imagettftext($certification, 45, 0, $center_text($course, 45), 810, $color, $font, $course);

    $date = $_POST['date'];
    imagettftext($certification, 35, 0, 660, 910, $color, $font, $date);

    // Generate ID
    $certificate_id = rand(1000, 10000);
    imagettftext($certification, 35, 0, 340, 1090, $color, $font, '#' . $certificate_id);

    // Save file
    $folder = __DIR__ . "/certifications/";
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    $filepath = $folder . $name . "_" . $certificate_id . ".jpg";

    if (!imagejpeg($certification, $filepath)) {
        die("Failed to save the certificate.");
    }

    imagedestroy($certification);

    // Redirect to the generated image
    header("Location: certifications/" . $name . "_" . $certificate_id . ".jpg");
    exit;

endif;
