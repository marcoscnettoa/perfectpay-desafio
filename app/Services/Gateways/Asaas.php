<?php

namespace App\Services\Gateways;

use App\Models\ProdutosServicos;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Asaas
{

    private $asaasApiKey;
    private $asaasApiUrl;
    private $products;

    public function __construct(){
        $this->asaasApiKey = ENV('ASAAS_API_KEY');
        $this->asaasApiUrl = ENV('ASAAS_BASE_URL');
    }

    public function getOrCreateCustomer(array $customData) {
        try {

            // !* Tratamento
            $customData['in_cpf_cnpj'] = preg_replace('/\D/', '', $customData['in_cpf_cnpj']);
            $customData['in_celular']  = preg_replace('/\D/', '', $customData['in_celular']);
            $customData['in_cep']      = preg_replace('/\D/', '', $customData['in_cep']);
            // -

            $response = Http::withHeaders([
                'access_token' => $this->asaasApiKey
            ])->get($this->asaasApiUrl.'/customers',[
                'cpfCnpj' => $customData['in_cpf_cnpj']
            ]);

            $response_json = $response->json();

            // !* Cliente encontrado
            if($response->successful() && !empty($response_json['data'])) {

                // !* Atualizar Dados do Cliente para os mais recente -| * Form
                $put = [
                    'name'                  => $customData['in_nome'],
                    'email'                 => $customData['in_email'],
                    //'cpfCnpj'               => $customData['in_cpf_cnpj'],
                    'mobilePhone'           => $customData['in_celular'],
                    'phone'                 => $customData['in_telefone'],
                    'address'               => $customData['in_rua'],
                    'addressNumber'         => $customData['in_numero'],
                    'complement'            => $customData['in_complemento'],
                    'province'              => $customData['in_bairro'],
                    'postalCode'            => $customData['in_cep'],
                    'city'                  => $customData['in_cidade'],
                    'state'                 => $customData['in_estado'],
                    'externalReference'     => null,
                    'notificationDisabled'  => false,
                    'observations'          => 'Cliente Teste Sandbox - Update'
                ];
                $response = Http::withHeaders([
                    'access_token'          => $this->asaasApiKey
                ])->put($this->asaasApiUrl.'/customers/'.$response_json['data'][0]['id'],$put);

                $response_json = $response->json();

                if($response->successful()) {
                    $response_json['json_request']  = json_encode($put);
                    $response_json['json_response'] = json_encode($response_json);
                    return $response_json;
                }

                throw new HttpResponseException(
                    response()->json([
                        'status'    => 'error',
                        'errors'    => (isset($response_json['errors'])?$response_json['errors']:null),
                        'message'   => 'Erro ao processar o pagamento! -| createCustomer - update'
                    ], 500)
                );

            }

            // !* Cliente não encontrado - * Criar *
            $post = [
                'name'                  => $customData['in_nome'],
                'email'                 => $customData['in_email'],
                'cpfCnpj'               => $customData['in_cpf_cnpj'],
                'mobilePhone'           => $customData['in_celular'],
                'phone'                 => $customData['in_telefone'],
                'address'               => $customData['in_rua'],
                'addressNumber'         => $customData['in_numero'],
                'complement'            => $customData['in_complemento'],
                'province'              => $customData['in_bairro'],
                'postalCode'            => $customData['in_cep'],
                'city'                  => $customData['in_cidade'],
                'state'                 => $customData['in_estado'],
                'externalReference'     => null,
                'notificationDisabled'  => false,
                'observations'          => 'Cliente Teste Sandbox - Criação'
            ];
            $response = Http::withHeaders([
                'access_token'          => $this->asaasApiKey
            ])->post($this->asaasApiUrl.'/customers',$post);

            $response_json = $response->json();

            if($response->successful()) {
                $response_json['json_request']  = json_encode($post);
                $response_json['json_response'] = json_encode($response_json);
                return $response_json;
            }

            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'errors'    => (isset($response_json['errors'])?$response_json['errors']:null),
                    'message'   => 'Erro ao processar o pagamento! -| createCustomer - new'
                ], 500)
            );


        }catch(HttpResponseException $e){
            throw $e;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'message'   => 'Erro ao processar o pagamento! -| createCustomer'
                ], 500)
            );
        }
    }

    public function createAsaasPayment(array $customData, object $AsaasCustomerData) {
        try {

            $ProdutoOuServico = ProdutosServicos::where('chave', $customData['in_produto_servico'])->first();
            if(!$ProdutoOuServico){
                throw new HttpResponseException(
                    response()->json([
                        'status'    => 'error',
                        'message'   => 'Erro ao processar o pagamento! -| createAsaasPayment -| Produto não encontrado!'
                    ], 500)
                );
            }

            // !* Forma de Pagamento -| [ boleto_bancario, cartao_credito, pix ]
            $billingType = '';
            switch($customData['in_forma_pagamento']){
                case 'boleto_bancario': $billingType = 'BOLETO'; break;
                case 'cartao_credito':  $billingType = 'CREDIT_CARD'; break;
                case 'pix':             $billingType = 'PIX'; break;
            }

            $payload = [
                'customer'          => $AsaasCustomerData->asaas_id,
                'billingType'       => $billingType,
                'value'             => $ProdutoOuServico->valor,
                'dueDate'           => now()->addDays(5)->toDateString(), // !* Data de Vencimento
                'description'       => $ProdutoOuServico->descricao,
                'externalReference' => 'ASAAS-CLIENTE-ID-'.$AsaasCustomerData->id.'-PRODUTO-SERVICO-ID-'.$ProdutoOuServico->id,
                //'callback'          => null,
            ];

            if($billingType == 'BOLETO') {
                /* ... */
            }elseif($billingType == 'CREDIT_CARD') {
                $payload['creditCard'] = [
                    'holderName'    => $customData['in_titular_cartao'],
                    'number'        => preg_replace('/\D/', '', $customData['in_numero_cartao']),
                    'expiryMonth'   => (string) $customData['in_validade_mes'],
                    'expiryYear'    => (string) $customData['in_validade_ano'],
                    'ccv'           => $customData['in_codigo_seguranca']
                ];
                $payload['creditCardHolderInfo'] = [
                    'name'          => $customData['in_titular_cartao'],
                    'email'         => $customData['in_email'],
                    'cpfCnpj'       => preg_replace('/\D/', '', $customData['in_cpf_cnpj_titular_cartao']),
                    'postalCode'    => preg_replace('/\D/', '', $customData['in_cep']),
                    'addressNumber' => $customData['in_numero'],
                    'address'       => $customData['in_rua'],
                    'province'      => $customData['in_bairro'],
                    'phone'         => preg_replace('/\D/', '', $customData['in_celular']),
                ];
                $payload['remoteIp']         = request()->ip();
                $payload['installments']     = 1; // !* 1x Parcela
                $payload['installmentValue'] = $ProdutoOuServico->valor; // !* 1x Parcela
            }elseif ($billingType == 'PIX') {
                $payload['chargeType'] = 'DEFAULT';

            }

            $response = Http::withHeaders([
                'access_token' => $this->asaasApiKey,
                'Content-Type' => 'application/json'
            ])->post($this->asaasApiUrl.'/payments', $payload);

            $response_json = $response->json();

            if($response->successful()) {

                // !* BOLETO
                if(in_array($billingType,['BOLETO'])){
                    $getBarCode     = $this->getBarCode($response_json['id']);
                }

                // !* BOLETO ou PIX -| consulta o Pagamento -| QR Code
                if(in_array($billingType,['BOLETO','PIX'])){
                    $getQrCodePix   = $this->getQrCodePix($response_json['id']);
                }

                $response_json['json_request']  = json_encode($payload);
                $response_json['json_response'] = json_encode($response_json);
                $response_json['barCode']       = (isset($getBarCode)?$getBarCode['barCode']:null);
                $response_json['encodedImage']  = (isset($getQrCodePix)?$getQrCodePix['encodedImage']:null);
                $response_json['payload']       = (isset($getQrCodePix)?$getQrCodePix['payload']:null);
                return $response_json;
            }

            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'errors'    => (isset($response_json['errors'])?$response_json['errors']:null),
                    'message'   => 'Erro ao processar o pagamento! -| createAsaasPayment -| Http - payments'
                ], 500)
            );

        }catch(HttpResponseException $e){
            throw $e;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'message'   => 'Erro ao processar o pagamento! -| createAsaasPayment'
                ], 500)
            );
        }
    }

    public function getBarCode($pay_id){
        try {

            $response       = Http::withHeaders([
                'access_token' => $this->asaasApiKey,
            ])->get($this->asaasApiUrl.'/payments/'.$pay_id.'/identificationField');

            $response_json  = $response->json();

            if($response->successful()){
                return $response_json;
            }

            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'errors'    => (isset($response_json['errors'])?$response_json['errors']:null),
                    'message'   => 'Erro ao consultar Boleto Bar Code ou Linha Digitável! -| getBarCode - (pay_id: '.$pay_id.') - 1*'
                ], 500)
            );

        }catch(HttpResponseException $e){
            throw $e;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'message'   => 'Erro ao consultar Boleto Bar Code ou Linha Digitável! -| getBarCode - (pay_id: '.$pay_id.') - 2*'
                ], 500)
            );
        }
    }

    public function getQrCodePix($pay_id){
        try {

            $response       = Http::withHeaders([
                'access_token' => $this->asaasApiKey,
            ])->get($this->asaasApiUrl.'/payments/'.$pay_id.'/pixQrCode');

            $response_json  = $response->json();

            if($response->successful()){
                return $response_json;
            }

            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'errors'    => (isset($response_json['errors'])?$response_json['errors']:null),
                    'message'   => 'Erro ao consultar QR Code pagamento Pix! -| getQrCodePix - (pay_id: '.$pay_id.') - 1*'
                ], 500)
            );

        }catch(HttpResponseException $e){
            throw $e;
        }catch(\Exception $e){
            Log::error($e->getMessage());
            throw new HttpResponseException(
                response()->json([
                    'status'    => 'error',
                    'message'   => 'Erro ao consultar QR Code pagamento Pix! -| getQrCodePix - (pay_id: '.$pay_id.') - 2*'
                ], 500)
            );
        }
    }

}
