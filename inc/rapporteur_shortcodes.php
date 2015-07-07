<?php
add_shortcode('kencrestportfolio', 'kencrestportfolio');
function kencrestportfolio () 
{  
  $loop = new WP_Query(
      array(
        'post_type' => 'kencrestportfolio',
        'orderby' => 'meta_value',
        'order' => 'ASC',
      )
    );
    $portfolio = '<div class="row"> <div class="projects">';
    if($loop->have_posts())
    {
        while($loop->have_posts())
        {
            $loop->the_post();
            $id = get_the_id();
            $meta = get_post_meta($id);

            $portfolio_title = $meta['portfolio_description_title'][0];
            $portfolio_description = $meta['portfolio_description_description'][0];
            $file = $meta['portfolio_description_portfolio_image'][0];
            $terms = get_the_terms( $id, 'type' );

            $arr = array();
            if ( $terms && ! is_wp_error( $terms ) )
            {
                foreach ($terms as $term) 
                {
                    $arr [] =  $term->slug;
                }
            }

        $portfolio .= '<div class="span3 element '.join(' ', $arr).'" data-category="'.join(' ', $arr).'">
        <div class="hover_img">
        <img src="'.$file.'" alt="" />
        <span class="portfolio_zoom"><a href="'.$file.'" data-rel="prettyPhoto[portfolio1]"></a></span>
        <span class="portfolio_link"><a href="'.get_permalink().'">View item</a></span>
        </div> 
        <div class="item_description">
        <a href="'.get_permalink().'"><span>'.$portfolio_title.'</span></a><br/>
        '.$portfolio_description.'
        </div>
        </div>';
        }
      this_theme_content_nav();
    }
    $portfolio .= '</div> </div>';

    $taxonomy_terms = get_terms('type'); 
    $content ='<div id="options"> <ul id="filters" class="option-set" data-option-key="filter">';
    $content .='<li><a href="#filter" data-option-value="*" class=" selected">All</a></li>';
            foreach ($taxonomy_terms as $term) 
            {
              $content .= '<li><a href="#filter" data-option-value=".'. $term->slug.'">'. $term->name .'</a></li>'; 
            }                                           
    $content  .= '</ul><div class="clear"></div></div>';

    return $content . $portfolio; 
}

add_shortcode('resource-center', 'resource_center_shortcode_function');
function resource_center_shortcode_function ( $attr ) 
{  
    $attr = shortcode_atts(
        array(
            'posts_per_page' => -1,
            'type' => 'resource-center',
            'tax' => null,
            'taxterm' => null,
            'meta_box' => 'meta',
            'field' => null,
            'meta_key' => 'parent',
            'meta_value' => '',
            'meta_compare' => '='
        ),
        $attr
    );

    extract($attr);
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $options = array(
        'posts_per_page' => $posts_per_page,
        'post_type' => $type,
        'orderby' => 'post_date',
        'order' => 'ASC',
        'paged' => $paged
    );

    // if( $metakey && ( $metavalue || $meta_compare ) )
    if( $meta_key && $meta_compare)
    {
        $options += array(
            'meta_query' => array(
                array(
                    'key' => "{$type}_{$meta_box}_{$meta_key}",
                    'value' => $meta_value,
                    'compare' => $meta_compare 
                )
            )       
        );
    }    

    if($tax && $field && $taxterm)
    {
      $options +=array(  
        'tax_query' => array(
                array(
                    'taxonomy' => $tax,
                    'field' => $field,
                    'terms' => $taxterm
                )
            )
        );        
    }
    
    $loop = new WP_Query( $options );
    $content = '';
    if( $loop->have_posts() )
    {
        while( $loop->have_posts() )
        {
            $loop->the_post();
            global $post;

            $id = get_the_id();
            $the_content = get_the_content();
            $the_content = apply_filters('the_content', $the_content);
            $content .= "<li>";  
                $content .= "<h2 class='title-divider cbp-nttrigger'>". get_the_title() ."</h2>";  
                $content .= "<div class='cbp-ntcontent'>";  
                    $content .= get_the_content(); 
                    $release_date = null;
                    if( $date = get_post_meta($id, $key.'_release_date', true) ) 
                    {
                        $content .= date('d-m-Y', strtotime($date));
                    }

                    if ( has_post_thumbnail() ) 
                    {
                        $content .= '<a href="'.get_permalink().'" title="'. get_the_title(). '">'. get_the_post_thumbnail($id, 'large'). '</a>';
                    }
    
                    //Children
                    $content .= prepare_children( 'parent', $post->post_name );
                   
                    $terms = get_the_terms($id, $tax);
                    $taxnomies = null;
                    if($terms)
                    {
                        $post_terms = array();
                        foreach ($terms as $term) 
                        {
                            $term_link = get_term_link( $term );            
                            $post_terms []= "&nbsp; <i class='icon-star-empty grey'></i> <a data-placement='top' href='{$term_link}' rel='tooltip' data-original-title='{$term->name}'> {$term->name}</a> ";
                        }
                        $taxnomies [] = " Categories: ".join(' &nbsp;', $post_terms);  
                    }     

                    $tags = get_the_tags();
                    if($tags)
                    {
                        $post_tags = array();
                        foreach ($tags as $tag) 
                        {
                            $tag_link = get_tag_link( $tag->term_id );            
                            $post_tags []= "<a class='btn btn-small btn-inverse marg-bottom5 {$tag->slug}' href='{$tag_link}' title='{$tag->name} Tag'>{$tag->name}</a>";
                        }
                        $taxnomies [] = "Tags: &nbsp;".join(' ', $post_tags);
                    }
                    $content .= ($taxnomies) ? "<p>".join(' &nbsp;&nbsp; ', $taxnomies)."</p>" : ''; 
                $content .= '</div>'; 
            $content .= "</li>"; 
        }
        wp_reset_query();
    }
    return '<ul id="cbp-ntaccordion" class="cbp-ntaccordion">'. $content .'</ul>';
}

