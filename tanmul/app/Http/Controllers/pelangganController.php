<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class pelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/pelanggan";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('dashboard2.pelanggan.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard2.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nama_plg = $request->nama_plg;
        $telp_plg = $request->telp_plg;
        $alamat_utama = $request->alamat_utama;

        $parameter = [
            'nama_plg' => $nama_plg,
            'telp_plg' => $telp_plg,
            'alamat_utama' => $alamat_utama,
        ];
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/pelanggan";
        $response = $client->request('POST', $url,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter),
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        
        if($contentArray['status']!=true) {
            $error = $contentArray['data'];
            return redirect()->to('dashboard/pelanggan')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/pelanggan')->with('success','Berhasil memasukkan data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/pelanggan/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if($contentArray['status']!=true) {
            $error = $contentArray['message'];
            return redirect()->to('dashboard/pelanggan')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('dashboard2.pelanggan.edit', ['data'=>$data]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/pelanggan/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if($contentArray['status']!=true) {
            $error = $contentArray['message'];
            return redirect()->to('dashboard/pelanggan')->withErrors($error);
        } else {
            $data = $contentArray['data'];
            return view('dashboard2.pelanggan.create', ['data'=>$data]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nama_plg = $request->nama_plg;
        $telp_plg = $request->telp_plg;
        $alamat_utama = $request->alamat_utama;

        $parameter = [
            'nama_plg' => $nama_plg,
            'telp_plg' => $telp_plg,
            'alamat_utama' => $alamat_utama,
        ];
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/pelanggan/$id";
        $response = $client->request('PUT', $url,[
            'headers'=>['Content-type'=>'application/json'],
            'body'=>json_encode($parameter),
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        
        if($contentArray['status']!=true) {
            $error = $contentArray['data'];
            return redirect()->to('dashboard/pelanggan')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/pelanggan')->with('success','Berhasil melakukan update data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:8080/api/pelanggan/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if($contentArray['status']!=true) {
            $error = $contentArray['data'];
            return redirect()->to('dashboard/pelanggan')->withErrors($error)->withInput();
        } else
        {
            return redirect()->to('dashboard/pelanggan')->with('success','Berhasil melakukan delete data.');
        }
    }
}
