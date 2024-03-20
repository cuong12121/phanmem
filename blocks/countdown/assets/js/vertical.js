$(function() {
	$('.block_product_list #carousel').carouFredSel({
		responsive: true,
		auto:true,
		prev: '.block_product_list #prev',
		next: '.block_product_list #next',
		direction: 'down',
		height: '100%',
		items: {
			visible: {
				min: 3,
				max: 8
			}
		},
		scroll: {
			items: '-1',
			duration: 600
		}
	});

});