function prepare_children($meta_key = null, $meta_value = null) 
{   
    if($meta_key && $meta_value)
    {
        return '<ul class="cbp-ntsubaccordion">'. 
                    do_shortcode("[resource-center meta_key='{$meta_key}' meta_value='{$meta_value}']") . 
                '</ul>';                      
    }
}

add_shortcode('rapporteurspreadsheets', 'rapporteurspreadsheet');
function rapporteurspreadsheet ( $attr ) 
{  
    $attr = shortcode_atts(
        array(
            'posts_per_page' => -1,
            'type' => 'spreadsheets',
            'tax' => 'spreadsheets_category',           
            'metabox' => 'spreadsheets_uploads'        
        ),
        $attr
    );

    extract($attr);
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $options = array(
        'posts_per_page' => $posts_per_page,
        'post_type' => $type,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'paged' => $paged
    );
    
    //$loop = new WP_Query( $options);
    $loop = query_posts( $options);
    $tabs = null;
    $tabs_content = null;
    $j = 0;
    if(have_posts())
    {
        while(have_posts())
        {
            the_post();
            $id = get_the_id();
            $the_title = get_the_title();
            $tab_id = preg_replace('/[^a-z0-9\_]/i', '_', $the_title);
            
            $spreadsheet =  get_post_meta($id, $metabox.'_spreadsheet', true);
            $upload_dir =  wp_upload_dir();
            $file_path = preg_replace("#". preg_quote( $upload_dir['baseurl'] ) ."#i", $upload_dir['basedir'], $spreadsheet );
            
            $xlsx = new SimpleXLSX($file_path);
            $active = ( $j == 0) ? 'active' : '';
            $tabs [] = "<li class='{$active}'><a data-toggle='tab' href='#{$tab_id}'>{$the_title}</a></li>";
            $tabs_content [] = "<div class='tab-pane {$active}' id='{$tab_id}'>";
            $tabs_content [] = '<table class="table table-bordered table-striped">';
            $i = 0;
            foreach( $xlsx->rows() as $index => $rows ) 
            {
                $class = ( $i % 3 == 0) ? 'class="alternate"' : '';
                $cells = ( $i== 0) ? 'th' : 'td';
                $tabs_content [] = "<tr {$class}>";
                foreach( $rows as $column => $text )
                {
                    $tabs_content [] = "<{$cells}>".( ! empty($text) ? $text : '&nbsp;' )."</ {$cells}>";
                }
                $tabs_content [] ='</tr>';
                $i ++;
            }
            $tabs_content [] = "</table></div>";
            $j ++;
        }   
        wp_reset_query();
    }
    return "<ul class='nav nav-tabs' id='myTab'>".join("", $tabs )."</ul> <div class='tab-content'>". join("", $tabs_content)."</div> <script> $('#myTab a:first').tab('show'); </script>"; 
}

