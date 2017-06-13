$(document).ready(function(){
	//alert("0");
	$(document).on('click','#checkdone',function(e){
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.value;
		}).get();

		//alert("1");
        
		$.ajax({
                url: '/checkdone',
                data: 'checkedValues='+checkedValues,
                method: 'POST',
                dataType: "json",
                success: function(response)
                {                	                                    
                    $('#alerts').html('Actualizados los registros -> '+response);
                },
                error: function (xhr)
                {
                  $('#alerts').html('Error al actualizar los campos');  
                },
                complete: function(data)
                {
                  //$('#alerts').html("hola");  
                }
		});


    });

    $(document).on('change', '.select_category',function(e){
        //alert($(this).val()+"<-");
        var id = $(this).val();

        $.ajax({
            url: '/taskslist',
            data: 'taskCategory='+id+ '&url=taskslist',
            method: 'POST',
            //dataType: 'json',
            success: function(response)
            {
                $( "#my_tasks" ).html(response);
            },
            error: function(xhr)
            {
                alert("mal");
            },
            complete: function(data)
            {

            }
        });
    });
});