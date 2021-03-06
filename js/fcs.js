$(function() {
	
	var editing = 0;
	var n_editing = 0;
	var submitting = 0;
	
	// Adding a friend code
	$('#submit').click(function() {
		if (submitting == 0)
		{
			submitting = 1;
			$('#aresponse').slideUp(300, function() {
				$(this).remove();
			});
		
			var type = $('#addcode_type').val();
			var title = $('#addcode_type :selected').text();
			var data = $('#addcode_data').val();
		
			$.ajax({
				url: 'js/requests/changecode.php',
				type: 'GET',
				data: 'addcode_data=' + data + '&addcode_type=' + type + '&addcode_ap=1&mode=add',
				success: function(result) {
					$('#response').hide();
					$('#response').append(result);
					$('#response').slideDown();
					if (!($('#aresponse').hasClass("error")))
						$('#codes').append('<div id="'+type+'"><div style="float: left; width: 20px; height: 20px"><a href="#" class="del" value="'+type+'"><img src="images/delete.png" border="0"></a></div><div style="float: left; width: 330px; height: 20px">'+title+'</div><div style="float: left; width: 200px; height: 20px" class="edit" value="'+data+'" type="'+type+'">'+data+'</div><div style="clear: both"></div></div>');
					submitting = 0;
				
				}
			});
		}
		return false;
	});
	
	// Removing a friend code
	$('.del').live("click",function() {
		if(confirm("Are you sure you wish to delete this friend code?"))
		{
		if (submitting == 0)
		{
			submitting = 1;
			$('#aresponse').slideUp(300, function() {
				$(this).remove();
			});
		
			var type = $(this).attr('value');
		
			$.ajax({
				url: 'js/requests/changecode.php',
				type: 'GET',
				data: 'type=' + type + '&mode=del',
				success: function(result) {
						$('#response').hide();
						$('#response').append(result);
						$('#response').slideDown();
						$('#' + type).remove();
						submitting = 0;
				}
			});
		
		}
		return false;
		}
	});
	
	// Editing a friend code (setting up edit)
	$('.edit').live("click",function() {
		if (editing == 0) {
			editing = 1;
			var code = $(this).attr('value');
			var type = $(this).attr('type');
			var where = $(this);
			
			$(this).html("<input type=\"text\" name=\"ecode_data\" id=\"ecode_data\" maxlength=\"15\" size=\"17\" class=\"input\" value=\"" + code + "\" /><input type=\"image\" src=\"images/edit.png\" name=\"esubmit\" id=\"esubmit\" value=\"Edit!\" />");
		}
		
		$('#esubmit').click(function() {
			if (submitting == 0)
			{
				$('#aresponse').slideUp(300, function() {
					$(this).remove();
				});
				$(this).remove();
				var newcode = $('#ecode_data').val();
				where.text(newcode);
			
				where.attr({
					value: newcode
				});
			
				$.ajax({
					url: 'js/requests/changecode.php',
					type: 'GET',
					data: 'data=' + newcode + '&type=' + type + '&ap=0&mode=edit',
					success: function(result) {
						$('#response').hide();
						$('#response').append(result);
						$('#response').slideDown();
						editing = 0;
						submitting = 0;
					}
				});
			}
		});
	});
	
	// Edit notes
	$('#editnotes').click(function() {
		if (n_editing == 0) {
			n_editing = 1;
			
			var where = $(this);
			
			var data = $(this).html();
			$(this).html('<textarea class="textarea" rows="6" cols="62" id="notesedit">' + data + '</textarea><input type=\"image\" src=\"images/edit.png\" name=\"ensubmit\" id=\"ensubmit\" />');
		}
		
		$('#ensubmit').click(function() {
			$('#aresponse').slideUp(300, function() {
				$(this).remove();
			});
			$(this).remove();
			
			var notes = $("#notesedit").val();
			
			where.html(notes);
			
			$.ajax({
				url: 'js/requests/changecode.php',
				type: 'GET',
				data: 'notes=' + notes + '&mode=notes',
				success: function(result) {
					$('#response').hide();
					$('#response').append(result);
					$('#response').slideDown();
					n_editing = 0;
				}
			});
		});
	});
	
	$('#response').click(function() {
		$('#response').slideUp();
	});
});

/*
	$('#somediv').fadeOut(500, function() {
		$(this).remove();
	});
*/