add_shortcode('rapporteurshortcode', 'rapporteurshortcode');
function rapporteurshortcode ( $attr ) 
{  
    $attr = shortcode_atts(
        array(
            'posts_per_page' => -1,
            'type' => 'rapporteurpressnews',
            'tax' => 'press_category',
            'field' => null,
            'taxterm' => null,
            'metabox' => 'rapporteur_press_news',
            'metakey' => null,
            'metavalue' => null,
            'meta_compare' => null,
            'pageview' => false,
            'mediaclass' => true,
            'frontpage' => false,
        ),
        $attr
    );

    extract($attr);
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    $options = array(
        'posts_per_page' => $posts_per_page,
        'post_type' => $type,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'paged' => $paged
    );
    
    if($metakey && $metavalue && $meta_compare)
    {
        $options += array(
            'meta_query' => array(
                array(
                    'key' => $type."_".$metakey,
                    'value' => $metavalue,
                    'compare' => $meta_compare 
                )
            )       
        );
    }    

    if($tax && $field && $taxterm)
    {
      $options +=array(  
        'tax_query' => array(
          array(
            'taxonomy' => $tax,
            'field' => $field,
            'terms' => $taxterm
          )
        )
      );        
    }

    //$loop = new WP_Query( $options);
    $loop = query_posts( $options);
    $content = '';
    if(have_posts())
    {
        while(have_posts())
        {
            the_post();

            $id = get_the_id();
            $the_content = get_the_excerpt();
            $the_content = apply_filters('the_content', $the_content);
            
            $file =  get_post_meta($id, $type.'_'.$metabox.'_upload_file', true);
            $communications_date = '';
            $institution = '';
            if($type == 'rapcommunications')
            {
                $key = $type.'_rapporteur_communications';
                $date = get_post_meta($id, $key.'_communication_date', true);
                $communications_date = '<p> Communication Date :- &nbsp;'. date('F j, Y', strtotime($date));
                $institution =  'institution :- &nbsp;'. get_post_meta($id, $key.'_institution', true) .' </p>';
            }

            $release_date = null;
            if($type == 'rapporteurpressnews' || $type == 'rapporteurreports' || $type == 'rapdiscussions')
            {
                $key = $type.'_discussions_info';
                if($type == 'rapporteurpressnews') 
                { 
                    $key = $type.'_rapporteur_press_news';
                }

                if($type == 'rapporteurreports') 
                { 
                    $key = $type.'_rapporteur_reports';
                }

                $date = get_post_meta($id, $key.'_release_date', true);
                if(! empty($date)) 
                {
                    $day = date('d', strtotime($date));
                    $month = date('M', strtotime($date));
                    $year = date('Y', strtotime($date));

                    $release_date .= '<div class="span1">';
                    $release_date .= '<div class="date-post2"><span class="day hue">'. $day .'</span><span class="month">'. $month .'</span><span class="year">'. $year .'</span></div>';
                    $release_date .= '</div>';
                }
            }            

            if($frontpage)
            {  
                $content .= "<li>";
                $content .= '<a href="'.get_permalink().'" title="'. get_the_title(). '">'. get_the_title(). ' <small class="red"> &nbsp; '.$date.' </small></a>';
                $content .= "</li>";
            }            
            elseif(! $pageview)
            {  
                $class_media =  $mediaclass != 'false' ? 'class="media"' : '';
                $content .= "<li {$class_media} >";
                $content .= '<a href="'.get_permalink().'" title="'. get_the_title(). '">'. get_the_title(). ' <small> &nbsp; '.$date.' </small></a>';
                if ( has_post_thumbnail() ) 
                {
                  $content .= '<a href="'.get_permalink().'" title="'. get_the_title(). '">'. get_the_post_thumbnail(array(42, 42), array('class'=> 'pull-left quote_sections_img')). '</a>';
                }
                $content .= '<div class="media-body">';
                $content .= "{$communications_date} {$institution}";
                $content .=  get_the_excerpt(22);
                $content .= "</div></li>";
            }
            else
            {
                $content .= '<div class="row">';
                $content .= ($release_date) ? $release_date. '<div class="span11">' : '<div class="span12">' ;

                if ( has_post_thumbnail() ) 
                {
                    $content .= '<a href="'.get_permalink().'" title="'. get_the_title(). '">'. get_the_post_thumbnail($id, 'large'). '</a>';
                }

                $content .= "<h2 class='title-divider span11 post_link pad15'><a href='".get_permalink()."'>".get_the_title()."</a><span></span></h2>";  
                $content .= "<p>". $the_content ."</p>"; 
                if($file) 
                {       
                  $content .= "<p> Document..".$file."</p>";    
                }
                // $content .= '<hr />';
                
                $terms = get_the_terms($id, $tax);
                $_tags = null;
                if($terms)
                {
                    $post_terms = array();
                    foreach ($terms as $term) 
                    {
                        $term_link = get_term_link( $term );            
                        $post_terms []= "&nbsp; <i class='icon-star-empty grey'></i> <a data-placement='top' href='{$term_link}' rel='tooltip' data-original-title='{$term->name}'> {$term->name}</a> ";
                    }
                    $_tags [] = " Categories: ".join(' &nbsp;', $post_terms);  
                }     

                $tags = get_the_tags();
                if($tags)
                {
                    $post_tags = array();
                    foreach ($tags as $tag) 
                    {
                        $tag_link = get_tag_link( $tag->term_id );            
                        $post_tags []= "<a class='btn btn-small btn-inverse marg-bottom5 {$tag->slug}' href='{$tag_link}' title='{$tag->name} Tag'>{$tag->name}</a>";
                    }
                    $_tags [] = "Tags: &nbsp;".join(' ', $post_tags);
                }
                $content .= ($_tags) ? "<p>".join(' &nbsp;&nbsp; ', $_tags)."</p>" : ''; 
                $content .= '</div>'; 
                $content .= '</div>'; 
            }
        }
        
        if(! $frontpage)
        {
            $content .= '<nav class="navigation" role="navigation">';
                $content .= '<div class="nav-previous pull-left">' . get_next_posts_link( __( '&larr; Older posts' )) . '</div>';
                $content .= '<div class="nav-next pull-right">' . get_previous_posts_link( __( 'Newer posts &rarr;' ) ) . '</div>';
            $content .= '</nav>';
        }
        wp_reset_query();
    }
    return $content; 
}

