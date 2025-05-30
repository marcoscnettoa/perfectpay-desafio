// # Seleção -| Produtos / Serviços
var sel_produtos_servicos = $(".sel-produtos-servicos");
sel_produtos_servicos.find('li').on('click',function(){

    sel_produtos_servicos.find('li').removeClass('sel');

    $(this).addClass('sel');

    $("#in_produto_servico").val($(this).attr('value'));

});

// # Seleção -| Forma de Pagamento
var sel_formas_pagamentos = $(".sel-formas-pagamentos");
sel_formas_pagamentos.find('li').on('click',function(){

    sel_formas_pagamentos.find('li').removeClass('sel');

    $(this).addClass('sel');

    if($(this).attr('value')=='cartao_credito'){
        $("#box-fp-cartao-credito").show();
    }else {
        $("#box-fp-cartao-credito").hide();
    }

    $("#in_forma_pagamento").val($(this).attr('value'));

});

// # Consulta CEP
// URL: https://viacep.com.br/ws/[CEP]/json
$("#in_cep").on('blur', function() {

    // !* Reset
    $("#in_cidade").attr('_value','');

    let cep = $(this).val().replace(/\D/g,'');

    if(cep.length === 8){
        $.getJSON('https://viacep.com.br/ws/'+cep+'/json', function(dados) {
            //console.log(dados);
            if(!dados.erro){
                $("#in_rua").val(dados.logradouro);
                $("#in_bairro").val(dados.bairro);
                $("#in_complemento").val(dados.complemento);
                $("#in_estado").val(dados.uf).trigger('change');
                $("#in_cidade").attr('_value',dados.localidade).trigger('change');
            }else {
                console.log('CEP não encontrado!');
            }
        }).fail(function(){
            console.log('Erro ao consultar o CEP!');
        });
    }

});

// # Estado
$("#in_estado").on('change', function() {

    // !* Reset
    $("#in_cidade").attr('_value','');

    let uf = $(this).val();

    if(!uf) {
        $("#in_cidade").html('<option value="">---</option>').trigger('change');
        return;
    }

    $.ajax({
        url: `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`,
        method: 'GET',
        success: function (data) {
            let options = '<option value="">---</option>';
            data.forEach(function (cidade) {
                options += `<option value="${cidade.nome}">${cidade.nome}</option>`;
            });
            $('#in_cidade').select2('destroy');
            $('#in_cidade').html(options);
            $('#in_cidade').select2();
            $('#in_cidade').val($('#in_cidade').attr('_value'));
            $('#in_cidade').trigger('change');
        },
        error: function () {
            alert('Erro ao buscar municípios!');
        }
    });
});

