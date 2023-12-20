'use strict';

var utils = require('../utils/writer.js');
var Auth = require('../service/AuthService');

module.exports.login_phpPOST = function login_phpPOST (req, res, next) {
  Auth.login_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.register_phpPOST = function register_phpPOST (req, res, next) {
  Auth.register_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.verify_phpPOST = function verify_phpPOST (req, res, next) {
  Auth.verify_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
