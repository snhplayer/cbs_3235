'use strict';

var utils = require('../utils/writer.js');
var User = require('../service/UserService');

module.exports.userpanel_phpGET = function userpanel_phpGET (req, res, next) {
  User.userpanel_phpGET()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
