$(document).ready(function(){
//$(function(){
	$(".btn_click").click(function(){
		var id = $(this).attr('data-number');

		console.log(id);

		//Mengambil nilai dari form
		var p_angka = $(".p_angka_"+id).val();
		var p_predikat = $(".p_predikat_"+id).val();
		var k_angka = $(".k_angka_"+id).val();
		var k_predikat = $(".k_predikat_"+id).val();

		//Data lainnya
		var id_mapel = $("input[name=id_mapel]").val();

		//Cek isi data
		if (p_angka == "" || p_predikat == "" || k_angka == "" || k_predikat == "") {
			sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');
		} else {
			$.ajax({
				method 	: "POST",
				url 	: "cek.php?q=input",
				async 	: true,
				cache 	: false,
				data 	: {
					jenis : "rapot",
					id_mapel : id_mapel,
					p_agk : p_angka,
					p_pre : p_predikat,
					k_agk : k_angka,
					k_pre : k_predikat,
				}
			});
		}
	});

	$("input[name=p_angka]").click(function(){
		var id = $(this).attr('data-ids');
		var id_mapel = $("input[name=id_mapel]").val();
		
		$(".p_angka_"+id).on("keyup", function(){
			var p_akg = $(".p_angka_"+id).val();

			if (p_akg.length == 2){
				if (p_akg < 75) {
					$.ajax({
						method	: "POST",
						url 	: "cek.php?q=otr",
						async	: true,
						cache 	: false,
						data 	: {
							id_mapel : id_mapel,
							core 	 : "pth"
						},
						success : function(sms){
							var result = jQuery.parseJSON(sms);

							$.each(result, function(m,n){
								if (n.predikat == "C") {
									$(".p_predikat_"+id).val(n.predikat);
									$(".pth_des_"+id).val(n.deskripsi);
								}
							});
						}
					});
				} else {
					$.ajax({
						method	: "POST",
						url		: "cek.php?q=pth",
						async 	: true,
						cache 	: false,
						data 	: {
							id_mapel : id_mapel,
							p_angka : p_akg
						},
						success : function(e){
							//var data = JSON.parse(e);
							var data = jQuery.parseJSON(e);

							$.each(data, function(a,b){
								if (b.predikat == "A" || b.predikat == "B" || b.predikat == "C" ) {
									$(".p_predikat_"+id).val(b.predikat);
									$(".pth_des_"+id).val(b.deskripsi);
								}
							});
						}
					});
				}
			}
			if ($(".p_angka_"+id).val() == "") {
				$(".p_predikat_"+id).val("");
				$(".pth_des_"+id).val("");
			}
		});
	});

	$("input[name=k_angka]").click(function(){
		var id = $(this).attr('data-ids');
		var id_mapel = $("input[name=id_mapel]").val();
		
		$(".k_angka_"+id).keyup(function(){
			var k_akg = $(".k_angka_"+id).val();

			if (k_akg.length == 2) {
				if (k_akg < 75) {
					$.ajax({
						method 	: "POST",
						url 	: "cek.php?q=otr",
						async	: true,
						cache 	: false,
						data 	: {
							id_mapel : id_mapel,
							core 	 : 'ktr' 
						},
						success	: function(msg){
							var hasil = jQuery.parseJSON(msg);

							console.log(hasil);

							$.each(hasil, function(x,y){
								if (y.predikat == "C") {
									$(".k_predikat_"+id).val(y.predikat);
									$(".ktr_des_"+id).val(y.deskripsi);								
								}
							});
						}
					});
				} else {
					$.ajax({
						method	: "POST",
						url		: "cek.php?q=ktr",
						async 	: true,
						cache 	: false,
						data 	: {
							id_mapel : id_mapel,
							k_angka : k_akg
						},
						success : function(back){
							var data = jQuery.parseJSON(back);

							$.each(data, function(i,n){
								if (n.predikat == "A" || n.predikat == "B" || n.predikat == "C" ) {
									$(".k_predikat_"+id).val(n.predikat);
									$(".ktr_des_"+id).val(n.deskripsi);
								}
							});
						}
					});
				}
			}
			if ($(".k_angka_"+id).val() == "") {
				$(".k_predikat_"+id).val("");
				$(".ktr_des_"+id).val("");
			}
		});
	});
});