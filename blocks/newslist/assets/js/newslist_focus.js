$(document).ready(function() {
	configFocusNews();
});

function configFocusNews(){
	if($("#news-focus").length){
		$("#news-focus").carouFredSel({items:{visible:1,width:568,height:18},scroll:{items:1,mousewheel:true},auto:{play:true,delay:100}})
	}
}