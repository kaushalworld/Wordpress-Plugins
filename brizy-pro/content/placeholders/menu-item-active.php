<?php
use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_MenuItemActive extends Brizy_Content_Placeholders_Simple
{
	/**
	 * BrizyPro_Content_Placeholders_MenuItemActive constructor.
	 *
	 * @param $label
	 * @param $placeholder
	 */
	public function __construct( $label, $placeholder, $group=null )
	{
		parent::__construct(
			$label,
			$placeholder,
			function ( Brizy_Content_Context $context, ContentPlaceholder $contentPlaceholder ) {
				return $this->getMenuUids( $contentPlaceholder->getAttributes() );
			},
            $group
		);
	}

	/**
	 * @param $attrs
	 *
	 * @return string
	 */
	public function getMenuUids($attrs ) {

		if ( empty( $attrs['menu'] ) ) {
			return '';
		}

		$menu = get_terms( [ 'meta_key' => 'brizy_uid', 'meta_value' => $attrs['menu'], 'fields' => 'ids' ] );

		if ( is_wp_error( $menu ) || count( $menu ) !== 1 ) {
			return '';
		}

		$current = '';
		$items   = wp_get_nav_menu_items( $menu[0] );

		_wp_menu_item_classes_by_context( $items );

		foreach ( $items as $item ) {
			if ( isset( $item->current ) && $item->current ) {
				$current = $item;
				break;
			}
		}

		if ( ! $current ) {
			return '';
		}

		return implode( ',', $this->getMenuUid( $current, $items ) );
	}

	/**
	 * @param $item
	 * @param $items
	 * @param array $uids
	 *
	 * @return array
	 */
	private function getMenuUid( $item, $items, $uids = [] ) {

		$uids[] = get_post_meta( $item->ID, 'brizy_post_uid', true );

		$parent = $item->menu_item_parent;

		if ( ! $parent ) {
			return $uids;
		}

		foreach ( $items as $aitem ) {
			if ( $aitem->ID == $parent ) {
				$parent = $aitem;
				break;
			}
		}

		return $this->getMenuUid( $parent, $items, $uids );
	}
}
