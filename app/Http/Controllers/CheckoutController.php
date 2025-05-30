<?php

namespace App\Http\Controllers;


use App\Models\AsaasClientes;
use App\Models\AsaasCobrancas;
use App\Models\Estados;
use App\Models\ProdutosServicos;
use App\Services\Gateways\Asaas;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

//use App\Support\ProdutosServicos;


class CheckoutController extends Controller
{

    public function validate(array $data, $Request){

        try {

            $in_cpf_cnpj_titular_cartao = '';
            $in_titular_cartao          = '';
            $in_numero_cartao           = '';
            $in_codigo_seguranca        = '';
            $in_validade_mes            = '';
            $in_validade_ano            = '';

            // ! Boleto Bancário ou Pix
            if(in_array($Request->get('in_forma_pagamento'),['boleto_bancario','pix'])) {

                /* ... */

            // ! Cartão de Crédito
            }elseif(in_array($Request->get('in_forma_pagamento'),['cartao_credito'])) {

                $in_cpf_cnpj_titular_cartao = 'required';
                $in_titular_cartao          = 'required';
                $in_numero_cartao           = 'required';
                $in_codigo_seguranca        = 'required';
                $in_validade_mes            = 'required';
                $in_validade_ano            = 'required';

            }

            $validation = Validator::make($data, [
                'in_produto_servico'                     => ['required'],
                'in_nome'                                => ['required'],
                'in_email'                               => ['required','email'],
                'in_cpf_cnpj'                            => ['required'],
                'in_celular'                             => ['required'],
                'in_cep'                                 => ['required'],
                'in_rua'                                 => ['required'],
                'in_numero'                              => ['required'],
                'in_bairro'                              => ['required'],
                'in_cidade'                              => ['required'],
                'in_estado'                              => ['required'],
                'in_forma_pagamento'                     => ['required'],
                'in_cpf_cnpj_titular_cartao'             => [$in_cpf_cnpj_titular_cartao],  // !* [ Crédito ]
                'in_titular_cartao'                      => [$in_titular_cartao],           // !* [ Crédito ]
                'in_numero_cartao'                       => [$in_numero_cartao],            // !* [ Crédito ]
                'in_codigo_seguranca'                    => [$in_codigo_seguranca],         // !* [ Crédito ]
                'in_validade_mes'                        => [$in_validade_mes],             // !* [ Crédito ]
                'in_validade_ano'                        => [$in_validade_ano],             // !* [ Crédito ]
            ],[
                'in_produto_servico.required'            => 'Selecione um produto ou serviço.',
                'in_nome.required'                       => 'Informe o nome.',
                'in_email.required'                      => 'Informe o seu e-mail.',
                'in_email.email'                         => 'Informe um e-mail válido.',
                'in_cpf_cnpj.required'                   => 'Informe CPF ou CNPJ.',
                'in_celular.required'                    => 'Informe o número do celular.',
                'in_cep.required'                        => 'Informe o seu CEP.',
                'in_rua.required'                        => 'Informe o nome da rua.',
                'in_numero.required'                     => 'Informe o número.',
                'in_bairro.required'                     => 'Informe o seu bairro.',
                'in_cidade.required'                     => 'Informe a sua cidade.',
                'in_estado.required'                     => 'Informe o seu estado.',
                'in_forma_pagamento.required'            => 'Selecione a forma de pagamento',
                'in_cpf_cnpj_titular_cartao.required'    => 'Informe o CPF ou CNPJ titular do cartão.',     // !* [ Crédito ]
                'in_titular_cartao.required'             => 'Informe o nome titular do cartão.',            // !* [ Crédito ]
                'in_numero_cartao.required'              => 'Informe o número do cartão.',                  // !* [ Crédito ]
                'in_codigo_seguranca.required'           => 'Informe o código de segurança do cartão.',     // !* [ Crédito ]
                'in_validade_mes.required'               => 'Informe a validade mês do cartão.',            // !* [ Crédito ]
                'in_validade_ano.required'               => 'Informe a validade ano do cartão.',            // !* [ Crédito ]
            ]);

            return $validation;

        }catch(\Exception $e){
            Log:error($e->getMessage());
            return false;
        }

    }

