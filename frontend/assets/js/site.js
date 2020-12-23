$('#editor').editor();

$('.open-poem').on('click', function() {
  var container = $(this).closest('.poem-content').find('.poem-content-wrap');
  if(container.hasClass('open')) {
    container.removeClass('open');
    $(this).html('Раскрыть');
  } else {
    container.addClass('open');
    $(this).html('Свернуть');
  }
});


// AUTH //
$('#auth-btn').on('click', function() {
  $('#reg-log').prop('checked', false);
});
$('#reg-btn').on('click', function() {
  $('#reg-log').prop('checked', true);
});
// END AUTH //

$(document).ready(function() {
 $('#redactorForm').on('keyup keypress', function(e) {
   if(e.target.id != 'editor') {
     var keyCode = e.keyCode || e.which;
     if (keyCode === 13) {
       e.preventDefault();
       return false;
     }
   }
  });
});

$('#poemTagInput').on('input', function(e) {
  e.preventDefault();
  var val = $(this).val();
  $.ajax({
    type: 'GET',
    url: '/redactor/get-tags',
    data: "search="+val,
    success: function(data) {
      console.log(data);
      $('.tags-list div').html('');
      if(data) {
        for (var i = 0; i < data.length; i++) {
          $('.tags-list div').append('<a data-id="'+data[i]['id']+'" class="add-tag">'+data[i]['title']+'</a>');
        }
        addTagClickInit();
      } else {
        $('.tags-list div').append('Ничего не найдено');
      }
      $('.tags-list').show();
    }
  });
  return false;
});

$('#poemTagInput').on('focus', function(e) {
  if($(this).val().length > 0) {
    $('.tags-list').show();
  } else {
    $(this).trigger('input');
  }
});

$('body').on('click', function(e) {
  if($('.tags-list[style="display: block;"]').length > 0) {
    if(!$(e.target).hasClass('tags-list') && $(e.target).closest('.tags-list').length < 1 && e.target.id != 'poemTagInput') {
      $('.tags-list').hide();
    }
  }
  if($('.modal-wrapper.open').length > 0) {
    if($(e.target).hasClass('modal-wrapper') || $(e.target).hasClass('close-modal-btn')) {
      $('.modal-wrapper').hide();
      return false;
    }
  }
});


if($('#modelId').length < 1) {
  if (localStorage.getItem('title_in_editor') !== null) {
    $('.redactor-index #poem-title').val(localStorage.getItem('title_in_editor'));
  }
  if (localStorage.getItem('text_in_editor') !== null) {
    $('.redactor-index #editor').html(localStorage.getItem('text_in_editor'));
    $('.redactor-index #poem-text').val(localStorage.getItem('text_in_editor'));
  }
  if (localStorage.getItem('tags_in_editor') !== null) {
    var tags = JSON.parse(localStorage.getItem("tags_in_editor"));
    for (var i = 0; i < tags.length; i++) {
      $('.redactor-index .poem-tags').append('<a data-id='+tags[i][0]+'>'+tags[i][1]+'</a>');
    }
    removeTagClickInit();
  }

  if (localStorage.getItem('isAnonymous_in_editor') == 'true') {
    $('.redactor-index #isAnonymous').prop('checked', true)
  }
  if (localStorage.getItem('forAdults_in_editor') == 'true') {
    $('.redactor-index #forAdults').prop('checked', true)
  }
  if (localStorage.getItem('isPublished_in_editor') == 'true') {
    $('.redactor-index #isPublished').prop('checked', true)
  } else if (localStorage.getItem('isPublished_in_editor') == 'false') {
    $('.redactor-index #isPublished').prop('checked', false)
  }
} else {
  removeTagClickInit();
}

$('#saveBtn').on('click', function(e) {
  e.preventDefault();

  localStorage.setItem('title_in_editor', $('#poem-title').val());
  localStorage.setItem('text_in_editor', $('#editor').html());

  localStorage.setItem('isAnonymous_in_editor', $('#isAnonymous').prop('checked'));
  localStorage.setItem('forAdults_in_editor', $('#forAdults').prop('checked'));
  localStorage.setItem('isPublished_in_editor', $('#isPublished').prop('checked'));

  var tags = [];
  $('.poem-tags a').each(function(index) {
    tags.push([$(this).attr('data-id'), $(this).html()])
  });
  localStorage.setItem('tags_in_editor', JSON.stringify(tags));

  $(this).html('Сохранено!');

  return false;
});

