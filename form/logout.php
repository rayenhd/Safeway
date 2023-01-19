<?php 

include 'dbConn.php';
session_start();
session_unset();
session_destroy();
header('refresh:1;url=../html/main.html');

?>

<div class="one">
	<div class="two">
		<div class="three"></div>
	</div>
</div>

<style>
    div
{
	border-radius: 50%;
	transition: all 3s ease-in-out;
	
}

.one
{
	margin: 20px auto;
	width: 200px;
	height: 200px;
	animation: charging infinite 3s ease-in-out;
	animation-delay: 1s;
	
}
.two
{	
	margin: 10px auto;
	border-left:10px green solid;
	border-bottom:10px green solid;
	width: 160px;
	height: 160px;
	animation: charging infinite 3s ease-in-out;
	animation-delay: 2s;

}
.three
{
	margin: 10px auto;
	border-right: 10px gold solid;
	border-top: 10px gold solid;
	width: 120px;
	height: 120px;
	animation: charging infinite 3s ease-in-out;
	animation-delay: 3s;
}
@keyframes charging
{
	0%{transform: rotateZ(0turn);}
	100%{transform: rotateZ(1turn);}


}
</style>