$("#form-processar-pagamento").on('submit',function(e){
    e.preventDefault();

    let form     = $(this);
    let formData = form.serialize();

    $("#in_produto_servico_txt").removeClass('error');
    $("#in_forma_pagamento_txt").removeClass('error');
    $("input[required],select[required]").removeClass('error');
    $("select[required]").closest('.form-group').removeClass('error');

    // # Verificação # Loop - Input(s) -> Required
    $('#form-processar-pagamento').find('input[required],select[required]').each(function(i,e) {
        // # Seleção -| Produto Serviço
        if($(e).attr('id')=='in_produto_servico' && $("#in_produto_servico").val() == "") {
                $("#in_produto_servico_txt").addClass('error');
                $(e).addClass('error');
        // # Seleção -| Forma de Pagamento
        }else if($(e).attr('id')=='in_forma_pagamento' && $("#in_forma_pagamento").val() == "") {
                $("#in_forma_pagamento_txt").addClass('error');
                $(e).addClass('error');
        }else if($(e)[0].nodeName == 'SELECT' && $(e).val()=="") {
                $(e).closest('.form-group').addClass('error');
                $(e).addClass('error');
        }else {
            if(
                (($.inArray($("#in_forma_pagamento").val(),['boleto_bancario','pix','cartao_credito']) == -1) && $(e).val()=="") ||
                // !* Campos obrigatórios / Vazios ( Boleto Bancário / Pix )
                (
                    ($.inArray($("#in_forma_pagamento").val(),['boleto_bancario','pix']) > -1) &&
                    !($.inArray($(e).attr('id'),['in_cpf_cnpj_titular_cartao','in_titular_cartao','in_numero_cartao','in_codigo_seguranca','in_numero_cartao','in_validade_mes','in_validade_ano']) > -1) &&
                    $(e).val()==""
                ) ||
                // !* Campos obrigatórios / Vazios ( Cartão de Crédito )
                (
                    ($.inArray($("#in_forma_pagamento").val(),['cartao_credito']) > -1) &&
                    //($.inArray($(e).attr('id'),['in_cpf_cnpj_titular_cartao','in_titular_cartao','in_numero_cartao','in_codigo_seguranca','in_numero_cartao','in_validade_mes','in_validade_ano']) > -1) &&
                    $(e).val()==""
                ) ||
                // !* E-mail
                ($(e).attr('id')=='in_email' && !(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($(e).val())))
            ) {
                $(e).addClass('error');
            }
        }
    });

    // !* Valida se deve processar o pagamento
    if(!$("#form-processar-pagamento").find('input.error,select.error').length) {
        goScrollTop();
        onPreloaderLoad();
        setTimeout(function(){

            $.ajax({
                url: APP_URL+'/checkout/payment',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response.status === 'ok'){
                        /* ... */
                        onPreloaderContent(response.payment_view);
                    }else {
                        /* ... */
                    }
                },
                error: function(xhr){
                    console.log(xhr);
                    if(xhr.status === 500){
                        let respJSON    = xhr.responseJSON;
                        if(respJSON.status == 'error') {
                            let errors   = (respJSON.errors!=undefined?respJSON.errors:null);
                            let msg      = '';
                            if(errors!=null){
                                $(errors).each(function(i,e){ msg += '<span class="mxg-st1">'+e.description+'</span>' });
                            }else {
                                msg      = respJSON.message;
                            }
                            Swal.fire({
                                title: "Atenção",
                                html: msg,
                                type: "warning",
                                confirmButtonClass: "btn btn-danger",
                                buttonsStyling: false
                            });
                        }
                    }
                    offPreloader();
                },
                complete: function(){
                    /* ... */
                }
            });

        },3000);
        return false;
    }

    Swal.fire({
        title: "Atenção",
        text: "Os Campos em vermelho são obrigatórios!",
        type: "warning",
        confirmButtonClass: "btn btn-danger",
        buttonsStyling: false
    });

    return false;
});

// ! Teste - Metodo de Pagamento - Retorno
function load_hash_method_payment(hash){
    $.ajax({
        url: APP_URL+'/checkout/payment/method_return/'+hash,
        method: 'POST',
        data: null,
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if(response.status === 'ok'){
                /* ... */
                onPreloaderContent(response.payment_view);
            }else {
                /* ... */
            }
        },
        error: function(xhr){
            console.log(xhr);
            if(xhr.status === 500){
                let respJSON    = xhr.responseJSON;
                if(respJSON.status == 'error') {
                    let errors   = (respJSON.errors!=undefined?respJSON.errors:null);
                    let msg      = '';
                    if(errors!=null){
                        $(errors).each(function(i,e){ msg += '<span class="mxg-st1">'+e.description+'</span>' });
                    }else {
                        msg      = respJSON.message;
                    }
                    Swal.fire({
                        title: "Atenção",
                        html: msg,
                        type: "warning",
                        confirmButtonClass: "btn btn-danger",
                        buttonsStyling: false
                    });
                }
            }
            offPreloader();
        },
        complete: function(){
            /* ... */
        }
    });
}

$("#bt-forma-pagamento-reset").on('click', function() {
    $("#in_produto_servico_txt,#in_forma_pagamento_txt").removeClass('error');
    $("#in_produto_servico,#in_forma_pagamento").val('');
    $("select[required]").closest('.form-group').removeClass('error');
    $("input[required]").removeClass('error');
    sel_produtos_servicos.find('li').removeClass('sel');
    sel_formas_pagamentos.find('li').removeClass('sel');
    $("#box-fp-cartao-credito").hide();
});

// # Open Preloader
function offPreloader() {
    $(".content-preloader, .content-preloader .preloader, .content-preloader .preloader-load-content").hide();
    $(".content-preloader").removeClass('ok');
}

function onPreloaderLoad() {
    $(".content-preloader .preloader-load-content").hide();
    $(".content-preloader").show();
    $(".content-preloader,.content-preloader .preloader").show();
}

function onPreloaderContent(msg) {
    $(".content-preloader,.content-preloader .preloader").hide();
    $(".content-preloader").show().addClass('ok');
    $(".content-preloader .preloader-load-content").html(msg).show();
}

// # On Load -| ******
$(window).on('load', function() {
    $("#bt-forma-pagamento-submit, #bt-forma-pagamento-reset").prop('disabled',false);
});
