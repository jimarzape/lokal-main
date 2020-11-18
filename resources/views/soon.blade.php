<!DOCTYPE html>
<html>
<head>
	<title>LokaldatPH</title>
	<style>
		.countdown {
		  text-align: center;
		  margin-bottom: 20px;
		}
		.countdown .timeel {
		  display: inline-block;
		  padding: 10px;
		  background: #151515;
		  margin: 0;
		  color: white;
		  min-width: 2.6rem;
		  margin-left: 13px;
		  border-radius: 10px 0 0 10px;
		}
		.countdown span[class*="timeRef"] {
		  border-radius: 0 10px 10px 0;
		  margin-left: 0;
		  background: #e8c152;
		  color: black;
		}
		.countdown
		{
			font-size: 4em;
		}
		</style>
</head>
<body style="text-align: center">
	<img src="/media/img/logo-hd.png" style="width: 250px;height: 250px;object-fit: contain;margin-top: 5em">
	<h1 style="font-family: sans-serif;font-size: 4em; color: red;">Coming Soon</h1>
	<div class="countdown" id="countdown1">
	  <span class="days">00</span>:
	  <span class="hours">00</span>:
	  <span class="minutes">00</span>:
	  <span class="seconds">00</span>
	</div>
</body>
<script type="text/javascript">
	/*
 * Basic Count Down to Date and Time
 * Author: @guwii / guwii.com
 * https://guwii.com/bytes/easy-countdown-to-date-with-javascript-jquery/
*/
	window.onload = function() {
	  // Month Day, Year Hour:Minute:Second, id-of-element-container
	  countDownToTime("Dec 1, 2020 00:00:00", 'countdown1'); // ****** Change this line!
	}
	function countDownToTime(countTo, id) {
	  countTo = new Date(countTo).getTime();
	  var now = new Date(),
	      countTo = new Date(countTo),
	      timeDifference = (countTo - now);
	      
	  var secondsInADay = 60 * 60 * 1000 * 24,
	      secondsInAHour = 60 * 60 * 1000;

	  days = Math.floor(timeDifference / (secondsInADay) * 1);
	  hours = Math.floor((timeDifference % (secondsInADay)) / (secondsInAHour) * 1);
	  mins = Math.floor(((timeDifference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
	  secs = Math.floor((((timeDifference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);

	  var idEl = document.getElementById(id);
	  idEl.getElementsByClassName('days')[0].innerHTML = timestr(days);
	  idEl.getElementsByClassName('hours')[0].innerHTML = timestr(hours);
	  idEl.getElementsByClassName('minutes')[0].innerHTML = timestr(mins);
	  idEl.getElementsByClassName('seconds')[0].innerHTML = timestr(secs);

	  clearTimeout(countDownToTime.interval);
	  countDownToTime.interval = setTimeout(function(){ countDownToTime(countTo, id); },1000);
	}

	function timestr(number)
	{	
		if(number < 10)
		{
			number = '0' + number;
		}
		return number;
	}
</script>
</html>