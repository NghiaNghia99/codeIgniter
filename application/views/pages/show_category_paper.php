<?php
/**
 * Created by PhpStorm.
 * User: bssdev
 * Date: 23-Apr-19
 * Time: 14:26
 */
?>
    <h2>Category/Subcategory: <?= $posts[2][0]['name'] .'/'.$posts[2][1]['name'] ?></h2>
<?php foreach ($posts[0] as $key => $value){
    if ($key == 'Video'){
        echo '<a href="'. base_url('show-category-video/'. $posts[2][0]['id'] .'/'. $posts[2][1]['id']) .'"><span style="margin-right: 20px">Videos:'. $value .'</span></a>';
    }
    elseif ($key == 'Poster'){
        echo '<a href="'. base_url('show-category-poster/'. $posts[2][0]['id'] .'/'. $posts[2][1]['id']) .'"><span style="margin-right: 20px">Posters:'. $value .'</span></a>';
    }
    elseif ($key == 'Paper'){
        echo '<a href="'. base_url('show-category-paper/'. $posts[2][0]['id'] .'/'. $posts[2][1]['id']) .'"><span style="margin-right: 20px">Papers:'. $value .'</span></a>';
    }
    elseif ($key == 'Presentation'){
        echo '<a href="'. base_url('show-category-presentation/'. $posts[2][0]['id'] .'/'. $posts[2][1]['id']) .'"><span style="margin-right: 20px">Presentation:'. $value .'</span></a>';
    }
}
if (count($posts[1]) > 0){
    foreach ($posts[1] as $post){
        echo '<h2><a href="'. base_url('paper/'.$post['id']) .'">'. $post['paperTitle'] .'</a></h2>';
        echo '<p>Author: '. $post['firstName'] .' '. $post['lastName'] .'</p>';
        echo '<p class="limitTextCaption"><i>'. $post['caption'] .'</i></p>';
        echo '<p>View: '. $post['views'] .'</p>';
    }
}
else{
  echo '<p>There are no papers within this category so far.</p>';
}
?>
<script>
  // (function ($) {
  //   $(document).ready(function () {
  //     let textCaption = $('.limitTextCaption').text().trim();
  //     if (textCaption.length > 230)
  //     {
  //       let newString = textCaption.substr(0, 230) + '<a href="">...more</a>';
  //       $(this).html(newString);
  //     }
  //   });
  // })(jQuery);
</script>
