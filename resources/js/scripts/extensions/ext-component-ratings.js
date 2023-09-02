/*=========================================================================================
	File Name: ext-component-ratings.js
	Description: Ratings Commnent
	----------------------------------------------------------------------------------------
	Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(function () {
  'use strict';

  var isRtl = $('html').attr('data-textdirection') === 'rtl',

    basicRatings = $('.basic-ratings'),

    readOnlyRatings = $('.read-only-ratings'),

    onSetEvents = $('.onset-event-ratings'),

    onChangeEvents = $('.onChange-event-ratings'),

    ratingMethods = $('.methods-ratings'),
    initializeRatings = $('.btn-initialize'),
    destroyRatings = $('.btn-destroy'),
    getRatings = $('.btn-get-rating'),
    setRatings = $('.btn-set-rating');

  // Basic Ratings
    if (basicRatings.length) {
    basicRatings.each(function() {
        var ratingValue = $(this).data('rating');  // Prendere il valore di data-rating
        $(this).rateYo({
        rating: ratingValue / 2 || 3.6,  // Se non esiste un valore di data-rating, allora usa il valore predefinito di 3.6
        rtl: isRtl
        });
    });
    }

  // Read Only Ratings
  // --------------------------------------------------------------------
  if (readOnlyRatings.length) {
    readOnlyRatings.rateYo({
      rating: 2,
      rtl: isRtl
    });
  }

  // Ratings Events
  // --------------------------------------------------------------------

  // onSet Event
  if (onSetEvents.length) {
    onSetEvents
      .rateYo({
        rtl: isRtl
      })
      .on('rateyo.set', function (e, data) {
        alert('The rating is set to ' + data.rating + '!');
      });
  }

  // onChange Event
  if (onChangeEvents.length) {
    onChangeEvents
      .rateYo({
        rtl: isRtl
      })
      .on('rateyo.change', function (e, data) {
        var rating = data.rating;
        $(this).parent().find('.counter').text(rating);
      });
  }

  // Ratings Methods
  // --------------------------------------------------------------------
  if (ratingMethods.length) {
    var $instance = ratingMethods.rateYo({
      rtl: isRtl
    });

    if (initializeRatings.length) {
      initializeRatings.on('click', function () {
        $instance.rateYo({
          rtl: isRtl
        });
      });
    }

    if (destroyRatings.length) {
      destroyRatings.on('click', function () {
        if ($instance.hasClass('jq-ry-container')) {
          $instance.rateYo('destroy');
        } else {
          window.alert('Please Initialize Ratings First');
        }
      });
    }

    if (getRatings.length) {
      getRatings.on('click', function () {
        if ($instance.hasClass('jq-ry-container')) {
          var rating = $instance.rateYo('rating');
          window.alert('Current Ratings are ' + rating);
        } else {
          window.alert('Please Initialize Ratings First');
        }
      });
    }

    if (setRatings.length) {
      setRatings.on('click', function () {
        if ($instance.hasClass('jq-ry-container')) {
          $instance.rateYo('rating', 1);
        } else {
          window.alert('Please Initialize Ratings First');
        }
      });
    }
  }


});
