<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Url;


class UrlController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create', 'list', 'update', 'show']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $messages = [
            'url.required' => 'Fill the URL',
            'url.url' => 'URL must be valid'
        ];

        try {
            $url = $request->validate([
                'url' => 'required|url'
            ], $messages);

            if (!empty($url['url'])) {

                $endpoint = $url['url'];
                $url = new Url;
                $url->url = $endpoint;
                $url->save();

                return response()->json(['success' => 'Created'], 200);

            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Put a valid URL'], 200);
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        $url = Url::where('id', $id)->get();

        foreach ($url as $index => $record) {
            $http_response = $record->http_response;
        }
        return response($http_response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public static function update()
    {
        $records = Url::all();

        $client = new Client();

        try {
            foreach ($records as $index => $record) {

                $response = $client->request('GET', $record->url);
                $status_code = $response->getStatusCode();
                $http_response = $response->getBody()->getContents();

                Url::where("id", $record->id)->update([
                        "id" => $record->id,
                        "http_response" => $http_response,
                        "status_code" => $status_code
                    ]
                );
            }
            return response()->json(['success' => 'Updated'], 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function list()
    {

        $records = Url::all();

        foreach ($records as $index => $record) {
            $data[$index]['url'] = $record->url;
            $data[$index]['status_code'] = $record->status_code;
            $data[$index]['http_response'] = $record->id;
        }
        if(empty($data)){
            return response()->json([], 200);
        }
        return response()->json($data, 200);

    }

}
