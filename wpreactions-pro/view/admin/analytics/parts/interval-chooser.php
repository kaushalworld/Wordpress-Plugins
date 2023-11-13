<?php
$chart_type = '';
if (isset($data)) {
    extract($data);
}
?>

<div class="wpra-interval-chooser" data-chart_type="<?php echo $chart_type; ?>">
	<button class="btn wpra-interval-chooser-toggle">
		<span class="wpra-interval-chooser-current">Last 30 days</span>
		<i class="qa qa-calendar-alt"></i>
	</button>
	<div class="wpra-interval-chooser-options">
		<div class="interval-options">
			<span data-interval="this_week">This Week</span>
			<span data-interval="last_week">Last Week</span>
			<span data-interval="last_30_days">Last 30 days</span>
			<span data-interval="this_month">This Month</span>
			<span data-interval="last_month">Last Month</span>
			<span data-interval="this_year">This Year</span>
			<span class="interval-custom-range" data-interval="custom_range">Custom Range</span>
		</div>
	</div>
    <div class="wpra-interval-chooser-range"></div>
</div>