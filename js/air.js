var thisForm = document.getElementById("adesao");
const headers_ = {
     'Authorization': 'Bearer keyNEmaNWdysrYOjr',
     'Content-Type': 'application/json'
};
// When the form is submitted...
thisForm.addEventListener("submit", function(event) {
   event.preventDefault();
// POST the data
// o sufixo tblVjW7bR49CiQhG6 é o id da tabela TA
axios.post('https://api.airtable.com/v0/appV9hUETmlTsyQrg/tblVjW7bR49CiQhG6',
{
   "fields": {
    "fldokU6xSwyIQlBt2":document.getElementById("razaosocial").value,
    "flds3Fcw3IS230KOM":document.getElementById("cnpj").value,
    "fldxjQb1xBHM6znsa":document.getElementById("empresa").value,
    "fldC2P8pFRQOq0LA2":document.getElementById("cep").value,
    "fld3zEgAyRid3lfBo":document.getElementById("logradouro").value,

    "fldx8KnG3cXf9dfQq":document.getElementById("numero").value,
    "fldq3tjhCU9HMlBmW":document.getElementById("complemento").value,

    "fldRYSKdkm1AcsHvs":document.getElementById("cidade").value,
    "fldxqnHYYovZQhZRU":document.getElementById("estado").value,
    "fldC2P8pFRQOq0LA2":document.getElementById("cep").value,
    "fldHoj8hsXY2ZY0r0":document.getElementById("representantelegal").value,
    "fldcZKOB3PuLGSPLW":document.getElementById("email").value,
    "fldOCibQrn89Ml99E":document.getElementById("site").value,
    
    "fldp9kF9ySe4dZ0iU":document.getElementById("telefonecomercial").value,
    "fldNtzjxCrOTJ45h4":document.getElementById("celular").value,
    "flda0Mr4RdFyzu5oG":document.getElementById("cpf").value,
    "fldn1Wcf4JS1IMfbV":document.getElementById("rg").value,
    "fldYy340dLeausv6M":document.getElementById("orgaoexpedidoruf").value,
    "flda0Mr4RdFyzu5oG":document.getElementById("cpf").value,
    
    "fldpyusNg56DtAxT3":document.querySelector('input[name="plano"]:checked').value,
    "fldetKN923gTTZdw5":document.getElementById("fat").value,
    "fldXH7RwL96oeGinP":document.getElementById("concordo").value,
        
}
}, {headers: headers_}
)
.then((resp) => {
  console.log("successo!")
})
.catch(function (error) {
  console.log(error);
});
});