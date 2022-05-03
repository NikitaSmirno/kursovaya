function loadGroups() {
	
	$.get('groups_get.php', {token:localStorage['token']},function(date) {
		
		let otvet = JSON.parse(date)
		if ('error' in otvet) {
			alert(otvet['error']['text'])
		}
		else if ('groups' in otvet) {
			let groups = otvet['groups']
			let div = $('#groups');
			groups.forEach(function(item, i, groups) {
				let btn = $('<button onclick="get_shedule('+item['ID']+')">'+item['name']+'</button>')
				div.append(btn)
				
			});
			
		}
		
	});
}

function get_shedule(id_group) {
	$.get('shedule_get.php', {token:localStorage['token'],id_group:id_group},function(date) {
		
		let otvet = JSON.parse(date)
		if ('error' in otvet) {
			alert(otvet['error']['text'])
		}
		else if ('shedule' in otvet) {
			let shedule = otvet['shedule']
			shedule.forEach(function(item, i, shedule) {
			$('#td_lesson_'+item['id_day']+'_'+item['id_time']).html(item['lesson'])
			$('#td_room_'+item['id_day']+'_'+item['id_time']).html(item['room'])
			$('#td_id_day_'+item['id_day']+'_'+item['id_time']).html(item['id_day'])
			$('#td_id_time_'+item['id_day']+'_'+item['id_time']).html(item['id_time'])
			$('#td_teacher_'+item['id_day']+'_'+item['id_time']).html(item['teacher'])
				
			});
			
		}
		
	});
}