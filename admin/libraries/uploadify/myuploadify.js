function removeElement(divNum,data) {
  if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
	  var d = document.getElementById('sortable');
	  var olddiv = document.getElementById(divNum);
	  $.ajax({
			url: "index2.php?module=products&view=products&raw=1&task=deleteOtherImage",
			type: "get",
			data: "data="+data,
			error: function(){
				alert("Lỗi xoa dữ liệu");
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
	$("#sortable").sortable({
		update : function () {
			serial = $('#sortable').sortable('serialize');
			$.ajax({
				url: "index2.php?module=products&view=products&raw=1&task=sortProductImages",
				type: "post",
				data: serial,
				error: function(){
					alert("Lỗi load dữ liệu");
				}
			});

		}
	});
	
});