function addTagClickInit() {
  $('.add-tag').on('click', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id'),
        title = $(this).html();

    if($('.poem-tags a[data-id="'+id+'"]').length < 1) {
      $('.poem-tags').append('<a data-id='+id+'>'+title+'<input type="hidden" name="tags[]" value="'+id+'" /><span>✖</span></a>');
      removeTagClickInit();
    }

    $('.tags-list').hide();
    return false;
  });
}

function removeTagClickInit() {
  $('.poem-tags a span').on('click', function(e) {
    var id = $(this).parent().attr('data-id');
    $('.poem-tags a[data-id="'+id+'"]').remove();
  });
}


$('.poem-likes-btn').on('click', function(e) {
  e.preventDefault();
  var id = $(this).attr('data-id');
  var btn = $(this);
  var span = btn.find('span');
  $.ajax({
    type: 'get',
    url: '/poem/add-like',
    data: "id="+id,
    success: function(data) {
      console.log(data);
      if(data['status']) {

        if(btn.hasClass('active')) {
          btn.removeClass('active');
          span.html(Number(span.html()) - 1);
        } else {
          btn.addClass('active');
          span.html(Number(span.html()) + 1);
        }

      } else {
        if(data['redirectTo']) {
          window.location = data['redirectTo'];
        } else {
          alert('Что-то пошло не так!(');
        }
      }
    }
  });
  return false;
});

$('.poem-bookmark-btn').on('click', function(e) {
  e.preventDefault();
  var id = $(this).attr('data-id');
  var btn = $(this);
  $.ajax({
    type: 'get',
    url: '/poem/bookmark',
    data: "id="+id,
    success: function(data) {
      console.log(data);
      if(data['status']) {

        if(btn.hasClass('active')) {
          btn.removeClass('active');
        } else {
          btn.addClass('active');
        }

      } else {
        if(data['redirectTo']) {
          window.location = data['redirectTo'];
        } else {
          alert('Что-то пошло не так!(');
        }
      }
    }
  });
  return false;
});

$('#followBtn').on('click', function(e) {
  e.preventDefault();
  var id = $(this).attr('data-id');
  var btn = $(this);
  var span = $('#followersCount');
  $.ajax({
    type: 'get',
    url: '/profile/follow/' + id,
    success: function(data) {
      console.log(data);
      if(data['status']) {

        if(btn.hasClass('active')) {
          btn.removeClass('active');
          btn.html('Следить');
          span.html(Number(span.html()) - 1);
        } else {
          btn.addClass('active');
          btn.html('Вы подписаны');
          span.html(Number(span.html()) + 1);
        }

      } else {
        if(data['redirectTo']) {
          window.location = data['redirectTo'];
        } else {
          alert('Ай-яй-яй, так нельзя)');
        }
      }
    }
  });
  return false;
});

$('#followsBtn, #followersBtn').on('click', function(e) {
  e.preventDefault();
  var userId = $(this).attr('data-user-id'),
      title = 'Подписки';
  if($(this).attr('id') == 'followsBtn') {
    url = '/profile/get-follows';
  } else {
    url = '/profile/get-followers';
    title = 'Подписчики';
  }
  console.log(url);
  var modal = $('.modal-wrapper');

  $.ajax({
    type: 'get',
    url: url,
    data: "id="+userId,
    success: function(data) {
      console.log(data);
      if(data['status']) {
        modal.find('.modal-header span').html(title);
        modal.find('.modal-scroll').html(data.content);
        modal.addClass('open');
        modal.show();
        followListInit();
      } else {
        alert('Что-то пошло не так!(');
      }
    }
  });
  return false;
});


function followListInit() {
  $('.fml-follow-btn').on('click', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var btn = $(this);
    $.ajax({
      type: 'get',
      url: '/profile/follow/' + id,
      success: function(data) {
        console.log(data);
        if(data['status']) {

          if(btn.hasClass('active')) {
            btn.removeClass('active');
            btn.html('Следить');
          } else {
            btn.addClass('active');
            btn.html('Вы подписаны');
          }

        } else {
          if(data['redirectTo']) {
            window.location = data['redirectTo'];
          } else {
            alert('Ай-яй-яй, так нельзя)');
          }
        }
      }
    });
    return false;
  });
}


$('#menuBtn').on('click', function(e) {
  e.preventDefault();
  $('.mobile-menu').show();
  return false;
});
$('#closeMenu').on('click', function(e) {
  e.preventDefault();
  $('.mobile-menu').hide();
  return false;
});


$('#editor').on('input', function() {
  $('#poem-text').val($(this).html());
});
