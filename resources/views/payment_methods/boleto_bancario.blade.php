<p class="text-right"><button type="button" class="btn btn-xs btn-danger" onclick="javascript: offPreloader(); $('#bt-forma-pagamento-reset').trigger('click');"><i class="fa fa-times"></i>{{--&nbsp;&nbsp;Cancelar--}}</button></p>

<p class="bandeiras text-center">
    <img src="{{URL('assets/images')}}/perfectpay_logo.png" title="Perfect Pay"/>
    <img src="{{URL('assets/images')}}/asaas-sandbox.svg" title="Asaas - Sandbox"/>
</p>

<h1 class="text-center"><strong><i class="fa fa-check"></i>&nbsp;&nbsp;Tudo certo!</strong></h1>
<br/>
<h4 class="text-center">Agora é só realizar o pagamento no valor de<br/><br/><strong class="valor">R$ {{ \App\Helper\Helper::H_Decimal_DB_ptBR($AsaasCobrancas->value) }}</strong></h4>
<br/>

<h3><strong>Para pagar com Boleto Bancário:</strong></h3>
<br/>
<p>-- Copie a linha digitável ou baixe seu boleto --</p>
<p class="numero-boleto"><a href="javascript:copyTxt('{{$AsaasCobrancas->barCode}}');">{{\App\Helper\Mask::MSK_G($AsaasCobrancas->barCode,'boleto_bancario')}}</a></p>
<br/>
<button type="button" class="btn btn-xs btn-success" onclick="javascript:copyTxt('{{$AsaasCobrancas->barCode}}');"><i class="fa fa-copy"></i>&nbsp;&nbsp;Copiar</button>
<a href="{{$AsaasCobrancas->bankSlipUrl}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Baixar Boleto</a>

<br/><br/><br/>
<h3><strong>Pagar com Pix:</strong></h3>
<br/>
<p>-- Acesse seu APP de pagamentos, faça a leitura do QR Code ou cole o código abaixo --</p>
<div class="qr-code">
    <div class="qr-c-a">
        <img class="pix-qr-code" height="160" width="160" src="data:image/jpeg;base64, {{$AsaasCobrancas->encodedImage_pixQrCode}}" alt="QR Code Pix">
    </div>
    <div class="qr-c-b text-left">
        <a class="numero-pix" href="javascript:copyTxt('{{$AsaasCobrancas->payload_pix}}');">{{$AsaasCobrancas->payload_pix}}</a><br/><br/>
        <button type="button" class="btn btn-xs btn-success" onclick="javascript:copyTxt('{{$AsaasCobrancas->payload_pix}}');"><i class="fa fa-copy"></i>&nbsp;&nbsp;Copiar</button>
    </div>
</div>
<br/>
