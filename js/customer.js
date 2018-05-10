/* global $, document  */
var first_name,father_name ,grand_name ,family_name,identity_number ,phone_number, customer_address,customer_notes ;
var discount_name,discount_number,discount_address,discount_notes ;
var agent_name ,agent_number ,agent_address ,agent_notes;
var court_address,procecution_number,court_name,procecution_subject ,procecution_value,procecution_date ;


$(document).ready(function(){
    $("body").niceScroll({
             cursorcolor:"#31b0d5",
             cursorwidth:"7px"
    });
    var current_fieldset,next_fieldset,previous_fieldset;
    var opacity,left,scale;
	var animating;



	function insert_customer(){
	var customer_info={ "first_name": first_name ,"father_name" :father_name,"grand_name":grand_name ,
		"family_name":family_name, "identity_number":identity_number ,"phone_number":phone_number, "customer_address":customer_address,"customer_notes":customer_notes };
	
		var discount_info={"discount_name":discount_name,"discount_number":discount_number,"discount_address":discount_address,"discount_notes":discount_notes}
		var agent_info={"agent_name": agent_name,"agent_number":agent_number ,"agent_address":agent_address ,"agent_notes":agent_notes};
		var court_info={"court_address":court_address,"procecution_number":procecution_number,"court_name":court_name,
		"procecution_subject":procecution_subject ,"procecution_value":procecution_value,"procecution_date":procecution_date };
		
		var customer=JSON.stringify(customer_info);
		var discount=JSON.stringify(discount_info);
		var agent=JSON.stringify(agent_info);
		var court=JSON.stringify(court_info);

		var msg="";
		$.ajax({url: "../php/customers_operations.php",
				type: "POST",
				data:{"customer":customer,"discount":discount,"agent":agent,"court":court,"operation":"insert"},
			success: function(data){
			var obj=JSON.parse(data);
			var x=obj.court;
			
			var there_exist_errors=false;
			for (err in obj) {
				if(err!=1){
					there_exist_errors=true;
					msg += obj[err]+"<br> ";
			}
			}
			if(!there_exist_errors){
				msg="تم اضافة الزبون بنجاح"
			}

			$("#div1").html(msg);
		}});
	
	}
	
	$('#client_btn').click(function(){
		first_name =document.getElementById('first-name-customer').value;
		father_name =document.getElementById('father-name-customer').value;
		grand_name =document.getElementById('grandfather-name-customer').value;
		family_name =document.getElementById('family-name-customer').value;
		identity_number =document.getElementById('identification-customer').value;
		phone_number =document.getElementById('contact-number-customer').value;
		customer_address =document.getElementById('address-customer').value;
		customer_notes =document.getElementById('note-about-customer').value;

		//  اذا حطيت اسم المتغير لحاله بين القوسين رح يرجع فولس اذا كان المتغير واحد من هذول الحالات 
		/*null,undefined,NaN,empty string (""),0,false*/
		if(!phone_number){ phone_number="-";}
		if(!customer_address){ customer_address="-";}
		if(!customer_notes){ customer_notes="-";}
	
		console.log(first_name+"\n",father_name+" " ,grand_name+" " ,family_name+" "+identity_number+" " ,phone_number+" ", customer_address+" ",customer_notes+" ");
	});


	$('#discount_btn').click(function(){
		discount_name =document.getElementById('name-discount').value;
		discount_number =document.getElementById('number-discount').value;
		discount_address =document.getElementById('address-discount').value;
		discount_notes =document.getElementById('note-discount').value;

		if(!discount_name){ discount_name="-";}
		if(!discount_number){ discount_number="-";}
		if(!discount_address){ discount_address="-";}
		if(!discount_notes){ discount_notes="-";}

	//	console.log(discount_name+"\n",discount_number+"\n " ,discount_address+"\n " ,discount_notes+"\n");
	});


	$('#discount_agent_btn').click(function(){
		agent_name =document.getElementById('agent-name').value;
		agent_number =document.getElementById('number-agent').value;
		agent_address =document.getElementById('address-agent').value;
		agent_notes =document.getElementById('note-agent').value;
		if(!agent_name){ agent_name="-";}
		if(!agent_number){ agent_number="-";}
		if(!agent_address){ agent_address="-";}
		if(!agent_notes){ agent_notes="-";}

		console.log(agent_name+"\n",agent_number+"\n " ,agent_address+"\n " ,agent_notes+"\n");
	});


	$('#court_btn').click(function(){
		document.getElementById('addsec').style.display='none';

		court_address =document.getElementById('address-court').value;
		procecution_number =document.getElementById('number-session').value;
		court_name =document.getElementById('name-court').value;
		procecution_subject =document.getElementById('theme-court').value;
		procecution_value =document.getElementById('value-court').value;
		procecution_date =document.getElementById('date-court').value;


		if(!court_address){ court_address="-";}
		if(!procecution_number){ procecution_number="-";}
		if(!court_name){ court_name="-";}
		if(!procecution_subject){ procecution_subject="-";}
		if(!procecution_value){ procecution_value="-";}
		if(!procecution_date){ procecution_date="0000-00-00";}
		insert_customer();

		//console.log(court_address+"\n",session_number+"\n " ,court_name+"\n " ,procecution_subject+" \n" ,procecution_value+"\n ", procecution_date+"\n ");
	});
    
    $('.next').click(function(){



       if(animating)
           return false;
        animating=true;
        current_fieldset=$(this).parent();
        next_fieldset=$(this).parent().next();
        $('.progressbar li').eq($("fieldset").index(next_fieldset)).addClass("active");
        	//show the next fieldset
	next_fieldset.show(); 
	//hide the current fieldset with style
	current_fieldset.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fieldset.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
    });
			next_fieldset.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fieldset.hide();
			animating = false;
		},easing: 'easeInOutBack' 
		//this comes from the custom easing plugin
	});
});
    
    
    
    
    $('.previous').click(function(){
        if(animating) return false;
        animating=true;
        current_fieldset=$(this).parent();
        previous_fieldset=$(this).parent().prev();
        $('.progressbar li').eq($("fieldset").index(current_fieldset)).removeClass("active");
        previous_fieldset.show();
        
        previous_fieldset.show();
        //hide the current fieldset with style
     	current_fieldset.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fieldset.css({'left': left});
			previous_fieldset.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fieldset.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
        });
    });
    
    $(".submit").click(function(){
                return false;
    });
    $('#btn-addNewCustomer').click(function(){
       var doc=document.getElementById('addsec');
        $(doc).css('display','block');
    });
    
    $('.view-button').click(function(){
        var doc=document.getElementById('show-details');
        $(doc).css('display','block');
    });

});