// AGENTES DE INNOVACIÓN - TÚ EVALÚAS APP CREATOR
// date     : 07/04/2015
// @package : agentes
// @file    : main.admin.js
// @version : 2.0.0
// @author  : Gobierno fácil <howdy@gobiernofacil.com>
// @url     : http://gobiernofacil.com

require.config({
  baseUrl : BASE_PATH  + "/js",
  paths : {
    jquery     : 'lib/jquery.min',
    backbone   : "lib/backbone",
    underscore : "lib/underscore-min",
    text       : "lib/text",
    velocity   : 'lib/velocity.min',
    d3         : 'lib/d3.min',
    sweetalert : 'lib/sweetalert.min',
    "jquery-validation" : "lib/jquery.validate.min"
  },
  shim : {
    backbone : {
      deps    : ["jquery", "underscore"],
      exports : "Backbone"
    },
    "jquery-validation" : {
      deps : ["jquery"]
    }
  }
});

 var app;


require(['controller.admin'], function(controller){ 
  app = new controller();
});
