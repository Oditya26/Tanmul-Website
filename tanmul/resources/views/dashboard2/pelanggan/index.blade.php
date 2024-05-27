@extends('dashboard2.layout')
@section('main')
<!-- MAIN -->
<main>
    <?php
        function set_list_error($isi) {
            $isi = str_replace('"', '', $isi);
            $isi = str_replace("[[", '', $isi);
            $isi = str_replace("]]", '', $isi);
            $isi = str_replace('\n', '<br>', $isi);
            $isi = str_replace("Key: 'Pelanggan.Nama_plg' Error:Field validation for 'Nama_plg' failed on the 'required' tag",
            'Nama tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Pelanggan.Telp_plg' Error:Field validation for 'Telp_plg' failed on the 'required' tag",
            'No. Telepon tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Pelanggan.Alamat_utama' Error:Field validation for 'Alamat_utama' failed on the 'required' tag",
            'Alamat tidak boleh kosong', $isi);
            return $isi;
        }
        function formatPhoneNumber($number) {
            // Remove any non-digit characters
            $number = preg_replace('/\D/', '', $number);

            // Insert hyphen every 4 digits
            $formattedNumber = '';
            for ($i = 0; $i < strlen($number); $i++) {
                if ($i > 0 && $i % 4 == 0) {
                    $formattedNumber .= '-';
                }
                $formattedNumber .= $number[$i];
            }

            return $formattedNumber;
        }
        function convertToUnorderedList($input) {
            // Membagi string menjadi array berdasarkan <br>
            $lines = explode('<br>', $input);
            
            // Mengonversi setiap baris menjadi item dalam unordered list
            $output = '<ul class="custom-ul">';
                foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $output .= '<li>' . $line . '</li>';
                }
            }
            $output .= '</ul>';
            
            return $output;
        }
    ?>
    <div class="head-title">
        <div class="left">
            <h1>Pelanggan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('dashboard')}}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="{{url('dashboard/pelanggan')}}">Pelanggan</a>
                </li>
            </ul>
        </div>
    </div>
    <br><br>
    @if ($errors->any())
        <div class="alert alert-danger">
            {!!convertToUnorderedList(set_list_error($errors))!!}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <div class="head-title">
        <a href="{{route('pelanggan.create')}}" class="btn-download">
            <span class="text">Tambah Data</span>
            <i class='bx bx-plus'></i>
        </a>
    </div>
    <?php
        $sizeArray = count($data);
    ?>
    <ul class="box-info">
        <li>
            <i class='bx bxs-group' ></i>
            <span class="text">
                <h3>{{$sizeArray}}</h3>
                <p>Jumlah Pelanggan</p>
            </span>
        </li>
    </ul>
    <div class="table-data">
        <div class="order">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th >No. Telepon</th>
                        <th>Alamat</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item) 
                    <tr>
                        <td>
                            <p>{{$item['nama_plg']}}</p>
                        </td>
                        <td>{!!formatPhoneNumber($item['telp_plg'])!!}</td>
                        <td>{{$item['alamat_utama']}}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{url('dashboard/pelanggan/'.$item['id_plg'])}}" type="button" class="status process">Edit</a>
                                <form action="{{url('dashboard/pelanggan/'.$item['id_plg'])}}" method="post" onsubmit="return confirm('Apakah yakin akan melakukan penghapusan data?')" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="status pending" type="submit" name="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</main>
<!-- MAIN -->
@endsection