add_shortcode('rapporteur', 'rapporteur');
function rapporteur($attr)
{
    $attr = shortcode_atts(
        array(
          'latitude' => '0.1757807', 
          'longitude' => '23.7304700', 
          'width' => '600',
          'height' => '300',
          'zoom' => 2,
          'maptype' => 'ROADMAP',
          'scale' => 2,
          'count' => -1
        ),
        $attr
    );
    extract($attr);
    
    $locations = array();
    $countries_related_data_accordions = array();
    $countries_visited_list = array();
    $loop = new WP_Query(array('post_type' => 'rapporteur', 'posts_per_page' => $count, 'orderby' => 'title', 'order' => 'ASC'));
    $i = 0;
    if($loop->have_posts())
    {
        while($loop->have_posts())
        {
            $loop->the_post();
            $id = get_the_id();

            $title = get_the_title();
            $description = get_the_content();
            $description = apply_filters('the_content', $description);

            $__latitude = get_post_meta($id, 'rapporteur_rapporteur_latitude', true);
            $__longitude = get_post_meta($id, 'rapporteur_rapporteur_longitude', true);
            
            $file = get_post_meta($id, 'rapporteur_rapporteur_file', true);
            $visit_date = get_post_meta($id, 'rapporteur_rapporteur_visit_date', true);
            $visit_status = get_post_meta($id, 'rapporteur_rapporteur_visit_status', true);

            $country = get_post_meta($id, 'rapporteur_rapporteur_country', true);            
            list($_latitude, $_longitude, $_country)  = explode(':::', $country);            

            $data = array(
                'latitude' =>  $__latitude != '' ? $__latitude : $_latitude,
                'longitude' => $__longitude != '' ? $__longitude : $_longitude,
                'country' => $_country,
                'title' => $title,
                'description' => $description,
                'file' => $file,
                'visit_date' => $visit_date,
                'visit_status' => ucwords($visit_status)
            );

            $locations [] = $data;

            $countries_related_data_accordions [] = prepare_country_related_data_accordions($data);
            $countries_visited_list [] = prepare_countries_visited($data, $i);

            $i ++;
        }

        //$prepare_accordions_ = prepare_accordions1();
        return  '<p><a href="#" class="pull-right rapporteur-toggle-map"><i class="icon-list"></i></a></p> 
          <div id="map-container" class="span12"><div id="map"></div></div>

          <div class="span8">
            <h4 class="title-divider span8"><strong>Countries </strong><span></span></h4>
            <ul id="cbp-ntaccordion" class="cbp-ntaccordion">'
            . join('', $countries_related_data_accordions) .
            '</ul>
          </div> 
          <div class="span4">
            <h4 class="title-divider"><strong>Countries </strong><span></span> Visited</h4> <div class="clear"></div>
            <div class="accordion" id="accordion">'             
              . join('', $countries_visited_list) .
            '</div>
          </div>

        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>  
         <script type="text/javascript" src="'. get_template_directory_uri() .'/js/markerclusterer.js"></script>
        <script type="text/javascript"> 
        // Info window trigger function 
         function onItemClick(pin, map) {  
           // Create content  
           var contentString = "<p><h6>" + pin.data.title + "</h6> <small>" + pin.data.description + "</small>"; 
           if(pin.data.file) {
               contentString = contentString + "<br/> Download <a href ="+ pin.data.file + "> Report Document</a>";
           }
            contentString = contentString + "</p>";
            
           // Replace our Info Window content and position 
           infowindow.setContent(contentString); 
           infowindow.setPosition(pin.position); 
           infowindow.open(map) 
         } 

         function theme_map_initialize() {
           var center = new google.maps.LatLng(0.1757807, 23.7304700);
           var options = {
                zoom: '. $zoom .',
                center: center,
                scale: '. $scale .',
                // mapTypeId: google.maps.MapTypeId.'.$maptype.',
           };
           var data = '.json_encode($locations).';
           var map = new google.maps.Map(document.getElementById("map"), options);

           var markers = [];
           $.each(data, function(i, res) {
               var latLng = new google.maps.LatLng(res.latitude, res.longitude);
               var marker = new google.maps.Marker({ position: latLng, map: map, data: res});
               
               google.maps.event.addListener(marker, "click", function() { 
                   map.setCenter(new google.maps.LatLng(marker.position.lat(), marker.position.lng())); 
                   map.setZoom(5); 
                   onItemClick(marker, map); 
               }); 
               
               markers.push(marker);
           });

           var markerCluster = new MarkerClusterer(map, markers);
           infowindow = new google.maps.InfoWindow(); 
         }
        google.maps.event.addDomListener(window, "load", theme_map_initialize);
        </script>
        ';
    }
}

