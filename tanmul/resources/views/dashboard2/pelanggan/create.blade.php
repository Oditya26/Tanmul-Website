@extends('dashboard2.layout')
@section('main')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Tambah Data</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('dashboard')}}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a href="{{url('dashboard/pelanggan')}}">Pelanggan</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="{{url('dashboard/pelanggan/create')}}">Tambah Data</a>
                </li>
            </ul>
        </div>
        <a href="{{route('pelanggan.index')}}" class="btn-download">
            <i class='bx bx-chevron-left' ></i>
            <span class="text">Back</span>
        </a>
    </div>

    <div class="table-data">
        <div class="todo">
            <div class="head">
                <h3>Tambah Data</h3>
            </div>
            
            <form action="{{route('pelanggan.store')}}" method="POST">
                @csrf
                <div class="form-input">
                    <label for="nama_plg" class="form-label">Nama</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nama_plg"
                        id="nama_plg"
                        aria-describedby="helpId"
                        placeholder="Nama Pelanggan"
                        value="{{Session::get('nama_plg')}}"
                    />
                </div>
                <div class="form-input">
                    <label for="telp_plg" class="form-label">No. Telp</label>
                    <input
                        type="number"
                        class="form-control"
                        name="telp_plg"
                        id="telp_plg"
                        aria-describedby="helpId"
                        placeholder="No. Telepon Pelanggan"
                        step="1"
                        value="{{Session::get('telp_plg')}}"
                    />
                </div>
                <div class="form-input">
                    <label for="alamat_utama" class="form-label">Alamat</label>
                    <input
                        type="text"
                        class="form-control"
                        name="alamat_utama"
                        id="telp_plg"
                        aria-describedby="helpId"
                        placeholder="Alamat Pelanggan"
                        value="{{Session::get('alamat_utama')}}"
                    />
                </div>
                <button class="btn" name="submit" type="submit">Submit</button>
            </form> 
        </div>
    </div>
</main>
@endsection