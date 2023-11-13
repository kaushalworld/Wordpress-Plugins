<?php
$page_count = 0;
if (isset($data)) {
	extract($data);
}
?>

<div class="wpra-analytics-table-navs">
	<div class="wpra-analytics-table-navs-total">
		<span>Showing <span class="wpra-analytics-table-navs-total-curr">1</span> of <?php echo $page_count; ?> total pages</span>
	</div>
	<div class="wpra-analytics-table-navs-items">
		<span class="table-nav-first"><i class="qa qa-angle-double-left"></i></span>
		<span class="table-nav-prev"><i class="qa qa-angle-left"></i></span>
		<span class="table-nav-next"><i class="qa qa-angle-right"></i></span>
		<span class="table-nav-last"><i class="qa qa-angle-double-right"></i></span>
	</div>
</div>
