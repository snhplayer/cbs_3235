'use strict';

var utils = require('../utils/writer.js');
var Default = require('../service/DefaultService');

module.exports.userpanel_phpPOST = function userpanel_phpPOST (req, res, next) {
  Default.userpanel_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
