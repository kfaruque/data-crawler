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

$k = count($categories);
for($i=0; $i<$k; $i++){
    $category_link = 'http://books.toscrape.com/'.strstr($categories[$i],'">',true );
    $cat_content = getData($category_link);

    $cat_explode = explode('product_pod',$cat_content );
    $cat_explode = explode('<article class="product_pod">',$cat_content );
    $category_name = str_replace('">','' ,strstr($categories[$i],'">' ));
    $category_name = explode(' </a>',$category_name);
//    
echo "<h3>".$category_name[0]."</h3>"."<br/>";
    

    $j = count($cat_explode);
    for($i=1; $i<$j; $i++){

        $book_link = explode('<a href="../../../',$cat_explode[$i] );
        $book_link = explode('">',$book_link[1] );

        $b_link = strstr($category_link, 'category',true )."$book_link[0]";

        $book_name = explode('title="',$cat_explode[$i]);
        $book_name = explode('"',$book_name[1]);

        echo "<a href='$b_link'>".$book_name[0]."</a><br/>";

        // Next Page Content
        if( $i === 20 ){
            $np = explode('"next"><a href="',$cat_explode[$i] );
            $np = explode('">next',$np[1] );

            $np_no = explode("Page 1 of ",$cat_explode[$i]);
            $np_no = explode("</li>",$np_no[1]);

            for($q=2; $q < $np_no[0]+1; $q++ ){
            $np_link[] = str_replace(strrchr($category_link,'/' ),'/',$category_link ).''.str_replace( '2', $q, $np[0] ) ;
            }
//print_r($np_link);
            for($p=0; $p<count($np_link); $p++ ){
                $np_content = getData($np_link[$p]);
                $np_content_explode = explode('<article class="product_pod">',$np_content);
                $m = count($np_content_explode);
                
                for($l=1; $l<$m; $l++){
                    $book_link_1 = explode('<a href="../../../',$np_content_explode[$l] );
                    $book_link_1 = explode('">',$book_link_1[1] );
                    $b_link_1 = strstr($category_link, 'category',true )."$book_link_1[0]";

                    $book_name_1 = explode('title="',$np_content_explode[$l]);
                    $book_name_1 = explode('"',$book_name_1[1]);

                    echo "<a href='$b_link_1'>".$book_name_1[0]."</a><br/>";
                }
            }
        }   // End Next Page
    }
}
//print_r($book_link);

// CSV file
//header('Content-Type: application/excel');
//header('Content-Disposition: attachment; filename="sample.csv"');
//$data = array(
//        'aaa,bbb,ccc,dddd',
//        '123,456,789',
//        '"aaa","bbb"'
//);
//
//$fp = fopen('php://output', 'w');
//foreach ( $data as $line ) {
//    $val = explode(",", $line);
//    fputcsv($fp, $val);
//}
//fclose($fp);