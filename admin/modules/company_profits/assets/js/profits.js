function add_time_profits(){
	var go_time = $('.filter_area #text0').val();
	var to_time = $('.filter_area #text1').val();
	if(!go_time || !to_time){
		alert("Vui lòng chọn tìm kiếm mốc thời gian trước !")
		return false;
	}

	var doanh_thu = $('#doanh_thu').attr('data');
	var chi_phi = $('#chi_phi').attr('data');
	var loi_nhuan = $('#loi_nhuan').attr('data');
	var tong_don_hang = $('#tong_don_hang').attr('data');
	
	
	var text = "Bạn có chắc chắn muốn tạo mốc thời gian từ " + go_time + " đến " + to_time + " có lợi nhuận " + format_money_text(loi_nhuan) + " cho shop của bạn !";
	var r = confirm(text);
	if (r==true){
		$.ajax({url: "/admin/index.php?module=company_profits&view=items&task=ajax_add_time_profits&raw=1",
			async:false,
			data: {go_time: go_time,to_time: to_time,doanh_thu: doanh_thu,chi_phi: chi_phi,loi_nhuan: loi_nhuan,tong_don_hang: tong_don_hang},
			dataType: "json",
			success: function(data) {
				console.log(data);
				if(data.error == false){
					alert(data.messenger);
					location.href = data.link;
				}else{
					alert(data.messenger);
				}
			}
		});
	}
}


