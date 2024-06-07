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
            <h1>Stock</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{url('dashboard')}}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right' ></i></li>
                <li>
                    <a class="active" href="{{url('dashboard/stock')}}">Stock</a>
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
        <a href="{{route('stock.create')}}" class="btn-download">
            <span class="text">Tambah Data</span>
            <i class='bx bx-plus'></i>
        </a>
    </div>
    <?php
        $sizeArray = count($data1);
    ?>
    <ul class="box-info">
        <li>
            <i class='bx bxs-data' ></i>
            <span class="text">
                <h3>{{$sizeArray}}</h3>
                <p>Jumlah Data</p>
            </span>
        </li>
        <?php
            $totalPemasukkan = 0;
            foreach ($data3 as $item) {
                $totalPemasukkan += $item['hrg_jual'] * $item['jml_pcs_jual'];
            }
        ?>
        <li>
            <i class='bx bx-arrow-from-top' ></i>
            <span class="text">
                <h3>{{formatRupiah($totalPemasukkan)}}</h3>
                <p>Omset</p>
            </span>
        </li>
        <?php
            $totalPengeluaran = 0;
            foreach ($data1 as $item) {
                $totalPengeluaran += $item['hrg_beli'] * $item['pcs'];
            }
        ?>
        <li>
            <i class='bx bx-arrow-from-bottom'></i>
            <span class="text">
                <h3>{{formatRupiah($totalPengeluaran)}}</h3>
                <p>Modal</p>
            </span>
        </li>
        <?php
            $profit = $totalPemasukkan - $totalPengeluaran;
        ?>
        <li>
            <i class='bx bx-money'></i>
            <span class="text">
                <h3>{{formatRupiah($profit)}}</h3>
                <p>Laba Kotor</p>
            </span>
        </li>
    </ul>
    <div class="table-data">
        <div class="order">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th >Satuan</th>
                        <th>Pcs</th>
                        <th>Harga Jual</th>
                        <th>Harga Beli</th>
                        <th>Stok Aman</th>
                        <th>Stok Now</th>
                        <th>Stok Retur</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data1 as $key => $item) 
                    <tr>
                        <td>
                            <p>{{ $item['nama_bar'] }}</p>
                        </td>
                        <td>{{ $item['sat_qty'] }}</td>
                        <td>{{ $item['pcs'] }}</td>
                        <td>{{ formatRupiah($item['hrg_jual']) }}</td>
                        <td>{{ formatRupiah($item['hrg_beli']) }}</td>
                        @if (isset($data2[$key]))
                            <td>{{ $data2[$key]['stok_aman'] }}</td>
                            <td>{{ $data2[$key]['stok_now'] }}</td>
                            <td>{{ $data2[$key]['stok_retur'] }}</td>
                        @else
                            <td colspan="3">Data tidak tersedia</td>
                        @endif
                        <td>
                            <div class="action-buttons">
                                <a href="{{ url('dashboard/stock/'.$item['id_bar']) }}" type="button" class="status process">Edit</a>
                                <form action="{{ url('dashboard/stock/'.$item['id_bar']) }}" method="post" onsubmit="return confirm('Apakah yakin akan melakukan penghapusan data?')" class="d-inline">
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