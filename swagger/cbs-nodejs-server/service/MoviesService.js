'use strict';


/**
 * Add movie
 * Adds a new movie
 *
 * returns inline_response_200
 **/
exports.add_movie_phpPOST = function() {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = {
  "message" : "Movie successfully added",
  "status" : "success"
};
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * Get movies
 * Retrieves list of movies
 *
 * returns List
 **/
exports.get_movies_phpGET = function() {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = [ {
  "MovieID" : 0,
  "Title" : "Title"
}, {
  "MovieID" : 0,
  "Title" : "Title"
} ];
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}


/**
 * List movies
 * Retrieves list of movies
 *
 * returns String
 **/
exports.movielist_phpGET = function() {
  return new Promise(function(resolve, reject) {
    var examples = {};
    examples['application/json'] = "";
    if (Object.keys(examples).length > 0) {
      resolve(examples[Object.keys(examples)[0]]);
    } else {
      resolve();
    }
  });
}

