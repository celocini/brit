function free(){
    for (i = 0; i < 5; i++) {
        document.getElementsByName('faturamento')[i].disabled="true";
        desseleciona(i);
        document.getElementById('fat').value=""
    }
}

function premium(){
    for (i = 0; i < 5; i++) {
        document.getElementsByName('faturamento')[i].removeAttribute('disabled');
    }
}

function desseleciona(ind){
    document.getElementsByName('faturamento')[ind].checked=false;
}

function setpremium(){
    document.getElementsByName('plano')[1].checked=true;
    document.getElementById("fat").value=document.querySelector('input[name="faturamento"]:checked').value;
}