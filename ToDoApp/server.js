const express = require('express');
const app = express();
const bodyParser = require('body-parser');
app.use(bodyParser.urlencoded({ extended: true }));

const MongoClient = require('mongodb').MongoClient;
const methodOverride = require('method-override');
app.use(methodOverride('_method'))

require('dotenv').config()

const passport = require('passport');
const LocalStrategy = require('passport-local').Strategy;
const session = require('express-session');

const http = require('http').createServer(app);
const { Server } = require("socket.io");
const io = new Server(http);


var db;
MongoClient.connect(process.env.DB_URL, { useUnifiedTopology: true }, function (에러, client) {
  if (에러) return console.log(에러);
  db = client.db('todoapp');

  http.listen(process.env.PORT, function () {
    console.log('listening on 8080');
  });
})


app.set('view engine', 'ejs');
app.use('/public', express.static('public'));




app.get('/pet', function (요청, 응답) {
  응답.send('펫용품 쇼핑할 수 있는 페이지 입니다.');
});
app.get('/beauty', function (요청, 응답) {
  응답.send('뷰티용품 쇼핑할 수 있는 페이지 입니다.');
  console.log(요청.body.title);
});

app.get('/', function (요청, 응답) {
  응답.render('index.ejs');
});



app.use(session({ secret: 'dkagh123', resave: true, saveUninitialized: false }));
app.use(passport.initialize());
app.use(passport.session());

app.get('/login', function (req, res) {
  console.log(req.user);
  res.render('login.ejs');
});

app.post('/login', passport.authenticate('local', {
  failureRedirect: '/fail'
}), function (req, res) {
  res.redirect('/mypage');
});

app.get('/fail', function (req, res) {
  res.send('login fail');
})

passport.use(new LocalStrategy({
  usernameField: 'id',
  passwordField: 'pw',
  session: true,
  passReqToCallback: false,
}, function (입력한아이디, 입력한비번, done) {
  console.log(입력한아이디, 입력한비번);
  db.collection('login').findOne({ id: 입력한아이디 }, function (에러, 결과) {
    if (에러) return done(에러)

    if (!결과) return done(null, false, { message: 'ID is not exist' })
    if (입력한비번 == 결과.pw) {
      return done(null, 결과)
    } else {
      return done(null, false, { message: 'Wrong password' })
    }
  });
}));

passport.serializeUser(function (user, done) {
  done(null, user.id)
});

passport.deserializeUser(function (아이디, done) {
  db.collection('login').findOne({ id: 아이디 }, function (error, result) {
    done(null, result)
  });
});


function 로그인했니(req, res, next) {
  if (req.user) {
    next();
  } else {
    res.redirect('/login');
  }
}

app.get('/mypage', 로그인했니, function (req, res) {
  res.render('mypage.ejs', { user: req.user.id })
});



app.get('/list', 로그인했니, function (req, 응답) {
  db.collection('post').find().toArray(function (에러, 결과) {
    응답.render('list.ejs', { data: 결과, user: req.user.id });
  });
});


app.post('/add', function (req, 응답) {
  db.collection('counter').findOne({ name: 'totalPost' }, function (에러, 결과) {
    var 총게시물갯수 = 결과.totalPost;
    var saving = {
      _id: 총게시물갯수 + 1,
      제목: req.body.title,
      날짜: req.body.date,
      작성자: req.user.id
    }
    db.collection('post').insertOne(saving, function (에러, 결과) {
      console.log(에러);
      db.collection('counter').updateOne({ name: "totalPost" },
        { $inc: { totalPost: 1 } }, function (error, result) {
          if (error) { return console.log(error) }
        });
    });
    응답.redirect('/list');
  });
});


app.put('/update', function (req, res) {
  db.collection('post').updateOne({ _id: parseInt(req.body.id) },
    { $set: { 제목: req.body.title, 날짜: req.body.date, 작성자: req.user.id } }, function (error, result) {
      console.log(error);
      res.redirect('/list');
    })
})

app.delete('/delete', function (req, 응답) {
  req.body._id = parseInt(req.body._id);
  var 삭제할거 = { _id: req.body._id, 작성자: req.user.id }
  db.collection('post').deleteOne(삭제할거, function (에러, 결과) {
    응답.send('삭제완료');
  })
  응답.status;
})

app.get('/write', function (요청, 응답) {
  응답.render('write.ejs')
});




app.get('/detail/:id', function (요청, 응답) {
  db.collection('post').findOne({ _id: parseInt(요청.params.id) }, function (에러, 결과) {
    console.log(에러);
    응답.render('detail.ejs', { data: 결과, user: 요청.user.id });
  })

});

app.get('/edit/:id', function (req, res) {
  db.collection('post').findOne({ _id: parseInt(req.params.id) },
    function (error, result) {
      console.log(error);
      res.render('edit.ejs', { data: result, user: req.user.id });
    }
  )
})


function 홈화면(req, res, next) {
  if (req.user) {
    next();
  } else {
    res.redirect('index.ejs');
  }
}
app.get('/home', 홈화면, function (req, res) {
  res.render('mypage.ejs', { user: req.user.id });
})

