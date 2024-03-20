function removeElement(divNum,data,table) {
  if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
	  var d = document.getElementById('my-dropzone');
	  var olddiv = document.getElementById(divNum);
	  $.ajax({
			url: "index.php?module=estores&view=product&raw=1&task=deleteOtherImage",
			type: "get",
			data: "data="+data+"&table="+table,
			error: function(){
				alert("Lỗi xóa dữ liệu");
			},
            success: function(){
                d.removeChild(olddiv);
            }
 		});
  }else{
  	return false;
  }
}
$(function() {
//	$("#my-dropzone").load("index.php?module=estores&view=product&raw=1&task=getAjaxImages&data="+uploadConfig);
	$("#my-dropzone").sortable({
		update : function () {
			serial = $('#my-dropzone').sortable('serialize');
			$.ajax({
				url: "index.php?module=estores&view=product&raw=1&task=sortProductImages",
				type: "post",
				data: serial,
				error: function(){
					alert("Lỗi load dữ liệu");
				}
			});

		}
	});
});
