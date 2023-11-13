<?php
use WPRA\Config;
?>
<div class="floating-menu">
    <ul>
		<?php foreach ( Config::$top_menu_items as $top_menu_item ): ?>
            <li>
                <a target="<?php echo $top_menu_item["target"]; ?>"
                   href="<?php echo $top_menu_item["link"]; ?>">
					<?php
					echo $top_menu_item["icon"];
					echo '<span>' . $top_menu_item["name"] . '</span>';
					?>
                </a>
            </li>
		<?php endforeach; ?>
    </ul>
</div>
