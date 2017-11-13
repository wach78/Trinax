$(document).ready(function() {

	/**
	 * $name log
	 * $param value
	 */
	(function($){
		
		$.log = function(value) {
			if (console)
				console.log(value);
		};
		
		$.log.group = function(value) {
			if (console && console.group)
				console.group(value);
		}; 
			
		$.log.groupEnd = function(){
			if (console && console.group)
				console.groupEnd();
		};
	}(jQuery));
	
	
	/**
	 * @name ajaxError
	 * @param jqXHR --> XMLHttpRequest object
	 * @param textStatus --> exception object
	 * @param errorThrown -->  textual portion of the HTTP status
	 */
	(function($){

		$.ajaxError = function(jqXHR,textStatus,errorThrown) {
			$.log.group('ajax errors');
			$.log(jqXHR.responseText);
			$.log('jqXHR.status: ' + jqXHR.status);
			$.log('textStatus: ' + textStatus);
			$.log('error Thrown: ' + errorThrown);
			
			$.log.group('parseJSON(jqXHR.responseText)');
			var r = jQuery.parseJSON(jqXHR.responseText);
			$.log("Message: " + r.Message);
			$.log("StackTrace: " + r.StackTrace);
			$.log.groupEnd();
			$.log("ExceptionType: " + r.ExceptionType);
			$.log.groupEnd();
		};
	}(jQuery));
	
	
	
	$("#selectworkplace").selectmenu();
	$("#trselectworkplace").selectmenu();
	

	$.datepicker.regional['sv'] = {
			  closeText: 'Stäng',
				prevText: '< Föregående',
				nextText: 'Nästa >',
				currentText: 'Nu',
				monthNames: ['Januari','Februari','Mars','April','Maj','Juni','Juli','Augusti','September','Oktober','November','December'],
			    monthNamesShort: ['Jan','Feb','Mar','Apr','Maj','Jun','Jul','Aug','Sep','Okt','Nov','Dec'],
				dayNamesShort: ['Sön','Mån','Tis','Ons','Tor','Fre','Lör'],
				dayNames: ['Söndag','Måndag','Tisdag','Onsdag','Torsdag','Fredag','Lördag'],
				dayNamesMin: ['Sö','Må','Ti','On','To','Fr','Lö'],
				weekHeader: 'Не',
				dateFormat: 'yy-mm-dd',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['sv']);


			
	$(".datepicker").datepicker();
	
	$("#tabs").tabs();
	
	// list all workplaces when page load
	$.ajax({
		url: 'src/ajaxCalls.php',
		type: "post",
		data:{
				who : 'filtertimereports',
		},
		success:function(data){
			
			//$.log(data);
			$('#tbllistTRplaceholder').empty();
			$('#tbllistTRplaceholder').append(data);
		},
		error:function(jqXHR,textStatus,errorThrown){
			$.ajaxError(jqXHR,textStatus,errorThrown);
		}
	});						
	
	$.extend({ alert: function (message, title) {
		  $("<div></div>").dialog( {
		    buttons: { "Ok": function () { $(this).dialog("close"); } },
		    close: function (event, ui) { $(this).remove(); },
		    resizable: false,
		    title: title,
		    modal: true
		  }).text(message);
		}
		});
	
	
	gselectval = -1;
	$('body').on('change','#fromdate,#todate',function(){
		
		var fromdate = $('#fromdate').val();
		var todate =  $('#todate').val();
		var WPID = gselectval;
		

		if (fromdate == '' && todate != '')
		{
			$.alert('Från datum kan inte var tom när till datum är vald',' Datum');
			return false;
		}
		$.log(checkDate(fromdate,todate));
		if (checkDate(fromdate,todate))
		{
			$.alert('Till datum kan inte vara före från datum','TIll datum');
			return false;
		}
		else
		{
			ajaxCallListTR(WPID,fromdate,todate);
		}
		 
	});
	
	
	$( "#selectworkplace" ).selectmenu({

		  change: function( event, ui ) { 
			    var optionSelected = $("option:selected", this);
			    var valueSelected = this.value;
			 
			    gselectval = ui.item.value;
	
			    var fromdate = $('#fromdate').val();
				var todate =  $('#todate').val();
				
				
				if (fromdate == '' && todate != '')
				{
					$.alert('Från datum kan inte var tom när till datum är vald',' Datum');
					return false;
				}
				
			    
			    if (checkDate(fromdate,todate))
				{
			    	$.alert('Till datum kan inte vara före från datum','TIll datum');
			    	return false;
				}
				else
				{
					ajaxCallListTR(valueSelected,fromdate,todate);
				}
				
			
		  }
	});
	
	

	$('body').on('click','#btnSendTR',function(){
		
		
		var date = $('#trdate').val();
		var hour = $('#numberofhour').val();
		var valueSelected = $("#trselectworkplace option:selected").val();
	    var comment = $('#comment').val();
		var file = $('#fileToUpload')[0].files[0]

		if (date == '')
		{
			$.alert('Kan inte vara tom', 'Datum')
			return false;
		}
		
		if (hour == '')
		{
			$.alert('Kan inte vara tom', 'Timmar')
			return false;
		}
	
		if (valueSelected == -1)
		{
			$.alert('Kan inte vara tom', 'Arbetsplats')
			return false;
		}
		
		if (isNaN(parseFloat(hour)))
		{
			$.alert('Skriv in ett tal', 'Hour')
		}
		
		var fd = new FormData();
	
		
		fd.append('who','addtimereport');
		fd.append('date', date)
		fd.append('hour', hour)
		fd.append('WPID', valueSelected,)
		fd.append('comment', comment)
		fd.append('file',file)
		
		$.ajax({
			url: 'src/ajaxCalls.php',
			type: "post",
			data: fd,
			contentType: false,
            processData: false,
				
			success:function(data){
				
				$.log(data);
				$('#trdate').val('');
				$('#numberofhour').val('');
				$('#comment').val('');
				$('#strelectworkplace option').removeAttr('selected');
				
				var value = -1
				$('#trselectworkplace').find('option[value="'+value+'"]').prop('selected',true);
				$('#trselectworkplace').selectmenu("refresh");

				$('#fileToUpload').val("");
				
			},
			error:function(jqXHR,textStatus,errorThrown){
				$.ajaxError(jqXHR,textStatus,errorThrown);
			}
		});
	});
	
	
	
});//end dokument ready

function checkDate(fromdate,todate)
{
	return new Date(fromdate).getTime() > new Date(todate).getTime();
}

function ajaxCallListTR($WPID,$fromdate,$todate) 
{
	$.ajax({
		url: 'src/ajaxCalls.php',
		type: "post",
		data:{
				who : 'filtertimereports',
				WPID : $WPID,
				fromdate : $fromdate,
				todate : $todate
		},
		success:function(data){
			
			//$.log(data);
			$('#tbllistTRplaceholder').empty();
			$('#tbllistTRplaceholder').append(data);
		},
		error:function(jqXHR,textStatus,errorThrown){
			$.ajaxError(jqXHR,textStatus,errorThrown);
		}
	});						
}



