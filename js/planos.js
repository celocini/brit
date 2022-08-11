function free(){
    for (i = 0; i < 5; i++) {
        document.getElementsByName('faturamento')[i].disabled="true";
        desseleciona(i);
    }
}

function premium(){
    for (i = 0; i < 5; i++) {
        document.getElementsByName('faturamento')[i].removeAttribute('disabled');
        desseleciona(i);
    }
}

function desseleciona(ind){
    document.getElementsByName('faturamento')[ind].checked=false;
}

function setpremium(){
    document.getElementsByName('plano')[1].checked=true;
}