$(document).ready(function () {
  var width = $(window).width();
  var base_url = $('#get_base_url').val();
  var href = window.location.href;
  var is_iPad = navigator.userAgent.match(/iPad/i);
  var is_iPhone = navigator.userAgent.match(/iPhone/i);

  if (is_iPad || is_iPhone) {
    $('body').css('cursor', 'pointer');
  }

  //set min height
  function setHeightContent() {
    var window_height = $(window).height();
    var header_height = $('header').height();
    var cate_menu_list_height = $('.cate-menu-list').outerHeight();
    var footer_height = $('footer').height();
    var top_header_height = $('.top-header').outerHeight();

    if (cate_menu_list_height === undefined || width < 768 || (href.lastIndexOf('/auth/') !== -1 && width > 767)) {
      cate_menu_list_height = 0;
    }
    if (top_header_height === undefined) {
      top_header_height = 0;
    }

    $('.wrapper-content').css('min-height', window_height - header_height - top_header_height - cate_menu_list_height - footer_height);

  }

  setHeightContent();
  $(window).on('resize', function () {
    setHeightContent();
  });
  $('.search-menu-item').on('click', function () {
    setHeightContent();
  });
  $('.category-menu-item').on('click', function () {
    setHeightContent();
  });

  //btn reload
  $('.btn-reload').on('click', function () {
    location.reload();
  });

  //limit text category
  var limitTextFileName = 45;
  if (width < 768){
    var limitTextFileName = 30;
  }
  $('.limitTextFileName').each(function () {
    var text = ($(this).text()).trim();
    if (text.length > limitTextFileName) {
      var newString = text.substr(0, limitTextFileName - 3) + '...';
      $(this).html(newString);
      $(this).removeClass('d-none');
    }
  });

// device detection
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    if ($('body').hasClass('home-page')) {
      $('#presentation_list_home').on('click', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#video_list_home').on('click', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#poster_list_home').on('click', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#paper_list_home').on('click', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });
    }
    else{
      $('.post-item-custom').on('click', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });
    }
  }
  else{
    if ($('body').hasClass('home-page')) {
      $('#presentation_list_home').on('mouseover', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#presentation_list_home').on('mouseout', '.post-item-custom', function(){
        if($(this).hasClass('flipped')){
          $(this).removeClass('flipped');
        }
      });

      $('#video_list_home').on('mouseover', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#video_list_home').on('mouseout', '.post-item-custom', function(){
        if($(this).hasClass('flipped')){
          $(this).removeClass('flipped');
        }
      });

      $('#poster_list_home').on('mouseover', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#poster_list_home').on('mouseout', '.post-item-custom', function(){
        if($(this).hasClass('flipped')){
          $(this).removeClass('flipped');
        }
      });

      $('#paper_list_home').on('mouseover', '.post-item-custom', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('#paper_list_home').on('mouseout', '.post-item-custom', function(){
        if($(this).hasClass('flipped')){
          $(this).removeClass('flipped');
        }
      });
    }
    else{
      $('.post-item-custom').on('mouseover', function(){
        $('.post-item-custom').not($(this)).removeClass('flipped');
        if(!$(this).hasClass('flipped')){
          $(this).addClass('flipped');
        }
        else{
          $(this).removeClass('flipped');
        }
      });

      $('.post-item-custom').on('mouseout', function(){
        if($(this).hasClass('flipped')){
          $(this).removeClass('flipped');
        }
      });
    }
  }

  //show/hide post detail when move over post item
  // $('.post-item-custom').on('mouseover', function(){
  //   $(this).find('.post-item-custom-detail').removeClass('d-none-custom');
  // });
  //
  // $('.post-item-custom').on('mouseout', function(){
  //   $(this).find('.post-item-custom-detail').addClass('d-none-custom');
  // });
  //


  //check click
  $(document).on('click', function (e) {
    var target = e.target;
    if (!$(target).is('#collapse-session') && !$(target).parents().is('#collapse-session') && !$(target).is('.btn_remove_input_add_session')) {
      $('#collapse-session').collapse('hide');
    }
    if (!$(target).is('#collapse-organizing') && !$(target).parents().is('#collapse-organizing')) {
      $('#collapse-organizing').collapse('hide');
    }
    if (!$(target).is('#collapse-location') && !$(target).parents().is('#collapse-location')) {
      $('#collapse-location').collapse('hide');
    }

    if (!$(target).is('#collapse-abstract') && !$(target).parents().is('#collapse-abstract')) {
      $('#collapse-abstract').collapse('hide');
    }
    if (!$(target).is('#collapse-programme') && !$(target).parents().is('#collapse-programme')) {
      $('#collapse-programme').collapse('hide');
    }
    if (!$(target).is('#collapse-LOC') && !$(target).parents().is('#collapse-LOC')) {
      $('#collapse-LOC').collapse('hide');
    }
    if (!$(target).is('#collapse-SOC') && !$(target).parents().is('#collapse-SOC')) {
      $('#collapse-SOC').collapse('hide');
    }
    if (!$(target).is('#collapse-keynoteSpeakers') && !$(target).parents().is('#collapse-keynoteSpeakers')) {
      $('#collapse-keynoteSpeakers').collapse('hide');
    }
    if (!$(target).is('#collapse-venue') && !$(target).parents().is('#collapse-venue')) {
      $('#collapse-venue').collapse('hide');
    }
    if (!$(target).is('#collapse-importantDates') && !$(target).parents().is('#collapse-importantDates')) {
      $('#collapse-importantDates').collapse('hide');
    }
    if (!$(target).is('#collapse-registrationPayment') && !$(target).parents().is('#collapse-registrationPayment')) {
      $('#collapse-registrationPayment').collapse('hide');
    }
    if (!$(target).is('#collapse-hotelInfos') && !$(target).parents().is('#collapse-hotelInfos')) {
      $('#collapse-hotelInfos').collapse('hide');
    }
    if (!$(target).is('#collapse-travelInformation') && !$(target).parents().is('#collapse-travelInformation')) {
      $('#collapse-travelInformation').collapse('hide');
    }

    if ((!$(target).is('.btn-update-type') && !$(target).parents().is('.btn-update-type')) &&
      (!$(target).is('.dropdown-menu-type') && !$(target).parents().is('.dropdown-menu-type'))) {
      $('.dropdown-menu-type').removeClass('d-block-custom');
      if ($('.btn-update-type').hasClass('show')){
        $('.btn-update-type').removeClass('show');
        $('.dropdown-menu-type').removeClass('d-block-custom');
      }
      // else{
      // }
    }
    if ((!$(target).is('.btn-update-status') && !$(target).parents().is('.btn-update-status')) &&
      (!$(target).is('.dropdown-menu-status') && !$(target).parents().is('.dropdown-menu-status'))) {
      $('.dropdown-menu-status').removeClass('d-block-custom');
      if ($('.btn-update-status').hasClass('show')){
        $('.btn-update-status').removeClass('show');
        $('.dropdown-menu-status').removeClass('d-block-custom');
      }
    }

  });

  //add spinner
  $('.add-spinner').on('click', function () {
    $('.spinner-block').removeClass('d-none');
  });

  function addSpinner(status) {
    if (status){
      $('.spinner-block').removeClass('d-none');
    }
    else{
      $('.spinner-block').addClass('d-none');
    }
  }

  //show notification modal
  function showNotificationModal (status, msg) {
    var _this = $('.notification-modal');
    _this.removeClass('d-none');
    if (status == 'success'){
      _this.append('<div class="btn-custom btn-bg green label">'+ msg +'</div>');
    }
    else{
      _this.append('<div class="btn-custom btn-bg red label">'+ msg +'</div>');
    }
    setTimeout(function () {
      hideNotificationModal();
    }, 2000);
  }

  function hideNotificationModal (){
    var _this = $('.notification-modal');
    if (_this.hasClass('reload')){
      location.reload();
    }
    else{
      _this.addClass('d-none');
      _this.html('');
    }
  }

  function reloadNotificationModal (){
    var _this = $('.notification-modal');
    _this.addClass('reload');
  }

  $('.notification-modal').on('click', function () {
    hideNotificationModal();
  });

  //Explore more
  $('#explore_more_presentation').on('click', function () {
    var _this = $(this);
    var _inputStart = $('#start_presentation');
    var total = $('#total_presentation').val();
    var start = _inputStart.val();
    var new_start = parseInt(start) + 8;
    $.ajax({
      url: base_url + "/get-presentations-limit",
      method: 'GET',
      dataType: "json",
      data: {"start": start},
      success: function (data) {
        if (data) {
          $('#presentation_list_home').append(data);
        }
        if (new_start < total) {
          _inputStart.val(new_start);
        }
        else {
          _this.parent().addClass('d-none');
        }
      }
    });
  });

  $('#explore_more_video').on('click', function () {
    var _this = $(this);
    var _inputStart = $('#start_video');
    var total = $('#total_video').val();
    var start = _inputStart.val();
    var new_start = parseInt(start) + 8;
    $.ajax({
      url: base_url + "/get-videos-limit",
      method: 'GET',
      dataType: "json",
      data: {"start": start},
      success: function (data) {
        if (data) {
          $('#video_list_home').append(data);
        }
        if (new_start < total) {
          _inputStart.val(new_start);
        }
        else {
          _this.parent().addClass('d-none');
        }
      }
    });
  });

  $('#explore_more_poster').on('click', function () {
    var _this = $(this);
    var _inputStart = $('#start_poster');
    var total = $('#total_poster').val();
    var start = _inputStart.val();
    var new_start = parseInt(start) + 8;
    $.ajax({
      url: base_url + "/get-posters-limit",
      method: 'GET',
      dataType: "json",
      data: {"start": start},
      success: function (data) {
        if (data) {
          $('#poster_list_home').append(data);
        }
        if (new_start < total) {
          _inputStart.val(new_start);
        }
        else {
          _this.parent().addClass('d-none');
        }
      }
    });
  });

  $('#explore_more_paper').on('click', function () {
    var _this = $(this);
    var _inputStart = $('#start_paper');
    var total = $('#total_paper').val();
    var start = _inputStart.val();
    var new_start = parseInt(start) + 8;
    $.ajax({
      url: base_url + "/get-papers-limit",
      method: 'GET',
      dataType: "json",
      data: {"start": start},
      success: function (data) {
        if (data) {
          $('#paper_list_home').append(data);
        }
        if (new_start < total) {
          _inputStart.val(new_start);
        }
        else {
          _this.parent().addClass('d-none');
        }
      }
    });
  });

  if (href.lastIndexOf('/auth/') === -1) {
    $('.my-science-media').removeClass('d-none');
    $('.wrapper-content').removeClass('container-custom');
    $('.wrapper-content').removeClass('setHeightContent');
  }

  //submit paypal_form
  $('.btnBuyNowOrderCID').on('click', function () {
    var _this = $(this);
    var cid = _this.parent().find('.getCID').val();
    if (cid !== ''){
      $.ajax({
        type: 'POST',
        url: base_url + 'auth/conference/set-session-cid',
        dataType: "json",
        data: {"CID": cid},
        success: function (res) {
          if (res === 'success'){
            _this.parent().submit();
          }
        }
      });
    }
  });

  //preview TeX
  $('.TeXModal').on('click', function () {
    $('#teXFormulaInput').val('');
    $('#formula').html('');
  });

  $('#button_TeXit').on('click', function () {
    $('#formula').html($('#teXFormulaInput').val());
    MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
    $(this).blur();
  });

  //select country, state
  populateCountries("country", "state");

  //delete video
  $('.btn-delete-video').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/video/delete/' + postID,
      success: function (res) {
        if (res === 'true') {
          $('.modal-description').html('If you delete this video, all entries to this content will be lost. The SMN ScienceMedia Network will not keep any records connected, except for backup purposes.');
          $('.sm-modal-footer').removeClass('d-none');
        } else {
          $('.modal-description').html('This video cannot be deleted because it has a DOI or it has been linked to a conference. Please re-check carefully.');
          $('.sm-modal-footer').addClass('d-none');
        }
        $('#deletePost').modal('show');
      }
    });
  });

  $('.btn-delete-video-confirm').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/video/delete/confirm/' + postID,
      success: function (res) {
        if (res === 'success') {
          $('.modal-description').html('Video has been deleted successfully!');
          $('#deleteStatus').modal('show');
          setTimeout(function () {
            window.location.href = base_url + "auth/content/videos";
          }, 2000);
        } else {
          $('.modal-description').html('Failed to delete video!');
          $('#deleteStatus').modal('show');
        }
      }
    });
  });

  //delete presentation
  $('.btn-delete-presentation').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/presentation/delete/' + postID,
      success: function (res) {
        if (res === 'true') {
          $('.modal-description').html('If you delete this presentation, all entries to this content will be lost. The SMN ScienceMedia Network will not keep any records connected, except for backup purposes.');
          $('.sm-modal-footer').removeClass('d-none');
        } else {
          $('.modal-description').html('This presentation cannot be deleted because it has a DOI or it has been linked to a conference. Please re-check carefully.');
          $('.sm-modal-footer').addClass('d-none');
        }
        $('#deletePost').modal('show');
      }
    });
  });

  $('.btn-delete-presentation-confirm').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/presentation/delete/confirm/' + postID,
      success: function (res) {
        if (res === 'success') {
          $('.modal-description').html('Presentation has been deleted successfully!');
          $('#deleteStatus').modal('show');
          setTimeout(function () {
            window.location.href = base_url + "auth/content/presentations";
          }, 2000);
        } else {
          $('.modal-description').html('Failed to delete presentation!');
          $('#deleteStatus').modal('show');
        }
      }
    });
  });

  //delete poster
  $('.btn-delete-poster').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/poster/delete/' + postID,
      success: function (res) {
        if (res === 'true') {
          $('.modal-description').html('If you delete this poster, all entries to this content will be lost. The SMN ScienceMedia Network will not keep any records connected, except for backup purposes.');
          $('.sm-modal-footer').removeClass('d-none');
        } else {
          $('.modal-description').html('This poster cannot be deleted because it has a DOI or it has been linked to a conference. Please re-check carefully.');
          $('.sm-modal-footer').addClass('d-none');
        }
        $('#deletePost').modal('show');
      }
    });
  });

  $('.btn-delete-poster-confirm').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/poster/delete/confirm/' + postID,
      success: function (res) {
        if (res === 'success') {
          $('.modal-description').html('Poster has been deleted successfully!');
          $('#deleteStatus').modal('show');
          setTimeout(function () {
            window.location.href = base_url + "auth/content/posters";
          }, 2000);
        } else {
          $('.modal-description').html('Failed to delete poster!');
          $('#deleteStatus').modal('show');
        }
      }
    });
  });

  //delete paper
  $('.btn-delete-paper').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/paper/delete/' + postID,
      success: function (res) {
        if (res === 'true') {
          $('.modal-description').html('If you paper this poster, all entries to this content will be lost. The SMN ScienceMedia Network will not keep any records connected, except for backup purposes.');
          $('.sm-modal-footer').removeClass('d-none');
        } else {
          $('.modal-description').html('This paper cannot be deleted because it has a DOI or it has been linked to a conference. Please re-check carefully.');
          $('.sm-modal-footer').addClass('d-none');
        }
        $('#deletePost').modal('show');
      }
    });
  });

  $('.btn-delete-paper-confirm').on('click', function () {
    var postID = $(this).parent().find('.get-id-post').val();
    $.ajax({
      type: 'GET',
      url: base_url + 'auth/content/paper/delete/confirm/' + postID,
      success: function (res) {
        if (res === 'success') {
          $('.modal-description').html('Paper has been deleted successfully!');
          $('#deleteStatus').modal('show');
          setTimeout(function () {
            window.location.href = base_url + "auth/content/papers";
          }, 2000);
        } else {
          $('.modal-description').html('Failed to delete paper!');
          $('#deleteStatus').modal('show');
        }
      }
    });
  });

  //back function
  $('.back').click(function () {
    parent.history.back();
    return false;
  });

  $('.btn-redirect').on('click', function () {
    var url = $(this).attr('data-link');
    $(location).attr('href',url);
  });

  //button pagination
  // $('.menu-pagination').each(function () {
    // if (!$(this).children().hasClass('prevlink') && $(this).children('strong').length !== 0) {
    //   $(this).prepend('<span class="prevlink default"><a></a></span>');
    // }
    // if (!$(this).children().hasClass('nextlink') && $(this).children('strong').length !== 0) {
    //   $(this).append('<span class="nextlink default"><a></a></span>');
    // }
    // var _prevLink = $('.prevlink').children('a');
    // _prevLink.html('');
    // _prevLink.append('<span class="icon-chevron-circle-left"></span>');
    //
    // var _nextLink = $('.nextlink').children('a');
    // _nextLink.html('');
    // _nextLink.append('<span class="icon-chevron-circle-right"></span>');
  // });

  //count characters in textarea
  var _thisCountChar = $('.countCharacters');
  var countCharacter = _thisCountChar.val();
  if (countCharacter !== undefined && countCharacter.length > 0) {
    var limit = _thisCountChar.parent().find('.limit-character').val();
    countCharacters(_thisCountChar, limit);
  }

  $('.countCharacters').on('keyup', function () {
    var limit = $(this).parent().find('.limit-character').val();
    countCharacters($(this), limit);
  });

  function countCharacters(content, limit) {
    var len = content.val().length;
    if (len > limit) {
      var newString = content.val().substr(0, limit);
      $(content).val(newString);
    } else {
      $(content).parent().find('#charNumber').text(limit - len);
    }
  }

  //remove session postType, sort by
  // if (href.lastIndexOf('/videos') === -1) {
  //   $.ajax({
  //     type: 'GET',
  //     url: base_url + 'remove-post-type',
  //   })
  // }
  if (href.lastIndexOf('/search') === -1) {
    $.ajax({
      type: 'GET',
      url: base_url + 'remove-post-type-search',
    })
  }

  //
  $('.select-custom').select2();
  $('.select-custom-none-search').select2({
    minimumResultsForSearch: -1,
  });

  //update session post type
  $('.category-menu-item').on('click', function () {
    var type = $(this).find('.sidebar-item-text').text();
    $.ajax({
      type: 'GET',
      url: base_url + 'sort/update-post-type/' + type,
    })
  });

  $('.dropdown-item-contribution').on('click', function () {
    var type = $(this).children('.contribution-type').text();
    $.ajax({
      type: 'GET',
      url: base_url + 'sort/update-contribution-type/' + type,
    })
  });

  $('.search-menu-item').on('click', function () {
    var type = $(this).find('.sidebar-item-text').text();
    $.ajax({
      type: 'GET',
      url: base_url + 'sort/update-post-type-search/' + type,
    })
  });

  //update session views, date, alpha sort
  $('.get-sort').on('click', function () {
    var text = $(this).text();
    if (width < 768) {
      text = $(this).parent().find('.sort-item-content').text();
    }

    $.ajax({
      type: 'GET',
      url: base_url + 'sort/update/' + text,
      success: function () {
        location.reload();
      }
    })
  });

  //update session views, date, alpha sort category
  $('.get-sort-search').on('click', function () {
    var text = $(this).text();
    if (width < 768) {
      text = $(this).parent().find('.sort-item-content').text();
    }

    $.ajax({
      type: 'GET',
      url: base_url + 'sort/update-search/' + text,
      success: function () {
        location.reload();
      }
    })
  });

  //hover input when error
  $('.error').each(function () {
    if ($(this).children().length > 0) {
      $(this).parents('.form-item').find('input').addClass('field-error');
      $(this).parents('.form-item').find('textarea').addClass('field-error');
      $(this).parents('.form-item').find('.select2-selection').addClass('field-error');
    } else {
      $(this).parents('.form-item').find('input').removeClass('field-error');
      $(this).parents('.form-item').find('textarea').removeClass('field-error');
    }
  });

  $('.error-login').each(function () {
    if ($(this).children().length > 0) {
      $(this).parents('.form-login').find('.error-submit-login').remove();
    }
  });

  if ($('.error-submit-login').children().length > 0) {
    var _thisError = $('.error');
    _thisError.each(function () {
      if (_thisError.children().length > 0) {
        _thisError.parents('.form-item').find('input').addClass('field-error');
      }
    });
  }

  //set active nav-item-summary-profile
  $('.nav-link-summary-profile').on('click', function () {
    $(this).parents('#myTabSummaryProfile').find('.active-custom').removeClass('active-custom');
    $(this).parent().addClass('active-custom');

    if ($(this).hasClass('video')){
      $.ajax({
        type: 'GET',
        url: base_url + 'sort/update-summary-type/video',
      })
    }
    else if($(this).hasClass('poster')){
      $.ajax({
        type: 'GET',
        url: base_url + 'sort/update-summary-type/poster',
      })
    }
    else if($(this).hasClass('paper')){
      $.ajax({
        type: 'GET',
        url: base_url + 'sort/update-summary-type/paper',
      })
    }
    else if($(this).hasClass('presentation')){
      $.ajax({
        type: 'GET',
        url: base_url + 'sort/update-summary-type/presentation',
      })
    }
    else if($(this).hasClass('conference')){
      $.ajax({
        type: 'GET',
        url: base_url + 'sort/update-summary-type/conference',
      })
    }

  });

  if (width > 767) {
    $('#accordionMenuCategory').on('shown.bs.collapse', function () {
      // if(!$('#menu').find('menu-list').hasClass('d-none-custom')){
      //   $('#menu').find('menu-list').addClass('d-none-custom');
      // }
      $('.cate-menu-list').addClass('relative-bg-white');
      $('body').append('<div class="modal-backdrop-custom fade"></div>');
      $('.modal-backdrop-custom').addClass('show');
    });
    $('#accordionMenuCategory').on('hidden.bs.collapse', function () {
      $('.modal-backdrop-custom').remove();
      $('.cate-menu-list').removeClass('relative-bg-white');
    });

    //limit text category
    var limitTextCategory = 35;
    $('.limitTextCategory').each(function () {
      var text = ($(this).text()).trim();
      if (text.length > limitTextCategory) {
        var newString = text.substr(0, limitTextCategory - 3) + '...';
        $(this).html(newString);
      }
    });
  } else {
    //show search menu
    $('#show_search_menu').on('click', function () {
      var _thisTab = $(this).parent('').find('#search_results_tab');
      var _this = $(this);
      addShowClass(_this);
      if (!_thisTab.hasClass('d-block-custom')) {
        if (_thisTab.find('a:first-child').hasClass('active')) {
          _thisTab.find('a:first-child').addClass('d-none');
        }
        _thisTab.addClass('d-block-custom');
      } else {
        _thisTab.removeClass('d-block-custom');
      }
    });

    $('#show_category_menu').on('click', function () {
      var _thisTab = $(this).parent().find('#category_results_tab');
      var _this = $(this);
      addShowClass(_this);
      if (!_thisTab.hasClass('d-block-custom')) {
        if (_thisTab.find('a:first-child').hasClass('active')) {
          _thisTab.find('a:first-child').addClass('d-none');
        }
        _thisTab.addClass('d-block-custom');
      } else {
        _thisTab.removeClass('d-block-custom');
      }
    });

    $('.search-menu-item').on('click', function () {
      var _this = $(this).parent('#search_results_tab');
      var type = $(this).find('.sidebar-item-text').text();
      var qty = $(this).find('.quantity-number').text();
      var _thisMenu = $('#show_search_menu');
      if (!_this.hasClass('d-block-custom')) {
        _this.addClass('d-block-custom');
      } else {
        _this.removeClass('d-block-custom');
      }
      addShowClass(_thisMenu);
      _thisMenu.find('.sidebar-item-text').text(type);
      _thisMenu.find('.quantity-number').text(qty);
      _thisMenu.find('.quantity-number').removeClass('videos presentations posters papers conferences');
      _thisMenu.find('.quantity-number').addClass(type);

      $('#search_results_tab').find('.sidebar-item').removeClass('d-none');
      $(this).addClass('d-none');
    });

    $('.category-menu-item').on('click', function () {
      var _this = $(this).parent('#category_results_tab');
      var type = $(this).find('.sidebar-item-text').text();
      var qty = $(this).find('.quantity-number').text();
      var _thisMenu = $('#show_category_menu');
      if (!_this.hasClass('d-block-custom')) {
        _this.addClass('d-block-custom');
      } else {
        _this.removeClass('d-block-custom');
      }
      addShowClass(_thisMenu);
      _thisMenu.find('.sidebar-item-text').text(type);
      _thisMenu.find('.quantity-number').text(qty);
      _thisMenu.find('.quantity-number').removeClass('videos presentations posters papers conferences');
      _thisMenu.find('.quantity-number').addClass(type);

      $('#category_results_tab').find('.sidebar-item').removeClass('d-none');
      $(this).addClass('d-none');
    });

    $('.dropdown-item-contribution').on('click', function () {
      var type = $(this).find('.contribution-type').text();
      var qty = $(this).find('.number').text();

      $('#show_contribution_menu').find('.contribution-type').text(type);
      $('#show_contribution_menu').find('.number').text(qty);

      $('.dropdown-menu-contribution').find('.dropdown-item-contribution').removeClass('d-none active');
      $(this).addClass('d-none');
    });

    function addShowClass(_this){
      if (!_this.hasClass('show')){
        _this.addClass('show');
      }
      else{
        _this.removeClass('show');
      }
    }

    //set active item category
    $('.cate-menu-item-title').click(function () {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
      } else {
        $('.cate-menu-item-title').removeClass('active');
        $(this).addClass('active');
      }
    });

    //set width navigation list
    var navigationListWidth = 0;
    var thisNav = $('.navigation-list-item');
    thisNav.each(function () {
      if ($(this).width() > 0) {
        navigationListWidth += $(this).outerWidth();
      }
    });
    thisNav.parent().css('width', navigationListWidth + 350);

    //limit text category
    var limitTextMenu = 16;
    $('.limitTextMenu').each(function () {
      var text = ($(this).text()).trim();
      if (text.length > limitTextMenu) {
        var newString = text.substr(0, limitTextMenu - 3) + '...';
        $(this).html(newString);
      }
    });

    var profile_width = $('.menu-profile').outerWidth();
    var content_width = $('.menu-content').outerWidth();
    var conference_width = $('.menu-conference').outerWidth();
    var postbox_width = $('.menu-postbox').outerWidth();

    if ($('.menu-content').hasClass('active-custom')) {
      $('.top-header-content-list').animate( {
        scrollLeft: profile_width
      }, 600 );
    }

    if ($('.menu-conference').hasClass('active-custom')) {
      $('.top-header-content-list').animate( {
        scrollLeft: profile_width + content_width
      }, 600 );
    }

    if ($('.menu-postbox').hasClass('active-custom')) {
      $('.top-header-content-list').animate( {
        scrollLeft: profile_width + content_width + conference_width
      }, 600 );
    }

    if ($('.menu-project').hasClass('active-custom')) {
      $('.top-header-content-list').animate( {
        scrollLeft: profile_width + content_width + conference_width + postbox_width
      }, 600 );
    }

    var view_width = $('.menu-view').outerWidth();
    var edit_width = $('.menu-edit').outerWidth();
    var request_doi_width = $('.menu-request-doi').outerWidth();

    if ($('.menu-edit').hasClass('active')) {
      $('.menu-post-detail').animate( {
        scrollLeft: view_width
      }, 600 );
    }

    if ($('.menu-request-doi').hasClass('active')) {
      $('.menu-post-detail').animate( {
        scrollLeft: view_width + edit_width
      }, 600 );
    }

    if ($('.menu-link-to-conference').hasClass('active')) {
      $('.menu-post-detail').animate( {
        scrollLeft: view_width + edit_width + request_doi_width
      }, 600 );
    }

    var ongoing_width = $('.menu-ongoing').outerWidth();
    var closed_width = $('.menu-closed').outerWidth();

    if ($('.menu-closed').hasClass('active')) {
      $('.menu-post-detail').animate( {
        scrollLeft: ongoing_width
      }, 600 );
    }

    if ($('.menu-in-preparation').hasClass('active')) {
      $('.menu-post-detail').animate( {
        scrollLeft: ongoing_width + closed_width
      }, 600 );
    }

    var basic_width = $('.basic-menu').outerWidth();
    var optional_width = $('.optional-menu').outerWidth();

    if ($('.optional-menu').hasClass('active')) {
      $('.menu-edit-detail').animate( {
        scrollLeft: basic_width
      }, 600 );
    }

    if ($('.file-upload-menu').hasClass('active')) {
      $('.menu-edit-detail').animate( {
        scrollLeft: basic_width + optional_width
      }, 600 );
    }

  }
  $('#show_menu').on('click', function () {
    var _this = $(this).parent().find('.menu-list');
    if (!_this.hasClass('d-none-custom')) {
      _this.addClass('d-none-custom');
      $('.modal-backdrop-custom-2').remove();
    } else {
      _this.removeClass('d-none-custom');
      $('body').append('<div class="modal-backdrop-custom-2 fade"></div>');
      $('.modal-backdrop-custom-2').addClass('show');
    }
  });

  $('#show_menu_category').on('click', function () {
    var _this = $('#accordionMenuCategory');
    if (!_this.hasClass('d-block-custom')) {
      _this.addClass('d-block-custom');
      $('body').append('<div class="modal-backdrop-custom fade"></div>');
      $('.modal-backdrop-custom').addClass('show');
    } else {
      _this.removeClass('d-block-custom');
      $('.modal-backdrop-custom').remove();
    }
  });
  $(document).on('click', function (e) {
    var target = e.target;
    if ($('.fee-conference').is(":checked")) {
      $('.banking-info').removeClass('d-none');

    } else {
      $('.banking-info').addClass('d-none');
    }

    if (!$(target).is('.post-item-custom') && !$(target).parents().is('.post-item-custom')) {
      $('.post-item-custom').removeClass('flipped');
    }

    if (width > 767) {
      if (!$(target).is('#accordionMenuCategory') && !$(target).parents().is('#accordionMenuCategory')) {
        $('#accordionMenuCategory').find('.collapse').removeClass('show');
        $('.modal-backdrop-custom').remove();
        $('.cate-menu-list').removeClass('relative-bg-white');
      }
    } else {
      if (!$(target).is('#show_menu_category') && !$(target).is('#accordionMenuCategory') && !$(target).parents().is('#accordionMenuCategory')) {
        $('.modal-backdrop-custom').remove();
        $('.cate-menu-list').removeClass('d-block-custom');
      }
    }
    if (!$(target).is('#menu') && !$(target).parents().is('#menu')) {
      $(this).find('.menu-list').addClass('d-none-custom');
      $('.modal-backdrop-custom-2').remove();
    }
  });

  //limit text further info
  var limitTextFurther = 70;
  $('.limitTextFurther').each(function () {
    var text = ($(this).text()).trim();
    if (text.length > limitTextFurther) {
      var newString = text.substr(0, limitTextFurther - 3) + '...';
      $(this).html(newString);
    } else {
      $(this).html(text);
      $(this).parent().children('.icon-show').css('visibility', 'hidden');
      $(this).parent().children('.btn-show').css('visibility', 'hidden');
    }
  });

  //get sub category
  var id_category = $('#get_id_category').val();
  var id_subcategory = $('#get_id_subcategory').val();

  if (id_category === undefined) {
    id_category = '';
  }

  if (id_subcategory === undefined) {
    id_subcategory = '';
  }

  if (id_category.length > 0 && id_subcategory.length === 0) {
    $.ajax({
      type: 'GET',
      url: base_url + '/getSubCategory/' + id_category,
      success: function (res) {
        $('#sub_category').html(res);
      }
    });
  } else if (id_category.length > 0 && id_subcategory.length > 0) {
    $.ajax({
      type: 'GET',
      url: base_url + '/getCategory/' + id_category + '/' + id_subcategory,
      success: function (res) {
        $('#sub_category').html(res);
      }
    });
  }

  $('#category').change(function () {
    id_category = $(this).val();
    if (id_category) {
      $.ajax({
        type: 'GET',
        url: base_url + '/getSubCategory/' + id_category,
        success: function (res) {
          $('#sub_category').html(res);
        }
      });
    } else {
      $('#sub_category').html('');
    }
  });

  var id_alt_category = $('#get_id_alt_category').val();
  var id_alt_subcategory = $('#get_id_alt_subcategory').val();

  if (id_alt_category === undefined) {
    id_alt_category = '';
  }

  if (id_alt_subcategory === undefined) {
    id_alt_subcategory = '';
  }

  if (id_alt_category.length > 0 && id_alt_subcategory.length === 0) {
    $.ajax({
      type: 'GET',
      url: base_url + '/getSubCategory/' + id_alt_category,
      success: function (res) {
        $('#alt_sub_category').html(res);
      }
    });
  } else if (id_alt_category.length > 0 && id_alt_subcategory.length > 0) {
    $.ajax({
      type: 'GET',
      url: base_url + '/getCategory/' + id_alt_category + '/' + id_alt_subcategory,
      success: function (res) {
        $('#alt_sub_category').html(res);
      }
    });
  }

  $('#alt_category').change(function () {
    id_alt_category = $(this).val();
    if (id_alt_category) {
      $.ajax({
        type: 'GET',
        url: base_url + '/getSubCategory/' + id_alt_category,
        success: function (res) {
          $('#alt_sub_category').html(res);
        }
      });
    } else {
      $('#alt_sub_category').html('');
    }
  });

  $('#category_conference').change(function () {
    id_category = $(this).val();
    var id_alt_subcategory = $('#get_id_alt_subcategory').val();
    if (id_category) {
      $.ajax({
        type: 'GET',
        url: base_url + '/getSubCategoryConference/' + id_category + '/' + id_alt_subcategory,
        success: function (res) {
          $('#sub_category').html(res);
        }
      });
    } else {
      $('#sub_category').html('');
    }
  });

  $('#alt_category_conference').change(function () {
    id_alt_category = $(this).val();
    var id_subcategory = $('#get_id_subcategory').val();
    if (id_alt_category) {
      $.ajax({
        type: 'GET',
        url: base_url + '/getSubCategoryConference/' + id_alt_category + '/' + id_subcategory,
        success: function (res) {
          $('#alt_sub_category').html(res);
        }
      });
    } else {
      $('#alt_sub_category').html('');
    }
  });

  //review avatar
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#avatar_profile').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#input_avatar_profile").change(function (e) {
    readURL(this);
    getInfoAvatar(e.target.files[0]);
  });

  //redirect after upload avatar, change password successfully
  var upload_avatar_msg = $('#upload_avatar_msg').html();
  if (upload_avatar_msg !== undefined && upload_avatar_msg === 'Profile photo has been uploaded successfully!') {
    setTimeout(function () {
      window.location.replace(base_url + "auth/profile");
    }, 2000);
  }

  var change_password_msg = $('#change_password_msg').html();
  if (change_password_msg !== undefined && change_password_msg === 'Password changed successfully!') {
    setTimeout(function () {
      window.location.replace(base_url + "auth/profile");
    }, 2000);
  }

  //get avatar upload info
  function getInfoAvatar(file) {
    if (upload_avatar_msg !== undefined) {
      $('#upload_avatar_msg').remove();
    }
    var fileName = file.name;
    var fileSize = file.size;
    $('#avatar_upload_info').html('');
    $('#avatar_upload_info').append(
      '<p class="mb-1">File name: ' + fileName + '</p>' +
      '<p class="mb-4">File size: ' + calFileSize(fileSize) + '</p>'
    );
  }

  var upload_video_msg = $('#upload_video_msg').html();

  //get video upload info
  function getInfoVideo(file) {
    if (upload_video_msg !== undefined) {
      $('#upload_video_msg').html('');
      $('.btn-reset').remove();
    }

    var fileName = file.name;
    var fileSize = file.size;
    $('#get_video_name').html(fileName);
    $('#video_upload_info').html('');
    $('#video_upload_info').append(
      '<div class="title-sm-text-item">Upload information</div>' +
      '<div class="upload-info-content"><div><span>File name: </span>' + fileName + '</div>' +
      '<div><span>File size: </span>' + calFileSize(fileSize) + '</div>' +
      '<input type="hidden" id="getFileName" name="get-file-name" value="' + fileName + '">' +
      '<input type="hidden" id="getFileSize" name="get-file-size" value="' + fileSize + '"></div>'
    );
    $('#video_upload_btn').removeClass('d-none');
  }

  $('#input_upload_video').change(function (e) {
    getInfoVideo(e.target.files[0]);
  });

  function getInfoAttachment(file) {
    var fileName = file.name;
    var fileSize = file.size;
    var username = $('.usernameLogin').val();

    if(fileSize > 1000000) {
      showNotificationModal('fail', 'The file you upload is larger than the permitted size!');
      $('#input_upload_attachment').val("");
    }
    else{
      $('.block-file-list').html('');
      $('.block-file-list').append(
        '<div class="block-file-info d-flex align-items-center justify-content-start">' +
        '<div class="block-file-info-name">' +
        '<div class="name-item">' + fileName +
        '</div>' +
        '<button type="button" class="close icon-cancel btn-remove-upload btn-remove-new-upload""></button>' +
        '</div>' +
        '<div class="block-file-info-author-time-publishing">' +
        '<span>' + username + '</span> <span>a few seconds ago</span>' +
        '</div>' +
        '</div>'
      );
    }
  }

  $('.block-file-list').on('click', '.btn-remove-upload', function () {
    $('#input_upload_attachment').val('');
    $('.block-file-list').html('');
  });

  $('#input_upload_attachment').change(function (e) {
    getInfoAttachment(e.target.files[0]);
  });

  //submit form create, update document
  $('.btn-submit-document').on('click', function () {
    var _this = $(this);
    var title = _this.parents('.form-submit-document').find('.input-document-title').val();
    if (title !== ''){
      addSpinner(true);
    }
    _this.parents('.form-submit-document').submit();
  });

  $("html").on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(".upload-area-text").text("Drop your file here.");
  });

  $("html").on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
  });

  // Drag enter
  $('.upload-area').on('dragenter', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $(".upload-area-text").text("Drop your file here.");
  });

  // Drag over
  $('.upload-area').on('dragover', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $(".upload-area-text").text("Drop your file here.");
  });

  // Drop
  $('.upload-area').on('drop', function (e) {
    e.stopPropagation();
    e.preventDefault();

    var file = e.originalEvent.dataTransfer.files;

    if ($('#input_upload_video')[0] !== undefined){
      $('#input_upload_video')[0].files = file;
      getInfoVideo(file[0]);
    }

    if ($('#input_upload_attachment')[0] !== undefined){
      $('#input_upload_attachment')[0].files = file;
      getInfoAttachment(file[0]);
    }
  });

  $('.block-file-upload').on('drop', '.upload-area', function (e) {
    e.stopPropagation();
    e.preventDefault();

    var file = e.originalEvent.dataTransfer.files;
    var _this = $('#input_upload_attachment');

    if (_this[0] !== undefined){
      // _this.files = file;
      // console.log(file[0]);
      getInfoAttachment(file[0]);

      var work_packageID = _this.attr('data-work_packageID');
      var form_data = new FormData();

      form_data.append('file', file[0]);

      $.ajax({
        type: 'POST',
        url: base_url + 'auth/project/upload-attachment/' + work_packageID,
        dataType: "text",
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function (res) {
          var data = JSON.parse(res);
          if (data.status === 'success'){
            var _this = $('.btn-remove-new-upload');
            _this.removeClass('btn-remove-upload');
            _this.addClass('btn-delete-attachment');
            _this.attr('data-id', data.msg)
            showNotificationModal('success', 'Successful update.');
          }
          else{
            reloadNotificationModal();
            showNotificationModal('fail', data.msg);
          }
        }
      });
    }
  });

  //add alt category
  $("#add_alt_category").click(function () {
    if ($(this).is(":checked")) {
      $('.alt-category').removeClass('d-none');
      $('.select-custom-none-search').select2({
        minimumResultsForSearch: -1,
      });
    } else {
      $('.alt-category').addClass('d-none');
    }
  });

  //add link to conference
  if ($(".show-link-to-conference").is(':checked')){
    $('.link-to-conference').removeClass('d-none');
    $('.select-custom-none-search').select2({
      minimumResultsForSearch: -1,
    });
  }
  $(".show-link-to-conference").click(function () {
    if ($(this).is(":checked")) {
      $('.link-to-conference').removeClass('d-none');
      $('.select-custom-none-search').select2({
        minimumResultsForSearch: -1,
      });
    } else {
      $('.link-to-conference').addClass('d-none');
    }
  });

  //change payment status
  $('#update_payment_status').click(function () {
    $.ajax({
      type: 'POST',
      url: base_url + '/auth/conference/confirm-pay-cid/change-payment-status',
    });
  });

  //approve element
  $('#table_approve_element').DataTable( {
    dom: 'Bfrtip',
    "scrollX": true,
    buttons: {
      buttons: [
        {
          extend: 'print',
          exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
          },
          className: 'btn-custom btn-bg dark-green btn-print'
        },
        {
          extend: 'csv',
          exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
          },
          className: 'btn-custom btn-bg green btn-csv'
        }
      ]
    },
    "language": {
      searchPlaceholder: "Search",
      paginate: {
        next: '<span class="icon-chevron-circle-right"></span>',
        previous: '<span class="icon-chevron-circle-left"></span>'
      }
    },
    "pagingType": "full_numbers"
  } );

  $('#table_registration').DataTable( {
    dom: 'Bfrtip',
    "scrollX": true,
    buttons: {
      buttons: [
        { extend: 'print', className: 'btn-custom btn-bg dark-green btn-print' },
        { extend: 'csv', className: 'btn-custom btn-bg green btn-csv' }
      ]
    },
    "columnDefs": [
      { "targets": [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17], "searchable": false }
    ],
    "language": {
      searchPlaceholder: "Search",
      paginate: {
        next: '<span class="icon-chevron-circle-right"></span>',
        previous: '<span class="icon-chevron-circle-left"></span>'
      }
    },
    "pagingType": "full_numbers"
  } );

  $('#btn_save_approve_element').click(function () {
    var elements = table.$('input, select').serialize();
    var cid_element = $('#get_cid_element').val();
    $.ajax({
      data: elements,
      url: "/auth/conference/managed/manage-contribution/approve-element/" + cid_element,
      method: 'POST',
      success: function (msg) {
        location.reload();
      }
    });
    return false;
  });

  //search
  $(".input_search").keypress(function (e) {
    var key = $(this).val().trim();
    if (key.length < 3) {
      if (e.keyCode === 13) {
        alert('Please enter min 3 characters');
        e.preventDefault();
      }
    } else {
      $(this).unbind('keypress')
    }
  });
  $('#btn_search').on('click', function () {
    var key = $(this).parent().find('input').val().trim();
    if (key.length > 2) {
      $('#form_search').submit();
    }
    else{
      alert('Please enter min 3 characters');
    }
  });
  $('#btn_search_mobile').on('click', function () {
    var key = $(this).parent().find('input').val().trim();
    if (key.length > 2) {
      $('#form_search_mobile').submit();
    }
    else{
      alert('Please enter min 3 characters');
    }
  });

  $('.edit-conference-beta').on('change', function () {
    var _this = $(this);
    var name = _this.attr('name');
    var value = (_this.val()).trim();
    var placeholder = _this.attr('placeholder');
    var id = $('#get_id_conference').val();
    if (name === 'startDate' || name === 'endDate') {
      var date = value.split(".");
      var newDate = date[1] + "/" + date[0] + "/" + date[2];
      value = new Date(newDate).getTime() / 1000.0 + 7 * 60 * 60;
    }
    if (name === 'programme') {
      editConference_Beta(_this, id, name, value, placeholder, false, 2, 10000, null);
    }
    else if (name === 'confTitle'){
      editConference_Beta(_this, id, name, value, placeholder, true, 1, 200, null);
    }
    else if (name === 'confSeries'){
      editConference_Beta(_this, id, name, value, placeholder, false, 2, 200, null);
    }
    else if (name === 'abstract'){
      editConference_Beta(_this, id, name, value, placeholder, true, 2, 5000, null);
    }
    else if (name === 'startDate' || name === 'endDate'){
      editConference_Beta(_this, id, name, value, placeholder, true, 1, 9999999999, value);
    }
    else if (name === 'fee'){
      editConference_Beta(_this, id, name, value, placeholder, true, 1, 99999.99, value);
    }
    else if (name === 'LOC' || name === 'SOC' || name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' || name === 'hotelInfos'){
      editConference_Beta(_this, id, name, value, placeholder, false, 2, 3000, null);
    }
    else if (name === 'registrationPayment'){
      editConference_Beta(_this, id, name, value, placeholder, true, 2, 5000, null);
    }
    else if (name === 'travelInformation'){
      editConference_Beta(_this, id, name, value, placeholder, false, 2, 5000, null);
    }
    else if (name === 'showParticipation'){
      editConference(_this, id, name, value)
    }
    else if (name === 'paypalEmail'){
      editConference_Beta(_this, id, name, value, placeholder, true, 3, 100, null);
    }
  });

  function editConference_Beta(_this, id, name, value, placeholder, required, min, max, length) {
    var msg = null;
    var count = value.length;
    if (required){
      if (length){
        if (length > 0){
          unsetFailStatus(_this);
          hideErrorMessage(_this);
          if (length >= min && length <= max) {
            $.ajax({
              url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
              method: 'POST',
              dataType: "json",
              data: {"name": name, "value": value},
              success: function (data) {
                if (data['status'] === 'success') {
                  console.log(name);
                  console.log($('#collapse-' + name));
                  if (name === 'showParticipation') {
                    _this.parent().find('label').addClass('label-success');
                    setTimeout(function () {
                      _this.parent().find('label').removeClass('label-success');
                    }, 2000);
                  }
                  else if (name === 'fee' && value === '0'){
                    _this.html(data.msg);
                    $('.edit-conference-price').val('');
                    setTimeout(function () {
                      _this.html('');
                    }, 2000);
                  }
                  else if(name === 'organizingInstitutions'){
                    $('#collapse-organizing').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if(name === 'confLocation'){
                    $('#collapse-location').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'confTitle'){
                    $('#confTitleEditBasic').html(value);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'abstract' || name === 'programme' || name === 'LOC' || name === 'SOC' ||
                    name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' ||
                    name === 'hotelInfos' || name === 'travelInformation' || name === 'registrationPayment'){
                    $('#collapse-' + name).collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else {
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                } else {
                  setFailStatus(_this);
                  showErrorMessage(_this, data['msg'])
                }
              }
            });
          }
          else{
            msg = 'Please enter a valid ' + placeholder;
            showErrorMessage(_this, msg);
            setFailStatus(_this);
          }
        }
        else if (length < 0){
          msg = 'Please enter a valid ' + placeholder;
          showErrorMessage(_this, msg);
          setFailStatus(_this);
        }
        else{
          msg = 'The ' + placeholder + ' field is required.';
          showErrorMessage(_this, msg);
          setFailStatus(_this);
        }
      }
      else{
        if (count > 0){
          unsetFailStatus(_this);
          hideErrorMessage(_this);
          if (count >= min && count <= max) {
            $.ajax({
              url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
              method: 'POST',
              dataType: "json",
              data: {"name": name, "value": value},
              success: function (data) {
                if (data['status'] === 'success') {
                  if (name === 'showParticipation') {
                    _this.parent().find('label').addClass('label-success');
                    setTimeout(function () {
                      _this.parent().find('label').removeClass('label-success');
                    }, 2000);
                  }
                  else if (name === 'fee' && value === '0'){
                    _this.html(data.msg);
                    $('.edit-conference-price').val('');
                    setTimeout(function () {
                      _this.html('');
                    }, 2000);
                  }
                  else if(name === 'organizingInstitutions'){
                    $('#collapse-organizing').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if(name === 'confLocation'){
                    $('#collapse-location').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'confTitle'){
                    $('#confTitleEditBasic').html(value);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'abstract' || name === 'programme' || name === 'LOC' || name === 'SOC' ||
                    name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' ||
                    name === 'hotelInfos' || name === 'travelInformation' || name === 'registrationPayment'){
                    $('#collapse-' + name).collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else {
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                } else {
                  setFailStatus(_this);
                  showErrorMessage(_this, data['msg'])
                }
              }
            });
          }
          else{
            msg = 'Please enter a valid ' + placeholder;
            showErrorMessage(_this, msg);
            setFailStatus(_this);
          }
        }
        else{
          msg = 'The ' + placeholder + ' field is required.';
          showErrorMessage(_this, msg);
          setFailStatus(_this);
        }
      }
    }
    else {
      if (length){
        if (length > 0) {
          unsetFailStatus(_this);
          hideErrorMessage(_this);
          if (length >= min && length <= max) {
            $.ajax({
              url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
              method: 'POST',
              dataType: "json",
              data: {"name": name, "value": value},
              success: function (data) {
                if (data['status'] === 'success') {
                  if (name === 'showParticipation') {
                    _this.parent().find('label').addClass('label-success');
                    setTimeout(function () {
                      _this.parent().find('label').removeClass('label-success');
                    }, 2000);
                  }
                  else if (name === 'fee' && value === '0'){
                    _this.html(data.msg);
                    $('.edit-conference-price').val('');
                    setTimeout(function () {
                      _this.html('');
                    }, 2000);
                  }
                  else if(name === 'organizingInstitutions'){
                    $('#collapse-organizing').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if(name === 'confLocation'){
                    $('#collapse-location').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'confTitle'){
                    $('#confTitleEditBasic').html(value);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'abstract' || name === 'programme' || name === 'LOC' || name === 'SOC' ||
                    name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' ||
                    name === 'hotelInfos' || name === 'travelInformation' || name === 'registrationPayment'){
                    $('#collapse-' + name).collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else {
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                } else {
                  setFailStatus(_this);
                  showErrorMessage(_this, data['msg'])
                }
              }
            });
          }
          else{
            msg = 'Please enter a valid ' + placeholder;
            showErrorMessage(_this, msg);
            setFailStatus(_this);
          }
        }
        else{
          unsetFailStatus(_this);
          hideErrorMessage(_this);
          $.ajax({
            url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
            method: 'POST',
            dataType: "json",
            data: {"name": name, "value": value},
            success: function (data) {
              if (data['status'] === 'success') {
                if (name === 'showParticipation') {
                  _this.parent().find('label').addClass('label-success');
                  setTimeout(function () {
                    _this.parent().find('label').removeClass('label-success');
                  }, 2000);
                }
                else if (name === 'fee' && value === '0'){
                  _this.html(data.msg);
                  $('.edit-conference-price').val('');
                  setTimeout(function () {
                    _this.html('');
                  }, 2000);
                }
                else if(name === 'organizingInstitutions'){
                  $('#collapse-organizing').collapse('hide');
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
                else if(name === 'confLocation'){
                  $('#collapse-location').collapse('hide');
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
                else if (name === 'confTitle'){
                  $('#confTitleEditBasic').html(value);
                  setSuccessStatus(_this);
                }
                else if (name === 'abstract' || name === 'programme' || name === 'LOC' || name === 'SOC' ||
                  name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' ||
                  name === 'hotelInfos' || name === 'travelInformation' || name === 'registrationPayment'){
                  $('#collapse-' + name).collapse('hide');
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
                else {
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
              } else {
                setFailStatus(_this);
                showErrorMessage(_this, data['msg'])
              }
            }
          });
        }
      }
      else{
        if (count > 0) {
          unsetFailStatus(_this);
          hideErrorMessage(_this);
          if (count >= min && count <= max) {
            $.ajax({
              url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
              method: 'POST',
              dataType: "json",
              data: {"name": name, "value": value},
              success: function (data) {
                if (data['status'] === 'success') {
                  if (name === 'showParticipation') {
                    _this.parent().find('label').addClass('label-success');
                    setTimeout(function () {
                      _this.parent().find('label').removeClass('label-success');
                    }, 2000);
                  }
                  else if (name === 'fee' && value === '0'){
                    _this.html(data.msg);
                    $('.edit-conference-price').val('');
                    setTimeout(function () {
                      _this.html('');
                    }, 2000);
                  }
                  else if(name === 'organizingInstitutions'){
                    $('#collapse-organizing').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if(name === 'confLocation'){
                    $('#collapse-location').collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'confTitle'){
                    $('#confTitleEditBasic').html(value);
                    setSuccessStatus(_this);
                  }
                  else if (name === 'abstract' || name === 'programme' || name === 'LOC' || name === 'SOC' ||
                    name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' ||
                    name === 'hotelInfos' || name === 'travelInformation' || name === 'registrationPayment'){
                    $('#collapse-' + name).collapse('hide');
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                  else {
                    unsetFailStatus(_this);
                    setSuccessStatus(_this);
                  }
                } else {
                  setFailStatus(_this);
                  showErrorMessage(_this, data['msg'])
                }
              }
            });
          }
          else{
            msg = 'Please enter a valid ' + placeholder;
            showErrorMessage(_this, msg);
            setFailStatus(_this);
          }
        }
        else{
          unsetFailStatus(_this);
          hideErrorMessage(_this);
          $.ajax({
            url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
            method: 'POST',
            dataType: "json",
            data: {"name": name, "value": value},
            success: function (data) {
              if (data['status'] === 'success') {
                if (name === 'showParticipation') {
                  _this.parent().find('label').addClass('label-success');
                  setTimeout(function () {
                    _this.parent().find('label').removeClass('label-success');
                  }, 2000);
                }
                else if (name === 'fee' && value === '0'){
                  _this.html(data.msg);
                  $('.edit-conference-price').val('');
                  setTimeout(function () {
                    _this.html('');
                  }, 2000);
                }
                else if(name === 'organizingInstitutions'){
                  $('#collapse-organizing').collapse('hide');
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
                else if(name === 'confLocation'){
                  $('#collapse-location').collapse('hide');
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
                else if (name === 'confTitle'){
                  $('#confTitleEditBasic').html(value);
                  setSuccessStatus(_this);
                }
                else if (name === 'abstract' || name === 'programme' || name === 'LOC' || name === 'SOC' ||
                  name === 'keynoteSpeakers' || name === 'venue' || name === 'importantDates' ||
                  name === 'hotelInfos' || name === 'travelInformation' || name === 'registrationPayment'){
                  $('#collapse-' + name).collapse('hide');
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
                else {
                  unsetFailStatus(_this);
                  setSuccessStatus(_this);
                }
              } else {
                setFailStatus(_this);
                showErrorMessage(_this, data['msg'])
              }
            }
          });
        }
      }
    }
  }

  $('#free_conference').on('click', function () {
    var _this = $('#free_conference_status');
    var id = $('#get_id_conference').val();
    editConference(_this, id, 'fee', '0');
  });

  function editConference(_this, id, name, value) {
    $.ajax({
      url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit/" + id,
      method: 'POST',
      dataType: "json",
      data: {"name": name, "value": value},
      success: function (data) {
        if (data['status'] === 'success') {
          if (name === 'showParticipation') {
            _this.parent().find('label').addClass('label-success');
            setTimeout(function () {
              _this.parent().find('label').removeClass('label-success');
            }, 2000);
          }
          else if (name === 'fee' && value === '0'){
            _this.html(data.msg);
            $('.edit-conference-price').val('');
            setTimeout(function () {
              _this.html('');
            }, 2000);
          }
          else {
            unsetFailStatus(_this);
            setSuccessStatus(_this);
          }
        } else {
          setFailStatus(_this);
        }
      }
    });
  }

  function setSuccessStatus(_this) {
    _this.addClass('field-success');
    setTimeout(function () {
      _this.removeClass('field-success');
    }, 2000);
  }

  function showErrorMessage(_this, msg) {
    _this.parent().find('.error').html(msg);
    // setTimeout(function () {
    // location.reload();
    // }, 2000);
  }

  function hideErrorMessage(_this) {
    _this.parent().find('.error').html('');
  }

  function setFailStatus(_this) {
    _this.addClass('field-error');
    // setTimeout(function () {
    //   _this.removeClass('field-error');
    // }, 2000);
  }

  function unsetFailStatus(_this) {
    _this.removeClass('field-error');
    _this.parent().find('.error').html('');
  }

  $('.edit-category').change(function () {
    var name = 'category';
    var id = $('#get_id_conference').val();
    var idCategory = $(this).val();
    var _this = $('.input-main-category');
    $('#get_id_category').val(idCategory);
    $.ajax({
      url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit-category/" + id,
      method: 'POST',
      dataType: "json",
      data: {"name": name, "value": idCategory},
      success: function (data) {
        if (data['status'] === 'success') {
          setSuccessStatus(_this);
          $('#set_category').html(data['msg'][0]);
          $('#set_sub_category').html(data['msg'][1]);
          $('#get_id_subcategory').val(data['msg'][2]);
        } else {
          setFailStatus(_this);
        }
      }
    });
  });

  $('.edit-subcategory').change(function () {
    var name = 'subcategory';
    var value = $('#sub_category').val();
    var id = $('#get_id_conference').val();
    var _thisShow = $('.input-main-category');
    var _this = $(this);
    $.ajax({
      url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit-category/" + id,
      method: 'POST',
      dataType: "json",
      data: {"name": name, "value": value},
      success: function (data) {
        if (data['status'] === 'success') {
          _thisShow.removeClass('field-error');
          setSuccessStatus(_thisShow);
          $('#set_sub_category').html(data['msg'][0]);
          $('#get_id_subcategory').val(data['msg'][1]);
          _this.parent().find('.select2-selection').removeClass('field-error');
          showErrorMessage(_this, '');
        } else {
          setFailStatus(_thisShow);
          _this.parent().find('.select2-selection').addClass('field-error');
          showErrorMessage(_this, data['msg']);
        }
      }
    });
  });

  $('.edit-alt-category').change(function () {
    var name = 'altCategory1';
    var id = $('#get_id_conference').val();
    var idCategory = $(this).val();
    var _this = $('.input-alt-category');
    $('#get_id_alt_category').val(idCategory);
    $.ajax({
      url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit-category/" + id,
      method: 'POST',
      dataType: "json",
      data: {"name": name, "value": idCategory},
      success: function (data) {
        if (data['status'] === 'success') {
          setSuccessStatus(_this);
          $('#get_id_alt_subcategory').val(data['msg'][2]);
          if (data['msg'] === '') {
            $('#set_alt_category').html('');
            $('#set_alt_subcategory').html('');
          } else {
            $('#set_alt_category').html(data['msg'][0]);
            $('#set_alt_subcategory').html(' (' + data['msg'][1] + ')');
          }
        } else {
          setFailStatus(_this);
        }
      }
    });
  });

  $('.edit-alt-subcategory').change(function () {
    var name = 'altSubCategory1';
    var value = $('#alt_sub_category').val();
    var id = $('#get_id_conference').val();
    var _thisShow = $('.input-alt-category');
    var _this = $(this);
    $.ajax({
      url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit-category/" + id,
      method: 'POST',
      dataType: "json",
      data: {"name": name, "value": value},
      success: function (data) {
        if (data['status'] === 'success') {
          _thisShow.removeClass('field-error');
          setSuccessStatus(_this);
          $('#set_alt_subcategory').html(' (' + data['msg'][0] + ')');
          $('#get_id_alt_subcategory').val(data['msg'][1]);
          _this.parent().find('.select2-selection').removeClass('field-error');
          showErrorMessage(_this, '');
        } else {
          setFailStatus(_thisShow);
          _this.parent().find('.select2-selection').addClass('field-error');
          showErrorMessage(_this, data['msg']);
        }
      }
    });
  });

  //convert date dd.mm.yyyy to int
  function convertDate(dateValue){
    var result = '';
    if (dateValue !== ''){
      var date = dateValue.split(".");
      var newDate = date[1] + "/" + date[0] + "/" + date[2];
      result = new Date(newDate).getTime() / 1000.0 + 7 * 60 * 60;
    }
    return result;
  }

  function convertEndDate(dateValue){
    var result = '';
    if (dateValue !== ''){
      var date = dateValue.split(".");
      var newDate = date[1] + "/" + date[0] + "/" + date[2];
      result = new Date(newDate).getTime() / 1000.0 + 23 * 60 * 60 + 59 * 60;
    }
    return result;
  }

  //remove conference session
  $('.btn_remove_session').click(function () {
    var _this = $(this).parent();
    var session_id = _this.attr('id');
    if (session_id !== '') {
      if (confirm("Do you really want to delete this session?")) {
        $.ajax({
          url: base_url + "/auth/conference/managed/conference-edit/basic-information/remove-session",
          method: 'POST',
          dataType: "json",
          data: {"session_id": session_id},
          success: function (data) {
            if (data['status'] === 'success') {
              location.reload();
            } else {
              showErrorMessage(_this, data['msg']);
            }
          }
        });
      }
    }
  });

  //add conference session
  $('#btn_add_session').click(function () {
    // $('#show_add_session').removeClass('d-none');
    $('#session_conference_list').append(
      '<div id="form_item_add_session" class="form-item input-group">' +
      '<input type="text" class="input input-custom add-session input-session-name" placeholder="Session name" value="unnamedSession"/>' +
      '<div class="input-group-append">' +
      '<span class="btn_remove_input_add_session icon-cancel input-group-text"></span>' +
      '</div>' +
      '<div class="error"></div>' +
      '</div>'
    );
    // $(this).parent().addClass('d-none');
    // $('#btn_submit_add_session').parent().removeClass('d-none');
  });

  $('#session_conference_list').on('click', '.btn_remove_input_add_session', function () {
    $(this).parents('#form_item_add_session').remove();
    // $('#btn_submit_add_session').parent().addClass('d-none');
    // $('#btn_add_session').parent().removeClass('d-none');
  });

  $('#btn_submit_add_session').on('click', function () {
    var cid = $('#get_cid_conference').val();
    var session_name = $('#input_add_session').val().trim();
    if (session_name === '') {
      var placeholder = $('#input_add_session').attr('placeholder');
      var msg = 'The ' + placeholder + ' field is required.';
      showErrorMessage($('#input_add_session'), msg);
    } else {
      $.ajax({
        url: base_url + "/auth/conference/managed/conference-edit/basic-information/add-session",
        method: 'POST',
        dataType: "json",
        data: {"session_name": session_name, "cid": cid},
        success: function (msg) {
          if (msg === 'success') {
            location.reload();
          }
        }
      });
    }
  });

  $('#btn_submit_update_session').on('click', function () {
    var check = 1;
    var cid = $('#get_cid_conference').val();
    var sessionList = [];
    $(".input-session-name").each(function(){
      var session = {id:"", name:""};
      var sessionID = $(this).attr('id');
      var sessionName = $(this).val();
      var msg = null;
      if (sessionID === undefined){
        sessionID = null;
      }
      if (sessionName === '') {
        check = 0;
        msg = 'The session name field is required';
        showErrorMessage($(this), msg);
      }
      else if(sessionName.length > 5000){
        check = 0;
        msg = 'Please enter a valid Sessions';
        showErrorMessage($(this), msg);
      }
      session.id = sessionID;
      session.name = sessionName;
      sessionList.push(session);
    });
    sessionList = JSON.stringify(sessionList);
    if (check) {
      $.ajax({
        url: base_url + "/auth/conference/managed/conference-edit/basic-information/update-session",
        method: 'POST',
        dataType: "json",
        data: {"sessionList": sessionList, "cid": cid},
        success: function (msg) {
          if (msg === 'success') {
            location.reload();
          }
        }
      });
    }
  });

  //edit conference session
  // $('.input-session-name').on('change', function () {
  //   var _this = $(this);
  //   var session_name = _this.val().trim();
  //   var id = _this.attr('id');
  //   if (session_name === '') {
  //     var placeholder = _this.attr('placeholder');
  //     var msg = 'The ' + placeholder + ' field is required.';
  //     showErrorMessage(_this, msg);
  //   } else {
  //     $.ajax({
  //       url: base_url + "/auth/conference/managed/conference-edit/basic-information/edit-session",
  //       method: 'POST',
  //       dataType: "json",
  //       data: {"session_name": session_name, "id": id},
  //       success: function (msg) {
  //         if (msg === 'success') {
  //           setSuccessStatus(_this);
  //           location.reload();
  //         }
  //       }
  //     });
  //   }
  // });

  //invite co-author
  //check email co-author
  $('#btn_set_permission_coauthor').on('click', function () {
    var email = $('#input_email_coauthor').val().trim();
    var confID = $('#get_id_conference').val();
    if (email === '') {
      setFailStatus($('#input_email_coauthor'));
      $('#input_email_coauthor').parent().find('.error').html('The co-authors\'s email field is required.');
    } else {
      var coAuthorArr = coAuthor.listCoAuthor();
      var checkExist = 0;
      for (var i in coAuthorArr) {
        if (email === coAuthorArr[i].email) {
          checkExist = 1;
        }
      }
      if (checkExist) {
        setFailStatus($('#input_email_coauthor'));
        $('#input_email_coauthor').parent().find('.error').html('This email has been added.');
      } else if (coAuthorArr.length > 19) {
        setFailStatus($('#input_email_coauthor'));
        $('#input_email_coauthor').parent().find('.error').html('You can only send invitations to up to 20 co-authors at the same time.');
      } else {
        $.ajax({
          url: base_url + "/auth/conference/managed/conference-edit/basic-information/check-valid-email-co-author",
          method: 'POST',
          dataType: "json",
          data: {"email": email, "confID": confID},
          success: function (data) {
            if (data['status'] === 'success') {
              $('#permission').modal('show');
              $('#btn_submit_permission_co_author').removeClass('d-none');
              unsetFailStatus($('#input_email_coauthor'));
            } else {
              setFailStatus($('#input_email_coauthor'));
              $('#input_email_coauthor').parent().find('.error').html(data['msg']);
            }
          }
        });
      }
    }
  });

  //set permission
  if (coAuthor.listCoAuthor().length !== 0) {
    coAuthor.clearCoAuthor();
  }
  $('#btn_submit_permission_co_author').on('click', function () {
    var permissionsList = [];
    var email = $('#input_email_coauthor').val();
    $('.input-permission').each(function () {
      if ($(this).is(':checked')) {
        var permission = $(this).val();
        permissionsList.push(permission);
      }
    });
    if (permissionsList.length < 1) {
      $('.error-choose-permission').html('Please choose at least one option');
    } else {
      $('.error-choose-permission').html('');
      $('.error-email-coauthor').html('');
      var id = Date.now();
      coAuthor.addItemToCoAuthor(id, email, permissionsList);
      var coAuthorArr = coAuthor.listCoAuthor();
      appendCoAuthorArr(coAuthorArr);
      $('#input_email_coauthor').val('');
      $('#permission').modal('hide');
    }
  });

  function appendCoAuthorArr(coAuthorArr) {
    $('#list_set_permission_coauthor').html('');
    if($('#btn_send_email_invite_coauthor').hasClass('d-none')){
      $('#btn_send_email_invite_coauthor').removeClass('d-none');
    }
    for (var i in coAuthorArr) {
      $('#list_set_permission_coauthor').append(
        '<div id="set_permission_coauthor_' + i + '">' +
        '<div class="gr-form-item">' +
        '<div class="form-item">' +
        '<input type="text" class="input input-custom readonly-custom" readonly value="' + coAuthorArr[i].email + '"/>' +
        '</div>' +
        '<div class="form-item">' +
        '<div class="permission-co-author"></div>' +
        '</div>' +
        '</div>'
      );
      var permissions = coAuthorArr[i].permissions;
      for (var j in permissions) {
        $('#list_set_permission_coauthor #set_permission_coauthor_' + i + ' .permission-co-author').append(
          permissions[j] + '<br> '
        );
      }
    }
  }

  $('#btn_submit_permission_coauthor').on('click', function () {
    var coAuthorArr = coAuthor.listCoAuthor();
    var confID = $('#get_id_conference').val();
    var coAuthors = JSON.stringify(coAuthorArr);
    if (coAuthorArr.length > 0) {
      $.ajax({
        url: base_url + "/auth/conference/managed/conference-edit/basic-information/set-permission-co-author",
        method: 'POST',
        dataType: "json",
        data: {"confID": confID, "coAuthors": coAuthors},
        success: function (data) {
          if (data['status'] === 'success') {
            location.reload();
          }
        }
      });
    }
  });

  //resend mail invite co-author
  $('.btn-resend-invite-co-author').on('click', function () {
    var id = $(this).attr('data');
    $.ajax({
      url: base_url + "/auth/invite-co-author/resend",
      method: 'POST',
      dataType: "json",
      data: {"id": id},
      success: function (data) {
        if (data['status'] === 'success') {
          location.reload();
          // alert('Sent successfully!');
        }
      }
    });
  });

  //remove co-author
  $('.btn-remove-co-author').on('click', function () {
    var id = $(this).attr('data');
    if (confirm("Do you really want to delete this co-author?")) {
      $.ajax({
        url: base_url + "/auth/invite-co-author/remove",
        method: 'POST',
        dataType: "json",
        data: {"id": id},
        success: function (data) {
          if (data['status'] === 'success') {
            location.reload();
          }
        }
      });
    }
  });

  //show permission co-author
  $('.btn-show-permission-co-author').on('click', function () {
    var _this = $(this);
    var id = _this.attr('data');
    $.ajax({
      url: base_url + "/auth/invite-co-author",
      method: 'POST',
      dataType: "json",
      data: {"id": id},
      success: function (data) {
        if (data['status'] === 'success') {
          for (var i in data['msg']) {
            $('.input-permission').each(function () {
              if ($(this).attr('id') == data['msg'][i]) {
                $(this).prop('checked', true);
              }
            });
          }
          $('#permission').modal('show');
          $('#btn_change_permission_co_author').removeClass('d-none');
          $('#getConfPermissionID').val(id);
        }
      }
    });
  });

  //update permission co-author
  $('#btn_change_permission_co_author').on('click', function () {
    var permissionsList = [];
    var confPermissionID = $('#getConfPermissionID').val();
    $('.input-permission').each(function () {
      if ($(this).is(':checked')) {
        var permission = $(this).val();
        permissionsList.push(permission);
      }
    });
    if (permissionsList.length < 1) {
      $('.error-choose-permission').html('Please choose at least one option');
    } else {
      $('.error-choose-permission').html('');
      $('.error-email-coauthor').html('');
      $.ajax({
        url: base_url + "/auth/invite-co-author/update",
        method: 'POST',
        dataType: "json",
        data: {"confPermissionID": confPermissionID, "permissions": permissionsList},
        success: function (data) {
          if (data['status'] === 'success') {
            $('#permission').modal('hide');
            location.reload();
          }
        }
      });
    }
  });

  $('#permission').on('hidden.bs.modal', function (e) {
    $('.input-permission').each(function () {
      if ($(this).is(':checked')) {
        $(this).prop('checked', false);
      }
    });
  });

  //conference upload file
  $('.edit-conference-upload-file').change(function (e) {
    var fileName = e.target.files[0].name;
    // var fileSize = e.target.files[0].size;
    $(this).parents('.upload-area').find('.upload-info').append(
      '<input type="hidden" name="get-file-name" value="' + fileName + '"></div>'
    );
    $(this).parents('.upload-area').find('.file-name').val(fileName);
    $(this).parents('.upload-area').find('.upload-info').removeClass('d-none');
    $(this).parents('.upload-area').find('.btn-submit-upload-file').removeClass('d-none');
  });

  $('.form-upload-file').submit(function (e) {
    e.preventDefault();
    var name = $(this).find('.edit-conference-upload-file').attr('name');
    var id = $('#get_id_conference').val();
    var _this = $(this);
    $.ajax({
      url: base_url + "/auth/conference/managed/conference-edit/file-upload/upload/" + id + '/' + name,
      method: 'POST',
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      async: false,
      dataType: 'json',
      success: function (data) {
        if (data.status === 'fail') {
          _this.find('.error').html(data.msg);
        } else {
          location.reload();
        }
      }
    });
  });

  $('.btn-remove-upload').on('click', function () {
    $(this).parents('.detail-item-upload').find('.upload-info').addClass('d-none');
    $(this).parents('.detail-item-upload').find('.btn-upload').addClass('d-none');
  });

  // $('.btn-border.green').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-border.green').mouseout(function () {
  //   $(this).removeClass('hover');
  // });

  // $('.btn-bg.green').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-bg.green').mouseout(function () {
  //   $(this).removeClass('hover');
  // });
  // $('.btn-bg.dark-green').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-bg.dark-green').mouseout(function () {
  //   $(this).removeClass('hover');
  // });
  // $('.btn-bg.white').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-bg.white').mouseout(function () {
  //   $(this).removeClass('hover');
  // });
  // $('.btn-border.gray').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-border.gray').mouseout(function () {
  //   $(this).removeClass('hover');
  // });

  // $('.btn-bg.gray').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-bg.gray').mouseout(function () {
  //   $(this).removeClass('hover');
  // });

  // $('.btn-upload-file').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('.btn-upload-file').mouseout(function () {
  //   $(this).removeClass('hover');
  // });

  // $('a.link').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('a.link').mouseout(function () {
  //   $(this).removeClass('hover');
  // });

  // $('span.link').mouseover(function () {
  //   $(this).addClass('hover');
  // });
  // $('span.link').mouseout(function () {
  //   $(this).removeClass('hover');
  // });

  $('.profile-sidebar-item-content').mouseover(function () {
    $(this).addClass('hover');
  });
  $('.profile-sidebar-item-content').mouseout(function () {
    $(this).removeClass('hover');
  });
  $('.project-sidebar-item-content').mouseover(function () {
    $(this).addClass('hover');
  });
  $('.project-sidebar-item-content').mouseout(function () {
    $(this).removeClass('hover');
  });

  $('.sidebar-item').mouseover(function () {
    $(this).addClass('hover');
  });
  $('.sidebar-item').mouseout(function () {
    $(this).removeClass('hover');
  });

  $('.top-header-content-item').mouseover(function () {
    $(this).addClass('hover');
  });
  $('.top-header-content-item').mouseout(function () {
    $(this).removeClass('hover');
  });

  //show conference in db
  if (href.lastIndexOf('/link-to-conference/') !== -1 ||
    href.lastIndexOf('/upload') !== -1 ||
    href.lastIndexOf('/register/conference/') !== -1) {
    var all_cid = $('#get_all_cid').val().split('|,|');
    $(".get-all-cid").typeahead({
      source: all_cid,
      autoSelect: true,
      items: 'all'
    });
  }
  // $input.change(function() {
  // var current = $input.typeahead("getActive");
  // if (current) {
  //   // Some item from your model is active!
  //   if (current.name == $input.val()) {
  //     // This means the exact match is found. Use toLowerCase() if you want case insensitive match.
  //   } else {
  //     // This means it is only a partial match, you can either add a new item
  //     // or take the active if you don't want new items
  //   }
  // } else {
  //   // Nothing is active so it is a new value (or maybe empty value)
  // }
  // });

  //link to conference
  $('#btn_next_link_to_conference').on('click',function () {
    var _thisCID = $('#get_cid');
    var cid = _thisCID.val();
    var postID = $('#postID').val();
    var postType = $('#postType').val();

    if (cid === ''){
      setFailStatus(_thisCID);
      showErrorMessage(_thisCID, 'The CID field is required.');
    }
    else{
      $.ajax({
        type: 'POST',
        url: base_url + '/auth/conference/get-session-conference',
        data: {cid: cid, postID: postID, postType: postType},
        dataType: "json",
        success: function (data) {
          if (data.status === 'connected') {
            $('#btn_add_link_to_conference').addClass('d-none');
            $('#btn_next_link_to_conference').removeClass('d-none');
            setFailStatus(_thisCID);
            var msg = 'This ' + postType + ' is already connected with that conference.';
            showErrorMessage(_thisCID, msg);
          }
          else if (data.status === 'success') {
            unsetFailStatus(_thisCID);
            showErrorMessage(_thisCID, '');
            $('#get_session_cid').html(data.content);
            _thisCID.prop('readonly', true);
            $('.select-custom-choose-session').select2({
              minimumResultsForSearch: -1,
            });
            $('.session-link-to-conference').removeClass('d-none');
            $('#btn_next_link_to_conference').addClass('d-none');
            $('#btn_add_link_to_conference').removeClass('d-none');
          }
          else {
            $('#btn_add_link_to_conference').addClass('d-none');
            $('#btn_next_link_to_conference').removeClass('d-none');
            setFailStatus(_thisCID);
            showErrorMessage(_thisCID, 'Please enter a valid Conference ID');
          }
        }
      });
    }
  });

  $('#btn_add_link_to_conference').on('click', function () {
    var _this = $(this);
    var cid = _this.parent().find('#get_cid').val();
    var sessionID = _this.parent().find('#get_session_cid').val();
    var postType = _this.parent().find('#postType').val();
    var postID = _this.parent().find('#postID').val();
    var sharePublic = 1;
    if ($('#closeAccess').is(':checked')){
      sharePublic = 0;
    }
    $.ajax({
      url: base_url + '/auth/conference/link-to-conference',
      method: "POST",
      dataType: "json",
      data: {"cid": cid, "sessionID": sessionID, "postType": postType, "postID": postID, "sharePublic": sharePublic},
      success: function (data) {
        if (data.status === 'success'){
          $('.spinner-block').addClass('d-none');
          reloadNotificationModal();
          showNotificationModal('success', data.msg);
        }
        else{
          alert('Error, please check again!');
        }
      }
    })
  });

  $('.upload-content-item').on('click', function () {
    var postType = $(this).attr('data-href');
    var cid = $('#get_cid_conference').val();
    $.ajax({
      url: base_url + '/auth/conference/upload-content',
      method: "POST",
      dataType: "json",
      data: {"cid": cid},
      success: function (data) {
        if (data.status === 'success'){
          location.href = base_url + '/auth/content/' + postType + '/upload';
        }
      }
    })
  });

  $('.get-cid-upload').on('change', function () {
    var _thisCID = $('#get_cid');
    var cid = _thisCID.val();
    var postType = $('#postType').val();

    if (cid === ''){
      setFailStatus(_thisCID);
      showErrorMessage(_thisCID, 'The CID field is required.');
      $('#get_session_cid').html('');
    }
    else{
      $.ajax({
        type: 'POST',
        url: base_url + '/auth/conference/get-session-conference/upload-content',
        data: {cid: cid, postType: postType},
        dataType: "json",
        success: function (data) {
          if (data.status === 'success') {
            unsetFailStatus(_thisCID);
            showErrorMessage(_thisCID, '');
            $('#get_session_cid').html(data.content);
            $('.select-custom-choose-session').select2({
              minimumResultsForSearch: -1,
            });
            $('.session-link-to-conference').removeClass('d-none');
          }
          else {
            setFailStatus(_thisCID);
            showErrorMessage(_thisCID, 'Please enter a valid Conference ID');
          }
        }
      });
    }
  });

  //manage contributions
  $('#table_contributions').DataTable({
    "columnDefs": [
      { "targets": [2,3], "searchable": false }
    ],
    "scrollX": true,
    "language": {
      searchPlaceholder: "Search",
      paginate: {
        next: '<span class="icon-chevron-circle-right"></span>',
        previous: '<span class="icon-chevron-circle-left"></span>'
      }
    },
    "pagingType": "full_numbers"
  });
  $('#table_contributions').on('change', '.select-session-element', function () {
    var _this = $(this);
    var elementID = _this.attr('data-id');
    var sessionID = _this.val();

    $.ajax({
      url: base_url + '/auth/conference/managed/manage-contribution/updateSession',
      method: "POST",
      dataType: "json",
      data: {"elementID": elementID, "sessionID": sessionID},
      success: function (data) {
        if (data.status === 'success') {
          showNotificationModal('success', 'Update successfully!');
        }
        else{
          alert('Fail to update!');
        }
      }
    });
  });

  $('#table_contributions').on('click', '.btn-delete-element', function () {
    var _this = $(this);
    var elementID = _this.attr('data-id');
    var postTitle = _this.attr('data-title');
    var title = 'Do you want to delete ' + postTitle + ' ?'
    $('#elementID').val(elementID);
    $('#titleModalDeleteElement').text(title);
    $('#modalDeleteElement').modal('show');
  });

  $('#btnSubmitDeleteElement').on('click', function () {
    var _thisModal = $(this).parents('#modalDeleteElement');
    var elementID = _thisModal.find('#elementID').val();

    $.ajax({
      url: base_url + '/auth/conference/managed/manage-contribution/delete',
      method: "POST",
      dataType: "json",
      data: {"elementID": elementID},
      success: function (data) {
        if (data.status === 'success') {
          $('.spinner-block').addClass('d-none');
          _thisModal.modal('hide');
          reloadNotificationModal();
          showNotificationModal('success', 'Delete successfully!');
        }
        else{
          alert('Fail to delete!');
        }
      }
    });
  });

  // $('#get_cid_register_conference').change(function () {
  //   var get_cid = $('#get_cid');
  //   var cid = get_cid.val();
  //   $.ajax({
  //     type: 'GET',
  //     url: base_url + '/auth/conference/get-session-conference/' + cid,
  //     success: function (res) {
  //       if (res !== '') {
  //         $('.session-link-to-conference').removeClass('d-none');
  //         // $('#btn_add_link_to_conference').removeClass('d-none');
  //         $('#get_session_cid').html(res);
  //       } else {
  //         // $('#btn_add_link_to_conference').removeClass('d-none');
  //       }
  //     }
  //   });
  // });

  //register conference
  // $('#btn_next_register_conference').click(function () {
  //   var cid = $('#get_cid_register_conference').val().trim();
  //   if (cid !== '') {
  //     var _this = $(this);
  //     $.ajax({
  //       url: base_url + "/auth/conference/register/check-cid",
  //       method: 'POST',
  //       dataType: "json",
  //       data: {"cid": cid},
  //       success: function (data) {
  //         if (data.status === 'fail') {
  //           $('#register_conference_step_2').addClass('d-none');
  //           $('#register_conference_step_1').removeClass('d-none');
  //           setFailStatus($('#get_cid_register_conference'));
  //           showErrorMessage($('#get_cid_register_conference'), data.msg)
  //         } else {
  //           $('#register_conference_step_1').addClass('d-none');
  //           $('#set_cid_register_conference').val(cid);
  //           $('#register_conference_step_2').removeClass('d-none');
  //           $('.select-custom').select2();
  //         }
  //       }
  //     });
  //   }
  //   else{
  //     setFailStatus($('#get_cid_register_conference'));
  //     showErrorMessage($('#get_cid_register_conference'), 'Please enter a valid Conference ID');
  //   }
  // });

  $('.btn_submit_register_conference').on('click', function () {
    $.ajax({
      url: base_url + "/auth/conference/register/set-session-step-2",
      method: 'GET',
    });
  });

  $('.btn-register-conference').on('click', function () {
    $.ajax({
      url: base_url + "/auth/conference/register/unset-session-step-2",
      method: 'GET',
    });
  });

  $('#use_info_profile_register_conference').change(function () {
    var recName = '';
    var recStreet = '';
    var recCity = '';
    var recState = '';
    var recPostalCode = '';
    var recCountry = '';

    if (this.checked) {
      recName = $('#get_affiliation_register_conference').val();
      recStreet = $('#get_address_register_conference').val();
      recCity = $('#get_city_register_conference').val();
      recState = $('#get_state_register_conference').val();
      recPostalCode = $('#get_postalCode_register_conference').val();
      recCountry = $('#get_country_register_conference').val();
    }
    $('#set_affiliation_register_conference').val(recName);
    $('#set_address_register_conference').val(recStreet);
    $('#set_city_register_conference').val(recCity);
    $('#set_state_register_conference').val(recState);
    $('#set_postalCode_register_conference').val(recPostalCode);
    $('#set_country_register_conference').val(recCountry).trigger('change');
  });

  //submit abstract conference
  $('.btn-submit-abstract-conference').on('click', function () {
    var _this = $(this);
    if (!$(this).parent().hasClass('disabled')) {
      var talk = 0;
      var poster = 0;
      var title = $('.abstract-title').val();
      var coAuthors = $('.abstract-co-authors').val();
      var affiliations = $('.abstract-affiliations').val();
      var text = $('.abstract-text').val();
      var check = 1;
      if ($('.abstract-talk').is(':checked')){
        talk = 1;
      }
      if ($('.abstract-poster').is(':checked')){
        poster = 1;
      }
      if (title === ''){
        check = 0;
        setFailStatus($('.abstract-title'));
        showErrorMessage($('.abstract-title'), 'The title field is required.')
      }
      if (text === ''){
        check = 0;
        setFailStatus($('.abstract-text'));
        showErrorMessage($('.abstract-text'), 'The abstract text field is required.')
      }
      if (check === 1){
        $('.spinner-block').removeClass('d-none');
        var abstract = [talk, poster, title, coAuthors, affiliations, text];
        var CID = $('#get_cid_conference').val();
        var confID = $('#get_id_conference').val();
        $.ajax({
          url: base_url + "/auth/conference/abstract",
          method: 'POST',
          dataType: "json",
          data: {"abstract": abstract, "CID": CID, "confID": confID},
          success: function (data) {
            if (data['status'] === 'success') {
              if (_this.hasClass('auth')) {
                $('#submit_abstract_form').addClass('d-none');
                $('#submit_abstract_success').removeClass('d-none');
                $('.spinner-block').addClass('d-none');
              }
              else{
                window.location.href = base_url + "/conference/abstract/success/" + confID;
              }
            }
            else{
              alert('Spam');
              location.reload();
            }
          }
        });
      }
    }
  });

  $('.btn-reload-page').on('click', function () {
    location.reload();
  });

  //show registration detail
  $('#table_registration').on('click', '.show-registration-detail', function () {
    $('#registration-information-modal').html('');
    var id = $(this).attr('data-id');
    $.ajax({
      url: base_url + "/auth/conference/registration/get/" + id,
      method: 'GET',
      success: function (data) {
        if (data !== '') {
          $('#registration-information-modal').html(JSON.parse(data));
          $('#registration-information-modal').modal('show');
        }
      }
    });
  });

  //reject registration conference
  $('#table_registration').on('click', '.btn-remove-registration', function () {
    var id = $(this).attr('data-id');
    $('#reasonRejectRegistration').val('');
    unsetFailStatus($('#reasonRejectRegistration'));
    $('#get_id_registration').val(id);
    $('#reject_registration').modal('show');
  });

  $('#btn_submit_reject_registration').on('click', function () {
    var id = $('#get_id_registration').val();
    var reason = $('#reasonRejectRegistration').val();
    if (reason === ''){
      setFailStatus($('#reasonRejectRegistration'));
      showErrorMessage($('#reasonRejectRegistration'), 'The detail field is required.')
    }
    else {
      $.ajax({
        url: base_url + "/auth/conference/registration/reject",
        method: 'POST',
        dataType: "json",
        data: {"id": id, "reason": reason},
        success: function (data) {
          if (data.status === 'success') {
            reloadNotificationModal();
            showNotificationModal('success', 'Successful rejection!');
          }
          else{
            reloadNotificationModal();
            showNotificationModal('fail', 'Reject to fail!');
          }
        }
      });
    }
  });

  //send mail remind registration
  $('#table_registration').on('click', '.btn-remind-registration', function () {
    var id = $(this).attr('data-id');

    $.ajax({
      url: base_url + "/auth/conference/registration/remind",
      method: 'POST',
      dataType: "json",
      data: {"id": id},
      success: function (data) {
        if (data.status === 'success') {
          location.reload();
        }
        else{
          alert('Reject to fail!');
        }
      }
    });
  });

  //submit registration tool
  $('#btn_submit_registration_tool').on('click', function () {
    var check = 1;
    var registrationText = $('#registrationText').val();
    var startDate = convertDate($('#startDate').val());
    var endDate = convertEndDate($('#endDate').val());
    var registerForDinner = 0;
    var optionalCheckbox1 = $('#optionalCheckbox1').val();
    var optionalCheckbox2 = $('#optionalCheckbox2').val();
    var registrationTool = [];

    if ($('#registerForDinner').is(':checked')){
      registerForDinner = 1;
    }

    if (registrationText === '') {
      check = 0;
      setFailStatus($('#registrationText'));
      showErrorMessage($('#registrationText'), 'The note field is required.')
    }
    else {
      hideErrorMessage($('#registrationText'));
      unsetFailStatus($('#registrationText'));
    }

    if (startDate === '') {
      check = 0;
      setFailStatus($('#startDate'));
      showErrorMessage($('#startDate'), 'The Start of registration period field is required.')
    }
    else{
      unsetFailStatus($('#startDate'));
      hideErrorMessage($('#startDate'));
    }

    if (endDate === '') {
      check = 0;
      setFailStatus($('#endDate'));
      showErrorMessage($('#endDate'), 'The Deadline for registration field is required.')
    }
    else{
      unsetFailStatus($('#endDate'));
      hideErrorMessage($('#endDate'));
    }

    if (check === 1) {
      $('.spinner-block').removeClass('d-none');
      registrationTool = [registrationText, startDate, endDate, registerForDinner, optionalCheckbox1, optionalCheckbox2];
      var CID = $('#get_cid_conference').val();
      $.ajax({
        url: base_url + "/auth/conference/registration/tool",
        method: 'POST',
        dataType: "json",
        data: {"registrationTool": registrationTool, "CID": CID},
        success: function (data) {
          if (data['status'] === 'success') {
            location.reload();
          }
        }
      });
    }

  });

  //show abstract detail
  $('#table_approve_element').on('click', '.show-abstract-detail', function () {
    $('#abstract-information-modal').html('');
    var id = $(this).attr('data-id');
    $.ajax({
      url: base_url + "/auth/conference/abstract/get/" + id,
      method: 'GET',
      success: function (data) {
        if (data !== '') {
          $('#abstract-information-modal').html(JSON.parse(data));
          $('#abstract-information-modal').modal('show');
        }
      }
    });
  });

  //change type of abstract
  // $('.select-type-abstract').on('change', function () {
  //   var id = $(this).attr('data-id');
  //   var type = $(this).val();
  //
  //   $.ajax({
  //     url: base_url + "/auth/conference/abstract/change-type",
  //     method: 'POST',
  //     dataType: "json",
  //     data: {"id": id, "type": type},
  //     success: function (data) {
  //       if (data.status === 'success') {
  //         alert('Update successfully!');
  //       }
  //       else{
  //         alert('Fail to update!');
  //       }
  //     }
  //   });
  // });

  $('#table_approve_element').on('click', '.btn-edit-abstract', function () {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var firstName = $(this).attr('data-first-name');
    var lastName = $(this).attr('data-last-name');
    var title = $(this).attr('data-title');

    $('#id_abstract').val(id);
    $('#first_name_abstract').val(firstName);
    $('#last_name_abstract').val(lastName);
    $('#title_abstract').val(title);

    if (type === 'Poster'){
      $('#type_poster_abstract').prop("selected", true);
    }
    else{
      $('#type_talk_abstract').prop("selected", true);
    }

    $('#edit_abstract').modal('show');

    $('.select-custom-none-search').select2({
      minimumResultsForSearch: -1,
    });

  });

  $('#btn_submit_edit_abstract').on('click', function () {
    var type = $('#type_abstract').val();
    var id = $('#id_abstract').val();

    $.ajax({
      url: base_url + "/auth/conference/abstract/change-type",
      method: 'POST',
      dataType: "json",
      data: {"id": id, "type": type},
      success: function (data) {
        if (data.status === 'success') {
          location.reload();
        }
        else{
          alert('Fail to update!');
          location.reload();
        }
      }
    });
  });

  //reject abstract conference
  $('#table_approve_element').on('click', '.btn-remove-abstract', function () {
    var id = $(this).attr('data-id');
    $('#reasonRejectAbstract').val('');
    unsetFailStatus($('#reasonRejectAbstract'));
    $('#get_id_abstract').val(id);
    $('#reject_abstract').modal('show');
  });

  $('#btn_submit_reject_abstract').on('click', function () {
    var id = $('#get_id_abstract').val();
    var reason = $('#reasonRejectAbstract').val();
    if (reason === ''){
      setFailStatus($('#reasonRejectAbstract'));
      showErrorMessage($('#reasonRejectAbstract'), 'The detail field is required.')
    }
    else {
      $.ajax({
        url: base_url + "/auth/conference/abstract/reject",
        method: 'POST',
        dataType: "json",
        data: {"id": id, "reason": reason},
        success: function (data) {
          if (data.status === 'success') {
            reloadNotificationModal();
            showNotificationModal('success', 'Successful rejection!');
          }
          else{
            alert('Reject to fail!');
          }
        }
      });
    }
  });

  //submit abstract tool
  $('#btn_submit_abstract_tool').on('click', function () {
    var check = 1;
    var abstractSubmissionText = $('#abstractSubmissionText').val();
    var startDate = convertDate($('#startDate').val());
    var endDate = convertEndDate($('#endDate').val());
    var abstractTool = [];

    if (abstractSubmissionText === '') {
      check = 0;
      setFailStatus($('#abstractSubmissionText'));
      showErrorMessage($('#abstractSubmissionText'), 'The note field is required.')
    }
    else{
      unsetFailStatus($('#abstractSubmissionText'));
      hideErrorMessage($('#abstractSubmissionText'));
    }

    if (startDate === '') {
      check = 0;
      setFailStatus($('#startDate'));
      showErrorMessage($('#startDate'), 'The Start of registration period field is required.')
    }
    else{
      unsetFailStatus($('#startDate'));
      hideErrorMessage($('#startDate'));
    }

    if (endDate === '') {
      check = 0;
      setFailStatus($('#endDate'));
      showErrorMessage($('#endDate'), 'The Deadline for registration field is required.')
    }
    else{
      unsetFailStatus($('#endDate'));
      hideErrorMessage($('#endDate'));
    }

    if (check === 1) {
      $('.spinner-block').removeClass('d-none');
      abstractTool = [startDate, endDate, abstractSubmissionText];
      var CID = $('#get_cid_conference').val();
      $.ajax({
        url: base_url + "/auth/conference/abstract/tool",
        method: 'POST',
        dataType: "json",
        data: {"abstractTool": abstractTool, "CID": CID},
        success: function (data) {
          if (data['status'] === 'success') {
            location.reload();
          }
        }
      });
    }
  });

  //close collapse restrict access
  $('#closeCollapseRestrict').on('click', function () {
    $('#collapse-restricted').collapse('hide');
    $('#btnShowCollapseRestrict').removeClass('highlight');
  });

  //datepicker
  var newDate = new Date();
  var today = new Date(newDate.getFullYear(), newDate.getMonth(), newDate.getDate());


  // console.log($('#startDate').val());
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

  var minDate2 = $('.startDate').val();
  var maxDate2 = $('.endDate').val();
  $(".startDate").datepicker({
    endDate: maxDate2,
    todayHighlight: true
  })
    .on('changeDate', function (selected) {
      var min = new Date(selected.date.valueOf());
      $('.endDate').datepicker('setStartDate', min);
    });

  $(".endDate").datepicker({
    startDate: minDate2,
    todayHighlight: true
  })
    .on('changeDate', function (selected) {
      var max = new Date(selected.date.valueOf());
      $('.startDate').datepicker('setEndDate', max);
    });

  var minDate3 = $('#startDateSetToDay').val();
  var maxDate3 = $('#endDateSetToDay').val();
  $("#startDateSetToDay").datepicker({
    endDate: maxDate3,
    todayHighlight: true
  })
    .on('changeDate', function (selected) {
      var min = new Date(selected.date.valueOf());
      $('#endDateSetToDay').datepicker('setStartDate', min);
    });

  $("#endDateSetToDay").datepicker({
    startDate: minDate3,
    todayHighlight: true
  })
    .on('changeDate', function (selected) {
      var max = new Date(selected.date.valueOf());
      $('#startDateSetToDay').datepicker('setEndDate', max);
    });

  if ($('#startDateSetToDay').val() === '') {
    $('#startDateSetToDay').datepicker('setDate', today);
  }
  // if ($('#endDateSetToDay').val() === '') {
  //   $('#endDateSetToDay').datepicker('setDate', today);
  // }

  //ckeditor
  if (href.lastIndexOf('auth/conference/managed/conference-edit/basic-information/') > 0){
    CKEDITOR.replace('organizing');
    $('#btn_save_organizing').on('click', function () {
      var id = $('#get_id_conference').val();
      var name = 'organizingInstitutions';
      var value = CKEDITOR.instances["organizing"].getData();
      var length = (CKEDITOR.instances["organizing"].document.getBody().getText()).trim().length;
      var placeholder = 'Organizing institutions';
      $('#organizingInstitutions').html(value);
      var _this = $('#organizingInstitutions');
      editConference_Beta(_this, id, name, value, placeholder, true, 2, 5000, length);
    });

    CKEDITOR.replace('location');
    $('#btn_save_location').on('click', function () {
      var id = $('#get_id_conference').val();
      var name = 'confLocation';
      var value = CKEDITOR.instances["location"].getData();
      var length = (CKEDITOR.instances["location"].document.getBody().getText()).trim().length;
      var placeholder = 'Conference location';
      $('#confLocation').html(value);
      var _this = $('#confLocation');
      editConference_Beta(_this, id, name, value, placeholder, false, 2, 1000, length);
    });

    CKEDITOR.replace('abstract');
  }
  
  if (href.lastIndexOf('auth/conference/managed/conference-edit/optional-information/') > 0) {
    CKEDITOR.replace('programme');
    CKEDITOR.replace('LOC');
    CKEDITOR.replace('SOC');
    CKEDITOR.replace('keynoteSpeakers');
    CKEDITOR.replace('venue');
    CKEDITOR.replace('importantDates');
    CKEDITOR.replace('hotelInfos');
    CKEDITOR.replace('travelInformation');
    CKEDITOR.replace('registrationPayment');
  }

//edit conference
  $('.btn-save-content').on('click', function () {
    var _this = $(this);
    var id = $('#get_id_conference').val();
    var name = _this.attr('data-name');
    var button = _this.attr('data-button');
    var object = _this.attr('data-object');
    var value = CKEDITOR.instances[object].getData();
    var length = (CKEDITOR.instances[object].document.getBody().getText()).trim().length;
    var placeholder = _this.attr('data-placeholder');
    var _thisButton = $('#' + button);
    _thisButton.html(value);

    var min = 2;
    var max = 1000;
    var required = false;
    if (name === 'abstract' || name === 'registrationPayment'){
      max = 5000;
      required = true;
    }
    else if (name === 'programme'){
      max = 10000;
    }
    else if (name === 'LOC' || name === 'SOC' || name === 'keynoteSpeakers' || name === 'venue' ||
      name === 'importantDates' || name === 'hotelInfos'){
      max = 3000;
    }
    else if (name === 'travelInformation'){
      max = 5000;
    }

    editConference_Beta(_thisButton, id, name, value, placeholder, required, min, max, length);

  });

  $('.block-overview').on('click', '.add-comment-button', function () {
    $(".block-overview").animate({ scrollTop: 10000 }, 1000);
    var _this = $(this);
    if (!_this.hasClass('show')){
      _this.parent().find('.add-comment-textarea').removeClass('d-none');
      _this.addClass('show');
    }
    else{
      _this.parent().find('.add-comment-textarea').addClass('d-none');
      _this.removeClass('show');
    }
  });

  $('#btn_cancel_comment').on('click', function () {
    $('.add-comment-button').parent().find('.add-comment-textarea').addClass('d-none');
    $('.add-comment-button').removeClass('show');
  });

  CKEDITOR.replace('comment');

  $('#btn_save_comment').on('click', function () {
    var work_packageID = $('#work_package').val();
    var name = 'activities';
    var value = CKEDITOR.instances["comment"].getData();

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/add-content',
      dataType: "json",
      data: {"work_packageID": work_packageID, "name": name, "value": value},
      success: function (data) {
        if (data.status === 'success'){
          location.reload();
        }
      }
    });
  });

  $('.add-type-item').on('click', function () {
    var _this = $(this);
    var id = _this.attr('data-id');
    var name = _this.text();
    $('.btn-add-type').attr("data-id", id);
    $('.btn-add-type').text(name);
  });

  $('.add-status-item').on('click', function () {
    var _this = $(this);
    var id = _this.attr('data-id');
    var name = _this.text();
    $('.btn-add-status').attr("data-id", id);
    $('.btn-add-status').text(name);
  });

  $('.create-new-child').on('click', function () {
    if ($('.add-work-package').hasClass('d-none')){
      $('.add-work-package').removeClass('d-none');
      $(this).parent().addClass('d-none');
      $('.input-add-work-package').focus();
    }
    else{
      $('.add-work-package').addClass('d-none');
      $(this).parent().removeClass('d-none');
    }
  });

  $('.create-new-work-package').on('click', function () {
    if ($('.add-work-package').hasClass('d-none')){
      $('.row-create-work-package').addClass('d-none');
      $('.add-work-package').removeClass('d-none');
      $('.input-create-new-work-package').focus();
    }
    else{
      $('.add-work-package').addClass('d-none');
      $('.row-create-work-package').removeClass('d-none');
    }
  });

  $('.close-create-work-package').on('click', function () {
    $('.add-work-package').addClass('d-none');
    $('.row-create-work-package').removeClass('d-none');
    $('.input-create-new-work-package').val('');
  });

  $('.input-add-work-package').on('change', function () {
    var _this = $(this);
    var type =  $('.btn-add-type').attr('data-id');
    var status =  $('.btn-add-status').attr('data-id');
    var identifier = $('#work_package_identifier').val();
    var work_packageID = $('#work_package').val();
    var subject = _this.val();

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/add-content',
      dataType: "json",
      data: {
        "work_packageID": work_packageID,
        "name": 'createNewChild',
        "type": type,
        "status": status,
        "identifier": identifier,
        "subject": subject
      },
      success: function (data) {
        if (data.status === 'success'){
          reloadNotificationModal();
          showNotificationModal('success', 'Successful creation');
        }
        else{
          reloadNotificationModal();
          showNotificationModal('fail', data.msg);
        }
      }
    });
  });

  $('.input-add-work-package-custom').on('change', function () {
    var _this = $(this);
    var type =  _this.parent().parent().find('.btn-add-type').attr('data-id');
    var status =  _this.parent().parent().find('.btn-add-status').attr('data-id');
    var identifier = $('#work_package_identifier').val();
    var work_packageID = _this.attr('data-work_packageID');
    var subject = _this.val();

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/add-content',
      dataType: "json",
      data: {
        "work_packageID": work_packageID,
        "name": 'createNewChild',
        "type": type,
        "status": status,
        "identifier": identifier,
        "subject": subject
      },
      success: function (data) {
        if (data.status === 'success'){
          reloadNotificationModal();
          showNotificationModal('success', 'Successful creation');
        }
        else{
          reloadNotificationModal();
          showNotificationModal('fail', data.msg);
        }
      }
    });
  });

  $(".input-create-new-work-package").on('keypress', function (e) {
    var key = $(this).val().trim();
    if (key.length > 0) {
      if (e.keyCode === 13) {
        var _this = $(this);
        var identifier = $('#work_package_identifier').val();
        var subject = _this.val();

        $.ajax({
          type: 'POST',
          url: base_url + 'auth/project/add-content',
          dataType: "json",
          data: {
            "name": 'createTask',
            "type": 1,
            "status": 1,
            "identifier": identifier,
            "subject": subject
          },
          success: function (data) {
            if (data.status === 'success'){
              reloadNotificationModal();
              showNotificationModal('success', 'Successful creation');
            }
            else{
              reloadNotificationModal();
              showNotificationModal('fail', data.msg);
            }
          }
        });
      }
    } else {
      // $(this).unbind('keypress')
    }
  });

  $('.update-type-item').on('click', function () {
    var _this = $(this);
    updateWorkPackageType(_this);
  });

  $('.list-relations').on('click', '.update-type-item', function () {
    var _this = $(this);
    updateWorkPackageType(_this);
  });

  function updateWorkPackageType(_this){
    var work_packageID = _this.attr('data-work_packageID');
    var name = 'type';
    var value = _this.attr('data-id');
    var content = _this.text();

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/update-content',
      dataType: "json",
      data: {"work_packageID": work_packageID, "name": name, "value": value},
      success: function (data) {
        if (data.status === 'success'){
          _this.parents('td').find('button').text(content);
          $('#type_' + work_packageID).text(content);
          showNotificationModal('success', data.msg);
        }
        else{
          showNotificationModal('fail', data.msg);
        }
      }
    });
  }

  $('.update-status-item').on('click', function () {
    var _this = $(this);
    updateWorkPackageStatus(_this);
  });

  $('.list-relations').on('click', '.update-status-item', function () {
    var _this = $(this);
    updateWorkPackageStatus(_this);
  });

  function updateWorkPackageStatus(_this){
    var work_packageID = _this.attr('data-work_packageID');
    var name = 'status';
    var value = _this.attr('data-id');
    var content = _this.text();

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/update-content',
      dataType: "json",
      data: {"work_packageID": work_packageID, "name": name, "value": value},
      success: function (data) {
        if (data.status === 'success'){
          _this.parents('td').find('button').text(content);
          showNotificationModal('success', data.msg);
        }
        else{
          showNotificationModal('fail', data.msg);
        }
      }
    });
  }

  $('.update-content-item').on('keypress', function (e) {
    if (e.keyCode === 13) {
      var _this = $(this);
      var work_packageID = _this.attr('data-work_packageID');
      var name =  _this.attr('data-name');
      var value = _this.val();
      $.ajax({
        type: 'POST',
        url: base_url + 'auth/project/update-content',
        dataType: "json",
        data: {
          "work_packageID": work_packageID,
          "name": name,
          "value": value
        },
        success: function (data) {
          if (data.status === 'success'){
            showNotificationModal('success', data.msg);
          }
          else{
            reloadNotificationModal();
            showNotificationModal('fail', data.msg);
          }
        }
      });
    }
  });

  $('.update-content-item-select').on('change', function () {
    var _this = $(this);
    var work_packageID = _this.attr('data-work_packageID');
    var identifier = $('#work_package_identifier').val();
    var name =  _this.attr('data-name');
    var value = _this.val();
    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/update-content',
      dataType: "json",
      data: {
        "work_packageID": work_packageID,
        "name": name,
        "value": value,
        "identifier": identifier
      },
      success: function (data) {
        if (data.status === 'success'){
          if (name === 'assignee'){
            $('#assignee_' + work_packageID).text(data.msg);
            showNotificationModal('success', 'Successful update.');
          }
          else if (name === 'startDate') {
            $('#startDate_' + work_packageID).text(value.replace('.','/'));
            showNotificationModal('success', data.msg);
          }
          else if (name === 'dueDate') {
            $('#dueDate_' + work_packageID).text(value.replace('.','/'));
            showNotificationModal('success', data.msg);
          }
          else{
            showNotificationModal('success', data.msg);
          }
        }
        else{
          reloadNotificationModal();
          showNotificationModal('fail', data.msg);
        }
      }
    });
  });

  $('.work-package-detail').on('change', '.update-content-item-upload', function () {
    var _this = $(this);
    var work_packageID = _this.attr('data-work_packageID');
    var file_data = $('#input_upload_attachment').prop('files')[0];
    var form_data = new FormData();

    getInfoAttachment($('#input_upload_attachment')[0].files[0]);

    form_data.append('file', file_data);

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/upload-attachment/' + work_packageID,
      dataType: "text",
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function (res) {
        var data = JSON.parse(res);
        if (data.status === 'success'){
          var _this = $('.btn-remove-new-upload');
          _this.removeClass('btn-remove-upload');
          _this.addClass('btn-delete-attachment');
          _this.attr('data-id', data.msg)
          showNotificationModal('success', 'Successful update.');
        }
        else{
          reloadNotificationModal();
          showNotificationModal('fail', data.msg);
        }
      }
    });
  });

  $('.btn-delete-attachment').on('click', function () {
    var _this = $(this);
    var attachmentID = _this.attr('data-id');
    $('#attachmentID').val(attachmentID);
    if (attachmentID !== ''){
      $('#modalDeleteAttachment').modal('show');
    }
  });

  $('.block-file-list').on('click', '.btn-delete-attachment', function () {
    var _this = $(this);
    var attachmentID = _this.attr('data-id');
    $('#attachmentID').val(attachmentID);
    if (attachmentID !== ''){
      $('#modalDeleteAttachment').modal('show');
    }
  });

  $('#btnSubmitDeleteAttachment').on('click', function () {
    var attachmentID = $('#attachmentID').val();
    var name = 'attachments';

    if (attachmentID !== ''){
      $.ajax({
        type: 'POST',
        url: base_url + 'auth/project/delete-content',
        dataType: "json",
        data: {"attachmentID": attachmentID, "name": name},
        success: function (data) {
          if (data.status === 'success'){
            reloadNotificationModal();
            showNotificationModal('success', data.msg);
          }
          else{
            showNotificationModal('fail', data.msg);
          }
        }
      });
    }
  });

  //delete document
  $('.btn-delete-document').on('click', function () {
    var documentID = $(this).attr('data-id');
    var identifier = $(this).attr('data-identifier');
    $('#documentID').val(documentID);
    $('#identifier').val(identifier);
    $('#modalDeleteDocument').modal('show');
  });

  $('#btnSubmitDeleteDocument').on('click', function () {
    var documentID = $('#documentID').val();
    var identifier = $('#identifier').val();
    if (documentID !== '' && identifier !== ''){
      $.ajax({
        type: 'POST',
        url: base_url + 'auth/project/document/delete',
        dataType: "json",
        data: {"documentID": documentID},
        success: function (data) {
          if (data.status === 'success'){
            showNotificationModal('success', 'Delete successfully');
            window.location.href = base_url + "auth/project/"+ identifier +"/documents";
          }
        }
      });
    }
  });

  $('.btn-watcher').on('click', function () {
    var _this = $(this);
    var work_packageID = $('#work_package').val();
    var name = 'watchers';

    if (_this.hasClass('remove')){
      var userID = _this.attr('data-id');

      $.ajax({
        type: 'POST',
        url: base_url + 'auth/project/delete-content',
        dataType: "json",
        data: {
          "name": name,
          "work_packageID": work_packageID,
          "userID": userID
        },
        success: function (data) {
          if (data.status === 'success'){
            _this.parent().removeClass('watched');
            $('#watcher_' + userID).remove();
            _this.removeClass('remove');
            showNotificationModal('success', data.msg);
          }
          else{
            showNotificationModal('fail', data.msg);
          }
        }
      });
    }
    else{
      $.ajax({
        type: 'POST',
        url: base_url + 'auth/project/add-content',
        dataType: "json",
        data: {
          "name": name,
          "work_packageID": work_packageID,
        },
        success: function (data) {
          if (data.status === 'success'){
            reloadNotificationModal();
            showNotificationModal('success', data.msg);
          }
          else{
            showNotificationModal('fail', data.msg);
          }
        }
      });
    }
  });

  $('.btn-remove-watcher').on('click', function () {
    var _this = $(this);
    var work_packageID = $('#work_package').val();
    var userID = _this.attr('data-id');
    var name = 'watchers';

    $.ajax({
      type: 'POST',
      url: base_url + 'auth/project/delete-content',
      dataType: "json",
      data: {
        "name": name,
        "work_packageID": work_packageID,
        "userID": userID
      },
      success: function (data) {
        if (data.status === 'success'){
          _this.parent().removeClass('watched');
          $('#watcher_' + userID).remove();
          _this.addClass('btn-add-watcher');
          _this.removeClass('btn-remove-watcher');
          showNotificationModal('success', data.msg);
        }
        else{
          showNotificationModal('fail', data.msg);
        }
      }
    });
  });

  $('.btnRegister').on('click', function () {
    var email = $(this).parents('.row').find('#email').val();
    if (email !== undefined && email !== ''){
      $.ajax({
        type: 'POST',
        url: base_url + 'register/check-domain-valid',
        dataType: "json",
        data: {"email": email},
        success: function (res) {
          if (res === false){
            $('#modalNotificationNonConformEmail').modal('show');
          }
          else{
            $("#registerForm").submit();
          }
        }
      });
    }
    else{
      $("#registerForm").submit();
    }
  });

  $('#btnRegisterNonConformEmail').on('click', function () {
    $("#registerForm").submit();
    addSpinner(true);
  });

//start
  $('#submitUploadContentForm').on('click', function () {
    var type = $(this).attr('data-type');
    uploadFile(type);
  });

  var ajax = 0;
  function uploadFile(type)
  {
    // Form Validation
    var check_link_to_conference = 0;
    var sharePublic = 1;
    if ($('#check_link_to_conference').is(':checked')){
      check_link_to_conference = 1;

      var _thisCID = $('#get_cid');
      var CID = _thisCID.val();
      hideErrorMessage(_thisCID);
      unsetFailStatus(_thisCID);
      if (!CID) {
        setFailStatus(_thisCID);
        showErrorMessage(_thisCID, 'The CID field is required.');
        _thisCID.focus();
        return false;
      }
      else{
        var listCid = $('#get_all_cid').val();
        if (listCid.lastIndexOf(CID) < 0){
          setFailStatus(_thisCID);
          showErrorMessage(_thisCID, 'Please enter a valid Conference ID.');
          _thisCID.focus();
          return false;
        }
        else{
          var session = $('#get_session_cid').val();
        }
      }

      if ($('#closeAccess').is(':checked')){
        sharePublic = 0;
      }
    }

    var _thisTitle = $('#title');
    var title = _thisTitle.val();
    hideErrorMessage(_thisTitle);
    unsetFailStatus(_thisTitle);
    if (!title) {
      setFailStatus(_thisTitle);
      showErrorMessage(_thisTitle, 'The title field is required.');
      _thisTitle.focus();
      return false;
    }

    var _thisCaption = $('#caption');
    var caption = _thisCaption.val();
    hideErrorMessage(_thisCaption);
    unsetFailStatus(_thisCaption);
    if (!caption) {
      setFailStatus(_thisCaption);
      showErrorMessage(_thisCaption, 'The caption field is required.');
      _thisCaption.focus();
      return false;
    }

    var _thisCategory = $('#category');
    var category = _thisCategory.val();
    hideErrorMessage(_thisCategory);
    unsetFailStatus(_thisCategory.parent().find('.select2-selection'));
    if (!category) {
      setFailStatus(_thisCategory.parent().find('.select2-selection'));
      showErrorMessage(_thisCategory, 'The main field of research field is required.');
      _thisCategory.focus();
      return false;
    }

    var _thisSubCategory = $('#sub_category');
    var subCategory = _thisSubCategory.val();
    hideErrorMessage(_thisSubCategory);
    unsetFailStatus(_thisSubCategory.parent().find('.select2-selection'));
    if (!subCategory) {
      setFailStatus(_thisSubCategory.parent().find('.select2-selection'));
      showErrorMessage(_thisSubCategory, 'The main research topic field is required.');
      _thisSubCategory.focus();
      return false;
    }

    var altCategory = '';
    var altSubCategory = '';
    if ($('#add_alt_category').is(':checked')){
      var _thisAltCategory = $('#alt_category');
      altCategory = _thisAltCategory.val();
      hideErrorMessage(_thisAltCategory);
      unsetFailStatus(_thisAltCategory.parent().find('.select2-selection'));
      if (!altCategory) {
        setFailStatus(_thisAltCategory.parent().find('.select2-selection'));
        showErrorMessage(_thisAltCategory, 'The alternative field of research field is required.');
        _thisAltCategory.focus();
        return false;
      }

      var _thisAltSubCategory = $('#alt_sub_category');
      altSubCategory = _thisAltSubCategory.val();
      hideErrorMessage(_thisAltSubCategory);
      unsetFailStatus(_thisAltSubCategory.parent().find('.select2-selection'));
      if (!altSubCategory) {
        setFailStatus(_thisAltSubCategory.parent().find('.select2-selection'));
        showErrorMessage(_thisAltSubCategory, 'The alternative research topic field is required.');
        _thisAltSubCategory.focus();
        return false;
      }

      if (subCategory === altSubCategory) {
        setFailStatus(_thisAltSubCategory.parent().find('.select2-selection'));
        showErrorMessage(_thisAltSubCategory, 'Your alternative research topic can not be the same as your main research topic!');
        _thisAltSubCategory.focus();
        return false;
      }
    }

    hideErrorMessage($('#upload_video_msg'));
    var _thisFile = $('#input_upload_video');
    var file = _thisFile.val();
    if (!file) {
      showErrorMessage($('#upload_video_msg'), 'Please choose a file.');
      return false;
    }
    else {
      file = file.toLowerCase();
      var fileSize = document.getElementById('input_upload_video').files[0].size;
      var fileName = document.getElementById('input_upload_video').files[0].name;
      var fileExt = file.substr(file.lastIndexOf('.') + 1);

      var extAllowed = '';
      var sizeAllowed = 0;
      if (type === 'video'){
        extAllowed = 'mp4|flv|webm|3gp|wmv|mov|avi|mkv|vob|divx|xvid|ts|m4v|avchd|mpeg';
        sizeAllowed = 300 * 1024 * 1024;
      }
      else if (type === 'presentation'){
        extAllowed = 'pdf|ppt|pptx|odp';
        sizeAllowed = 50 * 1024 * 1024;
      }
      else if (type === 'poster' || type === 'paper'){
        extAllowed = 'pdf';
        sizeAllowed = 50 * 1024 * 1024;
      }
      if (extAllowed.lastIndexOf(fileExt) < 0){
        showErrorMessage($('#upload_video_msg'), 'The filetype you are attempting to upload is not allowed.');
        return false;
      }
      else{
        if (fileSize > sizeAllowed){
          showErrorMessage($('#upload_video_msg'), 'The file you are attempting to upload is larger than the permitted size.');
          return false;
        }
      }
    }

    var registerDOI = '';
    if ($('#registerDOI').is(':checked')){
      registerDOI = 1;
    }

    $('#progressBarModal').modal('show');
    var formData = new FormData();
    formData.append("file", document.getElementById('input_upload_video').files[0]);
    formData.append("title", title);
    formData.append("caption", $('#caption').val());
    formData.append("description", $('#description').val());
    formData.append("coAuthors", $('#coAuthors').val());
    formData.append("furtherReading", $('#furtherReading').val());
    formData.append("category", category);
    formData.append("subCategory", subCategory);
    formData.append("altCategory", altCategory);
    formData.append("altSubCategory", altSubCategory);
    formData.append("fileSize", fileSize);
    formData.append("fileName", fileName);
    formData.append("affiliation", $('#affiliation').val());
    formData.append("language", $('#language').val());
    formData.append("registerDOI", registerDOI);
    formData.append("sharePublic", sharePublic);
    formData.append("check_link_to_conference", check_link_to_conference);
    if(check_link_to_conference === 1){
      formData.append("CID", CID);
      formData.append("session", session);
    }

    ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);

    if (type === 'video'){
      ajax.open("POST", base_url + 'auth/test/video/upload/event');
    }
    else if (type === 'presentation'){
      ajax.open("POST", base_url + 'auth/test/presentation/upload/event');
    }
    else if (type === 'poster'){
      ajax.open("POST", base_url + 'auth/test/poster/upload/event');
    }
    else if (type === 'paper'){
      ajax.open("POST", base_url + 'auth/test/paper/upload/event');
    }

    ajax.send(formData);

    ajax.onreadystatechange = interpretRequest;
  }

  function interpretRequest() {
    switch (ajax.readyState) {
      case 4:{
        if (ajax.status !== 200 && ajax.status !== 500) {
          alert("The upload has been aborted.");
        } else {
          location.reload();
        }
        break;
      }
      default:
      {
      }
        break;
    }
  }

  function progressHandler(event) {
    // document.getElementById("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
    var percent = (event.loaded / event.total) * 100;
    document.getElementById("progressBar").value = Math.round(percent);
    document.getElementById("status").innerHTML = Math.round(percent) + "%";
  }

  function completeHandler(event) {
    document.getElementById("status").innerHTML = event.target.responseText;
    $('#progressBarModal').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
    addSpinner(true);
    // document.getElementById("progressBar").value = 0; //wil clear progress bar after successful upload
  }

  function errorHandler(event) {
    document.getElementById("status").innerHTML = "Upload Failed";
  }

  function abortHandler(event) {
    document.getElementById("status").innerHTML = "Upload Aborted";
  }

  function calFileSize(bytes) {
    var exp = Math.log(bytes) / Math.log(1024) | 0;
    var result = (bytes / Math.pow(1024, exp)).toFixed(2);

    return result + ' ' + (exp == 0 ? 'bytes': 'KMGTPEZY'[exp - 1] + 'B');
  }
  //end

});

// add class highlight to change bg button collapse
 $('.btn-manage').click(function() {
  $(this).toggleClass('highlight');
});

$('#table_invoice').DataTable( {
  "scrollX": true,
  "language": {
    paginate: {
      next: '<span class="icon-chevron-circle-right"></span>',
      previous: '<span class="icon-chevron-circle-left"></span>'
    }
  },
  "pagingType": "full_numbers"
} );
