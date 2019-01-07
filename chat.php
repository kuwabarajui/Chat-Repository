<style>
  h1{
    background-image: url(fantasy_001.jpg);
    font-size:28pt;
    border-bottom: 1px solid gray;
    color: blue;
  }
  form{
    overflow: hidden;
    margin: 0px 50px 0px 0px;
    border: 3px solid gray;
    padding: 10px;
    margin-bottom: 30px;
    font-size: 18pt;
  }
  .timestamp{
    font-size: 28pt;
    border: 10px solid #dadada;
    color: lightgray;
  }
  body{
    overflow: hidden;
    margin: 30px 30px 30px 30px;
    border: 3px solid #266666;
    padding: 10px;
    font-size: 18pt;
  }
</style>
</head>
<body>

<h1>秘密のチャット</h1>
<form>
<?php
  echo $_GET['uname'];
?>
<input type="hidden" id="uname" value="<?= $_GET['uname'] ?>">
<input type="text" id="msg">
<button type="button" id="sbmt">送信</button>
</form>

<div id="chatlog"></div>

<script>
window.onload = function(){
auth();

getLog();
document.querySelector("#sbmt").addEventListener("click",function(){
    var uname = document.querySelector("#uname").value;
    var msg   = document.querySelector("#msg").value;

    var request = new XMLHttpRequest();
      request.open('POST', 'http://127.0.0.1/chat2/set.php', false);
      request.onreadystatechange = function(){
     if (request.status === 200 || request.status === 304 ) {
      var response = request.responseText;
      var json     = JSON.parse(response);

        if( json["head"]["status"] === false ){
      alert("失敗しました");
      return(false);
      }

       getLog();
     }
    else if(request.status >= 500){
     alert("ServerError");
    }
    };

     request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

     request.send(
        "uname=" + encodeURIComponent(uname) + "&"
      + "msg="   + encodeURIComponent(msg)
      );
  });
};

function auth(){
var request = new XMLHttpRequest();
request.open('POST', 'http://127.0.0.1/chat2/auth.php', false);
request.onreadystatechange = function(){
  if (request.status === 200 || request.status === 304 ) {
    var response = request.responseText;
    var json     = JSON.parse(response);

    if( json["head"]["status"] === false ){
       alert("ログインに失敗しました");
       location.href = "/chat2/";
     }
    else{
       alert("ログインに成功しました");
     }
   }
 };

request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
request.send(
      "id=" + encodeURIComponent("<?php echo $id; ?>") + "&"
    + "pw=" + encodeURIComponent("<?php echo $pw; ?>")
);
}

function getLog(){
var request = new XMLHttpRequest();
request.open('GET', 'http://127.0.0.1/chat2/get.php', false);

request.onreadystatechange = function(){
  if (request.status === 200 || request.status === 304 ) {
    var response = request.responseText;
    var json     = JSON.parse(response);
    if( json["head"]["status"] === false ){
      alert("失敗しました");
      return(false);
    }

    var html="";
    for(i=0; i<json["body"].length; i++){
      html += json["body"][i]["name"] +":"+ json["body"][i]["message"] + "<br>";
    }
    document.querySelector("#chatlog").innerHTML = html;
  }
  else if(request.status >= 500){
    alert("ServerError");
  }
};

request.onerror = function(e){
  console.log(e);
};
request.send();
}
</script>
</body>
</html>
