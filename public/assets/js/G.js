// # Mask(s)
$('input.mask-celular').inputmask({
    mask: ['(99) 9999-9999','(99) 99999-9999'],
    keepStatic:true
});

$('input.mask-telefone').inputmask("(99) 9999-9999");

$('input.mask-cep').inputmask("99999-999");

function goScrollTop() {
    $('.app-content.content').animate({ scrollTop: 0 }, 'slow');
}

function copyTxt(txt) {
    let inputTemp = $("<input type='text' style='opacity:0;' width='1' height='1'>");
    $('body').append(inputTemp);
    inputTemp.val(txt).select();
    document.execCommand('copy');
    inputTemp.remove();
}
