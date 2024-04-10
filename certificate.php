<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") :
    // check if fields are passed
    if ($_POST['name'] == null || $_POST['course'] || $_POST['date']) :
        echo die("<center><span style='color:red'>All fields are required. <a href='index.php'>Home</a></span></center>");
    endif;
    header("Content-Type: image/jpeg");
    $font = realpath('fonts/PlayfairDisplay-Regular.ttf');
    $certification = imagecreatefromjpeg('images/certification_template.jpg');
    $color = imagecolorallocate($certification, 0, 0, 0);
    // center text on x position
    $center_text = function ($text, $position) use ($font, $certification) {
        $bbox = imagettfbbox($position, 0, $font, $text);
        return (imagesx($certification) / 2) - (($bbox[2] - $bbox[0]) / 2);
    };
    // paste name on the certificate
    $name = $_POST['name'];
    imagettftext($certification, 55, 0, $center_text($name, 55), 650, $color, $font, $name);
    // paste course name
    $course = $_POST['course'];
    imagettftext($certification, 45, 0, $center_text($course, 45), 810, $color, $font, $course);
    // paste date on the certificate
    $date = $_POST['date'];
    imagettftext($certification, 35, 0, 660, 910, $color, $font, $date);
    // paste certificate id
    $certificate_id = rand(1000, 10000);
    imagettftext($certification, 35, 0, 340, 1090, $color, $font, '#' . $certificate_id);
    // save image in cetfifications folder
    $filepath = "certifications/" . $name . "_" . $certificate_id . ".jpg";
    imagejpeg($certification, $filepath);
    header("Location: $filepath"); // redirecte to certificate
    imagedestroy($certification);

endif;
