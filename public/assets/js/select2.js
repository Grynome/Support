// npm package: select2
// github link: https://github.com/select2/select2

$(function() {
  'use strict'

  if ($(".js-example-basic-single").length) {
      $('.js-example-basic-single').select2();

      $('.js-example-basic-single').on('select2:open', function () {
          setTimeout(function () {
              $('.select2-search__field').get(0).focus();
          }, 0);
      });
  }
  if ($(".js-example-basic-multiple").length) {
    $(".js-example-basic-multiple").select2();
    $('.js-example-basic-multiple').on('select2:open', function () {
        setTimeout(function () {
            $('.select2-search__field').get(0).focus();
        }, 0);
    });
  }

});