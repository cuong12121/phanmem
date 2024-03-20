$(function () {
	listproductpage2.init();
});
listproductpage2 = (function () {


	  function init() {
	        handler();
	  }
	  function handler() {
		  $.when($('.list-product-hot').masonry({
	          gutterWidth: 5,
	          columnWidth: 1,
	          itemSelector: '.product'
	      })).done(function (v) {
	          ReloadListUI();
	      });
		  

	      $('.load_more').click(function () {
	    	var keyword = $( "#keyword" ).val();
	    	var width = $( window ).width();
	    	// Start Masonry
	    	  jQuery('.list-product-hot').masonry({
	    		  gutterWidth: 5,
		          columnWidth: 1,
		          itemSelector: '.product'
	    	  });
	            var _self = $(this);
	            _self.hide();
	            _self.parent().addClass("loading");
	            $.get("/index.php?module=products&view=search&task=fetch_pages&raw=1", { pagecurrent: $(this).attr('data-pagecurrent'),width:width,keyword:keyword}, function (data) {	             
	            	data = JSON.parse(data);
	            	
	            	$element = $(data.content);
	            	console.log(data.next);
	                console.log(data.next);
	                $('.list-product-hot').append($element).masonry('appended', $element);
	                if (data.next) {
	                    _self.attr('data-pagecurrent', parseInt(data.totalCurrent));
	                    _self.attr('data-nextpage', parseInt(data.nextpage));
	                    _self.show();
	                    _self.parent().removeClass("loading");
	                } else {
	                    _self.parent().remove();
	                }

	            });
	        });
	  }
    return {
        init: init,
    };
})();

function ReloadListUI() {
    $('.product').each(function (i, e) {
        if ($(e).position().top == 0) {
            $(e).addClass('border-top');
        }
    });
}
