'use strict';

var utils = require('../utils/writer.js');
var Admin = require('../service/AdminService');

module.exports.delete_item_phpPOST = function delete_item_phpPOST (req, res, next) {
  Admin.delete_item_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
