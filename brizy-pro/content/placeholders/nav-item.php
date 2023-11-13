<?php
use BrizyPlaceholders\ContentPlaceholder;
use BrizyPlaceholders\ContextInterface;

class BrizyPro_Content_Placeholders_NavItem extends Brizy_Content_Placeholders_Abstract
{
	public function support($placeholderName) {
		return strpos( $placeholderName, 'nav_item_' ) !== false;
	}

	public function getValue(ContextInterface $context, ContentPlaceholder $contentPlaceholder)
	{
		$placeholder = $contentPlaceholder->getName();
		$item        = $this->getItemField( $contentPlaceholder->getAttribute( 'menuId' ), $contentPlaceholder->getAttribute( 'itemId' ) );

		if ( ! $item ) {
			return '';
		}

		if ( strpos( $placeholder, 'url' ) ) {
			return $item['url'];
		} elseif ( strpos( $placeholder, 'title' ) ) {
			return $item['title'];
		}

		$replacer = new \BrizyPlaceholders\Replacer( $context->getProvider() );

		return $replacer->replacePlaceholders( $contentPlaceholder->getContent(), $context );
	}

	public function getItemField( $menuUid, $itemUid ) {

		static $menuUids;

		if ( isset( $menuUids[ $menuUid ] ) ) {
			return isset( $menuUids[ $menuUid ][ $itemUid ] ) ? $menuUids[ $menuUid ][ $itemUid ] : '';
		}

		$menu = get_terms( [ 'meta_key' => 'brizy_uid', 'meta_value' => $menuUid, 'fields' => 'ids' ] );

		if ( is_wp_error( $menu ) || count( $menu ) !== 1 ) {
			return '';
		}

		foreach ( wp_get_nav_menu_items( $menu[0] ) as $item ) {
			$uid = get_post_meta( $item->ID, 'brizy_post_uid', true );

            if ( ! $uid ) {
                $uid = $item->ID;
            }

			$menuUids[ $menuUid ][ $uid ] = [
				'title' => $item->title,
				'url'   => $item->url,
				'id'    => $uid
			];
		}

		return isset( $menuUids[ $menuUid ][ $itemUid ] ) ? $menuUids[ $menuUid ][ $itemUid ] : '';
	}

	public function replaceOnCompiling( &$items, $menuId ) {

		if ( empty( $items ) ) {
			return;
		}

		foreach ( $items as &$item ) {
			$item->value->title = sprintf( "{{ nav_item_title menuId='%s' itemId='%s' }}", $menuId, $item->value->id );
			$item->value->url   = sprintf( "{{ nav_item_url menuId='%s' itemId='%s' }}", $menuId, $item->value->id );

			if ( ! empty( $item->value->items ) ) {
				$this->replaceOnCompiling( $item->value->items, $menuId );
			}
		}
	}
}
