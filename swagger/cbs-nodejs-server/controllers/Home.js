'use strict';

var utils = require('../utils/writer.js');
var Home = require('../service/HomeService');

module.exports.index_phpGET = function index_phpGET (req, res, next) {
  Home.index_phpGET()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
