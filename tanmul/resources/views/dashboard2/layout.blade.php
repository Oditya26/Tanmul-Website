<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
	<link rel="stylesheet" href="{{asset('admin2')}}/style.css">
	<link rel="shortcut icon" href="{{asset('admin')}}/images/logo-tanmul.svg" />
	@notifyCss

	<title>Tanmul</title>
</head>
<body>
	<div class="notify-container">
		<x-notify::notify />
	</div>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="{{url('dashboard')}}" class="brand">
			<i class='bx bxs-home' ></i>
			<span class="text">Tanmul</span>
		</a>
		<ul class="side-menu top">
			<li class="{{ Request::is('dashboard/stock*')||Request::is('dashboard') ? 'active' : '' }}">
				<a href="{{url('dashboard/stock')}}">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Stock</span>
				</a>
			</li>
			<li class="{{ Request::is('dashboard/pelanggan*') ? 'active' : '' }}">
				<a href="{{url('dashboard/pelanggan')}}">
					<i class='bx bxs-group' ></i>
					<span class="text">Pelanggan</span>
				</a>
			</li>
			<li class="{{ Request::is('dashboard/buat-kiriman*') ? 'active' : '' }}">
				<a href="{{url('dashboard/buat-kiriman')}}">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Kiriman</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			
			<li>
				<a href="{{url('auth/logout')}}" class="logout">
					<i class='bx bxs-log-out'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			
			
			
			<a>{{Auth::user()->name}}</a>
			<a class="profile">
				<img src="{{asset('admin2')}}/img/{{Auth::user()->avatar}}">
			</a>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
		</nav>
		<!-- NAVBAR -->

		@yield('main')
	</section>
	<!-- CONTENT -->
	

	<script src="{{asset('admin2')}}/script.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="//cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
	<script>
		$(document).ready( function () {
			$('#myTable').DataTable({
                "columnDefs": [
                    { "className": "left-align", "targets": "_all"}  // Mengatur kolom pertama (indeks 0) menjadi rata kiri
                ]
            });
		} );
	</script>
	<script>
        document.addEventListener('DOMContentLoaded', function() {
            var tglKirimInput = document.getElementById('tgl_kirim');
            if (!tglKirimInput.value) {
                var today = new Date().toISOString().split('T')[0];
                tglKirimInput.value = today;
            }
			"responsive": true // Aktifkan responsif DataTables
        });
    </script>
	<script>
		$(document).ready(function() {
			$('.select').select2({
				theme:"custom"
			});
		});
	</script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
    @notifyJs
</body>
</html>