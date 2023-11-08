<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use session;    
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ClientTodoController extends Controller
{
    public function importTxt(Request $request)
    {
        $request->validate([
            'txt_file' => 'required',
        ]);

        $txtFile = $request->file('txt_file');

        $txtContent = file_get_contents($txtFile->getPathname());

        $lines = explode("\n", $txtContent);

        foreach ($lines as $line) {
            $line = trim($line);
            $duplicate = DB::table('domains')->where('name', $line)->first();

            if (!empty($line) && !$duplicate) {
                DB::table('domains')->insert(['name' => $line]);
            }
        }

        return redirect('/');
    }


    public function exportPowerDNS()
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
                'X-API-Key' => 'X8sEItGoEcwo7MLQo6jE4RgTTQ8CjIlr'
            ],
        ]);
        
        $data_domains = DB::table('domains')->get()->chunk(100);
        
        foreach ($data_domains as $data_domain) {
            foreach ($data_domain as $item) {
                $domain_name = $item->name;

                $response = $client->request('POST', 'http://103.217.209.123:8081/api/v1/servers/localhost/zones', [
                    'json' => [
                        'name' => $domain_name . '.', 
                        'kind' => "Native",
                        'masters' => [],
                        'nameservers' => ['ns1.' . $domain_name . '.', 'ns2.' . $domain_name . '.'] 
                    ]
                ]);
                
                $response2 = $client->request('PATCH', 'http://103.217.209.123:8081/api/v1/servers/localhost/zones/'.$domain_name.".", [
                    'json' => [
                        'rrsets' => [
                            [
                                'comments' => [],
                                'name' => $domain_name.".", 
                                'records' => [
                                    [
                                        "content" => "49.128.177.13",
                                        "disabled" => false,
                                    ],
                                ],
                                'ttl' => 3600,
                                'changetype' => "REPLACE",
                                'type' => "A"
                            ]
                                ]
                            ]
                ]);
                
                $history = DB::table('history')->insert([
                    'name' => $domain_name
                ]);
                

                if($history){
                    DB::table('domains')->where('name', $domain_name)->delete();
                }
            }
        }

        return redirect('/');
    }

    public function createDomain(Request $request)
    {
        $domain_name = $request->domain;
    
        // Cek apakah data dengan nama yang sama sudah ada
        $duplicate = DB::table('domains')->where('name', $domain_name)->first()||DB::table('history')->where('name', $domain_name)->first();
    
        if ($duplicate) {
            return response()->json([
                'message' => 'Data with name ' . $domain_name . ' already exists.',
            ], 400); // Mengirim respons JSON dengan pesan kesalahan
        }
    
        // Jika tidak ada data duplikat, tambahkan data ke database
        $insert = DB::table('domains')->insert([
            'name' => $domain_name,
        ]);
    
        return redirect('/');
    }


    public function deleteDomain($domain_name)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
                'X-API-Key' => 'X8sEItGoEcwo7MLQo6jE4RgTTQ8CjIlr'
            ],
        ]);

        // $response2 = $client->request('PATCH', 'http://103.217.209.123:8081/api/v1/servers/localhost/zones/'.$domain_name.".", [
        //     'json' => [
        //         'rrsets' => [
        //             [
        //                 'name' => $domain_name.".", 
        //                 'changetype' => "DELETE",
        //                 'type' => "A"
        //             ]
        //                 ]
        //             ]
        // ]);

        $response = $client->request('DELETE', 'http://103.217.209.123:8081/api/v1/servers/localhost/zones/'.$domain_name);

        $delete_history = DB::table('history')->where('name', $domain_name)->delete();

        return redirect('/history');
    }
    public function deleteListDomain($domain_name)
    {
        $delete_history = DB::table('domains')->where('name', $domain_name)->delete();

        return redirect('/');
    }

    // public function addrrset($domain_name)
    // {
    //     $client = new Client([
    //         'headers' => [
    //             'Authorization' => 'Bearer',
    //             'Accept' => 'application/json',
    //             'X-API-Key' => 'X8sEItGoEcwo7MLQo6jE4RgTTQ8CjIlr'
    //         ],
    //     ]);


    //             $response = $client->request('PATCH', 'http://103.217.209.123:8081/api/v1/servers/localhost/zones/'.$domain_name.".", [
    //                 'json' => [
    //                     'rrsets' => [
    //                         [
    //                             'comments' => [],
    //                             'name' => $domain_name.".", 
    //                             'records' => [
    //                                 [
    //                                     "content" => "49.128.177.13",
    //                                     "disabled" => false,
    //                                 ],
    //                             ],
    //                             'ttl' => 3600,
    //                             'changetype' => "REPLACE",
    //                             'type' => "A"
    //                         ]
    //                             ]
    //                         ]
    //             ]);
                

    //     return redirect('/rrset');
    // }
}
