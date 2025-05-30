@extends("layout.app")
@section("styles")
    <style>
        /* ... */
    </style>
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="row flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="centro box-shadow-2 p-0">
                            <div class="content-preloader" style="display: none;">
                                <div class="preloader">
                                    <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                                    <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"></div>
                                    <br/>
                                    <span class="preloader-txt">Processando...</span>
                                </div>
                                <div class="preloader-load-content" style="display: none;">

                                </div>
                            </div>
                            <div class="card card-bg border-grey border-lighten-3 px-1 py-1 box-shadow-3 m-0">
                                <form id="form-processar-pagamento" name="form" action="https://lh.projetos/Projetos/tocaws/perfectpay/_git/public/checkout/payment" method="post" enctype="application/x-www-form-urlencoded" novalidate>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">
                                    <div class="card-header text-left">
                                        <img src="{{URL('assets/images')}}/perfectpay_logo.png">
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="form-section"><i class="fa fa-cube   "></i> Produto / Serviço</h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <label id="in_produto_servico_txt" class="m-0" for="in_cpf_cnpj_titular_cartao">Selecione um Produto ou Serviço:</label>
                                                    <div class="row">
                                                        <div>
                                                            <ul class="sel-produtos-servicos">
                                                                {{-- # 1º Versão de Consulta --}}
                                                                {{--
                                                                @foreach($Produtos_Servicos as $PS)
                                                                    <li value="{{ $PS['chave'] }}">
                                                                        <h2>{{ $PS['nome'] }}</h2>
                                                                        <p>R$ {{ $PS['valor'] }}</p>
                                                                    </li>
                                                                @endforeach
                                                                --}}
                                                                {{-- # 2º Versão de Consulta --}}
                                                                @foreach($Produtos_Servicos as $PS)
                                                                    <li value="{{ $PS->chave }}">
                                                                        <h2>{{ $PS->nome }}</h2>
                                                                        <p>R$ {{ \App\Helper\Helper::H_Decimal_DB_ptBR($PS->valor) }}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <input type="hidden" id="in_produto_servico" name="in_produto_servico" value="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:15px;">
                                                <div class="col-md-12">
                                                    <h4 class="form-section"><i class="fa fa-user"></i> Identificação</h4>
                                                </div>
                                                <div class="col-md-10 col-lg-8">
                                                    <div class="form-group">
                                                        <label for="in_nome">Nome Completo</label>
                                                        <input type="text" id="in_nome" class="form-control" placeholder="Informe seu nome completo" name="in_nome" required="required" maxlength="200">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-5">
                                                            <div class="form-group">
                                                                <label for="in_email">E-mail</label>
                                                                <input type="text" id="in_email" class="form-control" placeholder="Informe seu e-mail" name="in_email" required="required" maxlength="200">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-5">
                                                            <div class="form-group">
                                                                <label for="in_cpf_cnpj">CPF ou CNPJ</label>
                                                                <input type="text" id="in_cpf_cnpj" class="form-control" placeholder="Informe seu CPF ou CNPJ" name="in_cpf_cnpj" required="required" maxlength="18">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-5">
                                                            <div class="form-group">
                                                                <label for="in_celular">Celular</label>
                                                                <input type="text" id="in_celular" class="form-control mask-celular" placeholder="(00) 00000-0000" name="in_celular" required="required" maxlength="15">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-5">
                                                            <div class="form-group">
                                                                <label for="in_telefone">Telefone</label>
                                                                <input type="text" id="in_telefone" class="form-control mask-telefone" placeholder="(00) 0000-0000" name="in_telefone" maxlength="14">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="form-section"><i class="fa fa-home"></i> Endereço</h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="in_cep">CEP</label>
                                                                <input type="text" id="in_cep" class="form-control mask-cep" placeholder="00000-000" name="in_cep" required="required" maxlength="10">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="in_rua">Rua</label>
                                                                <input type="text" id="in_rua" class="form-control" placeholder="" name="in_rua" required="required" maxlength="200">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="in_numero">Número</label>
                                                                <input type="text" id="in_numero" class="form-control" placeholder="0" name="in_numero" required="required" maxlength="5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="in_complemento">Complemento</label>
                                                                <input type="text" id="in_complemento" class="form-control" placeholder="" name="in_complemento" maxlength="200">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="in_bairro">Bairro</label>
                                                                <input type="text" id="in_bairro" class="form-control" placeholder="" name="in_bairro" required="required" maxlength="200">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="in_cidade">Estado</label>
                                                                <select id="in_estado" name="in_estado" class="select2 form-control" required="required">
                                                                    <option value="">---</option>
                                                                    {{-- # 1º Versão de Consulta --}}
                                                                    {{--<option value="AC">Acre</option>
                                                                    <option value="AL">Alagoas</option>
                                                                    <option value="AP">Amapá</option>
                                                                    <option value="AM">Amazonas</option>
                                                                    <option value="BA">Bahia</option>
                                                                    <option value="CE">Ceará</option>
                                                                    <option value="DF">Distrito Federal</option>
                                                                    <option value="ES">Espírito Santo</option>
                                                                    <option value="GO">Goiás</option>
                                                                    <option value="MA">Maranhão</option>
                                                                    <option value="MT">Mato Grosso</option>
                                                                    <option value="MS">Mato Grosso do Sul</option>
                                                                    <option value="MG">Minas Gerais</option>
                                                                    <option value="PA">Pará</option>
                                                                    <option value="PB">Paraíba</option>
                                                                    <option value="PR">Paraná</option>
                                                                    <option value="PE">Pernambuco</option>
                                                                    <option value="PI">Piauí</option>
                                                                    <option value="RJ">Rio de Janeiro</option>
                                                                    <option value="RN">Rio Grande do Norte</option>
                                                                    <option value="RS">Rio Grande do Sul</option>
                                                                    <option value="RO">Rondônia</option>
                                                                    <option value="RR">Roraima</option>
                                                                    <option value="SC">Santa Catarina</option>
                                                                    <option value="SP">São Paulo</option>
                                                                    <option value="SE">Sergipe</option>
                                                                    <option value="TO">Tocantins</option>--}}
                                                                    {{-- # 2º Versão de Consulta --}}
                                                                    @foreach($Estados as $E)
                                                                        <option value="{{$E->uf}}">{{$E->nome}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="in_cidade">Cidade</label>
                                                                <select id="in_cidade" name="in_cidade" class="select2 form-control" required="required">
                                                                    <option value="">---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 class="form-section"><i class="fa fa-credit-card"></i> Forma de Pagamento</h4>
                                                </div>
                                                <div class="col-md-12">
                                                    <label id="in_forma_pagamento_txt" class="m-0" for="in_cpf_cnpj_titular_cartao">Selecione a forma de pagamento:</label>
                                                    <div class="row">
                                                        <div>
                                                            <ul class="sel-formas-pagamentos">
                                                                <li value="boleto_bancario">
                                                                    <h4><i class="fa fa-barcode"></i> Boleto Bancário</h4>
                                                                </li>
                                                                <li value="cartao_credito">
                                                                    <h4><i class="fa fa-credit-card"></i> Cartão de Crédito</h4>
                                                                </li>
                                                                <li value="pix">
                                                                    <h4><i class="icon-pix"></i> Pix</h4>
                                                                </li>
                                                            </ul>
                                                            <input type="hidden" id="in_forma_pagamento" name="in_forma_pagamento" value="" required="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="box-fp-cartao-credito" style="display:none; margin-top:15px;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="in_cpf_cnpj_titular_cartao">CPF / CNPJ - Títular do Cartão</label>
                                                            <input type="text" id="in_cpf_cnpj_titular_cartao" class="form-control" placeholder="Informe CPF ou CNPJ títular do cartão" name="in_cpf_cnpj_titular_cartao" required="required" maxlength="18">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="in_titular_cartao">Nome Títular do Cartão</label>
                                                            <input type="text" id="in_titular_cartao" class="form-control" placeholder="Informe o nome títular do cartão" name="in_titular_cartao" required="required" maxlength="200">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="in_numero_cartao">Número do Cartão</label>
                                                            <input type="text" id="in_numero_cartao" class="form-control" placeholder="0000 0000 0000 0000" name="in_numero_cartao" required="required" maxlength="20">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="in_codigo_seguranca">Código de Segurança</label>
                                                            <input type="text" id="in_codigo_seguranca" class="form-control" placeholder="000" name="in_codigo_seguranca" required="required" maxlength="5">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="in_validade_mes">Validade Mês</label>
                                                            <input type="number" id="in_validade_mes" class="form-control" placeholder="00" name="in_validade_mes" required="required" maxlength="2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="in_validade_ano">Validade Ano</label>
                                                            <input type="number" id="in_validade_ano" class="form-control" placeholder="0000" name="in_validade_ano" required="required" maxlength="4">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="in_validade_mes">Aceitamos:</label>
                                                            <div class="aceitamos-cartoes">
                                                                <img src="{{URL('assets/images/cartoes')}}/visa.svg" height="25" alt="Visa" title="Visa" />
                                                                <img src="{{URL('assets/images/cartoes')}}/mastercard.svg" height="25" alt="Mastercard" title="Mastercard" />
                                                                <img src="{{URL('assets/images/cartoes')}}/elo.svg" height="25" alt="Elo" title="Elo" />
                                                                <img src="{{URL('assets/images/cartoes')}}/diners.svg" height="25" alt="Diners" title="Diners" />
                                                                <img src="{{URL('assets/images/cartoes')}}/discover.svg" height="25" alt="Discover" title="Discover" />
                                                                <img src="{{URL('assets/images/cartoes')}}/amex.svg" height="25" alt="American Express" title="American Express" />
                                                                <img src="{{URL('assets/images/cartoes')}}/hipercard.svg" height="25" alt="Hipercard" title="Hipercard" />
                                                                <img src="{{URL('assets/images/cartoes')}}/cabal.svg" height="25" alt="Cabal" title="Cabal" />
                                                                <img src="{{URL('assets/images/cartoes')}}/banescard.svg" height="25" alt="Banescard" title="Banescard" />
                                                                <img src="{{URL('assets/images/cartoes')}}/credz.svg" height="25" alt="Credz" title="Credz" />
                                                                <img src="{{URL('assets/images/cartoes')}}/sorocred.svg" height="25" alt="Sorocred" title="Sorocred" />
                                                                <img src="{{URL('assets/images/cartoes')}}/banescard.svg" height="25" alt="Banescard" title="Credy System" />
                                                                <img src="{{URL('assets/images/cartoes')}}/jcb.svg" height="25" alt="JCB" title="JCB" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-left">
                                            <button id="bt-forma-pagamento-submit" type="submit" disabled="disabled" class="btn btn-primary"><i class="fa fa-shopping-cart position-right"></i>&nbsp;&nbsp;Finalizar Pagamento</button>
                                            <button id="bt-forma-pagamento-reset" disabled="disabled" type="reset" class="btn btn-warning"><i class="fa fa-refresh position-right"></i>&nbsp;&nbsp;Recomeçar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
    <script src="{{URL('assets/js')}}/checkout.js?_v={{ENV('APP_VERSION')}}"> </script>
    <script>
        /* ... */
    </script>
@endsection
