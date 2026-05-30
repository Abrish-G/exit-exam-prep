<?php

function sanitize($data){

    return htmlspecialchars(trim($data));
}

function calculatePercentage($score, $total){

    if($total == 0){

        return 0;
    }

    return round(($score / $total) * 100, 2);
}

function isPass($percentage){

    return $percentage >= 50;
}
?>