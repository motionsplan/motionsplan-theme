<?php if ($page): ?>
<div class="exercise node <?php print $node_classes; ?>">
    <?php
    if($node->field_alternative_titles[0]['value'] != '') {
        $titles = array();
        foreach($node->field_alternative_titles as $t) {
            $titles[] = $t['value'];
        }
        echo '<h2 class="alternative"><strong>Alternative navne:</strong> '.implode(", ",$titles).'</h2>';
    }
    
     
    echo '<div class="intro">'.$node->field_exercise_intro[0]['safe'].'</div>';
    echo '<h4>Sådan udføres øvelsen</h4>';
    echo '<div class="guide">'.$node->field_exercise_guide[0]['value'].'</div>';
    
    
    echo '<div style="clear:right;font-size:1px;"></div>';
    
    if(sizeof($node->field_exercise_videos)>0) {
        $videoHTML = '';
        foreach($node->field_exercise_videos as $video) {
            if(!empty($video['view'])) {
                $videoHTML .= '<div class="video">' . $video['view'] . '</div>';
            }
        }
        if($videoHTML != '') {
            echo '<h4>Video af øvelsen</h4>';
        }
        if(!empty($user->uid)) {
            echo $videoHTML;  
        }
        else {
            echo '<p>
                Der er tilknyttet en video til denne øvelse.<br />
                Du skal dog være 
                <a href="/user?destination=node/'.$node->nid.'">registeret bruger</a>
                for at se videoen.
                </p>
                <p>
                <strong><a href="/user/register?destination=node/'.$node->nid.'">
                Klik her for at registere dig som bruger GRATIS</a></strong>
                </p>
            ';
        }
        
    }
    
    if($node->field_exercise_images[0]['view']!='') {
        echo '<h4>Billeder af øvelsen</h4>';
        foreach($node->field_exercise_images as $img) {
            echo '<div class="exerciseimg">';
            if($img['data']['description']!='') {
                echo '<h5>'.$img['data']['description'].'</h5>';
            }
            echo $img['view'];
            echo '</div>';
        }
        echo '<div style="clear:both;"></div>';
    }
    
    
    ?>

  <?php if ($links): ?>
  <div class="links">
    <?php print $links; ?>
  </div>
  <?php endif; ?>

  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom">
    <?php print $node_bottom; ?>
  </div>
  <?php endif; ?>

</div>
<?php else: ?>
<div class="exercistlist">
    <?php
    $presetname = 'exercisePictureList';
    $preset = imagecache_preset_by_name($presetname);

    if (!empty($node->field_exercise_images[0]['filepath'])) {
        $src = $node->field_exercise_images[0]['filepath'];
        $dst = imagecache_create_path($presetname, $src);
        if (file_exists($dst) || imagecache_build_derivative($preset['actions'], $src, $dst)) {
            $file = $dst;        
            echo '<div class="photo"><a href="'.url('node/'.$node->nid).'"><img src="/'.$file.'" alt="" /></a></div>';
        }
    }
    ?>
    <h2><a href="<?php print url('node/'.$node->nid); ?>"><?php print $node->title; ?></a></h2>
    <?php print $node->field_exercise_intro[0]['value']; ?>
    <br />
    <?php print l('Vis '.$node->title,'node/'.$node->nid); ?>
    <?php
    if(arg(0) == 'exerciseprogram' && arg(1) == 'show') {
        $dURL = url('exerciseprogram/show/'.arg(2).'/delete/'.$node->nid);
	    echo '| <a href="javascript:void(0)" onclick="if(confirm(\'Er du sikker på du vil slette øvelsen?\'))location.href=\''.$dURL.'\'" />Slet øvelse fra program</a>';
    }
    ?>
    <hr />
</div>
<?php endif; ?>
