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
                    <a href="{{url('dashboard/buat-kiriman')}}">Kiriman</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a href="{{url('dashboard/buat-kiriman/'.$id_kirim.'/details')}}">Details</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="{{url('dashboard/buat-kiriman/'.$id_kirim.'/details/create')}}">Tambah Produk Baru</a>
                </li>
            </ul>
        </div>
        <a href="{{route('buat-kiriman.details.index', $id_kirim)}}" class="btn-download">
            <i class='bx bx-chevron-left' ></i>
            <span class="text">Back</span>
        </a>
    </div>

    <div class="table-data">
        <div class="todo">
            <div class="head">
                <h3>Tambah Produk Baru</h3>
            </div>
            
            <form action="{{route('buat-kiriman.details.store', $id_kirim)}}" method="POST">
                @csrf
                
                <div class="form-input">
                    <label for="nama_bar" class="form-label">Nama Barang</label>
                    <select name="nama_bar" id="nama_bar" class="select">
                        @foreach ($data as $item)
                            <option value="{{ $item['nama_bar'] }}" {{ Session::get('nama_bar') == $item['nama_bar'] ? 'selected' : '' }}>
                                {{ $item['nama_bar'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-input">
                    <label for="jml_pcs_jual" class="form-label">Jumlah Pcs Jual</label>
                    <input
                        type="number"
                        class="form-control"
                        name="jml_pcs_jual"
                        id="jml_pcs_jual"
                        aria-describedby="helpId"
                        placeholder="Jumlah Pcs Jual"
                        step="1"
                        value="{{Session::get('jml_pcs_jual')}}"
                    />
                </div>

                <div class="form-input">
                    <label for="diskon" class="form-label">Diskon</label>
                    <input
                        type="number"
                        class="form-control"
                        name="diskon"
                        id="diskon"
                        aria-describedby="helpId"
                        placeholder="Diskon"
                        step="1"
                        value="{{Session::get('diskon')}}"
                    />
                </div>

                <button class="btn" name="submit" type="submit">Submit</button>
            </form> 
        </div>
    </div>
</main>
@endsection