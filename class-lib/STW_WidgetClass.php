<?php

/**
 *
 * Class STW Widget
 *
 * @ Special Teaser Widget
 *
 * building the actual widget
 *
 */
 
class Special_Teaser_Widget extends A5_Widget {
	
	private static $options;
	
	function __construct() {
		
		$widget_opts = array( 'description' => __('Put a featured post into the widget and choose one of the styles to get it into the attention af your readers.', 'special-teaser-widget') );
		$control_opts = array( 'width' => 400 );
		
		parent::__construct(false, $name = 'Special Teaser Widget', $widget_opts, $control_opts);
		
		self::$options = get_option('stw_options');
	
	}	
	 
	function form($instance) {
		
		// setup some default settings
		
		$defaults = array(
			'name' => NULL,
			'style' => false,
			'clickable' => false,
			'category_id' => false,
			'title' => NULL,
			'article' => false,
			'backup' => false,
			'linktocat' => false,
			'image' => false,
			'width' => get_option('thumbnail_size_w'),
			'thumb' => false,
			'headline' => false,
			'excerpt' => NULL,
			'fullpost' => false,
			'linespace' => false,
			'notext' => false,
			'noshorts' => false,
			'filter' => false,
			'readmore' => false,
			'rmtext' => NULL,
			'rmclass' => NULL,
			'homepage' => true,
			'frontpage' => false,
			'page' => false, 
			'category' => true,
			'single' => false,
			'date' => false,
			'archive' => false,
			'tag' => false,
			'attachment' => false,
			'taxonomy' => false,
			'author' => false,
			'search' => false,
			'not_found' => false,
			'login_page' => false
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title = esc_attr($instance['title']);
		$name = esc_attr($instance['name']);
		$clickable = esc_attr($instance['clickable']);
		$thumb = esc_attr($instance['thumb']);
		$image = esc_attr($instance['image']);
		$article = esc_attr($instance['article']);
		$backup = esc_attr($instance['backup']);
		$width = esc_attr($instance['width']);
		$headline = esc_attr($instance['headline']);	
		$excerpt = esc_attr($instance['excerpt']);
		$fullpost = esc_attr($instance['fullpost']);
		$linespace = esc_attr($instance['linespace']);	
		$notext = esc_attr($instance['notext']);	
		$noshorts = esc_attr($instance['noshorts']);
		$readmore = esc_attr($instance['readmore']);
		$rmtext = esc_attr($instance['rmtext']);
		$rmclass = esc_attr($instance['rmclass']);
		$filter = esc_attr($instance['filter']);
		$style = esc_attr($instance['style']);
		$linktocat=esc_attr($instance['linktocat']);
		$category_id=esc_attr($instance['category_id']);
		$homepage=esc_attr($instance['homepage']);
		$frontpage=esc_attr($instance['frontpage']);
		$page=esc_attr($instance['page']);
		$category=esc_attr($instance['category']);
		$single=esc_attr($instance['single']);
		$date=esc_attr($instance['date']);
		$archive=esc_attr($instance['archive']);
		$tag=esc_attr($instance['tag']);
		$attachment=esc_attr($instance['attachment']);
		$taxonomy=esc_attr($instance['taxonomy']);
		$author=esc_attr($instance['author']);
		$search=esc_attr($instance['search']);
		$not_found=esc_attr($instance['not_found']);
		$login_page=esc_attr($instance['login_page']);
		
		$features = get_categories('hide_empty=0');
		
		foreach ( $features as $feature ) $categories[] = array($feature->cat_ID, $feature->cat_name);
		
		$args = array(
			'posts_per_page' => -1,
			'post_status' => 'publish'
		);
		
		$features = get_posts($args);
		
		foreach ( $features as $feature ) $posts[] = array($feature->ID, $feature->post_title);
		
		$features = self::$options['style'];
		
		foreach ( $features as $id => $feature ) $styles[] = array($id, $feature['style_name']);
		
		$options = array (array('top', __('Above thumbnail', 'special-teaser-widget')) , array('bottom', __('Under thumbnail', 'special-teaser-widget')), array('none', __('Don&#39;t show title', 'special-teaser-widget')));
		
		$base_id = 'widget-'.$this->id_base.'-'.$this->number.'-';
		$base_name = 'widget-'.$this->id_base.'['.$this->number.']';
		
		a5_text_field($base_id.'name', $base_name.'[name]', $name, __('Title (will be displayed in blog):', 'special-teaser-widget'), array('space' => true, 'class' => 'widefat'));
		a5_select($base_id.'style', $base_name.'[style]', $styles, $style, __('Choose here the style of your widget.', 'special-teaser-widget'), __('Choose style', 'special-teaser-widget'), array('space' => true, 'class' => 'widefat'));
		a5_checkbox($base_id.'clickable', $base_name.'[clickable]', $clickable, __('Link the widget title to a category.', 'special-teaser-widget'), array('space' => true));
		a5_select($base_id.'category_id', $base_name.'[category_id]', $categories, $category_id, __('Category:', 'special-teaser-widget'), __('Choose a category', 'special-teaser-widget'), array('class' => 'widefat', 'space' => true));
		a5_text_field($base_id.'title', $base_name.'[title]', $title, __('Name (internal widgettitle):', 'special-teaser-widget'), array('space' => true, 'class' => 'widefat'));
		a5_select($base_id.'article', $base_name.'[article]', $posts, $article, __('Choose here the post, you want to appear in the widget.', 'special-teaser-widget'), __('Take a random post', 'special-teaser-widget'), array('space' => true, 'class' => 'widefat'));
		a5_select($base_id.'backup', $base_name.'[backup]',$posts,  $backup, __('Choose here the backup post. It will appear, when a single post page shows the featured article.', 'special-teaser-widget'), __('Take a random post', 'special-teaser-widget'), array('space' => true, 'class' => 'widefat'));
		a5_checkbox($base_id.'linktocat', $base_name.'[linktocat]', $linktocat, __('Check to link to the same category as the title is linking to.', 'special-teaser-widget'), array('space' => true));
		a5_checkbox($base_id.'image', $base_name.'[image]', $image, __('Check to get the first image of the post as thumbnail.', 'special-teaser-widget'), array('space' => true));
		a5_number_field($base_id.'width', $base_name.'[width]', $width, __('Width of the thumbnail (in px):', 'special-teaser-widget'), array('space' => true, 'size' => 4, 'step' => 1));
		a5_checkbox($base_id.'thumb', $base_name.'[thumb]', $thumb, sprintf(__('Check to %snot%s display the thumbnail of the post.', 'special-teaser-widget'), '<strong>', '</strong>'), array('space' => true));
		a5_select($base_id.'headline', $base_name.'[headline]', $options, $headline, __('Choose, whether or not to display the title and whether it comes above or under the thumbnail.', 'special-teaser-widget'), false, array('space' => true));
		a5_textarea($base_id.'excerpt', $base_name.'[excerpt]', $excerpt, __('If the excerpt of the post is not defined, by default the first 3 sentences of the post are shown. You can enter your own excerpt here, if you want.', 'special-teaser-widget'), array('space' => true, 'class' => 'widefat', 'style' => 'height: 60px;'));
		a5_checkbox($base_id.'fullpost', $base_name.'[fullpost]', $image, __('Check to display the full post instead of an excerpt.', 'special-teaser-widget'), array('space' => true));
		a5_checkbox($base_id.'linespace', $base_name.'[linespace]', $linespace, __('Check to have each sentence in a new line.', 'special-teaser-widget'), array('space' => true));
		a5_checkbox($base_id.'notext', $base_name.'[notext]', $notext, sprintf(__('Check to %snot%s display the excerpt.', 'special-teaser-widget'), '<strong>', '</strong>'), array('space' => true));
		a5_checkbox($base_id.'noshorts', $base_name.'[noshorts]', $noshorts, __('Check to suppress shortcodes in the widget (in case the content is showing).', 'special-teaser-widget'), array('space' => true));
		a5_checkbox($base_id.'filter', $base_name.'[filter]', $filter, __('Check to return the excerpt unfiltered (might avoid interferences with other plugins).', 'special-teaser-widget'), array('space' => true));
		parent::read_more($instance);
		parent::page_checkgroup($instance);
		a5_resize_textarea(array($base_id.'excerpt'), true);
		
	} // form
	 
	function update($new_instance, $old_instance) {
		 
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['name'] = strip_tags($new_instance['name']);
		$instance['clickable'] = @$new_instance['clickable'];
		$instance['article'] = strip_tags($new_instance['article']);
		$instance['backup'] = strip_tags($new_instance['backup']);	 
		$instance['thumb'] = @$new_instance['thumb'];	 
		$instance['image'] = @$new_instance['image'];	 
		$instance['width'] = strip_tags($new_instance['width']);	 
		$instance['headline'] = strip_tags($new_instance['headline']);
		$instance['excerpt'] = $new_instance['excerpt'];
		$instance['fullpost'] = @$new_instance['fullpost'];
		$instance['linespace'] = @$new_instance['linespace'];
		$instance['notext'] = @$new_instance['notext'];
		$instance['noshorts'] = @$new_instance['noshorts'];
		$instance['filter'] = @$new_instance['filter'];
		$instance['readmore'] = @$new_instance['readmore'];
		$instance['rmtext'] = strip_tags($new_instance['rmtext']);
		$instance['rmclass'] = strip_tags($new_instance['rmclass']);
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['linktocat'] = @$new_instance['linktocat'];
		$instance['category_id'] = strip_tags($new_instance['category_id']);
		$instance['homepage'] = @$new_instance['homepage'];
		$instance['frontpage'] = @$new_instance['frontpage'];
		$instance['page'] = @$new_instance['page'];
		$instance['category'] = @$new_instance['category'];
		$instance['single'] = @$new_instance['single'];
		$instance['date'] = @$new_instance['date'];
		$instance['archive'] = @$new_instance['archive'];
		$instance['tag'] = @$new_instance['tag'];
		$instance['attachment'] = @$new_instance['attachment'];
		$instance['taxonomy'] = @$new_instance['taxonomy'];
		$instance['author'] = @$new_instance['author'];
		$instance['search'] = @$new_instance['search'];
		$instance['not_found'] = @$new_instance['not_found'];
		$instance['login_page'] = @$new_instance['login_page'];
		
		return $instance;
	
	} // update
	 
	function widget($args, $instance) {
		
	if (!$instance['style']) :
	
		echo '<!-- Special Teaser Widget is not setup for this view. -->';
		
		return;
		
	endif;
		
	// get the type of page, we're actually on
	
	$show_widget = parent::check_output($instance);
	
	// display only, if said so in the settings of the widget
	
	if ($show_widget) :
	
		$eol = "\n";
		
		// the widget is displayed	
		
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['name']);
		$style = $instance['style'];
		
		$old_classname = $this->widget_options['classname'];
		$new_classname = $old_classname.' '.$style;
	
		$before_widget = str_replace($old_classname, $new_classname, $before_widget);
		
		$before_title='<div class="'.$style.'_title"><h3>';
		$after_title='</h3></div>';
		
		$before_content='<div class="'.$style.'_content">';
		$after_content='</div>';
		
		// widget starts
		
		echo $before_widget;
		
		// widget title and does it link?
		
		if ( $title && $instance['clickable'] ) $title = '<a href="'.get_category_link($instance['category_id']).'" title="'.__('Permalink to', 'special-teaser-widget').' '.get_cat_name($instance['category_id']).'">'.$title.'</a>';
		
		if ( $title ) echo $before_title . $title . $after_title;
		
		echo $before_content;
		
		global $wp_query, $post;
			
		$stw_post_id = get_post($instance['article']);
		$stw_post_name = $stw_post_id->post_name;
		
		$stw_post = ($instance['article'] == $wp_query->get( 'p' ) || $stw_post_name == $wp_query->get ( 'name' )) ? 'p='.$instance['backup'] : 'p='.$instance['article'];
		
		if ($stw_post == 'p=') $stw_post = 'posts_per_page=1&orderby=rand';
	 
		/* This is the actual function of the plugin, it fills the widget with the customized post */
		
		$stw_posts = new WP_Query($stw_post);
		
		while($stw_posts->have_posts()) :
			
			$stw_posts->the_post();
	 
			$stw_tags = A5_Image::tags();
			
			$stw_image_alt = $stw_tags['image_alt'];
			$stw_image_title = $stw_tags['image_title'];
			$stw_title_tag = $stw_tags['title_tag'];
   
			// get the headline, if wanted
			
			if ($instance['headline'] != 'none') :
				
				$stw_permalink = ($instance['linktocat']) ? get_category_link($instance['cat_selected']) : get_permalink();
				$stw_headline_tag = ($instance['linktocat']) ? __('Permalink to', 'special-teaser-widget').' '.get_cat_name($instance['cat_selected']) : $stw_title_tag;
				
				$stw_headline = '<p><a href="'.$stw_permalink.'" title="'.$stw_headline_tag.'">'.$post->post_title.'</a></p>';
				
			endif;
	   
			// thumbnail, if wanted
			
			if (!$instance['thumb']) :
			
				$id = get_the_ID();
				
				$number = ($instance['image']) ? $instance['image'] : NULL;
				
				$args = array (
					'id' => $id,
					'option' => 'stw_options',
					'width' => $instance['width'],
					'number' => $number
				);
				   
				$stw_image_info = A5_Image::thumbnail($args);
				
				$stw_thumb = $stw_image_info[0];
				
				$stw_width = $stw_image_info[1];
				
				$stw_height = ($stw_image_info[2]) ? ' height="'.$stw_image_info[2].'"' :'';
					
				if ($stw_thumb) $stw_img_tag = '<img title="'.$stw_image_title.'" src="'.$stw_thumb.'" alt="'.$stw_image_alt.'" class="wp-post-image" width="'.$stw_width.'"'.$stw_height.' />';
					
				if (!empty($stw_img_tag)) $stw_image = '<a href="'.get_permalink().'">'.$stw_img_tag.'</a>'.$eol.'<div style="clear: both;"></div>'.$eol;
			
			endif;
		
			// excerpt, if wanted
			
			if (!$instance['notext']) :
			
				$rmtext = ($instance['rmtext']) ? $instance['rmtext'] : '[&#8230;]';
				
				$shortcode = ($instance['noshorts']) ? false : 1;
				
				$filter = ($instance['filter']) ? false : true;
			
				$args = array(
					'usertext' => $instance['excerpt'],
					'excerpt' => $post->post_excerpt,
					'content' => $post->post_content,
					'shortcode' => $shortcode,
					'filter' => $filter,
					'linespace' => $instance['linespace'],
					'link' => get_permalink(),
					'title' => $stw_title_tag,
					'readmore' => $instance['readmore'],
					'rmtext' => $rmtext
				);
				
				if (!empty($instance['fullpost'])) $args['type'] = 'post';
			
				$stw_text = A5_Excerpt::text($args);
			
			endif;
		
			// writing the stuff in the widget
			
			if ($instance['headline'] == 'top') echo $stw_headline.$eol;
			
			if (!$instance['thumb'] && isset($stw_image)) echo $stw_image;
			
			if ($instance['headline'] == 'bottom') echo $stw_headline.$eol;
			
			if (!$instance['notext']) echo '<p>'.do_shortcode($stw_text).'</p>'.$eol;
		
		endwhile;
		
		// Restore original Query & Post Data
		wp_reset_query();
		wp_reset_postdata();
		
		echo $after_content;
		
		echo $after_widget;
	
	else:
	
		echo "<!-- Special Teaser Widget is not setup for this view. -->";
	 
	endif;
	
	} // widget
	
} // class

?>