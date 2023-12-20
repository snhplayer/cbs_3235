'use strict';


/**
 * Add session
 * Adds a new movie screening session
 *
 * returns inline_response_200_1
 **/
exports.add_session_phpPOST = function() {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
  "sessionInfo" : "Movie ID 5 - 2023-01-01T12:00",
  "sessionId" : 42,
  "message" : "Session successfully added",
  "status" : "success"
};
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}

