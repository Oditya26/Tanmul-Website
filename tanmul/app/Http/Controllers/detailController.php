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

        // Array of quotes
       $quotes = [
        "The difference between ordinary and extraordinary is that little extra.",
        "If you can dream it, you can do it.",
        "The important thing is not to stop questioning. Curiosity has its own reason for existing.",
        "Twenty years from now you will be more disappointed by the things that you didn't do than by the ones you did do. So throw off the bowlines, sail away from safe harbor, catch the trade winds in your sails. Explore, Dream, Discover.",
        "You don't have to be great to start, but you have to start to be great.",
        "Argue for your limitations, and sure enough, they're yours.",
        "The best revenge is massive success.",
        "The only true wisdom is in knowing you know nothing.",
        "The future belongs to those who believe in the beauty of their dreams.",
        "The key to success is to focus on the 'why' of what you do. People don't buy what you do; they buy why you do it.",
        "Success is not final; failure is not fatal: it is the courage to continue that counts.",
        "The best and most beautiful things in the world cannot be seen or even touched - they must be felt with the heart.",
        "If you want to live a happy life, tie it to a goal, not to people or things.",
        "Your time is limited, so don't waste it living someone else's life. Don't be trapped by dogma - which is living with the results of other people's thinking. Don't let the noise of others' opinions drown out your own inner voice. And most importantly, have the courage to follow your heart and intuition. They somehow already know what you truly want to become. Everything else is secondary.",
        "The purpose of life is not to be happy. It is to be useful, to be honorable, to be compassionate, to have it make some difference that you have lived and lived well.",
        "Education is the most powerful weapon which you can use to change the world.",
        "The only person you are destined to become is the person you decide to be.",
        "The important thing is this: to be able at any moment to sacrifice what you are for what you could become.",
        "The mind is everything. What you think you become.",
        "Believe you can and you're halfway there.",
        "I've learned that people will forget what you said, people will forget what you did, but people will never forget how you made them feel.",
        "There is no substitute for hard work.",
        "Innovation distinguishes between a leader and a follower.",
        "The only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle.",
        "Curiosity about life in all its aspects, I think, is still the secret of great creative people.",
        "Darkness cannot drive out darkness; only light can do that. Hate cannot drive out hate; only love can do that.",
        "The question isn't who will let me; it's who will stop me.",
        "Change is the only constant in life.",
        "The journey of a thousand miles begins with a single step.",
        "You miss 100% of the shots you don't take.",
        "Don't be afraid to give up the good to go for the great.",
        "The unexamined life is not worth living.",
        "You are never too old to set another goal or to dream a new dream.",
      ];

        // Get a random quote
        $randomQuote = $quotes[array_rand($quotes)];

        // Types of notifications
        $notificationTypes = ['error', 'success'];
        $randomType = $notificationTypes[array_rand($notificationTypes)];

        // Display notification
        emotify($randomType, $randomQuote);

        
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
