<?php
/**
 * Template file: inc/blocks/big-list-item/block.php
 *
 * Big List Item Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$blockName = "Big List Item";
$blockID = "big-list-item";
$classes = $blockID . " ";
$list_item_title = "List Item Title";
$list_item_text = "List Item Text";
$list_item_link = "Explore more";
$related_content = get_field( 'related_content' );

if ( $related_content ) :
    $list_item_title = get_the_title($related_content);
    $list_item_text = theme_main_excerpt(10, $related_content);
    $list_item_link = 'Explore '.$list_item_title;
endif;
$template = '{
    "blockName":"core/columns",
    "attrs":{
       "verticalAlignment":null
    },
    "innerBlocks":[
       {
          "blockName":"core/column",
          "attrs":{
             "verticalAlignment":"stretch",
             "width":"20%"
          },
          "innerBlocks":[
             {
                "blockName":"core/image",
                "attrs":{
                   "id":3885,
                   "width":"318px",
                   "height":"auto",
                   "sizeSlug":"full",
                   "linkDestination":"none"
                }
             }
          ]
       },
       {
          "blockName":"core/column",
          "attrs":{
             "verticalAlignment":"center",
             "width":"80%",
             "className":"d-flex flex-column justify-content-between align-items-start text-left"
          },
          "innerBlocks":[
             {
                "blockName":"core/heading",
                "attrs":{
                   "level":4
                },
                "innerBlocks":[
                   {
                      "blockName":"core/strong",
                      "innerContent":[
                         "'.$list_item_title.'"
                      ]
                   }
                ]
             },
             {
                "blockName":"core/paragraph",
                "innerContent":[
                   "'.$list_item_text.'"
                ]
             },
             {
                "blockName":"core/buttons",
                "attrs":{
                   "className":"order-3 mt-auto mt-xl-0",
                   "layout":{
                      "type":"flex",
                      "justifyContent":"left"
                   }
                },
                "innerBlocks":[
                   {
                      "blockName":"core/button",
                      "attrs":{
                         "className":"btn-icon",
                         "blockAnimation":"slide-up"
                      },
                      "innerBlocks":[
                         {
                            "blockName":"core/button",
                            "innerContent":[
                               "'.$list_item_link.' ",
                               {
                                  "blockName":"fa-solid/fa-chevron-right",
                                  "attrs":{
                                     "className":"ms-3"
                                  }
                               }
                            ]
                         }
                      ]
                   }
                ]
             }
          ]
       }
    ]
 }';

// add acf or other functions here

$classes .= "d-flex flex-column justify-content-between"; // Add extra classes here.
if (!empty($block['anchor'])) {
   $blockClasses = $blockID . " ";
   echo '<div '. get_block_settings($block, $blockID, $blockClasses) .'>';
   echo '<InnerBlocks ' . get_block_classes($block, $classes) . '" template="' . esc_attr(wp_json_encode($template)) . '" />';
   echo ' </div>';
 } else {
   echo '<InnerBlocks ' . get_block_settings($block, $blockID, $classes) . '" template="' . esc_attr(wp_json_encode($template)) . '" />';
 }


?>