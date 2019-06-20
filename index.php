<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Score Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/index.css">
    <script src="https://www.gstatic.com/firebasejs/5.9.1/firebase.js"></script>
        <script>
          // Initialize Firebase
          var config = {
            apiKey: "AIzaSyCspIDJz-M82jCFShayNGfIpXFyrlz9ry4",
            authDomain: "quizbca.firebaseapp.com",
            databaseURL: "https://quizbca.firebaseio.com",
            projectId: "quizbca",
            storageBucket: "quizbca.appspot.com",
            messagingSenderId: "110288190354"
          };
          firebase.initializeApp(config);
    </script>

    <script src="index.js"></script>
</head>
<body>
        <button onclick="cdStart()">Start</button>
        <p id="demo" class="countdown-live" style="text-align:right; font-size: 46px; margin-top: 0px; margin-right: 20px"><b>Time Limit: 7 m 0 s</b></p>
    <div class="container">
        <div class="header">
            <img class="s1" src="res/star.png" width="100px" height="100px" alt="star">
            <img class="s2" src="res/star.png" width="100px" height="100px" alt="star">
            <div class="title">TOP 3 HIGHSCORE</div>
        </div>

            <div id="score01">
                <span id="number1"></span> <span id="nick1"></span> <span id="score1"></span>
            </div>
            <div id="score02">
                <span id="number2"></span> <span id="nick2"></span> <span id="score2"></span>
            </div>
            <div id="score03">
                <span id="number3"></span> <span id="nick3"></span> <span id="score3"></span>
            </div>
            <!-- <div id="score04">
                <span id="number4"></span> <span id="nick4"></span> <span id="score4"></span>
            </div>
            <div id="score05">
                <span id="number5"></span> <span id="nick5"></span> <span id="score5"></span>
            </div> -->

            <div id="div1">
            </div>

            <script type="text/javascript">
                var allList = [];
                var d = new Date();
                var node = "";
                var query = firebase.database().ref("leaderboard");
                var nama = [];
                var allScore = [];
                var allName = [];

                query.on('value',function(snapshot){
                        allList = [];
                         snapshot.forEach(function(childSnapshot){
                            var key = childSnapshot.key;
                            var childNickname = childSnapshot.child('nickname').val();
                            var childTotalScore = childSnapshot.child('total_score').val();
                            sort(childNickname, childTotalScore, key);
                        });
                    });

                function sort(name, scores, key){
                        var mantab = {
                            key : key,
                            nama : name,
                            score : scores,
                            getKey : function(){
                                return this.key;
                            },
                            getName : function(){
                                return this.nama;
                            },
                            getScore : function(){
                                return this.score;
                            }
                        };

                        allList.push(mantab);

                        allList.sort(function(a, b) { 
                            return b.getScore() - a.getScore();
                        });

                        for (var i = 0; i < allList.length; i++) {
                            if(i < 3){
                                document.getElementById("score0"+(i+1)).style.display = 'block';
                                document.getElementById("number"+(i+1)).innerHTML = (i+1) + ". "
                                document.getElementById("nick"+(i+1)).innerHTML = allList[i].getName();
                                document.getElementById("score"+(i+1)).innerHTML = allList[i].getScore();
                            }
                        }
                }

                function cdStart(){
                    // Set the date we're counting down to
                    var countDownDate = new Date(Date.now() + 420000).getTime();

                    // Update the count down every 1 second
                    var x = setInterval(function() {

                    // Get todays date and time
                    var now = new Date().getTime();

                    // Find the distance between now and the count down date
                    var distance = countDownDate - now;

                    // Time calculations for days, hours, minutes and seconds
                    // var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    // var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Output the result in an element with id="demo"
                    document.getElementById("demo").innerHTML = "<b>Time left : "+minutes + " m " + seconds + " s</b>";

                    // If the count down is over, write some text 
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById("demo").innerHTML = '<b>TIME UP!</b>';
                    }
                    }, 1000);
                }

                
            </script>
</body>
</html>