function prepare_country_related_data_accordions($options) 
{   
    extract($options); 
    return '
        <li>
            <h3 class="cbp-nttrigger">'.ucwords($country).'</h3>
            <div class="cbp-ntcontent">
                <h6> Visit Status: <strong>'. $visit_status . '</strong> &nbsp; &nbsp; Visit Date: &nbsp;<span class="red">'.$visit_date .'</span></h6>
                <ul class="cbp-ntsubaccordion">
                    <li><h4 class="cbp-nttrigger">News</h4>
                        <div class="cbp-ntcontent">
                          <ul class="rapporteuracountrydetails">'. 
                              do_shortcode("[rapporteurshortcode mediaclass=false metakey=rapporteur_press_news_country metavalue='{$country}' meta_compare='LIKE']") . 
                          '</ul>
                        </div>
                    </li>

                    <li><h4 class="cbp-nttrigger">Reports</h4>
                        <div class="cbp-ntcontent">
                          <ul class=" rapporteuracountrydetails">'. 
                             do_shortcode("[rapporteurshortcode mediaclass=false type=rapporteurreports tax=type metabox=rapporteur_reports metakey=rapporteur_reports_country metavalue='{$country}' meta_compare='LIKE']") . 
                          '</ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>';
}

// <li><h4 class="cbp-nttrigger">Communications</h4>
//     <div class="cbp-ntcontent">
//       <ul class="rapporteuracountrydetails">'. 
//         do_shortcode("[rapporteurshortcode mediaclass=false type=rapcommunications tax=communications_type metabox=rapporteur_communications metakey=rapporteur_communications_country metavalue='{$country}' meta_compare='LIKE']") . 
//       '</ul>
//     </div>
// </li>

function prepare_countries_visited($options, $i = 0) 
{   
    extract($options); 
    if($visit_status == 'Visited' )
    {
     return ' <div class="accordion-group">
                  <div class="accordion-heading">
                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-'.$i.'">'. $country .'</a>
                  </div>
                  <div id="collapse-'.$i.'" class="accordion-body collapse" style="height: 0px;">
                      <div class="accordion-inner">
                        Visit Date: &nbsp;<span class="red"> '. $visit_date .'</span>
                      </div>
                  </div>
              </div>'; 
    } 

    return;       
}


