<div class="brz-posts__filter-wrapper">
    <ul class="brz-ul brz-posts__filter <?php echo $ulClassName;?>">
        <li class="brz-posts__filter__item <?php echo $liClassName;?>" data-filter="*"><?php echo $allTag;?></li>
	    <?php foreach( $tags as $tag ): ?>
            <li class="brz-posts__filter__item <?php echo $liClassName;?>" data-filter="<?php echo $tag->slug;?>"><?php echo $tag->name;?></li>
	    <?php endforeach; ?>
    </ul>
</div>
