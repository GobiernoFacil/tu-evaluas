// AGENTES DE INNOVACIÓN - TÚ EVALÚAS APP
// date     : 03/03/2015
// @package : agentes
// @file    : main.js
// @version : 2.0.1
// @author  : Gobierno fácil <howdy@gobiernofacil.com>
// @url     : http://gobiernofacil.com

require.config({
  baseUrl : '/js',
  paths : {
    jquery        : 'lib/jquery.min',
    backbone      : "lib/backbone",
    underscore    : "lib/underscore-min",
    text          : "lib/text"
  },
  shim : {
    backbone : {
      deps    : ["jquery", "underscore"],
      exports : "Backbone"
    }
  }
});

 var app;

require(['controller'], function(controller){ 
  app = new controller();
});