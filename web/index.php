<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        

    
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="assets/css/style.css">
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
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        
        <script src="assets/js/actions.js"></script> 
    </body>
    
</html>