    public function index(){
        try {
            // # Produto(s) / Serviços

            // !! - 1º Versão de Consulta
            //$Produtos_Servicos = ProdutosServicos::all();

            // !! - 2º Versão de Consulta
            $Produtos_Servicos = ProdutosServicos::all();
            $Estados           = Estados::all();

            return view('checkout', [
                'Produtos_Servicos' => $Produtos_Servicos,
                'Estados'           => $Estados
            ]);
        }catch(\Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function payment(Request $Request) {
        try {

            $data       = $Request->all();

            $validation   = $this->validate($data, $Request);
            if($validation->fails()){
                return response()->json([
                    'status'   => 'error',
                    'message'  => 'Erro ao processar o pagamento!',
                    'errors'   => $validation->errors()
                ], 500);
            }

            DB::beginTransaction();

            // !* Asaas
            $Asaas                              = new Asaas();
            $Asaas_createCustomer               = $Asaas->getOrCreateCustomer($data);

            // !* Consultando Cliente existente ou Criando*
            $AsaasClientes                      = AsaasClientes::where('asaas_id',$Asaas_createCustomer['id'])->first();
            if(!$AsaasClientes){
                $AsaasClientes                  = new AsaasClientes();
            }
            $AsaasClientes->asaas_id            = $Asaas_createCustomer['id'];                  // !* Identificador do Cliente ( cus_ )
            $AsaasClientes->asaas_dateCreated   = $Asaas_createCustomer['dateCreated'];
            $AsaasClientes->name                = $Asaas_createCustomer['name'];
            $AsaasClientes->email               = $Asaas_createCustomer['email'];
            $AsaasClientes->company             = $Asaas_createCustomer['company'];
            $AsaasClientes->phone               = $Asaas_createCustomer['phone'];
            $AsaasClientes->mobilePhone         = $Asaas_createCustomer['mobilePhone'];
            $AsaasClientes->address             = $Asaas_createCustomer['address'];
            $AsaasClientes->addressNumber       = $Asaas_createCustomer['addressNumber'];
            $AsaasClientes->complement          = $Asaas_createCustomer['complement'];
            $AsaasClientes->province            = $Asaas_createCustomer['province'];
            $AsaasClientes->postalCode          = $Asaas_createCustomer['postalCode'];
            $AsaasClientes->cpfCnpj             = $Asaas_createCustomer['cpfCnpj'];
            $AsaasClientes->personType          = $Asaas_createCustomer['personType'];
            $AsaasClientes->city                = $Asaas_createCustomer['city'];
            $AsaasClientes->cityName            = $Asaas_createCustomer['cityName'];
            $AsaasClientes->state               = $Asaas_createCustomer['state'];
            $AsaasClientes->country             = $Asaas_createCustomer['country'];
            $AsaasClientes->observations        = $Asaas_createCustomer['observations'];
            $AsaasClientes->json_request        = (isset($Asaas_createCustomer['json_request'])?$Asaas_createCustomer['json_request']:null);
            $AsaasClientes->json_response       = (isset($Asaas_createCustomer['json_response'])?$Asaas_createCustomer['json_response']:null);
            $AsaasClientes->save();

            // !* Gerando Cobrança
            $Asaas_createAsaasPayment               = $Asaas->createAsaasPayment($data, $AsaasClientes);

            // !* Salvando Banco Local* Cobrança
            $AsaasCobrancas                         = new AsaasCobrancas();
            $AsaasCobrancas->asaas_clientes_id      = $AsaasClientes->id;                           // !* ID relação base Local*
            $AsaasCobrancas->asaas_id               = $Asaas_createAsaasPayment['id'];              // !* Identificador da Cobrança ( pay_ )
            $AsaasCobrancas->customer               = $AsaasClientes->asaas_id;
            $AsaasCobrancas->dateCreated            = $Asaas_createAsaasPayment['dateCreated'];
            $AsaasCobrancas->value                  = $Asaas_createAsaasPayment['value'];
            $AsaasCobrancas->netValue               = $Asaas_createAsaasPayment['netValue'];
            $AsaasCobrancas->billingType            = $Asaas_createAsaasPayment['billingType'];
            $AsaasCobrancas->dueDate                = $Asaas_createAsaasPayment['dueDate'];
            $AsaasCobrancas->originalDueDate        = $Asaas_createAsaasPayment['originalDueDate'];
            $AsaasCobrancas->description            = $Asaas_createAsaasPayment['description'];
            $AsaasCobrancas->invoiceUrl             = $Asaas_createAsaasPayment['invoiceUrl'];
            $AsaasCobrancas->invoiceNumber          = $Asaas_createAsaasPayment['invoiceNumber'];
            $AsaasCobrancas->externalReference      = $Asaas_createAsaasPayment['externalReference'];
            $AsaasCobrancas->bankSlipUrl            = $Asaas_createAsaasPayment['bankSlipUrl'];
            $AsaasCobrancas->status                 = $Asaas_createAsaasPayment['status'];
            $AsaasCobrancas->barCode                = $Asaas_createAsaasPayment['barCode'];
            $AsaasCobrancas->encodedImage_pixQrCode = $Asaas_createAsaasPayment['encodedImage'];
            $AsaasCobrancas->payload_pix            = $Asaas_createAsaasPayment['payload'];
            $AsaasCobrancas->cc_holderName          = $data['in_titular_cartao'];            // !* [ Cartão de Crédito ]
            $AsaasCobrancas->cc_cpfCnpj             = $data['in_cpf_cnpj_titular_cartao'];   // !* [ Cartão de Crédito ]
            $AsaasCobrancas->cc_number              = $data['in_numero_cartao'];             // !* [ Cartão de Crédito ]
            $AsaasCobrancas->cc_expiryMonth         = $data['in_validade_mes'];              // !* [ Cartão de Crédito ]
            $AsaasCobrancas->cc_expiryYear          = $data['in_validade_ano'];              // !* [ Cartão de Crédito ]
            $AsaasCobrancas->cc_ccv                 = null;                                  // !* [ Cartão de Crédito ] * Null -| ( !* Segurança )
            $AsaasCobrancas->json_request           = (isset($Asaas_createAsaasPayment['json_request'])?$Asaas_createAsaasPayment['json_request']:null);
            $AsaasCobrancas->json_response          = (isset($Asaas_createAsaasPayment['json_response'])?$Asaas_createAsaasPayment['json_response']:null);
            $AsaasCobrancas->save();

            DB::commit();

            $payment_view_sel = '';
            switch($data['in_forma_pagamento']) {
                case 'boleto_bancario': $payment_view_sel = 'payment_methods.boleto_bancario'; break;
                case 'cartao_credito':  $payment_view_sel = 'payment_methods.cartao_credito'; break;
                case 'pix':             $payment_view_sel = 'payment_methods.pix'; break;
            }

            $payment_view = view($payment_view_sel, [
                'data'           => $data,
                'AsaasClientes'  => $AsaasClientes,
                'AsaasCobrancas' => $AsaasCobrancas
            ]);

            return response()->json([
                'status'         => 'ok',
                'message'        => 'Cobrança realizada com sucesso!',
                'payment_method' => $data['in_forma_pagamento'],
                'payment_view'   => $payment_view->render()
            ], 200);

        }catch(HttpResponseException $e){
            throw $e;
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'    => 'error',
                'message'   => 'Erro ao processar o pagamento!'
            ], 500);
        }
    }

