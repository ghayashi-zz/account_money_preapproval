var timer
var email;
        
$( document ).ready(function() {
    
    getListUsuerAuthorized(false);
    
    $("#box_loading").hide();
    $("#box_auth").show();
    
    
    $("#showModal").click(function(){
        
        $.ajax({
            url: "get_url_auth.php",
            success: function(resp){
                resp = jQuery.parseJSON(resp);
                
                $("#iframe_auth_url").attr("src", resp.url);
                $('#modal_auth').modal('toggle');
                
                timer = setInterval(function(){
                    getListUsuerAuthorized(true);
                }, 2000);
            }
        });
        
    });
    
    $("#showModalPagamento").click(function(){
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
    
});


function getListUsuerAuthorized(auto_get_balance) {
    $.ajax({
        url: "get_user_authorized.php",
        success: function(resp){
            resp = jQuery.parseJSON(resp);
            var html = "";
            
            if (resp.length == 0) {
                html += '<li>Nenhum usuário autorizou a aplicação</li>';
            }else{
                
                //caso seja maior significa que adicionou um novo usuario e a busca temq eu "acabar"
                if (resp.length >= $(".usuarios_autorizados").length) {
                    // pausa a action de buscar o saldo
                    clearInterval(timer);
                }
                
                for (var x in resp) {
                    user = resp[x];
                    
                    //caso seja automatico (processo de autorizacao)
                    /*if (auto_get_balance) {
                        console.log(auto_get_balance, resp.length);
                        if (resp.length == 1) {
                            email = user.email
                            getUserInfo(false);
                        }
                    }
                    
                    
                    if (user.email == email) {
                        selected = " selected";
                    }*/
                    var selected = "";
                    html += '<li class="usuarios_autorizados'+ selected + '">' + user.email + '</li>';
                }
                
            }
            
            $("#lista_usuarios").html(html);
            actionsUserAuthorized();
        }
    });
}


function actionsUserAuthorized(){
    $(".usuarios_autorizados").click(function(){
        $("#box_auth").hide();
        $(".usuarios_autorizados").removeClass("selected");
        $(this).addClass("selected");
        email = $(this).html();
        getUserInfo(true);
    });
}

function getUserInfo(show_box_auth) {
    $("#box_loading").show();
    $("#box_pagar").hide();
    $("#box_pagamento_status").hide();
    $("#user_info").hide();
    
    $.ajax({
        url: "get_user_info.php?email=" + email,
        success: function(resp){
            resp = jQuery.parseJSON(resp);
            
            if ('httpCode' in resp && resp.httpCode != 400) {
                var balance = resp.body;
                
                // esconde a modal
                //$('#modal_auth').modal('hide');
                
                $("#saldo_mp").html(balance.available_balance)
                
                
                $("#user_info").html(JSON.stringify(balance.user_info, null, 2));
                $("#user_info").show();
                
                $("#box_pagar").show();
                $("#box_loading").hide();
                $("#box_auth").hide();
                
            }else{
                
                // usuario no esta autenticado no mp
                // libera o box de autenticao
                if (show_box_auth) {
                    $("#box_loading").hide();
                    $("#box_auth").show();
                }
            }
            
        }
    });
}