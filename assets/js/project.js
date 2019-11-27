$(document).ready(function() {
	var base_url = $('#get_base_url').val();

	var heightWorkPackageList = $('#table-work-package-task').outerHeight();
	$('.work-package-detail').css('height', heightWorkPackageList + 17);

	$(".block-move-right").on("click", function(){
		$(this).parents("#col-id").insertAfter("#col-subject")
	})
	$('.project-sidebar-item-content').on('click', function(){
		var href = $(this).attr('href');
	});

	$(".icon-show-child").parents("td").css("padding-left","0")

	/* find item root */
	$("#embedded-GanttchartTable tr[id^='embedded-Ganttchildrow_child'").addClass("hide")

	/* gantt chart */
	$(".icon-show-child.icon-dropdown").on("click", function(){
		let idParent = $(this).attr("data-target").substr(12, $(this).attr("data-target").length)
		$("#embedded-GanttchartTable tr[id^='embedded-Ganttchildrow_child_"+idParent+"'").toggleClass("hide")
	})

	/* check collapseRow */
	$('tr[data-level="1"').find(".column-subject").css("padding-left","31px")
	$('tr[data-level="1"').find(".col-icon-collapse .icon").css("margin-right","-31px")

	/* check collapseRow */
	$('tr[data-level="2"').find(".column-subject").css("padding-left","48px")


	var limitTextMenu = 16;
	$(".limitTextMenu").each(function() {
		var text = $(this)
			.text()
			.trim();
		if (text.length > limitTextMenu) {
			var newString = text.substr(0, limitTextMenu - 3) + "...";
			$(this).html(newString);
		}
	});

  /* edit costs input */
	$(".cost").on("click", function() {
		$(this).parent().addClass("show");
		let current_cost = $(this).find('.input-cost').val()
		current_cost = current_cost.substr(0,current_cost.length-3)
		$(this).parent().find('.input-edit-cost').val(current_cost)
	});

	$(".icon-cancel-save-edit").on('click', function(){
		$(".input-cost").val($(".input-edit-cost").val() + 'USD')
		$(this).parents('.block-edit-costs').removeClass("show");
	})

	/* edit member ----------------------------------------------------*/
	$(".edit-member").on('click', function(){
		$('.info-member').removeClass("handle-edit-member")
		$('.info-member').removeClass("active")
		$(this).parents('.info-member').addClass("handle-edit-member");
		$(this).parents('.info-member').addClass("active");
		$(this).parents('.info-member').next().addClass("handle-edit-member");
		$(this).parents('.info-member').next().addClass("active");
	})

	$(".last-name .handle-column, .first-name .handle-column, .email .handle-column").on('click', function(){
		if($('.info-member').hasClass('handle-edit-member')){
			$(this).parent().addClass('edit-col')
			$(this).parent().find(".input-last-name, .input-first-name, .input-email").focus();
		}

	})

	$(".input-last-name, .input-first-name, .input-email").focusout(function(){
		$(this).parent().removeClass('edit-col')

	})

	$(".input-last-name, .input-first-name, .input-email").on("input", function() {
		$(this).text($(this).val());
		$(this).prev().text($(this).val());
	});

	$(".input-limit-text").change(function() {
		var limitTextMenu = 16;
		$(this).parent().find(".limitTextMenu").each(function() {
			var text = $(this)
				.text()
				.trim();
			if (text.length > limitTextMenu) {
				var newString = text.substr(0, limitTextMenu - 3) + "...";
				$(this).html(newString);
			}
		});
	});

  $(".btn-cancel-edit-member").on('click', function(){
    /* remove button */
    $(this).parents('.info-member').removeClass("handle-edit-member");
    $(this).parents('.info-member').removeClass("active");
    /* remove form edit member */
    $(this).parents('.info-member').prev().removeClass("handle-edit-member");
    $(this).parents('.info-member').prev().removeClass("active");
  });

  $(".btn-cancel-add-member").on('click', function(){
    $('#member').collapse('hide');
  });
	/* ------------------------------------------------------------------------------ */

	/* remove class limitTextMenu when mouser hover */
	$(".handle-column").mouseover(function(){
		$(this).removeClass('limitTextMenu')
	})

	$(".handle-column").mouseleave(function(){
		$(this).addClass('limitTextMenu')
	})


	/* ------------------------------------------------- */
	// $(".dropdown-toggle-info").on("click", function(e) {
	// 	 $(this).next().toggle();
	// });
	// $(".dropdown-menu.keep-open").on("click", function(e) {
	// 	e.stopPropagation();
	// });

	if (1) {
		$("body").attr("tabindex", "0");
	} else {
		alertify.confirm().set({ reverseButtons: true });
		alertify.prompt().set({ reverseButtons: true });
	}

	/* change tag and status column subject */
	$(".column-subject .handle-column").on("click", function() {
		$(this).parent().addClass("edit-subject");
		$(this).parent()
			.find(".input-subject")
			.focus();
	});

	$(".input-subject").on("keypress", function(e) {
		// $(this).text($(this).val());
		// $(this).
		// 	parents(".column-subject").find(".handle-column")
		// 	.text($(this).val());
    var content = $(this).val().trim();
    if (content.length > 0) {
      if (e.keyCode === 13) {
        idtask = $(this).attr("data-id");
        formsubmit = "#change-task-form-"+idtask;
        $(formsubmit).submit();
      }
    }

	});

	$(".input-subject").focusout(function() {
		$(this)
			.parents(".column-subject")
			.removeClass("edit-subject");
		$(".limitTextMenu").each(function() {
			var text = $(this)
				.text()
				.trim();
			if (text.length > limitTextMenu) {
				var newString = text.substr(0, limitTextMenu - 3) + "...";
				$(this).html(newString);
			}
		});

	});


	/* close modal row info */
	$(".btn-close-row-info").on("click", function(e) {
		$(".dropdown-menu.keep-open").attr("x-placement", "");
		$(".dropdown-menu.keep-open").removeClass("show");
	});

	/* edit state info in modal row info */
	$(".textarea-info-state").focusin(function() {
		$(".info-state-activity").addClass("edit-state-info");
	});

	$(".textarea-info-state").focusout(function() {
		$(".info-state-activity").removeClass("edit-state-info");
	});

	$(".dropdown-submenu .btn-more").on("click", function(e) {
		$(this)
			.next("ul")
			.toggle();
		  //e.stopPropagation();
      e.preventDefault();
	});
	/* event show modal chart */
	$(".project-layout-list-sort")
		.find(".btn-chart")
		.on("click", function() {
			if($(".project-layout-list-sort .btn-chart:not([disabled])")){
				$(this).toggleClass("active");
				$(".wrapper-chart").toggleClass("show");
				$('.btn-row-info').addClass('d-none');
				if($(".wrapper-chart").hasClass("show")){
					$('#btn_change_format').removeClass('d-none');
					if($(".wrapper-row-info").hasClass("show")){
						$('.wrapper-table-list-work-package').css('width', '30%');
						$('.wrapper-row-info').css('width', '40%');
						$('.wrapper-chart').css('width', '30%');
						$('.wrapper-block-create-new-child').css('width', '0%');
					}else{
						$('.wrapper-table-list-work-package').css('width', '50%');
						$('.wrapper-row-info').css('width', '0%');
						$('.wrapper-chart').css('width', '50%');
						$('.wrapper-block-create-new-child').css('width', '0%');
					}
					if($(".wrapper-block-create-new-child").hasClass("show")){
						$('.wrapper-table-list-work-package').css('width', '30%');
						$('.wrapper-block-create-new-child').css('width', '40%');
						$('.wrapper-chart').css('width', '30%');
						$('.wrapper-row-info').css('width', '0%');
					}else{
						$('.wrapper-table-list-work-package').css('width', '50%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-chart').css('width', '50%');
						$('.wrapper-row-info').css('width', '0%');
					}

				}
				else{
					$('#btn_change_format').addClass('d-none');
					$('.btn-row-info').removeClass('d-none');
					if($(".wrapper-row-info").hasClass("show")){
						$('.wrapper-table-list-work-package').css('width', '50%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '50%');
						$('.wrapper-chart').css('width', '0%');
					}else{
						$('.wrapper-table-list-work-package').css('width', '100%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '0%');
						$('.wrapper-chart').css('width', '0%');
					}
					if($(".wrapper-block-create-new-child").hasClass("show")){
						$('.wrapper-table-list-work-package').css('width', '50%');
						$('.wrapper-block-create-new-child').css('width', '50%');
						$('.wrapper-row-info').css('width', '0%');
						$('.wrapper-chart').css('width', '0%');
					}else{
						$('.wrapper-table-list-work-package').css('width', '100%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '0%');
						$('.wrapper-chart').css('width', '0%');
					}
			}
			}
			g.Draw();
	});
	/* event show info row */
	$(".wrapper-table-list-work-package")
		.find(".icon-info")
		.on("click", function() {
			var _this = $(this);
			var work_packageID = _this.attr('data-id');
			$('.start-date').removeAttr('id');
			$('.end-date').removeAttr('id');
			$('.date').removeAttr('id');
			$('.start-date-' + work_packageID).prop('id', 'startDate');
			$('.end-date-' + work_packageID).prop('id', 'endDate');
			$('.date-' + work_packageID).prop('id', 'date');
			var minDate = $('#startDate').val();
			var maxDate = $('#endDate').val();
			$("#startDate").datepicker({
				endDate: maxDate,
				todayHighlight: true
			})
				.on('changeDate', function (selected) {
					var minDate = new Date(selected.date.valueOf());
					$('#endDate').datepicker('setStartDate', minDate);
				});

			$("#endDate").datepicker({
				startDate: minDate,
				todayHighlight: true
			})
				.on('changeDate', function (selected) {
					var minDate = new Date(selected.date.valueOf());
					$('#startDate').datepicker('setEndDate', minDate);
				});

			$("#date").datepicker({
				todayHighlight: true
			});

			$('.work-package-detail').find('.block-file-upload').html('');
			$('.work-package-detail').find('.block-file-upload').append(
				'<div class="file-upload-content upload-area">' +
				'<div class="btn-custom btn-border btn-gray btn-upload-file">' +
				'<label for="input_upload_attachment">Choose File</label>' +
				'<input type="file" name="file" id="input_upload_attachment"' +
				'                                           class="update-content-item-upload"' +
				'                                           data-name="attachment" data-work_packageID="'+ work_packageID +'">' +
				'</div>' +
				'<p id="get_video_name" class="file-name"></p>' +
				'<p class="last-text upload-area-text">' +
				'Drop your file here.' +
				'</p>' +
				'</div>'
			);

			if($(".wrapper-block-create-new-child").hasClass("show")){
				let result = confirm("Are you sure you want to cancel editing the work package?");
				if(result === true){
					/* remove all class before show */
					$(".row-task").removeClass("active");
					$(".wrapper-row-info").removeClass("show");
					$(".block-create-new-child").removeClass("show");
					$(".wrapper-block-create-new-child").removeClass("show");
					$(".gutter.gutter-horizontal").remove();
					let dataId = _this.attr("data-id");

					if($(".wrapper-block-row-info[data-id='"+dataId+"'").hasClass("show")){
						$(".wrapper-block-row-info[data-id='"+dataId+"'").removeClass("show");
						$(".wrapper-row-info").removeClass("show");
						_this.parents(".row-task").removeClass("active");
					}else{
						$(".wrapper-block-row-info").removeClass("show");
						$(".wrapper-block-row-info[data-id='"+dataId+"'").addClass("show");
						$(".wrapper-row-info").addClass("show");
						_this.parents(".row-task").addClass("active");
					}

					if($(".wrapper-row-info").hasClass("show")){
						if($(".wrapper-chart").hasClass("show")){
							$('.wrapper-table-list-work-package').css('width', '30%');
							$('.wrapper-block-create-new-child').css('width', '0%');
							$('.wrapper-row-info').css('width', '40%');
							$('.wrapper-chart').css('width', '30%');
						}else{
							$('.wrapper-table-list-work-package').css('width', '35%');
							$('.wrapper-block-create-new-child').css('width', '0%');
							$('.wrapper-row-info').css('width', '65%');
							$('.wrapper-chart').css('width', '0%');
						}
					}
					else{
						if($(".wrapper-chart").hasClass("show")){
							$('.wrapper-table-list-work-package').css('width', '50%');
							$('.wrapper-block-create-new-child').css('width', '0%');
							$('.wrapper-row-info').css('width', '0%');
							$('.wrapper-chart').css('width', '50%');
						}else{
							$('.wrapper-table-list-work-package').css('width', '100%');
							$('.wrapper-block-create-new-child').css('width', '0%');
							$('.wrapper-row-info').css('width', '0%');
							$('.wrapper-chart').css('width', '0%');
						}
					}
				}
			}else{
				/* remove all class before show */
				$(".row-task").removeClass("active")
				$(".wrapper-row-info").removeClass("show")
				$(".block-create-new-child").removeClass("show")
				$(".wrapper-block-create-new-child").removeClass("show")
				$(".gutter.gutter-horizontal").remove()
				let dataId = _this.attr("data-id");

				if($(".wrapper-block-row-info[data-id='"+dataId+"'").hasClass("show")){
					$(".wrapper-block-row-info[data-id='"+dataId+"'").removeClass("show")
					$(".wrapper-row-info").removeClass("show")
					_this.parents(".row-task").removeClass("active")
				}else{
					$(".wrapper-block-row-info").removeClass("show")
					$(".wrapper-block-row-info[data-id='"+dataId+"'").addClass("show")
					$(".wrapper-row-info").addClass("show")
					_this.parents(".row-task").addClass("active")
				}

				if($(".wrapper-row-info").hasClass("show")){
					if($(".wrapper-chart").hasClass("show")){
						$('.wrapper-table-list-work-package').css('width', '30%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '40%');
						$('.wrapper-chart').css('width', '30%');
					}else{
						$('.wrapper-table-list-work-package').css('width', '35%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '65%');
						$('.wrapper-chart').css('width', '0%');
					}
				}
				else{
					if($(".wrapper-chart").hasClass("show")){
						$('.wrapper-table-list-work-package').css('width', '50%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '0%');
						$('.wrapper-chart').css('width', '50%');
					}else{
						$('.wrapper-table-list-work-package').css('width', '100%');
						$('.wrapper-block-create-new-child').css('width', '0%');
						$('.wrapper-row-info').css('width', '0%');
						$('.wrapper-chart').css('width', '0%');
					}
				}
			}
			$('.btn-chart').addClass('d-none');
			$('#btn_change_format').addClass('d-none');
	});

	$('.nav-activity-tab').on('click', function () {
		$('.list-activities').html('');
		var _this = $(this);
		var work_packageID = _this.attr('data-work_packageID');
		$.ajax({
			url: base_url + "auth/project/get-content/activities/" + work_packageID,
			method: 'GET',
			success: function (data) {
				data = JSON.parse(data);
				$('.list-activities').append(data);
			}
		});
	});

	$('.nav-relations-tab').on('click', function () {
		$('.list-relations').html('');
		var _this = $(this);
		var work_packageID = _this.attr('data-work_packageID');
		$.ajax({
			url: base_url + "auth/project/get-content/relations/" + work_packageID,
			method: 'GET',
			success: function (data) {
				$('.list-relations').prepend(data);
			}
		});
	});

	$('.nav-watches-tab').on('click', function () {
		$('.list-watchers').html('');
		var _this = $(this);
		var work_packageID = _this.attr('data-work_packageID');
		$.ajax({
			url: base_url + "auth/project/get-content/watches/" + work_packageID,
			method: 'GET',
			success: function (data) {
				$('.list-watchers').prepend(data);
			}
		});
	});

	$(".btn-create-new-child").on("click", function(){
		if($(".wrapper-row-info").hasClass("show")){
			/* remove all class before show */
			$(".wrapper-row-info").removeClass("show")
			$(".wrapper-block-row-info").removeClass("show")
			$(".row-task").removeClass("active")
			$(".wrapper-block-create-new-child").removeClass("show")
			$(".gutter.gutter-horizontal").remove()
			let dataId = $(this).attr("data-id");

			if($(".block-create-new-child[data-id='"+dataId+"'").hasClass("show")){
				$(".block-create-new-child[data-id='"+dataId+"'").removeClass("show")
				$(".wrapper-block-create-new-child").removeClass("show")
				$(this).parents(".row-task").removeClass("active")
			}else{
				$(".block-create-new-child").removeClass("show")
				$(".block-create-new-child[data-id='"+dataId+"'").addClass("show")
				$(".wrapper-block-create-new-child").addClass("show")
				$(this).parents(".row-task").addClass("active")
			}

			if($(".wrapper-block-create-new-child").hasClass("show")){
				if($(".wrapper-chart").hasClass("show")){
					$('.wrapper-table-list-work-package').css('width', '25%');
					$('.wrapper-block-create-new-child').css('width', '50%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '25%');
				}else{
					$('.wrapper-table-list-work-package').css('width', '35%');
					$('.wrapper-block-create-new-child').css('width', '65%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '0%');
				}
			}
			else{
				if($(".wrapper-chart").hasClass("show")){
					$('.wrapper-table-list-work-package').css('width', '50%');
					$('.wrapper-block-create-new-child').css('width', '0%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '50%');
				}else{
					$('.wrapper-table-list-work-package').css('width', '100%');
					$('.wrapper-block-create-new-child').css('width', '0%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '0%');
				}
		}
		}else{
			/* remove all class before show */
			$(".row-task").removeClass("active")
			$(".wrapper-block-create-new-child").removeClass("show")
			$(".gutter.gutter-horizontal").remove()
			let dataId = $(this).attr("data-id");

			if($(".block-create-new-child[data-id='"+dataId+"'").hasClass("show")){
				$(".block-create-new-child[data-id='"+dataId+"'").removeClass("show")
				$(".wrapper-block-create-new-child").removeClass("show")
				$(this).parents(".row-task").removeClass("active")
			}else{
				$(".block-create-new-child").removeClass("show")
				$(".block-create-new-child[data-id='"+dataId+"'").addClass("show")
				$(".wrapper-block-create-new-child").addClass("show")
				$(this).parents(".row-task").addClass("active")
			}

			if($(".wrapper-block-create-new-child").hasClass("show")){
				if($(".wrapper-chart").hasClass("show")){
					$('.wrapper-table-list-work-package').css('width', '25%');
					$('.wrapper-block-create-new-child').css('width', '50%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '25%');
				}else{
					$('.wrapper-table-list-work-package').css('width', '35%');
					$('.wrapper-block-create-new-child').css('width', '65%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '0%');
				}
			}
			else{
				if($(".wrapper-chart").hasClass("show")){
					$('.wrapper-table-list-work-package').css('width', '50%');
					$('.wrapper-block-create-new-child').css('width', '0%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '50%');
				}else{
					$('.wrapper-table-list-work-package').css('width', '100%');
					$('.wrapper-block-create-new-child').css('width', '0%');
					$('.wrapper-row-info').css('width', '0%');
					$('.wrapper-chart').css('width', '0%');
				}
			}
		}
	})

	/* go back */
	$(".prev-page").on("click", function() {
		window.history.back();
	});

	CKEDITOR.replace("description_document");

	$('#calendar').on('click', '.fc-content', function(){
		let idtask = $(this).find(".fc-title").attr("data-id");
		document.location.href = "work-package/edit/" + idtask
	});

	/* filter add status */
	$(".cancel-add-status").on("click", function() {
		$(this)
			.parent()
			.parent()
			.parent()
			.remove();
	});

	/* drag and drop input tag ----------------------------------------- */
	var backSpace;
	var close = '<a class="close icon-cancel"></a>';
	var PreTags = $(".tagarea").val() == undefined ? '' :  $(".tagarea").val().trim().split(" ")
	$(".tagarea").after('<ul class="tag-box"></ul>');

	for (i = 0; i < PreTags.length; i++) {
		$(".tag-box").append('<li class="tags">' + PreTags[i] + close + "</li>");
	}

	$(".tag-box").append(
		'<li class="new-tag"><input class="input-tag" type="text"></li>'
	);

	// Taging
	$(".input-tag").bind("keydown", function(kp) {
		var tag = $(".input-tag")
			.val()
			.trim();
		$(".tags").removeClass("danger");
		if (tag.length > 0) {
			backSpace = 0;
			if (kp.keyCode == 13) {
				$(".new-tag").before('<li class="tags">' + tag + close + "</li>");
				$(this).val("");
			}
		} else {
			if (kp.keyCode == 8) {
				$(".new-tag")
					.prev()
					.addClass("danger");
				backSpace++;
				if (backSpace == 2) {
					$(".new-tag")
						.prev()
						.remove();
					backSpace = 0;
				}
			}
		}
	});
	//Delete tag
	$(".tag-box").on("click", ".close", function() {
		$(this)
			.parent()
			.remove();
	});
	$(".tag-box").click(function() {
		$(".input-tag").focus();
	});
	// Edit
	$(".tag-box").on("dblclick", ".tags", function(cl) {
		var tags = $(this);
		var tag = tags.text().trim();
		$(".tags").removeClass("edit");
		tags.addClass("edit");
		tags.html('<input class="input-tag" value="' + tag + '" type="text">');
		$(".new-tag").hide();
		tags.find(".input-tag").focus();

		tag = $(this)
			.find(".input-tag")
			.val();
		$(".tags").dblclick(function() {
			tags.html(tag + close);
			$(".tags").removeClass("edit");
			$(".new-tag").show();
		});

		tags.find(".input-tag").bind("keydown", function(edit) {
			tag = $(this).val();
			if (edit.keyCode == 13) {
				$(".new-tag").show();
				$(".input-tag").focus();
				$(".tags").removeClass("edit");
				if (tag.length > 0) {
					tags.html(tag + close);
				} else {
					tags.remove();
				}
			}
		});
	});
	// sorting
	$(function() {
		$(".tag-box").sortable({
			items: "li:not(.new-tag)",
			containment: "parent",
			scrollSpeed: 100
		});
		$(".tag-box").disableSelection();
	});

	$(function() {
		$(".select2-selection__rendered").sortable({
			items: "li:not(.select2-search--inline)",
			containment: "parent",
			scrollSpeed: 100
		});
		$(".select2-selection__rendered").disableSelection();
	});

	$('#table-work-package-task').sorttable({
    placeholder: 'placeholder',
    helperCells: null
	}).disableSelection();

	/* ------------------------------------------------------------------ */

	/* input block filter */
	$(".icon-close-input-filter").on("click", function(){
		$(this).parents(".block-input-filter").hide()
	})

	/* close block filter work package */
	$(".btn-close-block-filter").on('click', function(){
		$(this).parents("#filter").removeClass("show")
	})

	/* hight light gantt chart */
	$(".row-task").mouseover(function(){
			let dataHighlight = $(this).attr("data-highlight").split('_')
			let idRowGanttChart = dataHighlight[dataHighlight.length-1]
			$(".glineitem"+idRowGanttChart+"").addClass("gitemhighlight")
			$(".glineitem"+idRowGanttChart+"").find(".gcaption").addClass("mouseover")
			$(".glineitem"+idRowGanttChart+"").find(".gcaptionleft").addClass("mouseover")

			if($(".glineitem"+idRowGanttChart+"").find(".gcaption").text()===""){
				$(".glineitem"+idRowGanttChart+"").find(".gcaption").removeClass("mouseover")
			}
			if($(".glineitem"+idRowGanttChart+"").find(".gcaptionleft").text()===""){
				$(".glineitem"+idRowGanttChart+"").find(".gcaptionleft").removeClass("mouseover")
			}
			if($(".glineitem"+idRowGanttChart+"").find(".gmilecaption").text()===""){
				$(".glineitem"+idRowGanttChart+"").find(".gmilecaption").removeClass("mouseover")
			}

			$(".glineitem"+idRowGanttChart+"").find(".gmilecaption").addClass("mouseover")

	}).mouseout(function() {
			let dataHighlight = $(this).attr("data-highlight").split('_')
			let idRowGanttChart = dataHighlight[dataHighlight.length-1]
			$(".glineitem"+idRowGanttChart+"").removeClass("gitemhighlight")
			$(".glineitem"+idRowGanttChart+"").find(".gcaption").removeClass("mouseover")
			$(".glineitem"+idRowGanttChart+"").find(".gcaptionleft").removeClass("mouseover")
			$(".glineitem"+idRowGanttChart+"").find(".gmilecaption").removeClass("mouseover")
	});

	$("#embedded-Ganttgchartbody #embedded-GanttchartTable tr:last-child").remove();

	$(".btn-close-row-info .icon-cancel").on("click", function(){
		$(".wrapper-row-info").removeClass("show");
		$(".wrapper-block-row-info").removeClass("show");
		$('.btn-chart').removeClass('d-none');
		$('#btn_change_format').removeClass('d-none');
		if($(".wrapper-chart").hasClass("show")){
			$('.wrapper-table-list-work-package').css('width', '50%');
			$('.wrapper-block-create-new-child').css('width', '0%');
			$('.wrapper-row-info').css('width', '0%');
			$('.wrapper-chart').css('width', '50%');
		}else{
			$('.wrapper-table-list-work-package').css('width', '100%');
			$('.wrapper-block-create-new-child').css('width', '0%');
			$('.wrapper-row-info').css('width', '0%');
			$('.wrapper-chart').css('width', '0%');
		}
	})

	$(".create-work-package").on("click",function(){
		$(this).parent().addClass("show-input")
		$(this).find("input").focus()
	})
	$(".close-create-work-package .icon-cancel").on("click", function(){
		$(this).parents("tr").removeClass("show-input")
	})
	$(".create-work-package input").on("keypress", function(e){
		if(e.which==13){
			// get val of input
			let value = $(this).find("input").val()
			$(this).val("")
			$(this).parents("tr").removeClass("show-input")
		}
	})


	$(".set-parent").on("click", function(){
		$(this).hide()
		$(".select-set-parent").show()
	})

	//show menu type
	$('#btnShowMenuType').on('click', function () {
		if (!$(this).hasClass('show')){
			$(this).addClass('show');
			$('.dropdown-menu-type').addClass('d-block-custom');
		}
		else{
			$(this).removeClass('show');
			$('.dropdown-menu-type').removeClass('d-block-custom');
		}
	});

	$('.dropdown-type-item').on('click', function () {
		var _this = $(this);
		var id = _this.attr('data-id');
		var icon = _this.attr('data-icon');
		var name = _this.attr('data-type');
		var _thisBtn = $('#btnShowMenuType');

		_thisBtn.find('#type_icon').removeClass();
		_thisBtn.find('#type_icon').addClass(icon);
		_thisBtn.find('#type_name').text(name);
		$('#type_id').val(id);

		_thisBtn.removeClass('show');
		_this.parent().removeClass('d-block-custom');
	});

	$('.btnShowMenuType').on('click', function () {
		var _this = $(this);
		if (!$(this).hasClass('show')){
			$(this).addClass('show');
			_this.parent().find('.dropdown-menu-type').addClass('d-block-custom');
		}
		else{
			$(this).removeClass('show');
			_this.parent().find('.dropdown-menu-type').removeClass('d-block-custom');
		}
	});

	$('.dropdown-type-item').on('click', function () {
		var _this = $(this);
		var id = _this.attr('data-id');
		var icon = _this.attr('data-icon');
		var name = _this.attr('data-type');
		var work_packageID = _this.attr('data-work_packageID');
		var _thisBtn = _this.parents().parent().find('.btnShowMenuType');

		_thisBtn.find('#type_icon_' + work_packageID).removeClass();
		_thisBtn.find('#type_icon_' + work_packageID).addClass(icon);
		_thisBtn.find('#type_name_' + work_packageID).text(name);
		$('#type_id_' + work_packageID).val(id);

		_thisBtn.removeClass('show');
		_this.parent().removeClass('d-block-custom');
	});

	//show menu status
	$('#btnShowMenuStatus').on('click', function () {
		if (!$(this).hasClass('show')){
			$(this).addClass('show');
			$('.dropdown-menu-status').addClass('d-block-custom');
		}
		else{
			$(this).removeClass('show');
			$('.dropdown-menu-status').removeClass('d-block-custom');
		}
	});

	$('.dropdown-status-item').on('click', function () {
		var _this = $(this);
		var id = _this.attr('data-id');
		var style = _this.attr('data-style');
		var name = _this.attr('data-status');
		var _thisBtn = $('#btnShowMenuStatus');

		_thisBtn.removeClass();
		_thisBtn.addClass(style);
		_thisBtn.find('#status_name').text(name);
		$('#status_id').val(id);

		_thisBtn.removeClass('show');
		_this.parent().removeClass('d-block-custom');
	});

	$('.btnShowMenuStatus').on('click', function () {
		var _this = $(this);
		if (!$(this).hasClass('show')){
			$(this).addClass('show');
			_this.parent().find('.dropdown-menu-status').addClass('d-block-custom');
		}
		else{
			$(this).removeClass('show');
			_this.parent().find('.dropdown-menu-status').removeClass('d-block-custom');
		}
	});

	$('.dropdown-status-item').on('click', function () {
		var _this = $(this);
		var id = _this.attr('data-id');
		var style = _this.attr('data-style');
		var name = _this.attr('data-status');
		var work_packageID = _this.attr('data-work_packageID');
		var _thisBtn = _this.parent().parent().find('.btnShowMenuStatus');

		_thisBtn.removeClass();
		_thisBtn.addClass(style);
		_thisBtn.find('#status_name_' + work_packageID).text(name);
		$('#status_id_' + work_packageID).val(id);

		_thisBtn.removeClass('show');
		_this.parent().removeClass('d-block-custom');
	});

	$('#statusFilter').on('change', function () {
		var value = $(this).val();
		if(value=="=" || value=="!"){
			$('#statusTask').show();
		}
		else{
			$('#statusTask').hide();
		}
	});

	$('#btn_change_format').on('click', function () {
		var _this = $(this);
		var formatRequest = _this.attr('data-format');
		$.ajax({
			url: base_url + "/auth/project/gantt-chart/" + formatRequest,
			method: 'GET',
			success: function () {
				location.reload();
			}
		});
	});

});
