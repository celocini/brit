var thisForm = document.getElementById("adesao");
const headers_ = {
    // sandbox
    //  'Authorization': 'Bearer keyNEmaNWdysrYOjr',
     'Authorization': 'Bearer key7ee003ZrFo0Va1',
     'Content-Type': 'application/json'
};
// When the form is submitted...
thisForm.addEventListener("submit", function(event) {
   show_loading()
   event.preventDefault();

   documento = {}
   documento.razao_social = document.getElementById("razaosocial").value
   documento.cnpj = document.getElementById("cnpj").value
   documento.nome_fantasia = document.getElementById("empresa").value
   documento.cep = document.getElementById("cep").value
   documento.logradouro = document.getElementById("logradouro").value
   
   documento.numero = document.getElementById("numero").value
   documento.complemento = document.getElementById("complemento").value
   
   documento.cidade = document.getElementById("cidade").value
   documento.estado = document.getElementById("estado").value
   documento.cep = document.getElementById("cep").value
   documento.nome_completo = document.getElementById("representantelegal").value
   documento.email = document.getElementById("email").value
   documento.website = document.getElementById("site").value
   
   documento.telefone = document.getElementById("telefonecomercial").value
   documento.celular = document.getElementById("celular").value
   documento.cpf = document.getElementById("cpf").value
   documento.rg = document.getElementById("rg").value
   documento.org_exp_uf = document.getElementById("orgaoexpedidoruf").value
   documento.cpf = document.getElementById("cpf").value
   
   documento.plano = document.querySelector('input[name="plano"]:checked').value
   documento.fat = document.getElementById("fat").value
   documento.concordo = document.getElementById("concordo").value

   documento.endereco = `${documento.logradouro} ${documento.numero} ${documento.complemento}`


   var documento_criado = {};
// POST the data 
// o sufixo tblVjW7bR49CiQhG6 é o id da tabela TA
  // rodar local
  // axios.post('http://localhost:8085/api/documento', documento, {headers: headers_})
  axios.post('https://brit.brasilitplus.com/api/documento', documento, {headers: headers_})
  .then((resp) => {
    console.log('resp',resp)
    documento_criado.uuid = resp.data.uuid
  
    axios.post('https://api.airtable.com/v0/appV9hUETmlTsyQrg/tblVjW7bR49CiQhG6',
    {
      "fields": {
        "fldokU6xSwyIQlBt2":documento.razao_social,
        "flds3Fcw3IS230KOM":documento.cnpj,
        "fldxjQb1xBHM6znsa":documento.nome_fantasia,
        "fldC2P8pFRQOq0LA2":documento.cep,
        "fld3zEgAyRid3lfBo":documento.logradouro,

        "fldx8KnG3cXf9dfQq":documento.numero,
        "fldq3tjhCU9HMlBmW":documento.complemento,

        "fldRYSKdkm1AcsHvs":documento.cidade,
        "fldxqnHYYovZQhZRU":documento.estado,
        "fldC2P8pFRQOq0LA2":documento.cep,
        "fldHoj8hsXY2ZY0r0":documento.nome_completo,
        "fldcZKOB3PuLGSPLW":documento.email,
        "fldOCibQrn89Ml99E":documento.website,
        
        "fldp9kF9ySe4dZ0iU":documento.telefone,
        "fldNtzjxCrOTJ45h4":documento.celular,
        "flda0Mr4RdFyzu5oG":documento.cpf,
        "fldn1Wcf4JS1IMfbV":documento.rg,
        "fldYy340dLeausv6M":documento.org_exp_uf,
        "flda0Mr4RdFyzu5oG":documento.cpf,
        
        "fldpyusNg56DtAxT3":documento.plano,
        "fldetKN923gTTZdw5":documento.fat,
        "fldXH7RwL96oeGinP":documento.concordo,
        "fldAyxwxRKAnSSVci":documento_criado.uuid,
        "fldnwFK5UqL06XpAS":"Enviado",
            
    }
    }, {headers: headers_}
    )
    .then((resp) => {
      documento_criado.id_airtable = resp.id

      // //redirecionar para sucesso
      // alert('Documento enviado com sucesso!')
      hide_loading()
      thisForm.reset()
      submit_sucesso()
      console.log("successo airtable!")
    })
    .catch(function (error) {
      console.log(error);
    });

  })
  .catch(function (error) {
    console.log(error);
    submit_erro()
  });
});

function verificaCNPJ(el) {

  axios.get(`https://api.airtable.com/v0/appV9hUETmlTsyQrg/tblVjW7bR49CiQhG6?filterByFormula=({CNPJ} = '${el.value}')`, {headers: headers_}
  )
  .then((resp) => {
    let tem = resp.data.records.length

    var botao_text = document.getElementById("button_text")
    if(tem) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Esse CNPJ já possui solicitação de adesão, por favor entrar em contato com internacional@softex.br',
      })
      botao_text.disabled = true
      el.value = "";
    } else {
      botao_text.disabled = false
    }
    //console.log('dados airtable: ',resp.data.records.length);
  })
  .catch(function (error) {
    console.log(error);
  });

}