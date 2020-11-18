function construir(){
  resultados.innerHTML = "Creando...";
	$.ajax({
    async:  true, 
    type: "POST",
    url: "functions/main.php?url="+$("#buscador").val(),
    data: "",
    dataType:"html",
    success: function(data){ 
     resultados.innerHTML = data;
   },
   error: function(){
    resultados.innerHTML = "Error inesperado";
   }
 });
}