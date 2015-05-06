<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
         <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
        <style>
            #box_pagar_mp{
                width: 275px;
                height: 170px;
                background-color: #f7f7f9;
                border: 1px solid #e1e1e8;
                margin: 30px auto;
                padding: 15px;
            }
            
            #logo{
                float: left;
                width: 100%;
                text-align:center;
                margin: 0 0 15px 0;
            }
            
            #logo img{
                width: 100px;
            }
            
            #box_loading{
                float: left;
                width: 100%;
                text-align: center;
            }
            
            #box_auth, #box_pagar, #box_pagamento_status{
                float: left;
                width: 100%;
                text-align: center;
                display: none;
            }
            
            #saldo_mp{
                font-weight: bold;    
            }
            
            #modal_auth .modal-dialog{
                width: 900px;
            }
            
            #iframe_auth_url{
                width: 870px;
                height: 600px;
                border: 0;
                overflow:hidden;
            }
            
            #modal_pay .modal-dialog{
                width: 900px;
            }
            
            #iframe_pay_url{
                width: 870px;
                height: 600px;
                border: 0;
                overflow:hidden;
            }
            
            .modal-content .close{
                z-index: 9999;
                top: 5px;
                right: 10px;
                position: fixed;
            }
            
        </style>
    </head>
    
    
    <body>
        
        <div id="box_pagar_mp">
            <div id="logo">
                <img src="https://mercadopago.mlstatic.com/static/YA8ChboXroj8W0yzaTXl25GRGSy3LsQXYSfkonNLra1.png">
            </div>
            
            <div id="box_loading">
                <img src="assets/images/ajax-loader.gif">
            </div>
            
            
            <div id="box_auth">
                <p>Pague com o seu saldo disponível no MercadoPago!</p>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" id="showModal">
                    Conectar conta do MercadoPago
                </button>
                
                <!-- Modal -->
                <div class="modal fade" id="modal_auth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Autenticação no MercadoPago</h4>
                            </div>
                            
                            <div class="modal-body">
                                <iframe id="iframe_auth_url" src="assets/images/ajax-loader.gif" border="0" scrolling="no"></iframe>
                            </div> <!-- end body -->
                        </div>
                    </div>
                </div>
                
            </div><!-- end box auth-->
            
             <div id="box_pagar">
                <p>Você possui o saldo de R$<span id="saldo_mp"></span> disponível na conta MercadoPago.</p>
                
                <button type="button" class="btn btn-primary" id="showModalPagamento">
                    Utilizar no Pagamento
                </button>
            </div>
             
             <div id="box_pagamento_status">
                <p>O dinheiro foi cobrado da sua conta!</p>
                <p>
                    Numero do Pagamento:
                    <b>
                        <span id="payment_id"></span>
                    </b>
                </p>
             </div>
            
        </div>

        <script>
            var timer
            
            $( document ).ready(function() {
                $("#showModal").click(function(){
                    
                    $.ajax({
                        url: "get_url_auth.php",
                        success: function(resp){
                            resp = jQuery.parseJSON(resp);
                            
                            $("#iframe_auth_url").attr("src", resp.url);
                            $('#modal_auth').modal('toggle');
                            
                            timer = setInterval(function(){
                                getBalance(false);
                            }, 2000);
                        }
                    });
                    
                });
                
                $("#showModalPagamento").click(function(){
                    var email = "test_user_44378241@testuser.com";
                    $("#box_pagar").hide();
                    $("#box_loading").show();
                    
                    $.ajax({
                        url: "create_preapproval.php?email=" + email + "&amount=" + $("#saldo_mp").html(),
                        success: function(resp){
                            resp = jQuery.parseJSON(resp);
                            
                            $("#payment_id").html(resp.payment.id)
                            $("#box_pagamento_status").show();
                            $("#box_loading").hide();
                                     
                        }
                    });
                    
                });
                
                
                getBalance(true);
            });
            
            function getBalance(show_box_auth) {
                var email = "test_user_44378241@testuser.com";
                
                $.ajax({
                    url: "get_balance.php?email=" + email,
                    success: function(resp){
                        resp = jQuery.parseJSON(resp);
                        
                        if ('httpCode' in resp && resp.httpCode != 400) {
                            var balance = resp.body;
                            
                            // esconde a modal
                            $('#modal_auth').modal('hide');
                            
                            // força a action de buscar o saldo
                            clearInterval(timer);
                            
                            $("#saldo_mp").html(balance.available_balance)
                            
                            
                            $("#box_pagar").show();
                            $("#box_loading").hide();
                            $("#box_auth").hide();
                            
                        }else{
                            
                            // usuario não esta autenticado no mp
                            // libera o box de autenticação
                            if (show_box_auth) {
                                $("#box_loading").hide();
                                $("#box_auth").show();
                            }
                        }
                        
                    }
                });
            }
            
            
        </script>
    </body>
    
</html>