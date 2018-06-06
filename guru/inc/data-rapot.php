<style>
	.input-group-addon{
		text-align: justify;
		width: 100%;
		color: #000;
		font-weight: normal;
		border-top-right-radius: 0px;
		border-bottom-right-radius: 0px;
	}
	.input-group-btn > button.btn{
		border-top-left-radius: 0px !important;
		border-bottom-left-radius: 0px !important;
	}
	.col-abu{
		padding-bottom: 0px !important;
		margin-bottom:15px;
	}
	.lg{
		font-size: 42px;
		vertical-align: middle;
	}
	.panel-footer{
		padding:10px;
	}
	.icn{
		text-align: center;
		background: #337ab7;
		padding-bottom: 10px;
		color:#fff;
		box-shadow: 0 1px 1px rgba(0, 0, 0, .05)
	}
	.panel,.panel-heading,.panel-body,.panel-footer{
		border-radius: 0px !important;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<h4>
					Input Data Rapot &nbsp;
					<button type="button" data-toggle="modal" data-target="#datarapot" class="btn btn-primary"><span class="glyphicon glyphicon-question-sign"></span></button>
				</h4>
				<hr>
				<div class="col-md-12 col-abu">
					<div class="col-md-1 icn">
						<br>
						<span class="glyphicon glyphicon-info-sign lg"></span>
						<br>
						<br>
						Sikap
					</div>
					<div class="col-md-11" style="padding: 0px;">
						<div class="panel panel-default">
							<div class="panel-body">
								Data mengenai deskripsi sikap siswa terkait perilakunya keseharian selama di Sekolah dan Data <strong>Catatan Wali Kelas</strong> yang diberikan kepada siswa
							</div>
							<div class="panel-footer">
								<a href="<?= base('guru/input-sikap'); ?>" class="btn-link">Entry Sekarang  &nbsp; <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
							</div> <!-- end of class panel footer -->
						</div> <!-- end of class panel -->
					</div> <!-- end of class col md 10 -->
				</div> <!-- end of class col md 12 -->
				<div class="col-md-12 col-abu">
					<div class="col-md-1 icn">
						<br>
						<span class="glyphicon glyphicon-calendar lg"></span>
						<br>
						<br>
						Absensi
					</div>
					<div class="col-md-11" style="padding: 0px;">
						<div class="panel panel-default">
							<div class="panel-body">
								Data absensi siswa selama 1 semester, mencakup <strong>Sakit</strong>, <strong>Izin</strong>, <strong>Alpha</strong> (Tanpa keterangan),
								<br> <br>
							</div>
							<div class="panel-footer">
								<a href="<?= base('guru/input-absensi'); ?>" class="btn-link">Entry Sekarang  &nbsp; <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
							</div> <!-- end of class panel footer -->
						</div> <!-- end of class panel -->
					</div> <!-- end of class col md 10 -->
				</div> <!-- end of class col md 12 -->
				<div class="col-md-12 col-abu">
					<div class="col-md-1 icn">
						<br>
						<span class="glyphicon glyphicon-queen lg"></span>
						<br>
						<br>
						P E P
					</div>
					<div class="col-md-11" style="padding: 0px;">
						<div class="panel panel-default">
							<div class="panel-body">
								<strong>Data PEP</strong> adalah Data Prestasi yang diraih oleh Siswa di bidang Akademik/Non-Akademik, Data Ekstrakurikuler dan Prakerin yang diikuti oleh Siswa.
							</div>
							<div class="panel-footer">
								<a href="<?= base('guru/input-pep') ?>" class="btn-link">Entry Sekarang  &nbsp; <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
							</div> <!-- end of class panel footer -->
						</div> <!-- end of class panel -->
					</div> <!-- end of class col md 10 -->
				</div> <!-- end of class col md 12 -->
<!-- 				<div class="col-md-6 col-abu">
					<div class="col-md-2 icn">
						<br>
						<span class="glyphicon glyphicon-edit lg"></span>
						<br>
						<br>
						Ekskul
					</div>
					<div class="col-md-10" style="padding: 0px;">
						<div class="panel panel-default">
							<div class="panel-body">
								Data kegiatan ekstrakurikuler yang diikuti oleh Siswa yang ada di Sekolah
							</div>
							<div class="panel-footer">
								<a href="<?=base('guru/input-ekskul');?>" class="btn-link">Entry Sekarang  &nbsp; <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
							</div> end of class panel footer
						</div> end of class panel
					</div> end of class col md 10
				</div> end of class col md 12
				<div class="col-md-6 col-abu">
					<div class="col-md-2 icn">
						<br>
						<span class="glyphicon glyphicon-briefcase lg"></span>
						<br>
						<br>
						PKL
					</div>
					<div class="col-md-10" style="padding: 0px;">
						<div class="panel panel-default">
							<div class="panel-body">
								Data kegiatan praktik kerja lapangan yang dilakukan Siswa pada Dunia Usaha	
							</div>
							<div class="panel-footer">
								<a href="<?=base('guru/input-prakerin');?>" class="btn-link">Entry Sekarang  &nbsp; <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
							</div> end of class panel footer
						</div> end of class panel
					</div> end of class col md 10
				 -->				</div> <!-- end of class col md 12 -->
			</div> <!-- end of class col md 8 -->
		</div> <!-- end of class row -->
	</div> <!-- end of class col md 12 -->
</div> <!-- end of class row -->
<!-- Modal -->
<div class="modal fade" id="datarapot" tabindex="-1" role="dialog" aria-labelledby="datarapot">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="datarapot">
					Apa itu <strong>Data Rapot ?</strong>
				</h4>
			</div>
			<div class="modal-body">
				<strong>Data Rapot</strong> adalah Data-data yang ditampilkan di rapot, contohnya :
				<br> <br>
				<ul class="list-group">
					<li class="list-group-item"><strong>Data Absensi</strong></li>
					<li class="list-group-item"><strong>Data Prestasi</strong></li>
					<li class="list-group-item"><strong>Data Ekstrakurikuler</strong></li>
					<li class="list-group-item"><strong>Data Praktik Kerja Lapangan</strong></li>
					<li class="list-group-item"><strong>Dll</strong></li>
				</ul>
			</div> <!-- end of class moda body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>