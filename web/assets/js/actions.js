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