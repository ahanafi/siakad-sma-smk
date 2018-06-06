$(function(){
	$("select[name=kelas]").change(function(){
		var kelas = $("select[name=kelas] option:selected").val();
		var element = $("select[name=mapel]");

		$("select[name=mapel] > option").remove();
		element.append("<option value=''>-- Pilih Mata Pelajaran --</option>");

		if (kelas == "") {
			sweetAlert('Oops!', 'Mohon pilih kelas terlebih dahulu!', 'error');
		} else {
			$.ajax({
				method	: "POST",
				url		: "../result.php?q=kelas",
				async 	: true,
				cache 	: false,
				data 	: {
					kelas : kelas
				},
				success	: function(em){
					var datanya = jQuery.parseJSON(em);
					$.each(datanya, function(a,b){
						element.append("<option value='"+b.id+"'>"+b.nama_mapel+"</option>");
					});
				}
			});
		}
	});

    $("select[name=mapel]").click(function(){
      var kelas = $("select[name=kelas] option:selected").val();
      if (kelas == "") {
        sweetAlert('Oops!', 'Mohon pilih kelas terlebih dulu!', 'error');
      }
    });
});