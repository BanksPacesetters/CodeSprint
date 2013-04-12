$(function(){
            
            $(".date").datepicker({
                                    dateFormat: "yy-mm-dd",
                                    changeMonth: true,
                                    changeYear: true
                                    //showOn: "button",
                                    //buttonImage: "../layout/images/calendar.gif",
                                    //buttonImageOnly: true

                                });
   
            
            //$(".time").timepicker({});
            
});

//validate functions

$(function(){
    
    $("#chg_pass_form").submit(function(){        
            var password1 = $("input[name='new_password']").val();
            var password2 = $("input[name='confirm_password']").val();
            
            if(password1 == "" || password2 == "")
            {
                alert('New password cannot be blank');
                return false;
            }
            
            if(password1 == password2)
            {
                goahead = 'true';
            }
            else
            {
                alert("New passwords don't match");
                return false;        
            }
            
            return true;
    });
});

////////////// SHOW FUNCTIONS

// Accordion
//$("#accordion").accordion({ header: "h3" });

$(function(){
            $( ".case_detail_div" ).dialog({
			autoOpen: false,
			height: 300,
			width: 400,
			modal: true,
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}
			
		});


            $( ".case_detail_link" ).click(function() {
                                            var val = $(this).attr("name");    
                                            $( "#details" + val ).dialog( "open" );
            			});
            
                                    
            });

$(function(){
            $( "#plaintiff_add_form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 400,
			modal: true,
			buttons: {
				Add_Plaintiff: function() {
                                    var plaintiff_val = $("select[name='plaintiff_select'] option:selected").val();
                                    var plaintiff_text = $("select[name='plaintiff_select'] option:selected").text();
                        
                                    if(plaintiff_val == "" || plaintiff_text=="-")
                                    {
                                        alert("Please select a plaintiff");
                                        
                                    }
                                    else
                                    {
                                                $("<option value='"+ plaintiff_val + "'>" + plaintiff_text + "</option>").appendTo("select[name='plaintiffs[]']");
                                                $( this ).dialog( "close" );                                                
                                    }

				}
			}
			
		});
            
            $( "#defendant_add_form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 400,
			modal: true,
			buttons: {
				Add_Defendant: function() {
                                    var defendant_val = $("select[name='defendant_select'] option:selected").val();
                                    var defendant_text = $("select[name='defendant_select'] option:selected").text();
                                    
                                    if(defendant_val == "" || defendant_text=="-")
                                    {
                                        alert("Please select a client");
                                    }
                                    else{
                                                $("<option value='"+ defendant_val + "'>" + defendant_text + "</option>").appendTo("select[name='defendants[]']");
                                                $( this ).dialog( "close" );                                                
                                    }
                                    

				}
			}
			
		});            
            
                                    
            });

////////////////// END SHOW FUNCTIONS

///////////////////////////// ACTION FUNCTIONS  /////////////////
$(function(){
            
            $("#add_plaintiff_to_list").click(function(){
                                    
                        $( "#plaintiff_add_form").dialog( "open" );
                        
                        });            
            
            $("#rem_plaintiff_from_list").click(function(){
        
                        $("select[name='plaintiffs[]'] option:selected").detach();
            
            });
            
            $("#add_defendant_to_list").click(function(){
                                    
                        $("#defendant_add_form").dialog( "open" );                                                
                        
                        });            
            
            $("#rem_defendant_from_list").click(function(){
        
                        $("select[name='defendants[]'] option:selected").detach();
            
            });
            
            });

$(function(){
            
            $("#calendar_form select[name='calendar_month']").change(function(){
                        
                        $("#calendar_form").submit();                        
                        
                        
                        });            
            
});

$(function(){
    
    $("#case_add_form, #case_update_form").submit(function(){
        
        
        var status_date = $("input[name='status_date']").val();
        var next_date = $("input[name='event_date']").val();
        var start_date = $("input[name='start_date']").val();        
        
        if(status_date > next_date){
            alert("The current status date cannot be after the next event date");
            return false;
        }
        
        if(start_date > next_date || start_date > status_date){
            alert("The start date cannot be after the current status date or next event date");
            return false;
        }
        
        $("select[name='plaintiffs[]'] option").each(function(){
          $(this).prop('selected',true);
        });
        
        $("select[name='defendants[]'] option").each(function(){
          $(this).prop('selected',true);
        });
        
        return true;
        
        });
    
});


$(function(){
    $("form").submit(function(){
            
            var error = 0;            
            
            $(".required").each(function(){
                
                $(this).removeClass("error");
                var the_value = $(this).val();
                
                if(the_value == "-" || the_value == "" )
                {                    
                    $(this).addClass("error");
                    error++;   
                }                                       
                
                });
            
            $(".error").first().focus();
            
            if(error != 0)
                return false;
            else
                return true;
        });
});
///////////////////// END ACTION FUNCTIONS