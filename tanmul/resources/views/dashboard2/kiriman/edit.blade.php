@extends('dashboard2.layout')
@section('main')
<main>
    <div class="head-title">
        <div class="left">
            <h1>Edit Kiriman</h1>
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
                    <a class="active" href="{{url('dashboard/buat-kiriman/'.$data1['id_kirim'])}}">Edit Kiriman</a>
                </li>
            </ul>
        </div>
        <a href="{{route('buat-kiriman.index')}}" class="btn-download">
            <i class='bx bx-chevron-left' ></i>
            <span class="text">Back</span>
        </a>
    </div>

    <div class="table-data">
        <div class="todo">
            <div class="head">
                <h3>Edit Data Kiriman</h3>
            </div>
            
            <form action="{{route('buat-kiriman.update', $data1['id_kirim'])}}" method="POST">
                @csrf
                @method('put')
                <div class="form-input">
                    <label for="tgl_kirim" class="form-label">Tanggal Kirim</label>
                    <input type="date"
                    class="form-control"
                    name="tgl_kirim"
                    id="tgl_kirim"
                    placeholder="dd/mm/yyyy"
                    value="{{ $data1['tgl_kirim'] }}">
                </div>

                <div class="form-input">
                    <label for="nama_supir" class="form-label">Nama Supir</label>
                    <input
                        type="text"
                        class="form-control"
                        name="nama_supir"
                        id="nama_supir"
                        aria-describedby="helpId"
                        placeholder="Nama Supir"
                        value="{{ $data1['nama_supir'] }}"
                    />
                </div>

                <div class="form-input">
                    <label for="nama_plg" class="form-label">Nama Pelanggan</label>
                    <select name="nama_plg" id="nama_plg" class="select">
                        @foreach ($data2 as $item)
                            <option value="{{ $item['nama_plg'] }}" {{ $data1['nama_plg'] == $item['nama_plg'] ? 'selected' : '' }}>
                                {{ $item['nama_plg'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn" name="submit" type="submit">Submit</button>
            </form> 
        </div>
    </div>
</main>
@endsection