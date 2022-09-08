<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Edmarr2\D4sign\Facades\D4Sign;
use Illuminate\Support\Facades\Http;            

class D4SignController extends Controller
{
    protected $client;
    protected $headers;
    protected $headersAir;

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

        $this->headersAir = [
            'Accept'   => 'application/json',
            'Authorization' => 'Bearer keyNEmaNWdysrYOjr',
            'Content-Type' => 'application/json'
        ];
    }


    public function getBaseUri($uri = '')
    {
        $baseUri = config('d4sign.mode') === 'producao' ? self::ENV_PRODUCTION : self::ENV_SANDBOX;
        return $baseUri . $uri;
    }

    public function index() { 
        echo ''; exit;
    }
    public function documento(Request $request) {
        $dados = (object)$request->all();

        $obj_send = $this->createDocument($dados);
        
        $response = Http::withHeaders($this->headers)
                    ->withBody(
                        json_encode($obj_send), 'application/json'
                    )
                    ->post($this->getBaseUri('documents/'.$this->cofre.'/makedocumentbytemplateword'));
        
        $document_uuid = $response->object()->uuid;
        if($document_uuid != '') {
            $this->addSigners($dados, $document_uuid);
            $this->sendToSign($document_uuid);
            $this->sendWebHook($document_uuid);
        }

        return response()->json(
            $response->object()
        , 200);
    }
    public function addSigners($dados, $document_uuid) {
        $signer = new \stdClass();

        $signer->email = $dados->email;
        $signer->act = "1";
        $signer->foreign = "0";
        $signer->certificadoicpbr = "0";
        $signer->assinatura_presencial = "0";
        $signer->docauth = "0";
        $signer->docauthandselfie = "0";
        $signer->embed_methodauth = "email";
        $signer->embed_smsnumber = "";
        $signer->upload_allow = "0";

        $signers = ['signers' => [$signer]];

        $response = Http::withHeaders($this->headers)
                    ->withBody(
                        json_encode($signers), 'application/json'
                    )
                    ->post($this->getBaseUri('documents/'.$document_uuid.'/createlist'));

    }
    public function sendToSign($document_uuid) {
        $sign = new \stdClass();

        $sign->message = "Recebemos um documento que necessita de sua assinatura. Por favor, prossiga com os passos deste e-mail.";
        $sign->skip_email = "0";
        $sign->workflow = "";
        $sign->tokenAPI = $this->token_api;
 
        $response = Http::withHeaders($this->headers)
                    ->withBody(
                        json_encode($sign), 'application/json'
                    )
                    ->post($this->getBaseUri('documents/'.$document_uuid.'/sendtosigner'));

    }
    public function sendWebHook($document_uuid) {
        $url = new \stdClass();

        $url->url = 'https://brit.brasilitplus.com/api/documento_webhook/';

        $response = Http::withHeaders($this->headers)
                    ->withBody(
                        json_encode($url), 'application/json'
                    )
                    ->post($this->getBaseUri('documents/'.$document_uuid.'/webhooks'));

    }
    public function createDocument($dados) {

        $temObj = new \stdClass();

        $temObj->razao_social = $dados->razao_social;
        $temObj->cnpj = $dados->cnpj;
        $temObj->nome_fantasia = $dados->nome_fantasia;
        $temObj->endereco = $dados->endereco;
        $temObj->estado = $dados->estado;
        $temObj->cep = $dados->cep;
        $temObj->telefone = $dados->telefone; 
        $temObj->email = $dados->email;
        $temObj->website = $dados->website;
        $temObj->nome_completo = $dados->nome_completo;

        $temObj->cpf = $dados->cpf;
        $temObj->rg = $dados->rg;
        $temObj->org_exp_uf = $dados->org_exp_uf;
        $temObj->celular = $dados->celular;

        $temp = [];

        $temp[$this->template] = $temObj;

        $obj = new \stdClass();
         $date = date('d-m-Y H-m-s');
        $obj->name_document = "Brasil IT + - ". $dados->razao_social . " - " . $date;
        $obj->uuid_folder = "";
        $obj->templates = $temp;

        return $obj;
    }
    public function documento_webhook(Request $request) {

        $dados = (object)$request->all();
        /*
        Pendente
        Cancelado
        Assinado
        */ 
        $mensagem = "";

        if($dados->type_post == "3") {
            $mensagem = "Cancelado";
        } else if($dados->type_post == "4") {
            $mensagem = "Assinado";
        } else if($dados->type_post == "1") {
            $mensagem = "Assinado";
        } else {
            $mensagem = "Enviado";
        }
        $obj = new \stdClass();
        $obj->document_uuid = $dados->uuid;

        $response = Http::withHeaders($this->headersAir)
                    ->withBody(
                        json_encode($dados), 'application/json'
                    )
                    ->get("https://api.airtable.com/v0/appV9hUETmlTsyQrg/tblVjW7bR49CiQhG6?filterByFormula=({Id_D4} = '".$obj->document_uuid."')");
        //$air = $response->records[0]->id;
        $dados_air = json_decode($response->body());

 


        if(!empty($dados_air->records)) {
            $id_air = $dados_air->records[0]->id;

            $objSend = new \stdClass();
            $objDados = new \stdClass();
            $objField = new \stdClass();
            $objDados->id = $id_air;
            $objField->Status = $mensagem;
            $objDados->fields = $objField;
            $objSend->records = [$objDados];
            //print_r(json_encode($objSend)); exit;

            $responseUpdate = Http::withHeaders($this->headersAir)
                    ->withBody(
                        json_encode($objSend), 'application/json'
                    )
                    ->patch("https://api.airtable.com/v0/appV9hUETmlTsyQrg/tblVjW7bR49CiQhG6");

            echo print_r($responseUpdate->body());
        }

    }
}
