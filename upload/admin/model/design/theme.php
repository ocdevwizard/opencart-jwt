<?php
namespace Opencart\Admin\Model\Design;
/**
 * Class Theme
 *
 * @package Opencart\Admin\Model\Design
 */
class Theme extends \Opencart\System\Engine\Model {
	/**
	 * @param int    $store_id
	 * @param string $route
	 * @param string $code
	 *
	 * @return void
	 */
	public function editTheme(int $store_id, string $route, string $code): void {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "theme` WHERE `store_id` = '" . (int)$store_id . "' AND `route` = '" . $this->db->escape($route) . "'");

		$this->db->query("INSERT INTO `" . DB_PREFIX . "theme` SET `store_id` = '" . (int)$store_id . "', `route` = '" . $this->db->escape($route) . "', `code` = '" . $this->db->escape($code) . "', `date_added` = NOW()");
	}

	/**
	 * @param int $theme_id
	 *
	 * @return void
	 */
	public function deleteTheme(int $theme_id): void {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "theme` WHERE `theme_id` = '" . (int)$theme_id . "'");
	}

	/**
	 * @param int    $store_id
	 * @param string $route
	 *
	 * @return array
	 */
	public function getTheme(int $store_id, string $route): array {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "theme` WHERE `store_id` = '" . (int)$store_id . "' AND `route` = '" . $this->db->escape($route) . "'");

		return $query->row;
	}

	/**
	 * @param int $start
	 * @param int $limit
	 *
	 * @return array
	 */
	public function getThemes(int $start = 0, int $limit = 10): array {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT *, (SELECT `name` FROM `" . DB_PREFIX . "store` `s` WHERE `s`.`store_id` = `t`.`store_id`) AS `store` FROM `" . DB_PREFIX . "theme` `t` ORDER BY `t`.`date_added` DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	/**
	 * @return int
	 */
	public function getTotalThemes(): int {
		$query = $this->db->query("SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "theme`");

		return (int)$query->row['total'];
	}
}
