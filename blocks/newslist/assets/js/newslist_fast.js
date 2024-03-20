$(document).ready(function() {
	configFastNews();
});

function configFastNews(){
	if($("#news-fast").length){
		$("#news-fast").carouFredSel({items:{visible:1,width:568,height:18},scroll:{items:1,mousewheel:true},auto:{play:true,delay:100}})
	}
}