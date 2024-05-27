@extends('dashboard2.layout')
@section('main')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Edit Data</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('dashboard')}}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a href="{{url('dashboard/stock')}}">Stock</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="{{url('dashboard/stock/'.$data1['id_bar'])}}">Edit Data</a>
                </li>
            </ul>
        </div>
        <a href="{{route('stock.index')}}" class="btn-download">
            <i class='bx bx-chevron-left' ></i>
            <span class="text">Back</span>
        </a>
    </div>

    <div class="table-data">
        <div class="todo">
            <div class="head">
                <h3>Edit Data</h3>
            </div>
            
            <form action="{{route('stock.update', $data1['id_bar'])}}" method="POST">
                @csrf
                @method('put')
                <div class="form-input">
                    <label for="nama_bar" class="form-label">Nama Barang</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nama_bar"
                        id="nama_bar"
                        aria-describedby="helpId"
                        placeholder="Nama Barang"
                        value="{{$data1['nama_bar']}}"
                    />
                </div>

                <div class="form-input">
                    <label for="sat_qty" class="form-label">Satuan Barang</label>
                    <select name="sat_qty" id="sat_qty">
                        <option value="bal" {{$data1['sat_qty'] == "bal" ? 'selected' : '' }}>bal</option>
                        <option value="karton" {{$data1['sat_qty'] == "karton" ? 'selected' : '' }}>karton</option>
                        <option value="pack" {{$data1['sat_qty'] == "pack" ? 'selected' : '' }}>pack</option>
                    </select>
                </div>

                <div class="form-input">
                    <label for="pcs" class="form-label">Jumlah Pcs</label>
                    <input
                        type="number"
                        class="form-control"
                        name="pcs"
                        id="pcs"
                        aria-describedby="helpId"
                        placeholder="Jumlah Pcs Barang"
                        step="1"
                        value="{{intval($data1['pcs'])}}"
                    />
                </div>

                <div class="form-input">
                    <label for="hrg_jual" class="form-label">Harga Jual</label>
                    <input
                        type="number"
                        class="form-control"
                        name="hrg_jual"
                        id="hrg_jual"
                        aria-describedby="helpId"
                        placeholder="Harga Jual Barang"
                        step="1"
                        value="{{$data1['hrg_jual']}}"
                    />
                </div>

                <div class="form-input">
                    <label for="hrg_beli" class="form-label">Harga Beli</label>
                    <input
                        type="number"
                        class="form-control"
                        name="hrg_beli"
                        id="hrg_beli"
                        aria-describedby="helpId"
                        placeholder="Harga Beli Barang"
                        step="1"
                        value="{{$data1['hrg_beli']}}"
                    />
                </div>

                <div class="form-input">
                    <label for="stok_aman" class="form-label">Stok Aman</label>
                    <input
                        type="number"
                        class="form-control"
                        name="stok_aman"
                        id="stok_aman"
                        aria-describedby="helpId"
                        placeholder="Stok Aman Barang"
                        step="1"
                        value="{{intval($data2['stok_aman'])}}"
                    />
                </div>

                <div class="form-input">
                    <label for="stok_now" class="form-label">Stok Now</label>
                    <input
                        type="number"
                        class="form-control"
                        name="stok_now"
                        id="stok_now"
                        aria-describedby="helpId"
                        placeholder="Stok Now Barang"
                        step="1"
                        value="{{$data2['stok_now']}}"
                    />
                </div>

                <div class="form-input">
                    <label for="stok_retur" class="form-label">Stok Retur</label>
                    <input
                        type="number"
                        class="form-control"
                        name="stok_retur"
                        id="stok_retur"
                        aria-describedby="helpId"
                        placeholder="Stok Retur Barang"
                        step="1"
                        value="{{$data2['stok_retur']}}"
                    />
                </div>

                <button class="btn" name="submit" type="submit">Submit</button>
            </form> 
        </div>
    </div>
</main>
@endsection