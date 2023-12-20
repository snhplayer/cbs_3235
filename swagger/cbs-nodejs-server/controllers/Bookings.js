'use strict';

var utils = require('../utils/writer.js');
var Bookings = require('../service/BookingsService');

module.exports.book_phpPOST = function book_phpPOST (req, res, next) {
  Bookings.book_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.booking_phpGET = function booking_phpGET (req, res, next) {
  Bookings.booking_phpGET()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
