<?php

/**
 * Make image style from name
 * @param $name
 * @return string
 */
function makeImageFromName($name) {
    $userImage = "";
    $shortName = "";

    $names = explode(" ", $name);

    foreach ($names as $w) {
        $shortName .= $w[0];
    }

    $userImage = '<div class="name-image bg-primary">'.$shortName.'</div>';
    return $userImage;
}
