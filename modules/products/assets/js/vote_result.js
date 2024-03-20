$(document).ready( function(){
	vote_result();
});
function vote_result(){
	$( "#button_vote" ).click(function() {
		vote_result_disable  = $('#vote_result_disable').val();
//		if(vote_result_disable == 1){
		if ($.cookie('vote_'+$('#record_id').val()) == $("#record_id").val()) {	
			alert('Bạn đã đánh giá thiết bị này rồi !');
			return false;
		} else {
			if ($("#pDesign").val() == '') {
				alert('Bạn phải đanh giá thiết kế !');
				$("#pDesign").focus();
				return false;
			}
			if ($("#pFeatures").val() == '') {
				alert('Bạn phải đanh giá tính năng !');
				$("#pFeatures").focus();
				return false;
			}	
			if ($("#pPerformance").val() == '') {
				alert('Bạn phải đanh giá hiệu suất !');
				$("#pPerformance").focus();
				return false;
			}
			id = $('#record_id').val();
			
			$.post("/index.php?module=products&view=product&task=vote_result&id="+id+"&raw=1",
				{
					pDesign     : $("#pDesign").val(),
					pFeatures   : $("#pFeatures").val(),
					pPerformance: $("#pPerformance").val()
				}, function(data)
					{
						var date = new Date();
						var minutes = 1;
						date.setTime(date.getTime() + (minutes * 60 * 1000));
						$("#voteresult").html(data);
						$.cookie('vote_'+id, id, { expires: date, secure: false });
					});
			
		}	
	});
}