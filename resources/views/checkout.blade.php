@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12 msg">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2>Dados para pagamento</h2>
                    <hr>
                </div>
            </div>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label> Nome no Cartão </label>
                        <input type="text" class="form-control" name="card_name" value="Gabriel Antonio">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label> Número do Cartão <span class="brand"></span></label>
                        <input type="text" class="form-control" name="card_number" value="411111111111111">
                        <input type="hidden" name="card_brand">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label> Mês de Expiração </label>
                        <input type="text" class="form-control" name="card_month" value="12">
                    </div>
                    <div class="col-md-4 form-group">
                        <label> Ano de Expiração </label>
                        <input type="text" class="form-control" name="card_year" value="2030">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label> Código de Segurança </label>
                        <input type="text" class="form-control" name="card_cvv" value="123">
                    </div>

                    <div class="col-md-12 installments form-group">

                    </div>

                </div>
                <button class="btn btn-success btn-lg processCheckout">
                    Efetuar pagamento
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/jquery.ajax.js') }}"></script>
    <script>
        const sessionId = '{{ session()->get('pagseguro_session_code') }}';
        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>

    <script>
        let amountTransaction = '{{$cartItems}}';
        let cardNumber = document.querySelector('input[name=card_number]');
        let spanBrand  = document.querySelector('span.brand');
        cardNumber.addEventListener('keyup', function(){
            if(cardNumber.value.length >= 6){
                PagSeguroDirectPayment.getBrand({
                    cardBin: cardNumber.value.substr(0, 6),
                    success: function(res){
                        // console.log(res)
                        let imgFlag = `<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/${res.brand.name}.png">`;
                        spanBrand.innerHTML = imgFlag;
                        document.querySelector('input[name=card_brand]').value = res.brand.name;
                        getInstallments(amountTransaction, res.brand.name)
                    },
                    error: function(err){
                        console.log(err)
                    },
                    complete: function(res){
                        console.log("Complete: " + res)
                    }
                });
            }
        });

        let submitButton = document.querySelector('button.processCheckout');

        submitButton.addEventListener('click', function(event){

            event.preventDefault();
            document.querySelector('div.msg').innerHTML = '';

            let buttonTarget = event.target;
            buttonTarget.disable = true;
            buttonTarget.innerHTML = 'Carregando...';

            PagSeguroDirectPayment.createCardToken({
                cardNumber: document.querySelector('input[name=card_number]').value ,
                brand: document.querySelector('input[name=card_brand]').value,
                cvv: document.querySelector('input[name=card_cvv]').value,
                expirationMonth: document.querySelector('input[name=card_month]').value ,
                expirationYear: document.querySelector('input[name=card_year]').value,
                success: function(res){                    
                    // console.log(res);
                    processPayment(res.card.token, buttonTarget);
                },
                error: function(err){
                    buttonTarget.disable = false;
                    buttonTarget.innerHTML = 'Efetuar Pagamento';
                    for(let i in err.errors){
                        document.querySelector('div.msg').innerHTML = showErrorMessages(errorsMapPagseguroJS(i));
                    }
                },
                
            })
        });

        function processPayment(token, buttonTarget)
        {
            let data = {
                card_token: token,
                hash: PagSeguroDirectPayment.getSenderHash(),
                installment: document.querySelector('select.select_installments').value,
                card_name: document.querySelector('input[name=card_name]').value,
                _token: '{{csrf_token()}}'
            };

            $.ajax({
                type: 'POST',
                url: '{{ route("checkout.proccess") }}',
                data: data,
                dataType: 'json',
                success: function(res){
                    // toastr.success(res.data.message, 'Sucesso')
                    
                    window.location.href = '{{ route('checkout.thanks') }}?order=' + res.data.order;
                },
                error: function(err){
                    buttonTarget.disable = false;
                    buttonTarget.innerHTML = 'Efetuar Pagamento';
                    let message = JSON.parse(err.responseText).data.message.error.message;
                    document.querySelector('div.msg').innerHTML = showErrorMessages(message);
                    
                }
            });
        }

        function getInstallments(amount, brand){
            PagSeguroDirectPayment.getInstallments({
                amount: amount,
                brand: brand,
                maxInstallmentNoInterest: 0,
                success: function(res){
                    // console.log(res)
                    let selectInstallments = drawSelectInstallments(res.installments[brand]);
                    document.querySelector('div.installments').innerHTML = selectInstallments;
                },
                error: function(err){
                     console.log(err);
                },
                complete: function(res){
                     
                },
            })
        }

        function drawSelectInstallments(installments) {
            let select = '<label>Opções de Parcelamento:</label>';

            select += '<select class="form-control select_installments">';

            for(let l of installments) {
                select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount} - Total fica ${l.totalAmount}</option>`;
            }


            select += '</select>';

            return select;
        }

        function showErrorMessages(message)
        {
            return `
                <div class="alert alert-danger">${message}</div>
            `;
        }
        function errorsMapPagseguroJS(code)
        {
            switch(code) {
                case "10000":
                    return 'Bandeira do cartão inválida!';
                break;

                case "10001":
                    return 'Número do Cartão com tamanho inválido!';
                break;

                case "10002":
                case  "30405":
                    return 'Data com formato inválido!';
                break;

                case "10003":
                    return 'Código de segurança inválido';
                break;

                case "10004":
                    return 'Código de segurança é obrigatório!';
                break;

                case "10006":
                    return 'Tamanho do código de segurança inválido!';
                break;

                default:
                    return 'Houve um erro na validação do seu cartão de crédito!';
            }
        }

    </script>
@endsection