<?php

/* autoload */

foreach (glob(get_stylesheet_directory() . "/includes/*.php") as $file) {
	require_once $file;
}


/* enqueue scripts and style from parent theme */
function twentytwenty_styles()
{
	wp_enqueue_style('parent', get_template_directory_uri() . '/style.css');
}

add_action('wp_enqueue_scripts', 'twentytwenty_styles');

/**
 *
 *  custom cpt
 */

add_action('init', 'create_af_cpt');

function create_af_cpt()
{	

	$labels = [
		"name"          => __( 'Projekty', 'VIZE2030' ),
		'add_new' 		=> __( 'Přidat projekt', 'VIZE2030' ),
		"singular_name" => __( 'Projekt', 'VIZE2030' ),
	];

	$args = [
		"label"               => __( 'Projekty', 'VIZE2030' ),
		"labels"              => $labels,
		"description"         => "",
		"public"              => true,
		"publicly_queryable"  => true,
		"show_ui"             => true,
		"show_in_rest"        => false,
		"rest_base"           => "",
		"show_in_menu"        => true,
					"has_archive"         => 'projekty',
		"exclude_from_search" => false,
		"capability_type"     => "post",
		'capabilities' => array(
			'read_post' => 'read_post'
		),
		"map_meta_cap"        => true,
		"hierarchical"        => false,
		"rewrite"             => array( "slug" => "projekty/%rocnik%", "with_front" => true ),
		"query_var"           => true,
		"supports"            => ['title', 'editor', 'thumbnail', 'custom-fields'],
	];

	register_post_type( 'projekt', $args );

	$labels = array(
		"name"          => __( 'Ročníky', 'VIZE2030' ),
		"singular_name" => __( 'Ročník', 'VIZE2030' ),
	);

	$args = array(
		"label"              => __( 'Ročníky', 'VIZE2030' ),
		"labels"             => $labels,
		"public"             => true,
		"hierarchical"       => true,
		"show_ui"            => true,
		"show_in_menu"       => true,
		"show_in_nav_menus"  => true,
		"query_var"          => true,
		"rewrite"            => array( 'slug' => 'projekty' ),
		"show_admin_column"  => true,
		"show_in_rest"       => false,
		"rest_base"          => "",
		"show_in_quick_edit" => false,
	);

    register_taxonomy( 'rocnik', ['projekt'], $args );

	register_post_type(
		'partner',
		[
			'labels' => [
				'name' => 'Partneři',
				'singular_name' => 'Partner',
				'add_new' => 'Přidat partnera',
				'all_items' => 'Všichni partneři',
				'add_new_item' => 'Přidat partnera',
				'edit_item' => 'Upravit partnera',
				'new_item' => 'Nový partner',
				'view_item' => 'Zobrazit partnera',
				'search_items' => 'Hledat partnera',
				'not_found' => 'Partneři nenalezeni',
				'not_found_in_trash' => 'Nenalezeno'
			],
			'public' => true,
			'has_archive' => false,
			'query_var' => true,
			'rewrite' => true,
			'hierarchical' => false,
			'supports' => ['title', 'custom-fields', 'excerpt', 'page-attributes']
		]
	);
}

/**
 *
 *  taxonomy dropdown
 */
add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy()
{
	global $typenow;
	$post_type = 'projekt'; // change to your post type
	$taxonomy  = 'rocnik'; // change to your taxonomy
	if ($typenow == $post_type) {
		$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
		$info_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories([
			'show_option_all' => 'Zobrazit všechny ročníky',
			'taxonomy'        => $taxonomy,
			'name'            => $taxonomy,
			'orderby'         => 'name',
			'selected'        => $selected,
			'show_count'      => false,
			'hide_empty'      => true,
		]);
	};
}

add_filter('parse_query', 'tsm_convert_id_to_term_in_query');

function tsm_convert_id_to_term_in_query($query)
{
	global $pagenow;
	$post_type = 'projekt';
	$taxonomy  = 'rocnik';
	$q_vars    = &$query->query_vars;
	if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
		$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
		$q_vars[$taxonomy] = $term->slug;
	}
}

/**
 * cpt slug
 */

add_filter('post_type_link', 'af_update_permalink_structure', 10, 2);
function af_update_permalink_structure( $post_link, $post )
{
    if ( false !== strpos( $post_link, '%rocnik%' ) ) {
        $taxonomy_terms = get_the_terms( $post->ID, 'rocnik' );

		if ($taxonomy_terms) {
			foreach ( $taxonomy_terms as $term ) {
				if ( ! $term->parent ) {
					$post_link = str_replace( '%rocnik%', $term->slug, $post_link );
				}
			} 
		}
        
    }
    return $post_link;
}

//add_action('wp_loaded', 'af_custom_redirect');
// function af_custom_redirect()
// {

// 	$request = $_SERVER['REQUEST_URI'];

// 	if (!is_user_logged_in() && !is_int(strpos($request, "/registrace")) && !is_int(strpos($request, "/vstup")) && !is_int(strpos($request, "/wp-login.php")) && !is_int(strpos($request, "/wp-json/")) && !is_int(strpos($request, "/zadost-odeslana"))) {
// 		wp_redirect(site_url("vstup"));
// 		exit;
// 	}
// }


// function af_add_cpt_post_names_to_main_query($query)
// {
//   // Bail if this is not the main query.
//   if (!$query->is_main_query()) {
//     return;
//   }
//   // Bail if this query doesn't match our very specific rewrite rule.
//   if (!isset($query->query['page']) || 2 !== count($query->query)) {
//     return;
//   }
//   // Bail if we're not querying based on the post name.
//   if (empty($query->query['name'])) {
//     return;
//   }
//   // Add CPT to the list of post types WP will include when it queries based on the post name.
//   $query->set('post_type', array('post', 'page', 'event'));
// }
//add_action('pre_get_posts', 'af_add_cpt_post_names_to_main_query');