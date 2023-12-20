'use strict';

var utils = require('../utils/writer.js');
var Sessions = require('../service/SessionsService');

module.exports.add_session_phpPOST = function add_session_phpPOST (req, res, next) {
  Sessions.add_session_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
