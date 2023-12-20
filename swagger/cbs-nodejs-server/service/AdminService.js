'use strict';


/**
 * Delete movie or session
 * Deletes movie or session with bookings
 *
 * returns String
 **/
exports.delete_item_phpPOST = function() {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = "Movie and associated sessions/bookings deleted";
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}

