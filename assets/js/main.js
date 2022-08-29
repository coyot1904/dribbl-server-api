// menu


$('.navbar-nav').click(function (e) {
  e.stopPropagation();
});
$('.openmodal1').click(function () {
  $('#register').modal('show');
});
$('.openmodal2').click(function () {
  $('#login').modal('show');
});

$('.close-menu ').click(function () {
  var $navbar = $(".navbar-collapse");
  $navbar.collapse('hide');
});

$('body').click(function () {
  var clickover = $(event.target);
  var $navbar = $(".navbar-collapse");
  var _opened = $navbar.hasClass("show");
  if (_opened === true && !clickover.hasClass("navbar-toggle")) {
      $navbar.collapse('hide');

  }
});


// menu
// select2 -->

$('.select2-single').select2({
  placeholder: 'همه گروه ها',
  width: null
});

$('.select2-single2').select2({
  placeholder: 'همه شهر ها',
  width: null
});
$('.select2-single3').select2({
  theme: 'default mynewsel',
  placeholder: 'همه شهر ها',
});


$(document).on('select2:open', 'select', function () {
  $('.select2-results').mCustomScrollbar({
    theme: 'inset-dark',
    scrollButtons: { enable: true }
  })
})

// select2 -->

// owl-carousel index-->

$('.owl-kala').owlCarousel({
  loop: true,
  margin: 10,
  nav: true,
  rtl: true,
  responsive: {
    0: {
      items: 1,
      nav: false
    },
    600: {
      items: 2
    },
    768: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
})

// owl-carousel index-->

// <!-- owl-carousel product-page-->
$('.owl-slider').owlCarousel({
  loop: true,
  margin: 10,
  nav: true,
  rtl: true,
  dots: false,
  responsive: {
    0: {
      items: 1,
      nav: false
    },
    600: {
      items: 1
    },
    768: {
      items: 1
    },
    1000: {
      items: 1
    }
  }
})

// owl_berand
$('.owl_berand').owlCarousel({
  margin: 10,
  responsiveClass: true,
  rtl: true,
  autoplay: true,
  autoplayTimeout: 5000,
  loop: true,
  nav: true,
  dots: true,
  responsive: {
    0: {
      items: 2,
      nav: false
    },
    600: {
      items:4
    },
    768: {
      items: 4
    },
    1000: {
      items:7
    }
  }

})
// owl_berand

$('.owl-kala2').owlCarousel({
  loop: true,
  margin: 10,
  nav: true,
  rtl: true,
  dots: false,
  responsive: {
    0: {
      items: 1,
      nav: false
    },
    600: {
      items: 1
    },
    768: {
      items: 2
    },
    1200: {
      items: 3
    }
  }
})

// <!-- owl-carousel product-page-->

// fix-menu -->

if ($('.my_nav').length) {
  var scrollTrigger = 100
  // px

  var backToTop = function () {
    var scrollTop = $(window).scrollTop()
    if (scrollTop > scrollTrigger) {
      $('.my_nav').addClass('fixtop')
      $('.navbar-brandlg').addClass('hide-logo')
      $('.navbar-brandfix').addClass('show-logo')
    } else {
      $('.my_nav').removeClass('fixtop')
      $('.navbar-brandlg').removeClass('hide-logo')
      $('.navbar-brandfix').removeClass('show-logo')
    }
  }
  backToTop()
  $(window).on('scroll', function () {
    backToTop()
  })
}

// fix-menu -->



/// * verification code */ -->

$(function () {
  var body = $('body')

  function goToNextInput (e) {
    var key = e.which

    var t = $(e.target)

    var sib = t.next('.input-vreifay')
    if (!sib || !sib.length) {
      sib = body.find('.input-vreifay').eq(0)
    }
    sib.select().focus()
  }

  body.on('keyup', '.input-vreifay', goToNextInput)
})
/* verification code */

// Ion.RangeSlider.js -->

var slider = $('#example_id').ionRangeSlider({
  type: 'double',
  grid: false,
  min: 1500,
  max: 25000,
  from: 1500,
  to: 15000,
  step: 500,
  min_interval: 1000,
  drag_interval: true,
  from_shadow: true,
  grid_num: 2,
  values_separator: '',
  postfix: ''
})

// Ion.RangeSlider.js -->

// <!-- add-city -->

function addaddItem () {
  var addItem = $('#new-add-item').val()
  $('#add-list').append(
    '<li>' +
      "<i class='fa fa-times-circle add-item-delete'></i>" +
      addItem +
      '</li><input type="hidden" name="tags_mine[]" value="'+addItem+'"/>'
  )

  $('#new-add-item').val('')
}
function deleteaddItem (e, item) {
  e.preventDefault()
  $(item)
    .parent()
    .fadeOut('slow', function () {
      $(item)
        .parent()
        .remove()
    })
}
$(function () {
  $('#add-add-item').on('click', function (e) {
    e.preventDefault()
    addaddItem()
  })
  $('#add-list').on('click', '.add-item-delete', function (e) {
    var item = this
    deleteaddItem(e, item)
  })
})

function addaddItem1 () {
  var addItem = $('#new-add-item1').val()
  $('#add-list1').append(
    '<li>' +
      "<i class='fa fa-times-circle add-item-delete'></i>" +
      addItem +
      '</li><input type="hidden" name="tags_need[]" value="'+addItem+'"/>'
  )

  $('#new-add-item1').val('')
}
function deleteaddItem1 (e, item) {
  e.preventDefault()
  $(item)
    .parent()
    .fadeOut('slow', function () {
      $(item)
        .parent()
        .remove()
    })
}
$(function () {
  $('#new-add-item1').keypress(function(e){
    if(e.which == 13) {
      e.preventDefault()
      addaddItem1()
    }
  });
  $('#add-list1').on('click', '.add-item-delete', function (e) {
    e.preventDefault()
    var item = this
    deleteaddItem1(e, item)
  })
})

// <!-- add-city -->

// cart-bank
function moveFocus (from, to) {
  var length = from.value.length
  var maxLength = from.getAttribute('maxLength')
  if (length == maxLength) {
    document.getElementById(to).focus()
  }
}
// cart-bank

// ticket-upload

$('.btnfile').click(function () {
  $('#file-input').click()
})
// ticket-upload

// Add smooth scrolling

$(document).ready(function () {
  $(window)
    .resize(function () {
      var viewportWidth = $(window).width()
      if (viewportWidth < 767) {
        $('a.scroll-item').on('click', function (event) {
          if (this.hash !== '') {
            event.preventDefault()

            var hash = this.hash

            $('html, body').animate(
              {
                scrollTop: $(hash).offset().top
              },
              100,
              function () {
                window.location.hash = hash
              }
            )
          }
        })
      }
    })
    .resize()
})
// Add smooth scrolling

/* img-upload */

$(function () {
  $(document).ready(function () {
    window.images = []

    $('body').on('change', '.upload__input', function (event) {
      let messages = $(this)
        .closest('.upload')
        .find('.count_img, .size_img, .file_types')
      $(messages).hide()

      let files = event.target.files

      let filename = $(this)
        .attr('name')
        .slice(0, -2)

      let names2 = window.images[filename]
      let names = []

      if (names2) {
        names = names2
      }

      let max_count = $(this).data('maxCount')

      for (var i = 0; i < files.length; i++) {
        let file = files[i]

        names.push(file.size)

        if (names.length == max_count) {
          $(this)
            .closest('.upload')
            .find('.count_img')
            .show()
          $(this)
            .closest('.upload')
            .find('.count_img_var')
            .html(max_count)
          $(this)
            .closest('.upload')
            .find('.upload__btn')
            .hide()
        }
        if (names.length > max_count) {
          names.pop()
          return false
        }
        window.images[filename] = names

        var fileType = file.type
        if (fileType == 'image/png' || fileType == 'image/jpeg') {
        } else {
          $(this)
            .closest('.upload')
            .find('.file_types')
            .show()
          return false
        }

        if (fileType == 'video/mp4') {
          var max_size = 1
        } else {
          var max_size = 1
        }

        var totalBytes = file.size

        var max_bites = max_size * 1024 * 1024

        if (totalBytes > max_bites) {
          $(this)
            .closest('.upload')
            .find('.size_img')
            .show()
          $(this)
            .closest('.upload')
            .find('.size_img_var')
            .html(max_size + 'MB')
          return false
        }

        var picBtn = $(this)
          .closest('.upload')
          .find('.upload__btn')

        var picReader = new FileReader()
        picReader.addEventListener('load', function (event) {
          var picFile = event.target
          var picSize = event.total
          var picCreate = $(
            "<div class='upload__item'><img src='" +
              picFile.result +
              "'" +
              " class='upload__img'/><a data-id='" +
              picSize +
              "' class='upload__del'></a></div>"
          )
          $(picCreate).insertBefore(picBtn)
        })

        picReader.readAsDataURL(file)
      }
    })

    $('body').on('click', '.upload__del', function () {
      $(this)
        .closest('.upload')
        .find('.upload__btn')
        .show()

      let filename = $(this)
        .closest('.upload')
        .find('.upload__input')
        .attr('name')
        .slice(0, -2)

      let names = window.images[filename]

      let messages = $(this)
        .closest('.upload')
        .find('.count_img, .size_img, .file_types')
      $(messages).hide()

      $(this)
        .closest('.upload__item')
        .remove()

      var removeItem = $(this).attr('data-id')
      var yet = names.indexOf(removeItem)
      names.splice(yet, 1)
    })
  })
})

/* img-upload */

// validator
$.validator.addMethod("letters", function(value, element) {
  return this.optional(element) || value == value.match(/[09]{2}[0-4]{1}[0-9]{8}/);
});
$('.form-contact').validate({
  rules: {
    name: {
      required: true
    },
    text: {
      required: true
    },
    email: {
      required: true,
      email: true
    }
  },
  messages: {
    name: 'نام شما نمی تواند خالی باشد .',
    text: 'متن پیام شما نمی تواند خالی باشد .',
    email: 'ایمیل اشتباه است .'
  }
});
$.validator.addMethod("letters", function(value, element) {
  return this.optional(element) || value == value.match(/[09]{2}[0-4]{1}[0-9]{8}/);
});
$('.form2').validate({
  rules: {
    title2: {
      required: true
    },
    cat2: {
      required: true
    },
    cat_parent: {
      required: true
    },
    desc2: {
      required: true
    },
    title: {
      required: true
    },
    mahale: {
      required: true
    },
    cat: {
      required: true
    },
    city: {
      required: true
    },
    desc: {
      required: true
    },
    tel: {
      required: true,
      letters: true,
    },
    email: {
      required: true,
      email: true
    },
    country: {
      required: true,
    },
    ads_model: {
      required: true,
    }
  },
  messages: {
    title: 'عنوان آگهی نمی تواند خالی باشد .',
    price: 'قیمت محصول نمی تواند خالی باشد .',
    mahale: ' محله نمی تواند خالی باشد .',
    cat: 'دسته بندی مورد نظر را انتخاب نمایید .',
    city: ' شهر مورد نظر را انتخاب نمایید .',
    desc: 'توضیحات  نمی تواند خالی باشد .',
    title2: 'عنوان آگهی نمی تواند خالی باشد .',
    cat2: 'دسته بندی مورد نظر را انتخاب نمایید .',
    cat_parent: 'دسته بندی مورد نظر را انتخاب نمایید .',
    desc2: 'توضیحات  نمی تواند خالی باشد .',
    country: 'استان نمی تواند خالی باشد.',
    ads_model: 'نوع آگهی نمی تواند خالی باشد',
    tel: {
      required: "لطفا شماره همراه خود را وارد نمایید .",
      letters: "شماره همراه اشتباه است ."
  },
    email: 'ایمیل اشتباه است .'
  }
});
$.validator.addMethod("letters", function(value, element) {
  return this.optional(element) || value == value.match(/[09]{2}[0-4]{1}[0-9]{8}/);
});
$('.login-form1').validate({
  rules: {
    tel: {
      required: true,
      letters: true,
    }
  },
  messages: {
    tel: {
      required: "لطفا شماره همراه خود را وارد نمایید .",
      letters: "شماره همراه اشتباه است ."
  }
},
submitHandler: function (form) {
  $("#confirm").modal('show');
  $('#register').modal('hide');
  $('#SubForm').click(function () {
      form.submit();
 });
}

});
$.validator.addMethod("letters", function(value, element) {
  return this.optional(element) || value == value.match(/[09]{2}[0-4]{1}[0-9]{8}/);
});
$('.login-form2').validate({
  rules: {
    tel: {
      required: true,
      letters: true,
    },
    pass:{
      required: true,
    }
  },
  messages: {
    pass: ' کلمه عبور نمیتواند خالی باشد .',
    tel: {
      required: "لطفا شماره همراه خود را وارد نمایید .",
      letters: "شماره همراه اشتباه است ."
  }
}

});
// validator

// modal -->

   $('.open-reg').click(function () {
     $('#confirm').modal('hide')
  })


// modal -->

// terms

function toggleIcon(e) {
  $(e.target)
      .prev('.panel-heading')
      .find(".more-less")
      .toggleClass('fa-chevron-up fa-chevron-down');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);

// terms

// gallery
$(document).ready(function () {

  $('#glasscase').glassCase({
    'capZType': 'in',
    'isSlowZoom': false,
    'isZoomDiffWH': false,
    'isOverlayFullImage': true,
    'colorActiveThumb': '#333',
    'thumbsPosition': 'bottom',
    nrThumbsPerRow: 4,

  });
});
// gallery

// slinky
var slinky = $('#menu').slinky({
  title: true
});
var slinky = $('#menu1').slinky({
  title: true
});
// slinky

// select-item
$('.data-val1').click(function () {
  var valuein = $(this).attr('data-value');
  $('.input-srch1').attr('value', valuein);
  $('#cat').modal('hide');
});
$('.data-val2').click(function () {
  var valuein = $(this).attr('data-value');
  $('.input-srch2').attr('value', valuein);
  $('#city').modal('hide');
});
// select-item

// live-search
$('.live-search-list li').each(function(){
  $(this).attr('data-search-term', $(this).text());
  });

  $('.live-search-box').on('keyup', function(){

  var searchTerm = $(this).val();

      $('.live-search-list li').each(function(){

          if ($(this).filter('[data-search-term *= ' + searchTerm + ']').length > 0 || searchTerm.length < 1) {
              $(this).show();
          } else {
              $(this).hide();
          }

      });

  });
// live-search
