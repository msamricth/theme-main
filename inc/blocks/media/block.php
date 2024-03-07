<?php
/**
 * Template file: templates/blocks/media.php
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Media (video, or image) Block";
$blockID = 'block-media';
$classes = $blockID . ' ';

$mediaClasses = '';
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
if (have_rows('media')):
    while (have_rows('media')):
        the_row();
        $video_ratio = get_sub_field('video_ratio');
        if (get_sub_field('make_full_screen') == 1):
            $mediaClasses.= "fullscreen_media";
        endif;
        if ( get_sub_field( 'dark_layout' ) == 1 ) : 
            $mediaClasses.= " dark_layout";
        endif; 
    endwhile;
endif;

$blockContent = '';
?>

<div <?php echo get_block_settings($block, $blockID, $classes); ?>>
    <?php
      $blockContent .= '<div class="'.$mediaClasses.'">'.media_block_main();
      if(get_field('caption')){
          $fig_classes = "";
          if(get_field('caption_placement')){
              $fig_classes = 'class="' . get_field('caption_placement').'"';
          }
  
          $blockContent .= '<figcaption '.$fig_classes.'>'.get_field('caption').'</figcaption>';
      }
      $blockContent .= '</div>';
  

    echo $blockContent;

?>
</div>