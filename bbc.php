<?php

include("imdb_lib.php");
$content = getData("http://www.bbc.com/");
$content_exploded = explode('<div class="media__image">',$content);
$k = count($content_exploded);
//print_r($content_exploded);
//echo $k;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Web Crawler for BBC</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        for($i=1; $i<$k; $i++){
            $img = explode('<img src="',$content_exploded[$i]);
            $img1 = explode('"',$img[1]);
            
            $title_link = explode('<a class="media__link" href="',$content_exploded[$i]);
            $title_link = explode('"',$title_link[1]);
            // Newly added for title link check and replacement
            $title_comp = substr($title_link[0],0,2);
            $str_rpl = ($title_comp=='ht'? '':'https://bbc.com');
            $title_new_link = substr_replace($title_link[0], $str_rpl, 0, 0); 
            
            $title = explode('headline" >',$content_exploded[$i]);
            $title = explode('</a>',$title[1]);
            
            
    ?>
    <div class="col-md-4">
        <img src="<?php echo $img1[0]; ?>" alt="">
        <h4><a href="<?php echo $title_new_link; ?>"><?php echo $title[0]; ?></a></h4>
<!--        <h6><?php echo $title_new_link; ?></h6>-->
<!--        <h6><?php echo $img1[0]; ?></h6>-->
    </div>
    <?php }; ?>
</body>
</html>
