function GetUserNew() {
	var date = new Date();
	var time = date.getTime();
	$.ajax({
		type: "POST",
		url: domainName+'/push-user-new',
		data:'time='+time, 
		async: true,
		cache: false,
		timeout: 50000,
		success: function (data) {
			$('#notification_user').html('');
			var obj = JSON.parse(data);
			var length = Object.keys(obj).length; //you get length json result 4
			var count_ms ='';
			//console.log(JSON.stringify(obj));
			$.each( obj, function( key, value ) {
				if(value.New ==='New'){
					count_ms ++;
				}
			});
			
			$.each( obj, function( key, value ) {
				
				if(value.PersonTitle ==='Mss'){
					var img = 'girl.jpg';
					}else{
					img = 'men.jpg';
				}
				if(value.New ==='New'){
					var unread ='unread';
					}else{
					unread ='';
					}
				var ID_User = 10000+parseInt(value.id);	
				//console.log(ID_User);
				$('#notification_user').append('<li class="inbox-item clearfix '+unread+' read-ms" data-user="'+value.id+'">'+
				'<a href="'+domainName+'/user/viewuser/id/'+ID_User+'">'+
				'<div class="media">'+
				'<div class="media-left"><img class="media-object" src="'+domainName+'/upload/images/'+img+'" alt="Antonio"></div>'+
				'<div class="media-body">'+
				'<h5 class="media-heading name">'+value.PersonTitle+' '+value.first_name+' '+value.last_name+'</h5>'+
				'<p class="text">Email: '+value.email+'</p>'+
				'<span class="timestamp">Date signup: '+value.datetime+'</span>'+
				'</div>'+
				'</div>'+
				'</a></li>'					
				);	
				
				if(key > 3){
					return false;
				}
			});			
			$('.count_user').html(count_ms);
			$('#notification_user').prepend('<li class="notification-header"><em>At the moment: '+count_ms+' New registered User </em></li>');
			$('#notification_user').append(' <li class="notification-footer read-ms" data-user="0"><a href="'+domainName+'/dashboard-user?notif_id='+time+'">View All Messages</a></li>');
			//console.log(count_ms);
			setTimeout(
				GetUserNew,
				3000
			);
		},
		error: function (XMLHttpRequest, textStatus, errorThrown) {
			addmsg("error", textStatus + " (" + errorThrown + ")");
			setTimeout(
			GetUserNew,
			15000);
		}
	});
}
$(document).ready(function () {	
	GetUserNew();
});