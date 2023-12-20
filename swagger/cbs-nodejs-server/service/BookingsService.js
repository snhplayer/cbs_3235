'use strict';


/**
 * Book tickets
 * Books movie tickets
 *
 * returns String
 **/
exports.book_phpPOST = function() {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = "Booking successful";
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * Seat booking page
 * Renders seat booking page
 *
 * no response value expected for this operation
 **/
exports.booking_phpGET = function() {
  return new Promise(function(resolve, reject) {
    resolve();
  });
}

