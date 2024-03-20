
## HEADER
wp-content/themes/blocksy/inc/panel-builder/header/trigger/view.php
```php 
    <?php /*
	<svg
		class="ct-icon"
		width="18" height="14" viewBox="0 0 18 14"
		aria-hidden="true"
		data-type="<1?php echo esc_attr($trigger_type) ?>">
		<rect y="0.00" width="18" height="1.7" rx="1"/>
		<rect y="6.15" width="18" height="1.7" rx="1"/>
		<rect y="12.3" width="18" height="1.7" rx="1"/>
	</svg>
    */
	?>

    <svg class="ct-icon" aria-hidden="true" data-type="<?php echo esc_attr($trigger_type) ?>"
    width="32" height="16" viewBox="0 0 32 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect y="10.345" width="27" height="5" rx="2.5" fill="white"/>
        <rect x="5" y="0.344971" width="27" height="5" rx="2.5" fill="white"/>
    </svg>

</button>
```

## HEADER - Sub menu
wp-content/themes/blocksy/inc/components/menus.php
```php
if (! function_exists('blocksy_menu_get_child_svgs')) {
	function blocksy_menu_get_child_svgs() {
        // 'default' => '<svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15"><path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/></svg>',
		return [
			'default' => '<svg width="11" height="7" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L5.5 5.5L10 1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',

```