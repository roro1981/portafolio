function Ver_Pdf(id){
	jAlert(id);
}
 
  
function Trae_tabla_resumen(sini){
	$("#d_Cargando").fadeIn(400);
	$.ajax({
		url:"funciones/trae_expedientes.php",
		type:"post",
		async	: true,
		data	: {
		id_sini	: sini
		},
		success: function(resultado){
			if(resultado.indexOf('error*',0)== -1){
				$("#tbl_resumen").html(resultado);
				$("#d_Cargando").css('display', 'none');
				$('#Tabla_exp').dataTable({
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				});
				$("img[title]").qtip();
			} else {
				var Error = resultado.split('*');
				jAlert(Error[1], Error[2]);
			}
		},
		error: function(err){
			jAlert("Error: "+ err);
		}
	});
}

	
function cierraFancy(){
	window.parent.$.fancybox.close();
}