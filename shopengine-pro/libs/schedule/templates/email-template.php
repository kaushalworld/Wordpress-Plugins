<style>
    .wpmet-mail-template-container {
        display: flex;
        justify-content: center;
        margin-top: 100px;
    }

    .wpmet-mail-template-container .wpmet-mail-template-box {
        max-width: 700px;
        box-shadow: -4px 4px 20px 3px rgb(0 0 0 / 10%);
    }

    .wpmet-mail-template-container .title {
        padding: 20px 10px;
        font-size: 30px;
        margin-bottom: 16px;
        background: #03a9f426;
        color: black;
    }
    .wpmet-mail-template-container .content {
        padding: 16px;
        line-height: 24px;
        padding-bottom: 30px
    }

    .wpmet-mail-template-box .content table {
        border-collapse: collapse;
        width: 100%;
    }

    .wpmet-mail-template-box .content table td, .wpmet-mail-template-box .content table th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

</style>
<div class="wpmet-mail-template-container">
    <div class="wpmet-mail-template-box">
        <div class="title"><?php
			echo esc_html($title); ?></div>

        <div class="content">

			<?php
            echo wp_kses($content, \ShopEngine_Pro\Util\Helper::get_kses_array()); 
			?>

        </div>
    </div>
</div>