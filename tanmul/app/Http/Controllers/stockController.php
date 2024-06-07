<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class stockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/infobar";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);
        $data1 = $contentArray1['data'];

        $url2 = "http://127.0.0.1:8080/api/stokbar";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);
        $data2 = $contentArray2['data'];

        $url3 = "http://127.0.0.1:8080/api/transdetail";
        $response3 = $client->request('GET', $url3);
        $content3 = $response3->getBody()->getContents();
        $contentArray3 = json_decode($content3, true);
        $data3 = $contentArray3['data'];

        return view('dashboard2.stock.index',['data1' => $data1, 'data2'=>$data2, 'data3'=>$data3]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard2.stock.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nama_bar = $request->nama_bar;
        $sat_qty = $request->sat_qty;
        $pcs = $request->pcs;
        $hrg_jual = $request->hrg_jual;
        $hrg_beli = $request->hrg_beli;

        $stok_aman = $request->stok_aman;
        $stok_now = $request->stok_now;
        $stok_retur = $request->stok_retur;

        if (empty($nama_bar) || empty($sat_qty) || empty($pcs) || empty($hrg_jual) || empty($hrg_beli) || 
            empty($stok_aman) || empty($stok_now)) {
            $error = 'Semua data harus diisi.';
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        }

        // Validasi untuk memeriksa apakah ada nilai negatif
        if ($pcs < 0 || $hrg_jual < 0 || $hrg_beli < 0 || $stok_aman < 0 || $stok_now < 0 || $stok_retur < 0) {
            $error = 'Nilai tidak boleh negatif.';
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        }

        $parameter1 = [
            'nama_bar' => $nama_bar,
            'sat_qty' => $sat_qty,
            'pcs' => intval($pcs),
            'hrg_jual' => intval($hrg_jual),
            'hrg_beli' => intval($hrg_beli),
        ];

        $parameter2 = [
            'stok_aman' => intval($stok_aman),
            'stok_now' => intval($stok_now),
            'stok_retur' => intval($stok_retur),
        ];

        

        $client = new Client();
        $url1 = "http://127.0.0.1:8080/api/infobar";
        $url2 = "http://127.0.0.1:8080/api/stokbar";

        $response1 = $client->request('POST', $url1,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter1),
        ]);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $response2 = $client->request('POST', $url2,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter2),
        ]);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);
        
        if($contentArray1['status']!=true||$contentArray2['status']!=true) {
            $error1 = $contentArray1['data'];
            $error2 = $contentArray2['data'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/stock')->with('success','Berhasil memasukkan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/infobar/$id";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/stokbar/$id";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        if($contentArray1['status']!=true||$contentArray2['status']!=true) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/stock')->withErrors($error);
        } else {
            $data1 = $contentArray1['data'];
            $data2 = $contentArray2['data'];
            return view('dashboard2.stock.edit', ['data1'=>$data1, 'data2'=>$data2]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/infobar/$id";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/stokbar/$id";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        if($contentArray1['status']!=true||$contentArray2['status']!=true) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/stock')->withErrors($error);
        } else {
            $data1 = $contentArray1['data'];
            $data2 = $contentArray2['data'];
            return view('dashboard2.stock.create', ['data1'=>$data1, 'data2'=>$data2]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nama_bar = $request->nama_bar;
        $sat_qty = $request->sat_qty;
        $pcs = $request->pcs;
        $hrg_jual = $request->hrg_jual;
        $hrg_beli = $request->hrg_beli;

        $stok_aman = $request->stok_aman;
        $stok_now = $request->stok_now;
        $stok_retur = $request->stok_retur;

        if (empty($nama_bar) || empty($sat_qty) || empty($pcs) || empty($hrg_jual) || empty($hrg_beli) || 
            empty($stok_aman) || empty($stok_now)) {
            $error = 'Semua data harus diisi.';
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        }

        // Validasi untuk memeriksa apakah ada nilai negatif
        if ($pcs < 0 || $hrg_jual < 0 || $hrg_beli < 0 || $stok_aman < 0 || $stok_now < 0 || $stok_retur < 0) {
            $error = 'Nilai tidak boleh negatif.';
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        }

        $parameter1 = [
            'nama_bar' => $nama_bar,
            'sat_qty' => $sat_qty,
            'pcs' => intval($pcs),
            'hrg_jual' => intval($hrg_jual),
            'hrg_beli' => intval($hrg_beli),
        ];

        $parameter2 = [
            'stok_aman' => intval($stok_aman),
            'stok_now' => intval($stok_now),
            'stok_retur' => intval($stok_retur),
        ];

        $client = new Client();
        $url1 = "http://127.0.0.1:8080/api/infobar/$id";
        $url2 = "http://127.0.0.1:8080/api/stokbar/$id";

        $response1 = $client->request('PUT', $url1,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter1),
        ]);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $response2 = $client->request('PUT', $url2,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter2),
        ]);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        
        
        
        if($contentArray1['status']!=true&&$contentArray2['status']!=true) {
            $error1 = $contentArray1['data'];
            $error2 = $contentArray2['data'];
            $error = array_merge((array)$error1);
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/stock')->with('success','Berhasil melakukan update data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/infobar/$id";
        $response1 = $client->request('DELETE', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/stokbar/$id";
        $response2 = $client->request('DELETE', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        if($contentArray1['status']!=true||$contentArray2['status']) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1);
            return redirect()->to('dashboard/stock')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/stock')->with('success','Berhasil melakukan delete data.');
        }
    }
}
