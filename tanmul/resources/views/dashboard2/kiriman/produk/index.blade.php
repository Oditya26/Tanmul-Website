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
            $isi = str_replace(',', '<br>', $isi);
            $isi = str_replace("Key: 'Info_bar.Nama_bar' Error:Field validation for 'Nama_bar' failed on the 'required' tag",
            'Nama Barang tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Info_bar.Sat_qty' Error:Field validation for 'Sat_qty' failed on the 'required' tag",
            'Satuan Barang tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Info_bar.Pcs' Error:Field validation for 'Pcs' failed on the 'required' tag",
            'Pcs Barang tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Info_bar.Hrg_jual' Error:Field validation for 'Hrg_jual' failed on the 'required' tag",
            'Harga Jual tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Info_bar.Hrg_beli' Error:Field validation for 'Hrg_beli' failed on the 'required' tag]",
            'Harga Beli tidak boleh kosong', $isi);
            $isi = str_replace("[Key: 'Stok_bar.Stok_aman' Error:Field validation for 'Stok_aman' failed on the 'required' tag",
            'Stok Aman tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Stok_bar.Stok_now' Error:Field validation for 'Stok_now' failed on the 'required' tag",
            'Stok Now tidak boleh kosong', $isi);
            $isi = str_replace("Key: 'Stok_bar.Stok_retur' Error:Field validation for 'Stok_retur' failed on the 'required' tag",
            'Stok Retur tidak boleh kosong', $isi);
            return $isi;
        }
        function formatRupiah($angka) {
            $rupiah = "Rp. " . number_format($angka, 0, ',', '.');
            return $rupiah;
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
            <h1>Kiriman</h1>
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
                    <a class="active" href="{{url('dashboard/details')}}">Detail</a>
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
        <a href="{{route('details.create')}}" class="btn-download">
            <span class="text">Tambah Produk Baru</span>
            <i class='bx bx-plus'></i>
        </a>
    </div>
    <?php
        $sizeArray = count($data);
    ?>
    <ul class="box-info">
        <li>
            <i class='bx bxs-data' ></i>
            <span class="text">
                <h3>{{$sizeArray}}</h3>
                <p>Jumlah Data</p>
            </span>
        </li>
    </ul>
    <div class="table-data">
        <div class="order">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Pcs Barang</th>
                        <th>Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item) 
                    <tr>
                        <td>
                            <p>{{ $item['nama_bar'] }}</p>
                        </td>
                        <td>
                            {{ $item['jml_pcs_jual'] }}
                        </td>
                        <td>{{ $item['hrg_jual'] }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ url('dashboard/details'.$item['id_detail']) }}" type="button" class="status process">Edit</a>
                                <form action="{{ url('dashboard/buat-kiriman/'.$item['id_kirim'].'/'.'details/'.$item['id_detail']') }}" method="post" onsubmit="return confirm('Apakah yakin akan melakukan penghapusan data?')" class="d-inline">
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