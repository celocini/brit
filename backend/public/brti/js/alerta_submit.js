
var loading = document.getElementsByClassName("loading")[0]
var botao_text = document.getElementById("button_text")

function show_loading(){
  // Habilitando o loading
  loading.style.display = "block"
  botao_text.style.display = "none"
}

function hide_loading(){
  // desabilitando o loading
  loading.style.display = "none"
  botao_text.style.display = "block"
}

function submit_sucesso(){
    Swal.fire(
        'Sucesso',
        'As informações foram enviadas com sucesso!',
        'success'
      ).then(function() {
        // Aqui é possível configurar o que acontece após clicar no OK na mensagem de sucesso
        console.log("Pós OK!!")
    });
}

function submit_erro(){
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Alguma coisa deu errado!!',
  })
}

