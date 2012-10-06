	
	function deselect(id) {
		var namer = "box"+id;
		var liname = "friend"+id;
		document.getElementById(liname).setAttribute('class', 'picked'); 
		document.getElementById(namer).checked = false;
	}
	
	function select(id) {
		var namer = "box"+id;
		var liname = "friend"+id;
		document.getElementById(liname).setAttribute('class', 'friend-box'); 
		document.getElementById(namer).checked = true;
	}
	
	function submiter() {
		
		var allSelected = "";
		var k = 0;
		
		for(i=0; i<document.friendpick.elements.length; i++)
		{
		if(document.friendpick.elements[i].checked == true) {
			allSelected = document.friendpick.elements[i].value+","+allSelected;
			k++;
		}
		}
		
		if(allSelected != "") {
		
		document.realform.allfriends.value = allSelected;
				
		document.realform.submit();
		
		}
		
		
	}
	
	function deselectAll() {
	
		for(i=0; i<document.friendpick.elements.length; i++)
		{
			var id = document.friendpick.elements[i].id;
			var liname = "friend"+id.substring(3);
			document.getElementById(liname).setAttribute('class', 'picked'); 
			document.friendpick.elements[i].checked = false;
		}
		
	}
	
	function selectAll() {
	
		for(i=0; i<document.friendpick.elements.length; i++)
		{
			var id = document.friendpick.elements[i].id;
			var liname = "friend"+id.substring(3);
			document.getElementById(liname).setAttribute('class', 'friend-box'); 
			document.friendpick.elements[i].checked = true;
		}
		
	}

	

		
		
	