app.get('/logout', function (req, res) {
  req.logout(function (error, result) {
    console.log(error);
  });
  res.render('index.ejs');
})

app.get('/signup', function (req, res) {
  res.render('signup.ejs');
})


app.post('/signingup', function (req, res) {
  db.collection('login').findOne({ id: req.body.id }, function (error, result) {
    if (error) res.send(error);
    if (result) res.send('Username is already exist');
    if (!result) {
      db.collection('login').insertOne({ id: req.body.id, pw: req.body.pw }, function (error, result) {
        console.log(error);
        db.collection('counter').updateOne({ name: "totalUser" },
          { $inc: { totalUser: 1 } }, function (error, result) {
            if (error) { return console.log(error) }
          });
        res.redirect('/login');
      });
    }
  })
});

app.get('/search', (req, res) => {
  console.log(req.query.value);
  var 검색조건 = [
    {
      $search: {
        index: 'title search',
        text: {
          query: req.query.value,
          path: "제목"
        }
      }
    },
    { $sort: { _id: 1 } },
    { $limit: 10 },
    { $project: { 제목: 1, 날짜: 1, _id: 1, score: { $meta: "searchScore" } } }
  ]
  db.collection('post').aggregate(검색조건).toArray(function (에러, 결과) {
    console.log(결과);
    res.render('search.ejs', { data: 결과 });
  });
})


app.use('/shop', require('./routes/shop.js'));
app.use('/board/sub', require('./routes/board.js'));


// 이미지업로드 관련

let multer = require('multer');
var storage = multer.diskStorage({

  destination: function (req, file, cb) {
    cb(null, './public/image')
  },
  filename: function (req, file, cb) {
    cb(null, file.originalname)
  }

});

var path = require('path');
var fs = require('fs');
const Db = require('mongodb/lib/db.js');

var upload = multer({
  storage: storage,
  fileFilter: function (req, file, callback) {
    var ext = path.extname(file.originalname);
    if (ext !== '.png' && ext !== '.jpg' && ext !== '.jpeg') {
      return callback(new Error('PNG, JPG만 업로드하세요'))
    }
    callback(null, true);
  },
  limits: {
    fileSize: 1024 * 1024
  }
});
app.get('/upload', function (요청, 응답) {
  응답.render('upload.ejs')
});

app.post('/upload', upload.single('profile'), function (요청, 응답) {
  응답.send('업로드완료')
});

app.get('/image/:imageName', function (요청, 응답) {
  응답.sendFile(__dirname + '/public/image/' + 요청.params.imageName)
});

// 채팅기능 관련
var now = Date();
var sendDate = now.slice(4, 15);

app.post('/chat', 로그인했니, function (req, res) {
  db.collection('chat').findOne({ receiver: req.body.수신자, user: req.user.id }, function (error, result) {
    if (result) res.redirect('/chat');
    else if (!result) {
      let chatCollection = {
        receiver: req.body.수신자,
        sender: req.user.id,
        date: sendDate,
        title: "chat room",
        member: [req.body.수신자, req.user.id],
        conversation: []
      }
      db.collection('chat').insertOne(chatCollection).then((result) => {
        res.redirect('/chat');
      });
    }
    else if (error) res.send(error);
  });
})

app.get('/chat', 로그인했니, function (req, res) {
  db.collection('chat').find({ member: req.user.id }).toArray().then((result) => {
    res.render('chat.ejs', { data: result, user: req.user.id })
  });
});

app.post('/message/:id', 로그인했니, function (req, res) {
  var messageContent = {
    parent: req.body.parent,
    date: sendDate,
    userid: req.user.id,
    sender: req.user.id,
    content: req.body.content
  }

  db.collection('message').insertOne(messageContent).then(() => {
    console.log('message saved')
    res.send('Saved in DB')
  }).catch((error) => { console.log(error) });
});

app.get('/message/:id', 로그인했니, function (req, res) {
  res.writeHead(200, {
    "Connection": "keep-alive",
    "Content-Type": "text/event-stream",
    "Cache-Control": "no-cache",
  });
  db.collection('message').find({ parent: req.params.id }).toArray()
    .then((result) => {
      console.log(result);
      res.write('event: chatLoading\n');
      res.write('data: ' + JSON.stringify(result) + '\n\n');
    });

  const pipeline = [
    { $match: { 'fullDocument.parent': req.params.id } }
  ];

  const changeStream = db.collection('message').watch(pipeline);
  changeStream.on('change', result => {
    var updatedMessage = [result.fullDocument];
    console.log(updatedMessage);
    res.write('event: sentMessage\n');
    res.write('data: ' + JSON.stringify(updatedMessage) + '\n\n');
  });
});

app.get('/socket', function(req, res){
  res.render('socket.ejs')
})
io.on('connection', function(socket){
  console.log('user connected');
  socket.on('userSent', function(data){
    console.log(data);
    io.emit('broadcast', data)
  })
})

io.on('connection', function(socket){
  console.log(socket);
  socket.on('userSent', function(data){
    console.log(data);
    io.to(socket.id).emit('broadcast', data)
  })
})