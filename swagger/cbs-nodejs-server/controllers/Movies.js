'use strict';

var utils = require('../utils/writer.js');
var Movies = require('../service/MoviesService');

module.exports.add_movie_phpPOST = function add_movie_phpPOST (req, res, next) {
  Movies.add_movie_phpPOST()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.get_movies_phpGET = function get_movies_phpGET (req, res, next) {
  Movies.get_movies_phpGET()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};

module.exports.movielist_phpGET = function movielist_phpGET (req, res, next) {
  Movies.movielist_phpGET()
    .then(function (response) {
      utils.writeJson(res, response);
    })
    .catch(function (response) {
      utils.writeJson(res, response);
    });
};
