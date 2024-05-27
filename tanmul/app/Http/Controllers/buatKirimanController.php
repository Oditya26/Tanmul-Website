<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class buatKirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/kiriman";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);
        $data1 = $contentArray1['data'];

        $url2 = "http://127.0.0.1:8080/api/pelanggan";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);
        $data2 = $contentArray2['data'];

        return view('dashboard2.kiriman.index',['data1' => $data1, 'data2'=>$data2]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new Client();

        $url2 = "http://127.0.0.1:8080/api/pelanggan";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);
        $data2 = $contentArray2['data'];

        return view('dashboard2.kiriman.create',['data2'=>$data2]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tgl_kirim = $request->tgl_kirim;
        $nama_supir = $request->nama_supir;
        $nama_plg = $request->nama_plg;

        if (empty($tgl_kirim) || empty($nama_supir) || empty($nama_plg)) {
            $error = 'Semua data harus diisi.';
            return redirect()->to('dashboard/buat-kiriman')->withErrors($error)->withInput();
        }

        $parameter1 = [
            'tgl_kirim' => $tgl_kirim,
            'nama_supir' => $nama_supir,
            'nama_plg' => $nama_plg,
        ];

        $client = new Client();
        $url1 = "http://127.0.0.1:8080/api/kiriman";

        $response1 = $client->request('POST', $url1,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter1),
        ]);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);
        
        if($contentArray1['status']!=true) {
            $error = $contentArray1['data'];
            return redirect()->to('dashboard/buat-kiriman')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/buat-kiriman')->with('success','Berhasil memasukkan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/kiriman/$id";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/pelanggan/";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);

        if($contentArray1['status']!=true && $contentArray2['status']!=true) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/buat-kiriman')->withErrors($error);
        } else {
            $data1 = $contentArray1['data'];
            $data2 = $contentArray2['data'];
            return view('dashboard2.kiriman.edit', ['data1'=>$data1, 'data2'=>$data2]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();

        $url1 = "http://127.0.0.1:8080/api/kiriman/$id";
        $response1 = $client->request('GET', $url1);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);

        $url2 = "http://127.0.0.1:8080/api/pelanggan/$id";
        $response2 = $client->request('GET', $url2);
        $content2 = $response2->getBody()->getContents();
        $contentArray2 = json_decode($content2, true);
        
        if($contentArray1['status']!=true&&$contentArray1['status']!=true) {
            $error1 = $contentArray1['message'];
            $error2 = $contentArray2['message'];
            $error = array_merge((array)$error1, (array)$error2);
            return redirect()->to('dashboard/stock')->withErrors($error);
        } else {
            $data1 = $contentArray1['data'];
            $data2 = $contentArray2['data'];
            return view('dashboard2.kiriman.create', ['data1'=>$data1, 'data2'=>$data2]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tgl_kirim = $request->tgl_kirim;
        $nama_supir = $request->nama_supir;
        $nama_plg = $request->nama_plg;

        if (empty($tgl_kirim) || empty($nama_supir) || empty($nama_plg)) {
            $error = 'Semua data harus diisi.';
            return redirect()->to('dashboard/buat-kiriman')->withErrors($error)->withInput();
        }

        $parameter1 = [
            'tgl_kirim' => $tgl_kirim,
            'nama_supir' => $nama_supir,
            'nama_plg' => $nama_plg,
        ];

        $client = new Client();
        $url1 = "http://127.0.0.1:8080/api/kiriman/$id";

        $response1 = $client->request('PUT', $url1,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter1),
        ]);
        $content1 = $response1->getBody()->getContents();
        $contentArray1 = json_decode($content1, true);
        
        if($contentArray1['status']!=true) {
            $error = $contentArray1['data'];
            return redirect()->to('dashboard/buat-kiriman')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/buat-kiriman')->with('success','Berhasil melakukan update data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/kiriman/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if($contentArray['status']!=true) {
            $error = $contentArray['data'];
            return redirect()->to('dashboard/buat-kiriman')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/buat-kiriman')->with('success','Berhasil melakukan delete data.');
        }
    }
}
