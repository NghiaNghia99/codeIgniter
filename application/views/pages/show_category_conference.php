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
        echo '<a href="'. base_url('show-category-presentation/'. $posts[2][0]['id'] .'/'. $posts[2][1]['id']) .'"><span style="margin-right: 20px">Presentations:'. $value .'</span></a>';
    }
    elseif ($key == 'Conference'){
        echo '<a href="'. base_url('show-category-conference/'. $posts[2][0]['id'] .'/'. $posts[2][1]['id']) .'"><span style="margin-right: 20px">Conferences:'. $value .'</span></a>';
    }
}
if (count($posts[1]) > 0){
    foreach ($posts[1] as $post){
      echo '<img style="width: 200px" src="/assets/images/video_avatar_default.jpg" alt="">';
        echo '<h2><a href="'. base_url('conference/'.$post['id']) .'">'. $post['confTitle'] .'</a></h2>';
        echo '<p>CID: '. $post['CID'] .'</p>';
        echo '<p>Location: '. $post['confLocation'] .'</p>';
        echo '<p>Date: '. $post['startDate'] . ' - '. $post['endDate'] .'</p>';
        echo '<p>View: '. $post['views'] .'</p>';
    }
}
else{
  echo '<p>There are no conferences within this category so far.</p>';
}
?>
<script>
  $(document).ready(function () {

    $('.limitTextCaption').each(function() {
      var text = ($(this).text()).trim();
      if (text.length > 230) {
        var newString = text.substr(0, 230) + '<a href=""> ...more</a>';
        $(this).html(newString);
      } else {
        $(this).html(text);
      }
    });
  });
</script>
