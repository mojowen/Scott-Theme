<?php
/**
 * Description: Home Page
 *
 * @package WordPress
 * @subpackage Urban League
 */
//get_header();

// do_project_loop();

//get_footer();
?>
<head>
<title>Scott Riker Duncombe - Homepage rebuild</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Coustard:wght@900&display=swap" rel="stylesheet">
<style type="text/css">
body {
  font-family: 'Coustard', serif;
  background-color: #45325D;
}
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 30%;
}
.title, .explain {
  width: 400px;
}
.title h1 {
  font-size: 3rem;
  color: #F0EBD8;
    word-spacing: 24px;
    text-indent: 12px;
    line-height: 110%;
}
.title h1 span {
  font-size: 120%;
}
.container:after,
.container:before {
    content: "";
    background-color: #F0EBD8;
    position: absolute;
    height: 200px;
    display: block;
    width: 200px;
    transform: rotate(45deg);
}
.container:before{
    top: -100px;left: -50px;}
.container:after {
  right: -50px; bottom: -100px;
}
</style>
</head>
<body>
  <div class="container"> 
    <div class="title">
      <h1>Scott Riker</br><span>Duncombe</span></h1>
    </div>
    <div class="explain">
      <h1>is working on his website.</h1>
    </div>
  </div>
</body>

