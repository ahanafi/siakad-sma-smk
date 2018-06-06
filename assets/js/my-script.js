$(function(){
	//Sikap dan catatan
	$(".btn-click").click(function(){
		var ids = $(this).attr('data-ids'); //Getting id siswa

		//Ambil data deskripsi dan catatan tiap siswa
		//Sesuai dengan idnya masing-masing
		var desk = $(".desk_"+ids).val();
		var cat = $(".cat_"+ids).val();

		if (desk == "" || cat == "") {
			sweetAlert('Oops!', 'Form tidak boleh kosong!', 'error');
		}else{

			//Kirim ke database dengan proses ajax
			$.ajax({
				method	: "POST",
				url 	: "p.php?ax=sicat",
				cache 	: false,
				data 	: {
					id_siswa : ids,
					deskripsi : desk,
					catatan : cat
				},
				success	: function(mess){
					if (mess == 1) {
						//Hide the form
						$(".desk_"+ids).hide();
						$(".cat_"+ids).hide();

						//Show the text
						$(".ds_"+ids).append(desk);
						$(".ct_"+ids).append(cat);
						$(".btn_"+ids).remove();
						$(".ctr_"+ids).append("<span class='glyphicon glyphicon-ok'></span>")
					}
				} //end of success function
			});   //end of ajax methode
		}		  //end of else
	});     	  //end of event click

	//Absensi Siswa
	$(".btn_abs").click(function(){
		//Make a variable for getting id from siswa with event click the button
		var stid = $(this).attr('data-st');
		
		//Get data form input type number
		var skt = $(".skt_"+stid).val();
		var izn = $(".izn_"+stid).val();
		var alf = $(".alf_"+stid).val();

		var data = {
			id_siswa : stid,
			sakit : skt,
			izin : izn,
			alfa : alf
		};

		//Validating
		if (skt == "" || izn == "" || alf == "") {
			sweetAlert('Oops!', 'Form tidak boleh kosong!', 'error');
		} else {

			//Send data with ajax
			$.ajax({
				method 	: "POST",
				url 	: "p.php?ax=abs",
				cache 	: false,
				data 	: data,
				success	: function(msj){
					if (msj == 1) {
						$(".skt_"+stid).hide();
						$(".izn_"+stid).hide();
						$(".alf_"+stid).hide();
						$(".b_"+stid).remove();

						$(".s_"+stid).append(data.sakit);
						$(".i_"+stid).append(data.izin);
						$(".a_"+stid).append(data.alfa);
						$(".ss_"+stid).append("<span class='glyphicon glyphicon-ok'></span>");
					}
				}
			});
		}
	});       //end of event click	
});           //end of ready function