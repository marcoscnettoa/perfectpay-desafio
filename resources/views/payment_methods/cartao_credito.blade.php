<p class="text-right"><button type="button" class="btn btn-xs btn-danger" onclick="javascript: offPreloader(); $('#bt-forma-pagamento-reset').trigger('click');"><i class="fa fa-times"></i>{{--&nbsp;&nbsp;Cancelar--}}</button></p>

<p class="bandeiras text-center">
    <img src="{{URL('assets/images')}}/perfectpay_logo.png" title="Perfect Pay"/>
    <img src="{{URL('assets/images')}}/asaas-sandbox.svg" title="Asaas - Sandbox"/>
</p>

<h1 class="text-center"><strong><i class="fa fa-check"></i>&nbsp;&nbsp;Tudo certo!</strong></h1>
<br/>
<h4 class="text-center">Seu pagamento no cartão de crédito no valor de<br/><strong class="valor">R$ {{ \App\Helper\Helper::H_Decimal_DB_ptBR($AsaasCobrancas->value) }}</strong> foi realizado<br/><br/></h4>
<br/><br/>
<p>Sua compra foi confirmada em 1 x de R$ {{ \App\Helper\Helper::H_Decimal_DB_ptBR($AsaasCobrancas->value) }}</p>
<br/>
<a href="{{$AsaasCobrancas->invoiceUrl}}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i>&nbsp;&nbsp;Visualizar Fatura</a>
