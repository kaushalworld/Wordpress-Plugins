<?php

namespace LivemeshAddons\Blocks;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('LAE_Blocks_Init')):

    class LAE_Blocks_Init {

        public function __construct() {

            $this->setup_constants();

            $this->includes();

            $this->hooks();
        }

        private function setup_constants() {

            // Plugin Folder Path
            if (!defined('LAE_BLOCKS_DIR')) {
                define('LAE_BLOCKS_DIR', LAE_PLUGIN_DIR. 'includes/blocks/');
            }

        }

        private function includes() {

            require_once LAE_BLOCKS_DIR . 'block.php';
            require_once LAE_BLOCKS_DIR . 'block-header.php';
            require_once LAE_BLOCKS_DIR . 'block-layout.php';
            require_once LAE_BLOCKS_DIR . 'blocks-manager.php';
            require_once LAE_BLOCKS_DIR . 'block-posts.php';
            require_once LAE_BLOCKS_DIR . 'block-gallery.php';
            require_once LAE_BLOCKS_DIR . 'block-twitter.php';
            require_once LAE_BLOCKS_DIR . 'block-youtube.php';
            require_once LAE_BLOCKS_DIR . 'block-vimeo.php';
            require_once LAE_BLOCKS_DIR . 'block-instagram.php';
            require_once LAE_BLOCKS_DIR . 'module.php';

            /* Block Headers */
            require_once LAE_BLOCKS_DIR . 'headers/block-header-1.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-2.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-3.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-4.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-5.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-6.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-7.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-youtube.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-vimeo.php';
            require_once LAE_BLOCKS_DIR . 'headers/block-header-instagram.php';

            /* Source */
            require_once LAE_BLOCKS_DIR . 'source/source.php';
            require_once LAE_BLOCKS_DIR . 'source/posts-source.php';
            require_once LAE_BLOCKS_DIR . 'source/gallery-source.php';
            require_once LAE_BLOCKS_DIR . 'source/twitter-source.php';
            require_once LAE_BLOCKS_DIR . 'source/youtube-source.php';
            require_once LAE_BLOCKS_DIR . 'source/vimeo-source.php';
            require_once LAE_BLOCKS_DIR . 'source/instagram-source.php';

            require_once LAE_BLOCKS_DIR . 'source/gallery/video-helper.php';

            /* Clients */
            require_once LAE_BLOCKS_DIR . 'clients/social-client.php';
            require_once LAE_BLOCKS_DIR . 'clients/twitter-client.php';
            require_once LAE_BLOCKS_DIR . 'clients/youtube-client.php';
            require_once LAE_BLOCKS_DIR . 'clients/vimeo-client.php';
            require_once LAE_BLOCKS_DIR . 'clients/instagram-client.php';

            /* Modules */
            require_once LAE_BLOCKS_DIR . 'modules/module-1.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-2.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-3.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-4.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-5.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-6.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-7.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-8.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-9.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-10.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-11.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-12.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-13.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-14.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-15.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-16.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-17.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-18.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-19.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-20.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-21.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-22.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-23.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-24.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-25.php';
            require_once LAE_BLOCKS_DIR . 'modules/module-26.php';

            /* Block Types */
            require_once LAE_BLOCKS_DIR . 'types/block-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-2.php';
            require_once LAE_BLOCKS_DIR . 'types/block-3.php';
            require_once LAE_BLOCKS_DIR . 'types/block-4.php';
            require_once LAE_BLOCKS_DIR . 'types/block-5.php';
            require_once LAE_BLOCKS_DIR . 'types/block-6.php';
            require_once LAE_BLOCKS_DIR . 'types/block-7.php';
            require_once LAE_BLOCKS_DIR . 'types/block-8.php';
            require_once LAE_BLOCKS_DIR . 'types/block-9.php';
            require_once LAE_BLOCKS_DIR . 'types/block-10.php';
            require_once LAE_BLOCKS_DIR . 'types/block-11.php';
            require_once LAE_BLOCKS_DIR . 'types/block-12.php';
            require_once LAE_BLOCKS_DIR . 'types/block-13.php';

            require_once LAE_BLOCKS_DIR . 'types/block-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-grid-2.php';
            require_once LAE_BLOCKS_DIR . 'types/block-grid-3.php';
            require_once LAE_BLOCKS_DIR . 'types/block-grid-4.php';
            require_once LAE_BLOCKS_DIR . 'types/block-grid-5.php';
            require_once LAE_BLOCKS_DIR . 'types/block-grid-6.php';

            require_once LAE_BLOCKS_DIR . 'types/block-custom-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-custom-grid-2.php';

            require_once LAE_BLOCKS_DIR . 'types/block-gallery-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-gallery-2.php';
            require_once LAE_BLOCKS_DIR . 'types/block-gallery-3.php';

            require_once LAE_BLOCKS_DIR . 'types/block-twitter-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-twitter-grid-2.php';
            require_once LAE_BLOCKS_DIR . 'types/block-twitter-grid-3.php';

            require_once LAE_BLOCKS_DIR . 'types/block-youtube-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-youtube-grid-2.php';

            require_once LAE_BLOCKS_DIR . 'types/block-vimeo-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-vimeo-grid-2.php';

            require_once LAE_BLOCKS_DIR . 'types/block-instagram-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-instagram-grid-2.php';
            require_once LAE_BLOCKS_DIR . 'types/block-instagram-grid-3.php';

            require_once LAE_BLOCKS_DIR . 'types/block-woocommerce-grid-1.php';
            require_once LAE_BLOCKS_DIR . 'types/block-woocommerce-grid-2.php';

            /* Block Functions */

            require_once LAE_BLOCKS_DIR . 'functions/post-functions.php';
            require_once LAE_BLOCKS_DIR . 'functions/gallery-functions.php';
            require_once LAE_BLOCKS_DIR . 'functions/twitter-functions.php';
            require_once LAE_BLOCKS_DIR . 'functions/youtube-functions.php';
            require_once LAE_BLOCKS_DIR . 'functions/vimeo-functions.php';
            require_once LAE_BLOCKS_DIR . 'functions/instagram-functions.php';
            require_once LAE_BLOCKS_DIR . 'functions/woocommerce-functions.php';
        }

        private function hooks(){

        }

    }

endif;

new LAE_Blocks_Init();
