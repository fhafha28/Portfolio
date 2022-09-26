const express = require('express');
const app = express();
var router = require('express').Router();

function 로그인했니(req, res, next) {
    if (req.user) {
      next();
    } else {
      res.redirect('/login');
    }
  }
router.use('/shirts', 로그인했니);

app.get('/sports', function(req, res){
    res.send('sports board')
})

app.get('/game',  function(req, res){
    res.send('game board')
})
 
module.exports = router;
