<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class detailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_kirim)
    {
        $client = new Client();

        $url = "http://127.0.0.1:8080/api/transdetail";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data1 = $contentArray['data'];
        

        $data = []; // Inisialisasi array data1
        
        foreach ($data1 as $item) {
            if ($item['id_kirim'] == $id_kirim) {
                // Menambahkan item ke dalam array $data1
                $data[] = $item;
            }
        }
        
        return view('dashboard2.kiriman.produk.index',['data' => $data, 'id_kirim' => $id_kirim]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id_kirim)
    {
        $client = new Client();

        $url = "http://127.0.0.1:8080/api/infobar";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        return view('dashboard2.kiriman.produk.create',['data' => $data, 'id_kirim' => $id_kirim]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id_kirim)
    {

        $nama_bar = $request->nama_bar;
        $jml_pcs_jual = $request->jml_pcs_jual;
        $diskon = $request->diskon;

        // Validasi untuk memeriksa apakah ada angka negatif
        if ($jml_pcs_jual < 0 || $diskon < 0) {
            $error = 'Nilai tidak boleh negatif.';
            return redirect()->to('dashboard/buat-kiriman/' . $id_kirim . '/details')->withErrors($error)->withInput();
        }
        
        $client = new Client();
        
        $url = "http://127.0.0.1:8080/api/infobar";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        $data_baru = null; // Definisikan variabel $data_baru di luar foreach

        foreach ($data as $item) {
            if ($item['nama_bar'] == $nama_bar) {
                $data_baru = $item;
                break; // Keluar dari loop setelah menemukan item yang sesuai
            }
        }

        $hrg_jual_baru = $data_baru['hrg_jual'] - $diskon;

        $parameter = [
            'id_kirim' => intval($id_kirim),
            'nama_bar' => $nama_bar,
            'jml_pcs_jual' => intval($jml_pcs_jual),
            'hrg_jual' => intval($hrg_jual_baru),
            'diskon' => intval($diskon),
        ];

        $url = "http://127.0.0.1:8080/api/transdetail";
        $response = $client->request('POST', $url,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter),
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        
        if($contentArray['status']!=true) {
            $error = $contentArray['data'];
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->with('success','Berhasil memasukkan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_kirim, string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/transdetail/$id";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/infobar";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        if($contentArray1['status']!=true||$contentArray1['status']!=true) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->withErrors($error);
        } else {
            $data1 = $contentArray1['data'];
            $data2 = $contentArray2['data'];
            return view('dashboard2.kiriman.produk.edit', ['data1'=>$data1, 'data2'=>$data2, 'id_kirim'=>$id_kirim]);
        }
    }

    /**
     * Show the form for editing the specified source.
     */
    public function edit($id_kirim, string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/infobar";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/transdetail/$id";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        if($contentArray1['status']!=true||$contentArray2['status']!=true) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->withErrors($error);
        } else {
            $data1 = $contentArray1['data'];
            $data2 = $contentArray2['data'];
            return view('dashboard2.stock.create', ['data1'=>$data1, 'data2'=>$data2, 'id_kirim'=>$id_kirim]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_kirim, $id_detail)
    {
        $nama_bar = $request->nama_bar;
        $jml_pcs_jual = $request->jml_pcs_jual;
        $diskon = $request->diskon;

        if ($jml_pcs_jual < 0 || $diskon < 0) {
            $error = 'Nilai tidak boleh negatif.';
            return redirect()->to('dashboard/buat-kiriman/' . $id_kirim . '/details')->withErrors($error)->withInput();
        }

        $client = new Client();

        $url = "http://127.0.0.1:8080/api/infobar";
        $response =  $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        $data_baru = null; // Definisikan variabel $data_baru di luar foreach

        foreach ($data as $item) {
            if ($item['nama_bar'] == $nama_bar) {
                $data_baru = $item;
                break; // Keluar dari loop setelah menemukan item yang sesuai
            }
        }

        $hrg_jual_baru = $data_baru['hrg_jual'] - $diskon;

        $parameter = [
            'id_kirim' => intval($id_kirim),
            'nama_bar' => $nama_bar,
            'jml_pcs_jual' => intval($jml_pcs_jual),
            'hrg_jual' => intval($hrg_jual_baru),
            'diskon' => intval($diskon),
        ];

        $url = "http://127.0.0.1:8080/api/transdetail/$id_detail";
        $response = $client->request('PUT', $url,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter),
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        
        if($contentArray['status']!=true) {
            $error = $contentArray['data'];
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->with('success','Berhasil melakukan update data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_kirim, string $id)
    {
        $client = new Client();

        $url = "http://127.0.0.1:8080/api/transdetail/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if($contentArray['status']!=true) {
            $error = $contentArray['message'];
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/buat-kiriman/'.$id_kirim.'/details')->with('success','Berhasil melakukan delete data.');
        }
    }
}
