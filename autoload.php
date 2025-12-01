<?php

$Controllers_files = scandir("./Controllers");
$Models_files = scandir("./Models");
$Views_files = scandir("./Views");

foreach($Controllers_files as $file){
    if($file == '.' || $file == '..'){
        continue;
    }
    else{
        require_once './Controllers/' . $file;
    }
}

foreach($Models_files as $file){
    if($file == '.' || $file == '..'){
        continue;
    }
    else{
        require_once './Models/' . $file;
    }
}

// foreach($Views_files as $file){
//     if($file == '.' || $file == '..'){
//         continue;
//     }
//     else{
//         require_once './Views/' . $file;
//     }
// }