    public function method_return($hash, Request $Request){
        try {

            $data               = $Request->all();

            $AsaasCobrancas     = AsaasCobrancas::where('hash',$hash)->first();
            $AsaasClientes      = AsaasClientes::find($AsaasCobrancas->asaas_clientes_id);

            switch($AsaasCobrancas->billingType){
                case 'BOLETO':      $data['in_forma_pagamento'] = 'boleto_bancario'; break;
                case 'CREDIT_CARD': $data['in_forma_pagamento'] = 'cartao_credito'; break;
                case 'PIX':         $data['in_forma_pagamento'] = 'pix'; break;
            }

            $payment_view_sel = '';
            switch($data['in_forma_pagamento']) {
                case 'boleto_bancario': $payment_view_sel = 'payment_methods.boleto_bancario'; break;
                case 'cartao_credito':  $payment_view_sel = 'payment_methods.cartao_credito'; break;
                case 'pix':             $payment_view_sel = 'payment_methods.pix'; break;
            }

            $payment_view = view($payment_view_sel, [
                'data'           => $data,
                'AsaasClientes'  => $AsaasClientes,
                'AsaasCobrancas' => $AsaasCobrancas
            ]);

            return response()->json([
                'status'         => 'ok',
                'message'        => 'Cobrança realizada com sucesso!',
                'payment_method' => $data['in_forma_pagamento'],
                'payment_view'   => $payment_view->render()
            ], 200);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json([
                'status'    => 'error',
                'message'   => 'Erro ao processar o pagamento!'
            ], 500);
        }
    }

}
