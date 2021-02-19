
jQuery(function($) {
     //moderator list

    $('.filter-button').on('click', function(){
        if($(this).hasClass('filter-selected')){
            $('.filter-button').removeClass('filter-selected');
            $(this).removeClass('filter-selected')
        }else{
            $('.filter-button').removeClass('filter-selected');
            $(this).addClass('filter-selected');
        }

        let typeId = $(this).data('id');

        var data = {
            'action': 'get_profiles_list',
            'security': moderator.security,
            'typeId' : typeId
        }
    
       $.ajax({
            type:"GET",
            url: moderator.ajaxurl,
            data: data,
            success:function(res){
                $('#user-list tbody').children('.user-list').remove();
                $('#user-list tbody').append(res);
            },
            error: function(errorThrown){
                alert(errorThrown);
            } 

        });
    });

    let userId = jQuery('#user-id').data('id');
    let $profileVisibility = jQuery('#tog-btn-profile-visibility');
    let $profileStatusApproved = jQuery('#profile_status_approved');
    let $profileStatusRejected = jQuery('#profile_status_rejected');
    let $profileStatusPending = jQuery('#profile_status_pending');

    let $personalDetailsVisibility = jQuery('#tog-btn-personal-visibility');
    let $introductionVisibility = jQuery('#tog-btn-introduction-visibility');
    let $headshotsVisibility = jQuery('#tog-btn-headshots-visibility');
    let $photosVisibility = jQuery('#tog-btn-photos-visibility');
    let $videosVisibility = jQuery('#tog-btn-videos-visibility');
    let $audiosVisibility = jQuery('#tog-btn-audios-visibility');
    let $experienceVisibility = jQuery('#tog-btn-experience-visibility');
    let $radioProfileStatus = jQuery('.profile_status_radio');


    var data = {
        'action': 'get_profile_visibility',
        'security': moderator.security,
        'user_id' : userId
    }

   jQuery.ajax({
    type:"GET",
    url: moderator.ajaxurl,
    data: data,
    success:function(res){
        let data = JSON.parse(res);
        if(data.profile == 1){
            $profileVisibility.prop('checked', true);
        }else{
            $profileVisibility.prop('checked', false);
        }

        

        if(data.profileStatus == 'Pending' || data.profileStatus == ''){
            $profileStatusPending.attr('checked', true);
        }else if(data.profileStatus == 'Approved'){
            $profileStatusApproved.attr('checked', true);
        }else if(data.profileStatus == 'Rejected'){
            console.log('d');
            $profileStatusRejected.attr('checked', true);
        }

        $('.profile_status_radio').map(function(){
            checkedAttr = $(this).attr('checked');
            if(checkedAttr == 'checked'){
                $(this).parent().addClass('active');
            }
        });

        if(data.personal == 1){
            $personalDetailsVisibility.prop('checked', true);
        }else{
            $personalDetailsVisibility.prop('checked', false);
        }

        if(data.introduction == 1){
            $introductionVisibility.prop('checked', true);
        }else{
            $introductionVisibility.prop('checked', false);
        }

        if(data.headshots == 1){
            $headshotsVisibility.prop('checked', true);
        }else{
            $headshotsVisibility.prop('checked', false);
        }

        if(data.photos == 1){
            $photosVisibility.prop('checked', true);
        }else{
            $photosVisibility.prop('checked', false);
        }

        if(data.videos == 1){
            $videosVisibility.prop('checked', true);
        }else{
            $videosVisibility.prop('checked', false);
        }

        if(data.audios == 1){
            $audiosVisibility.prop('checked', true);
        }else{
            $audiosVisibility.prop('checked', false);
        }

        if(data.experience == 1){
            $experienceVisibility.prop('checked', true);
        }else{
            $experienceVisibility.prop('checked', false);
        }
    },
    error: function(errorThrown){
        alert(errorThrown);
    } 
  
  });


let $selectAll = $('.selectAll');
let $checboxes = $('.checkbox');


$selectAll.on('click', function(){
    $(this).toggleClass('selected');

    if($(this).hasClass('selected')){
        $(this).closest('.details-block').find('.checkbox').prop('checked',true);
    }else{
        $(this).closest('.details-block').find('.checkbox').prop('checked',false);
    }
});


  $profileVisibility.on('click', function(){
    var data = {
        'action': 'set_profile_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });


  $radioProfileStatus.on('click', function(){
    var data = {
        'action': 'set_profile_status',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('value')
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $personalDetailsVisibility.on('click', function(){
    var data = {
        'action': 'set_personal_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $introductionVisibility.on('click', function(){
    var data = {
        'action': 'set_introduction_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $headshotsVisibility.on('click', function(){
    var data = {
        'action': 'set_headshots_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $photosVisibility.on('click', function(){
    var data = {
        'action': 'set_photos_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $videosVisibility.on('click', function(){
    var data = {
        'action': 'set_videos_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $audiosVisibility.on('click', function(){
    var data = {
        'action': 'set_audios_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $experienceVisibility.on('click', function(){
    var data = {
        'action': 'set_experience_visibility',
        'security': moderator.security,
        'user_id' : userId,
        'visibility': $(this).is(":checked") ? 1 : 0
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            //show confirmation here
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  $('.actionTaken').hide();
  let $personalDetailsControls = jQuery('.action-personal-details');
  $personalDetailsControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
    var data = {
        'action': 'action_personal_details',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('status'),
        'value' : 'Name: ' + $('#name').text() + "; Location:" + $('#location').text() + "; Gender:" + $('#gender').text()+ "; Mobile:" + $('#mobile').text()
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            statusLabel.text(actionTaken).show();
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  let $introductionControls = jQuery('.action-introduction');
  $introductionControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
        let $checked = $(this).closest('.details-block').find('.checkbox');

        let introtext = $('#introText').length > 0 ? '' : 'notset';
        let intro_camara =  $('#introToCamara').length > 0 ? '' : 'notset';

        $checked.map(function(elem){
            if($(this).is(":checked") && $(this).data('value') == 'text'){
                
                introtext = $('#introText').text();
            }else if($(this).is(":checked") && $(this).data('value') == 'camara'){
                intro_camara = $('#introToCamara').attr('src');
            }
        });

        if(introtext != '' || intro_camara != ''){
            var data = {
                'action': 'action_introduction',
                'security': moderator.security,
                'user_id' : userId,
                'status': $(this).data('status'),
                'introtext' : introtext,
                'intro_camara':intro_camara
            }

            jQuery.ajax({
                type:"POST",
                url: moderator.ajaxurl,
                data: data,
                success:function(res){
                    statusLabel.text(actionTaken).show();
                },
                error: function(errorThrown){
                    alert(errorThrown);
                } 
            
            });
        }else{
            console.log("Nothing selected"); //Show message here
        }
    });


    let $headshotsControls = jQuery('.action-headshots');
    $headshotsControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
    let $checked = $(this).closest('.details-block').find('.checkbox');

    headshots = [];
    $checked.map(function(elem){
        if($(this).is(":checked")){
            headshots.push($(this).closest('.image-block').find('img').attr('id'));
        }
    });

    var data = {
        'action': 'action_headshot_details',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('status'),
        'value' : headshots
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            statusLabel.text(actionTaken).show();
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });


  //photos
  let $photosControls = jQuery('.action-photos');
    $photosControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
    let $checked = $(this).closest('.details-block').find('.checkbox');

    photos = [];
    $checked.map(function(elem){
        if($(this).is(":checked")){
            photos.push($(this).closest('.image-block').find('img').attr('id'));
        }
    });

    var data = {
        'action': 'action_photos',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('status'),
        'value' : photos
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            statusLabel.text(actionTaken).show();
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  //videos
  let $videosControls = jQuery('.action-videos');
    $videosControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
    let $checked = $(this).closest('.details-block').find('.checkbox');

    videos = [];
    $checked.map(function(elem){
        if($(this).is(":checked")){
            videos.push($(this).closest('.video-block').find('iframe').data('row'));
        }
    });

    var data = {
        'action': 'action_videos',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('status'),
        'value' : videos
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            statusLabel.text(actionTaken).show();
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  //audio
  let $audiosControls = jQuery('.action-audios');
    $audiosControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
    let $checked = $(this).closest('.details-block').find('.checkbox');

    audios = [];
    $checked.map(function(elem){
        if($(this).is(":checked")){
            audios.push($(this).closest('.audio-block').find('.audioFile').attr('id'));
        }
    });

    var data = {
        'action': 'action_audios',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('status'),
        'value' : audios
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            statusLabel.text(actionTaken).show();
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });

  //experience
  let $experiencesControls = jQuery('.action-experience');
    $experiencesControls.on('click', function(){
    let actionTaken = $(this).data('status');
    let statusLabel = $(this).closest('.details-block').find('.actionTaken');
    let $checked = $(this).closest('.details-block').find('.checkbox');

    experiences = [];
    $checked.map(function(elem){
        if($(this).is(":checked")){
            experiences.push($(this).attr('id'));
        }
    });
    console.log(experiences);
    var data = {
        'action': 'action_experiences',
        'security': moderator.security,
        'user_id' : userId,
        'status': $(this).data('status'),
        'value' : experiences
    }

    jQuery.ajax({
        type:"POST",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            statusLabel.text(actionTaken).show();
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });


  //History tab
  jQuery('#history-tab').on('click', function(){
      console.log('clicked')
    var data = {
        'action': 'history_tab',
        'security': moderator.security,
        'user_id' : userId,
    }

    jQuery.ajax({
        type:"GET",
        url: moderator.ajaxurl,
        data: data,
        success:function(res){
            jQuery('.history-accordion').html(res);
        },
        error: function(errorThrown){
            alert(errorThrown);
        } 
      
      });
  });


});