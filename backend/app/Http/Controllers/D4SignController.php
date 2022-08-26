<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Edmarr2\D4sign\Facades\D4Sign;
use Illuminate\Support\Facades\Http;            

class D4SignController extends Controller
{
    protected $client;
    protected $headers;

    protected const ENV_PRODUCTION = 'https://secure.d4sign.com.br/api/v1/';
    protected const ENV_SANDBOX = 'https://sandbox.d4sign.com.br/api/v1/';

    protected $token_api;
    protected $crypt_key;
    protected $template;
    protected $cofre;

    //https://sandbox.d4sign.com.br/api/v1/documents/f29f8cd9-b4dd-415a-a5dc-4fece8b4e05d/makedocumentbytemplateword?tokenAPI=live_37bd93e7eb672c2406b413ea07831e162205fa5e8732c3d71151a8c4c6af9cef&cryptKey=live_crypt_CjbomwWXjlJ6hSF1U5jo5DNRlYz1ptRH

    public function __construct()
    {
        
        $this->token_api = config('d4sign.token_api');
        $this->crypt_key = config('d4sign.crypt_key');
        $this->template = config('d4sign.template');
        $this->cofre = config('d4sign.cofre');
        $this->headers = [
            'Accept'   => 'application/json',
            'tokenAPI' => $this->token_api,
            'cryptKey' => $this->crypt_key
        ];
    }


    public function getBaseUri($uri = '')
    {
        $baseUri = config('d4sign.mode') === 'production' ? self::ENV_PRODUCTION : self::ENV_SANDBOX;
        return $baseUri . $uri;
    }

    public function index() { 
        //$response = Http::get('http://example.com');
        /*$response = Http::withHeaders([
            'Accept'   => 'application/json',
            'tokenAPI' => $this->token_api,
            'cryptKey' => $this->crypt_key
        ])->get($this->getBaseUri('safes'), [
            'id_template'=> ''
        ]);
        */

        $response = Http::withHeaders($this->headers)->get($this->getBaseUri('safes'));

        return response()->json(
            $response->object()
        , 200);

        // $docs = (string) D4Sign::templates()->find()->getBody();
        // $doc = (array)json_decode($docs);
        // dd($doc[1]->name);
    }
    public function documento(Request $request) {

        $temObj = new \stdClass();
        $temObj->cnpj = '789211222'; 
        $temObj->razao = 'TESTE PHP'; 
        $temObj->endereco = 'TESTE ENDE PHP'; 

        $obj_send = $this->createDocument($temObj);
        
        $response = Http::withHeaders($this->headers)
                    ->withBody(
                        json_encode($obj_send), 'application/json'
                    )
                    ->post($this->getBaseUri('documents/'.$this->cofre.'/makedocumentbytemplateword'));
        
        $document_uuid = $response->object()->uuid;

        //dd($document_uuid);
        return response()->json(
            $response->object()
        , 200);
    }
    public function createDocument($dados) {

        // {
        //     "razao_social": "",
        //     "cnpj": "",
        //     "nome_fantasia": "",
        //     "endereco": "",
        //     "estado": "",
        //     "cep": "",
        //     "telefone": "",
        //     "email": "",
        //     "website": "",
        //     "nome_completo": "",
        //     "cpf": "",
        //     "rg": "",
        //     "org_exp_uf": "",
        //     "celular": ""
        // }


        $temObj = new \stdClass();
        $temObj->cnpj = $dados->cnpj;//'789211222'; 
        $temObj->razao = $dados->razao;//'TESTE PHP'; 
        $temObj->endereco = $dados->endereco;//'TESTE ENDE PHP'; 

        $temp = [];

        $temp[$this->template] = $temObj;

        $obj = new \stdClass();

        $obj->name_document = "Nome do documento test";
        $obj->uuid_folder = "";
        $obj->templates = $temp;

        return $obj;
    }
}
