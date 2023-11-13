<?php

namespace WPRA\Helpers;

class Notices {

	private static function getNotices() {
		$notices = get_transient('wpra_notices');

		return empty($notices) ? [] : $notices;
	}

	private static function save($notices) {
		set_transient('wpra_notices', $notices, YEAR_IN_SECONDS);
	}

	static function add($name, $type, $context = NoticeContext::ALL, $data = []) {
		$notices = self::getNotices();

		if (!isset($notices[$name])) {
			$notices = array_merge($notices, [
				$name => [
					'type'    => $type,
					'context' => $context,
					'data'    => $data,
				],
			]);
		}

		self::save($notices);
	}

	static function remove($name) {
		$notices = self::getNotices();
		unset($notices[$name]);
		self::save($notices);
	}

	static function printAll() {
		$notices = get_transient('wpra_notices');
		if (empty($notices)) return;

		foreach ($notices as $name => $notice) {
			$template = str_replace('_', '-', $name);

			if (
				$notice['context'] != NoticeContext::ALL &&
				(($notice['context'] == NoticeContext::PLUGIN && !Utils::isWpraAdmin())
					|| ($notice['context'] == NoticeContext::DASHBOARD && !Utils::isPage('dashboard')))
			) return;

			$notice['data']['type'] = $notice['type'];

			Utils::renderTemplate("view/admin/notices/$template", $notice['data'], true);

			if ($notice['type'] == 'success') {
				unset($notices[$name]);
			}
		}

		self::save($notices);
	}

	static function clearAll() {
		delete_transient('wpra_notices');
	}
}
