<div id="echo esc_attr( $id ); " class="echo esc_attr( $classes ); ">
<?php	the_field( 'header_type' ); 
	the_field( 'header_video' ); 
	if ( get_field( 'header_video_uploaded' ) ) : ?>
		<a href="the_field( 'header_video_uploaded' ); ">Download File</a>
    <?php endif; 
	$header_image = get_field( 'header_image' ); 
	$size = 'full'; 
	if ( $header_image ) : 
		echo wp_get_attachment_image( $header_image, $size ); 
	endif; 
	if ( have_rows( 'header_mobile' ) ) : 
		while ( have_rows( 'header_mobile' ) ) : the_row(); 
			the_sub_field( 'video_mobile' ); 
			if ( get_sub_field( 'video_mobile_uploaded' ) ) : ?>
				<a href="the_sub_field( 'video_mobile_uploaded' ); ">Download File</a>
			<?php endif; 
			$placeholder_image = get_sub_field( 'placeholder_image' ); 
			if ( $placeholder_image ) :  ?>
				<img src="echo esc_url( $placeholder_image['url'] ); " alt="echo esc_attr( $placeholder_image['alt'] ); " />
                <?php  endif; 
			if ( have_rows( 'options' ) ) : 
				while ( have_rows( 'options' ) ) : the_row(); 
					if ( get_sub_field( 'self_host_video' ) == 1 ) : 
						// echo 'true'; 
					else : 
						// echo 'false'; 
					endif; 
					if ( get_sub_field( 'make_full_screen' ) == 1 ) : 
						// echo 'true'; 
					else : 
						// echo 'false'; 
					endif; 
					the_sub_field( 'video_ratio' ); 
					if ( get_sub_field( 'turn_on_overlay' ) == 1 ) : 
						// echo 'true'; 
					else : 
						// echo 'false'; 
					endif; 
					the_sub_field( 'opacity_level' ); 
					the_sub_field( 'gradient_level' ); 
					the_sub_field( 'overlay_color' ); 
				endwhile; 
			endif; 
			if ( have_rows( 'options' ) ) : 
				while ( have_rows( 'options' ) ) : the_row(); 
					if ( get_sub_field( 'make_full_screen' ) == 1 ) : 
						// echo 'true'; 
					else : 
						// echo 'false'; 
					endif; 
					if ( get_sub_field( 'turn_on_overlay' ) == 1 ) : 
						// echo 'true'; 
					else : 
						// echo 'false'; 
					endif; 
					the_sub_field( 'opacity_level' ); 
					the_sub_field( 'gradient_level' ); 
					the_sub_field( 'overlay_color' ); 
				endwhile; 
			endif; 
		endwhile; 
	endif; 
	if ( have_rows( 'options' ) ) : 
		while ( have_rows( 'options' ) ) : the_row(); 
			if ( get_sub_field( 'self_host_video' ) == 1 ) : 
				// echo 'true'; 
			else : 
				// echo 'false'; 
			endif; 
			if ( get_sub_field( 'make_full_screen' ) == 1 ) : 
				// echo 'true'; 
			else : 
				// echo 'false'; 
			endif; 
			the_sub_field( 'video_ratio' ); 
			if ( get_sub_field( 'turn_on_overlay' ) == 1 ) : 
				// echo 'true'; 
			else : 
				// echo 'false'; 
			endif; 
			the_sub_field( 'opacity_level' ); 
			the_sub_field( 'gradient_level' ); 
			the_sub_field( 'overlay_color' ); 
		endwhile; 
	endif;  ?>
</div>