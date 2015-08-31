<?php
/**
 * Version    : 1.0.0
 * Author     : inc2734
 * Author URI : http://2inc.org
 * Created    : August 30, 2015
 * Modified   :
 * License    : GPLv2 or later
 * License URI: license.txt
 */

class Habakiri_Page_Header {

	protected $post_id;

	public function __construct( $post_id = null ) {
		$this->post_id = $post_id;
	}

	public function display() {
		$classes       = $this->get_classes();
		$style         = $this->get_style();
		$title_classes = $this->get_title_classes();
		$title         = $this->get_title();
		?>
		<div class="page-header text-center <?php echo esc_attr( $classes ); ?>" <?php echo $style; ?>>
			<div class="container">
				<h1 class="page-header__title <?php echo esc_attr( $title_classes ); ?>">
					<?php echo apply_filters( 'habakiri_title_in_page_header', esc_html( $title ) ); ?>
				</h1>
				<?php $this->the_excerpt(); ?>
			<!-- end .container --></div>
		<!-- end .page-header --></div>
		<?php
	}

	protected function the_excerpt() {
		global $post;
		$is_displaying_page_header_lead = Habakiri::get( 'is_displaying_page_header_lead' );

		if ( is_page() && !empty( $post->post_excerpt ) && $is_displaying_page_header_lead !== 'false' ) {
			?>
			<div class="page-header__description">
				<?php the_excerpt(); ?>
			<!-- end .page-header__description --></div>
			<?php
		}
	}

	protected function get_title() {
		if ( $this->post_id ) {
			return get_the_title( $this->post_id );
		}

		if ( is_404() ) {
			return __( 'Woops! Page not found.', 'habakiri' );
		}

		if ( is_search() ) {
			return sprintf( __( 'Search Results for: %s', 'habakiri' ), get_search_query() );
		}

		$post_type = get_post_type();
		$post_type_object = get_post_type_object( $post_type );
		if ( !empty( $post_type_object->label ) ) {
			return $post_type_object->label;
		}
		return $post_type_object->labels->name;
	}

	protected function get_style() {
		if ( get_header_image() ) {
			return sprintf(
				'style="background-image: url( %s )"',
				get_header_image()
			);
		}
	}

	protected function get_classes() {
		if ( get_header_image() ) {
			return 'page-header--has_background-image';
		}
	}

	protected function get_title_classes() {
		$title_classes = '';
		return apply_filters( 'habakiri_title_class_in_page_header', $title_classes );
	}
}