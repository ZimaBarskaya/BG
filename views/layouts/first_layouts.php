<html>
<head>
<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</head>
<body>
<script type="text/javascript">
 var Imtech = {};
Imtech.Pager = function() {
    this.paragraphsPerPage = 3;
    this.currentPage = 1;
    this.pagingControlsContainer = '#pagingControls';
    this.pagingContainerPath = '#content';

    this.numPages = function() {
        var numPages = 0;
        if (this.paragraphs != null && this.paragraphsPerPage != null) {
            numPages = Math.ceil(this.paragraphs.length / this.paragraphsPerPage);
        }

        return numPages;
    };
    
    this.showPage = function(page) {
        this.currentPage = page;
        var html = '';
        this.paragraphs.slice((page-1) * this.paragraphsPerPage,
            ((page-1)*this.paragraphsPerPage) + this.paragraphsPerPage).each(function() {
            html += '<div class=\"row\">' + $(this).html() + '</div>';
        });
        $(this.pagingContainerPath).html(html);
        renderControls(this.pagingControlsContainer, this.currentPage, this.numPages());
    }
    
    var renderControls = function(container, currentPage, numPages) {
        var pagingControls = 'Страницы: <ul>';
        for (var i = 1; i <= numPages; i++) {
            if (i != currentPage) {
                pagingControls += '<li><a href="#" onclick="pager.showPage(' + i + '); return false;">' + i + '</a></li>';
            } else {
                pagingControls += '<li>' + i + '</li>';
            }
        }

        pagingControls += '</ul>';

        $(container).html(pagingControls);
    } 
}   

var pager = new Imtech.Pager();
$(document).ready(function() {
    pager.paragraphsPerPage = 3; 
    pager.pagingContainer = $('#content'); 
    pager.paragraphs = $('div.z', pager.pagingContainer); 
    pager.showPage(1);
	
	$("#content ").on('click', 'input[type=\"radio\"]',function() {
		var t = 0;
		$("#content input[type=\"radio\"]").each(function() {
			if($(this).is(":checked")) {
				t++;
				if($(".edit_block_task").length > 0) {
					var name = $(this).closest(".row").find("input[name=\"name\"]").val();
					var text = $(this).closest(".row").find("input[name=\"text\"]").val();
					var email = $(this).closest(".row").find("input[name=\"email\"]").val();
					var status = $(this).closest(".row").find("input[name=\"status\"]").val();
					var task_file = $(this).closest(".row").find("img").attr("src");
					
					$(".edit_block_task .name").attr("value", ""+name);
					$(".edit_block_task .name").val(""+name);
					$(".edit_block_task .text").attr("value", ""+text);
					$(".edit_block_task .text").val(""+text);
					$(".edit_block_task .email").attr("value", ""+email);
					$(".edit_block_task .email").val(""+email);
					$(".edit_block_task .status").attr("value", ""+status);
					$(".edit_block_task .status").val(""+status);
					$(".edit_block_task .task_file").attr("files", ""+task_file);
					$(".edit_block_task .task_file").val(""+task_file);
				} 
			} 
		});
		if(t == 0) {
			$("#edit_block").remove();
		} else if(t == 1) {
			if(!$("#edit_block").length > 0) {
				$("<form enctype=\"multipart/form-data\" class=\"form_edit\" method=\"post\" action=\"/test/save\"></form>").insertAfter("#pagingControls");
				$(".form_edit").append("<div id=\"edit_block\"><input type=\"submit\" class=\"save\" value=\"Save\"><input type=\"button\" class=\"edit\" value=\"Edit\"><input class=\"preview\" type=\"button\" value=\"Предварительный просмотр\"></div>");
			} 
		}
	});

});
$("body ").on('click', '#edit_block .edit', function(){
	$("#content input[type=\"radio\"]").each(function() {
			if($(this).is(":checked")) {
				var task_id = $(this).closest(".row").find("input[name=\"edit\"]").val();
				var name = $(this).closest(".row").find("input[name=\"name\"]").val();
				var text = $(this).closest(".row").find("input[name=\"text\"]").val();
				var email = $(this).closest(".row").find("input[name=\"email\"]").val();
				var status = $(this).closest(".row").find("input[name=\"status\"]").val();
				var task_file = $(this).closest(".row").find("img").attr("src");
				
				$("<div class=\"edit_block_task\"></div>").insertBefore("#edit_block");
				$(".edit_block_task").append("<input name=\"task_id\" type=\"hidden\" class=\"name\" value="+task_id+">");
				$(".edit_block_task").append("<input name=\"new_name\" type=\"text\" class=\"name\" value="+name+">");
				$(".edit_block_task").append("<input name=\"new_email\" type=\"type=\"email\" class=\"email\" value="+email+">");
				$(".edit_block_task").append("<input name=\"new_text\" type=\"text\" class=\"text\" value="+text+">");
				$(".edit_block_task").append("<input type=\"hidden\" name=\"new_file2\" value="+task_file+"><input name=\"new_file\" type=\"file\" class=\"task_file\"><span class=\"no_art\">×</span>");
				$(".edit_block_task").append("<input name=\"new_status\" type=\"text\" class=\"status\" value="+status+">");
			} 
		});
	});
	
	$("body ").on('click', '#edit_block .preview', function(){
		if(!$(".preview_block").length > 0) {
			$(".container").append("<div class=\"preview_block\"><h2>Name: <span class=\"name\">"+$(".edit_block_task .name").val()+"</span></h2><h2>Email: <span class=\"email\">"+$(".edit_block_task .email").val()+"</span></h2><h2>Text: <img src="+$(".edit_block_task .task_file").attr("src")+"><span class=\"text\">"+$(".edit_block_task .text").val()+"</span></h2><h2>Status: <span class=\"status\">"+$(".edit_block_task .status").val()+"</span></h2></div>");
		} else {
			$(".preview_block .name").text($(".edit_block_task .name").val());
			$(".preview_block .email").text($(".edit_block_task .email").val());
			$(".preview_block .text").text($(".edit_block_task .text").val());
			$(".preview_block .task_file").text($(".edit_block_task .task_file").val());
			$(".preview_block .status").text($(".edit_block_task .status").val());
		}
		
	});
	
	
	
	$("body ").on('click', '.no_art',function() {
		$(this).closest("div").find(".task_file").remove();
		$(this).closest("div").find("input[name=\"new_file2\"]").remove();
		$(this).remove();
		$("<span class=\"add_art\">+</span>").insertAfter($(".edit_block_task .text"));
	});
	
	$("body ").on('click', '.add_art',function() {
		$(this).remove();
		$("#content input[type=\"radio\"]").each(function() {
			if($(this).is(":checked")) {
				var task_file = $(this).closest(".row").find("img").attr("src");
				$(".edit_block_task").append("<input type=\"hidden\" name=\"new_file2\" value="+task_file+"><input name=\"new_file\" type=\"file\" class=\"task_file\"><span class=\"no_art\">×</span>");
			}
		});
		
	});

</script>
	<?php
		include ($contentPage);
	?>
</body>
</html>
