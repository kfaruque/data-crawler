<?php

include("imdb_lib.php");

$contnet = getData("http://books.toscrape.com/");

$content_explode = explode('<div class="side_categories">', $contnet );
$content_explode = explode('</div>',$content_explode[1] );

// category Link
$cat_link = explode('<a href="',$content_explode[0] );
$k = count($cat_link);

for($i=2; $i<$k; $i++){
    $categories[] = $cat_link[$i];
}

$o = count($categories);

for($i=0; $i<$o; $i++){
//$i=3;
     $category_link = 'http://books.toscrape.com/'.strstr($categories[$i],'">',true );
//    $category_link = 'http://books.toscrape.com/'.strstr($categories[3],'">',true );
    $cat_content = getData($category_link);

//    $cat_explode = explode('product_pod',$cat_content );
    $cat_explode = explode('<article class="product_pod">',$cat_content );
    $category_name = str_replace('">','' ,strstr($categories[$i],'">' ));
    $category_name = explode(' </a>',$category_name);
    
echo "<h3>".$category_name[0]."</h3>"."<br/>";

    $j = count($cat_explode);
    for($n=1; $n<$j; $n++){

        $book_link = explode('<a href="../../../',$cat_explode[$n] );
        $book_link = explode('">',$book_link[1] );

        $b_link = strstr($category_link, 'category',true )."$book_link[0]";

        $book_name = explode('title="',$cat_explode[$n]);
        $book_name = explode('"',$book_name[1]);

        echo "<a href='$b_link'>".$book_name[0]."</a><br/>";
// Next Page
    if($n == 20){
        $np = explode('<li class="next">', $cat_content );
        $np = explode('<li class="current">',$np[0] );
    //    $np = explode('page 1 of ',$np[1] );
        $p_count = intval(substr(trim(strstr(trim($np[1]),"</li>",true)),-2));
        
        for($k=2; $k<=$p_count;$k++){
            $np_link = strstr($category_link,"index.html",true)."page-$k.html";
            $np_content = getData($np_link);
            $np_content_explode = explode('<article class="product_pod">',$np_content);
            $m= count($np_content_explode);
            for($l=1; $l<$m; $l++){
                $book_link_1 = explode('<a href="../../../',$np_content_explode[$l] );
                $book_link_1 = explode('">',$book_link_1[1] );
                $b_link_1 = strstr($category_link, 'category',true )."$book_link_1[0]";

                $book_name_1 = explode('title="',$np_content_explode[$l]);
                $book_name_1 = explode('"',$book_name_1[1]);

                echo "<a href='$b_link_1'>".$book_name_1[0]."</a><br/>";
            }
            
        }

    }
  
}

}