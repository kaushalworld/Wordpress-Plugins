<?php

class BrizyPro_Content_Placeholders_Comments extends Brizy_Content_Placeholders_Simple {

	private $atts = [];

	/**
	 * Brizy_Editor_Content_GenericPlaceHolder constructor.
	 *
	 * @param string $label
	 * @param string $placeholder
	 */
	public function __construct( $label, $placeholder, $group=null ) {
		parent::__construct( $label, $placeholder, function ( Brizy_Content_Context $context, \BrizyPlaceholders\ContentPlaceholder $contentPlaceholder ) {
			return $this->comments_template( $contentPlaceholder->getAttributes() );
		}, $group );
	}

	public function comments_template( $atts ) {

		$this->atts        = $atts;
		$this->atts['woo'] = is_singular( [ 'product' ] );

		add_action( 'wp_list_comments_args',        [ $this, '_action_wp_list_comments_args' ] );
		add_action( 'comments_template',            [ $this, '_action_comments_template' ], 99999 );
		add_action( 'comments_template_query_args', [ $this, '_action_comments_template_query_args' ] );
		add_action( 'comment_form_default_fields',  [ $this, '_action_comment_form_default_fields' ] );
		add_action( 'comment_form_defaults',        [ $this, '_action_comment_form_defaults' ] );
		add_action( 'option_comments_per_page',     [ $this, '_action_comments_per_page' ] );

		ob_start(); ob_clean();

		comments_template();

		return ob_get_clean();
	}

	public function _action_wp_list_comments_args( $args ) {
		return array_merge( $args, $this->atts );
	}

	public function _action_comments_template() {
		return implode( DIRECTORY_SEPARATOR, [ BRIZY_PRO_PLUGIN_PATH, 'templates', 'comments.php' ] );
	}

	public function _action_comments_template_query_args( $comment_args ) {

		$per_page = (int)$this->atts['limit'];
		$page     = get_query_var( 'cpage' );

		if ( $page ) {
			$comment_args['offset'] = ( $page - 1 ) * $per_page;
		} elseif ( 'oldest' === get_option( 'default_comments_page' ) ) {
			$comment_args['offset'] = 0;
		} else {
			// If fetching the first page of 'newest', we need a top-level comment count.
			$top_level_query = new WP_Comment_Query();
			$top_level_args  = [
				'count'   => true,
				'orderby' => false,
				'post_id' => $comment_args['post_id'],
				'status'  => 'approve',
			];

			if ( $comment_args['hierarchical'] ) {
				$top_level_args['parent'] = 0;
			}

			if ( isset( $comment_args['include_unapproved'] ) ) {
				$top_level_args['include_unapproved'] = $comment_args['include_unapproved'];
			}

			/**
			 * Filters the arguments used in the top level comments query.
			 *
			 * @since 5.6.0
			 *
			 * @see WP_Comment_Query::__construct()
			 *
			 * @param array $top_level_args {
			 *     The top level query arguments for the comments template.
			 *
			 *     @type bool         $count   Whether to return a comment count.
			 *     @type string|array $orderby The field(s) to order by.
			 *     @type int          $post_id The post ID.
			 *     @type string|array $status  The comment status to limit results by.
			 * }
			 */
			$top_level_args = apply_filters( 'comments_template_top_level_query_args', $top_level_args );

			$top_level_count = $top_level_query->query( $top_level_args );

			$comment_args['offset'] = ( ceil( $top_level_count / $per_page ) - 1 ) * $per_page;
		}

		$comment_args['number'] = $per_page;

		return $comment_args;
	}

	public function _action_comment_form_default_fields( $fields ) {

		$commenter     = wp_get_current_commenter();
		$req           = get_option( 'require_name_email' );
		$aria_req      = ( $req ? " aria-required='true'" : '' );

		$fields['author'] =
			'<p class="brz-comment-form-author">
				<label for="author">' . __( 'Name', 'brizy-pro' ) .
					( $req ? '<span class="required">*</span>' : '' ) .
				'</label>' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
			</p>';

		$fields['email'] =
			'<p class="brz-comment-form-email">
				<label for="email">' . __( 'Email', 'brizy-pro' ) .
				( $req ? '<span class="required">*</span>' : '' ) .
				'</label>' .
				'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
			</p>';

		$fields['url'] =
			'<p class="brz-comment-form-url">
				<label for="url">' . __( 'Website', 'brizy-pro' ) . '</label>' .
				'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
			</p>';

		return $fields;
	}

	public function _action_comment_form_defaults( $args ) {

		$req           = get_option( 'require_name_email' );
		$user          = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';
		$required_text = sprintf( ' ' . __( 'Required fields are marked %s', 'brizy-pro' ), '<span class="required">*</span>' );
		$form_title    = $this->atts['woo'] ? _x( 'Your review', 'noun', 'brizy-pro' ) : _x( 'Comment', 'noun', 'brizy-pro' );

		$args['id_form']            = 'brz-comment-form';
		$args['class_form']         = 'brz-form brz--comment__form-reply-body';
		$args['id_submit']          = 'brz-submit';
		$args['class_submit']       = 'brz-submit';
		$args['submit_field']       = '<p class="brz-form-submit">%1$s %2$s</p>';
		$args['title_reply_before'] = '<h3 id="reply-title" class="brz-comment-reply-title">';

		$args['comment_field'] =
			'<p class="brz-comment-form-comment">
				<label for="comment">' . $form_title . '</label>
				<textarea name="comment" cols="45" rows="8" aria-required="true"></textarea>
			</p>';

		$args['must_log_in'] =
			'<p class="brz-must-log-in">' .
				sprintf(
					__( 'You must be %1$slogged in%2$s to post a comment.', 'brizy-pro' ),
					'<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">',
                    '</a>'
				) .
			'</p>';

		$args['logged_in_as'] =
			'<p class="brz-logged-in-as">' .
				sprintf(
					__( 'Logged in as %1$s. %2$sLog out?%3$s', 'brizy-pro' ),
					'<a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>' ,
					'<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . esc_attr__( 'Log out of this account', 'brizy-pro' ) . '">',
					'</a>'
				) .
			'</p>';

		$args['comment_notes_before'] =
			'<p class="comment-notes">' .
				__( 'Your email address will not be published.', 'brizy-pro' ) . ( $req ? $required_text : '' ) .
			'</p>';

		if ( $this->atts['woo'] ) {

			$args['title_reply'] = have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() );

			if ( wc_review_ratings_enabled() ) {
				$args['comment_field'] =
					'<div class="comment-form-rating">
						<label for="rating">' . esc_html__( 'Your rating', 'brizy-pro' ) . '</label>
						<select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'brizy-pro' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'brizy-pro' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'brizy-pro' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'brizy-pro' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'brizy-pro' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'brizy-pro' ) . '</option>
						</select>
					</div>' .
					$args['comment_field'];
			}
		}

		return $args;
	}

	public function _action_comments_per_page() {
		return $this->atts['limit'];
	}

	public function _action_thread_comments_depth() {
		return 5; //$this->atts['thread'];
	}
}