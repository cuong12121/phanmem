<?php

class FSCalendar
{
	var $cal = "CAL_GREGORIAN";
	var $format = "%Y%m%d";
	var $today;
	var $day;
	var $month;
	var $year;
	var $pmonth;
	var $pyear;
	var $nmonth;
	var $nyear;
	var $wday_names = array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	
	function __construct()
	{
		$this->day = "1";
		$today = "";
		$month = "";
		$year = "";
		$pmonth = "";
		$pyear = "";
		$nmonth = "";
		$nyear = "";
	}


	function dateNow($month,$year)
	{
		if(empty($month))
			$this->month = strftime("%m",time());
		else
			$this->month = $month;
		if(empty($year))
			$this->year = strftime("%Y",time());	
		else
		$this->year = $year;
		$this->today = strftime("%d",time());		
		$this->pmonth = $this->month - 1;
		$this->pyear = $this->year - 1;
		$this->nmonth = $this->month + 1;
		$this->nyear = $this->year + 1;
	}

	function daysInMonth($month,$year)
	{
		if(empty($year))
			$year = FSCalendar::dateNow("%Y");

		if(empty($month))
			$month = FSCalendar::dateNow("%m");
		
		if($month == 2)
		{
			if(FSCalendar::isLeapYear($year))
			{
				return 29;
			}
			else
			{
				return 28;
			}
		}
		else if($month==4 || $month==6 || $month==9 || $month==11)
			return 30;
		else
			return 31;
	}

	function isLeapYear($year)
	{
      return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0); 
	}

	function dayOfWeek($month,$year) 
  { 
		if($month > 2) 
				$month -= 2; 
		else 
		{ 
				$month += 10; 
				$year--; 
		} 
		 
		$day =  ( floor((13 * $month - 1) / 5) + 
						$this->day + ($year % 100) + 
						floor(($year % 100) / 4) + 
						floor(($year / 100) / 4) - 2 * 
						floor($year / 100) + 77); 
		 
		$weekday_number = (($day - 7 * floor($day / 7))); 
		 
		return $weekday_number; 
  }

	function getWeekDay()
	{
		$week_day = FSCalendar::dayOfWeek($this->month,$this->year);
		//return $this->wday_names[$week_day];
		return $week_Day;
	}

	function showThisMonth($array_days)
	{
		$pmonth = $this->month - 1;
		$pyear = $this->year;
		$nmonth = $this->month + 1;
		$nyear = $this->year;
		if($this->month == 1){
			$pmonth = 12;
			$pyear = $this -> year - 1;
		}
		if($this->month == 12){
			$nmonth = 1;
			$nyear = $this -> year + 1;
		}
		// TITLE
		$link_pre = FSRoute::_('index.php?module=training&views=training&Itemid=46&month='.$pmonth.'&year='.$pyear);
		$link_next = FSRoute::_('index.php?module=training&views=training&Itemid=46&month='.$nmonth.'&year='.$nyear);
		print '<div class="calendar_title">';
		print '<a class="pre_month" href="'.$link_pre.'" >&laquo;&nbsp;</a>';
		print 'Tháng <b>'.$this->month ." / " .$this->year .'</b>';
		print '<a class="next_month" href="'.$link_next.'" >&nbsp;&raquo;</a>';
		print '</div>';
		
		
		
		// DAYS IN WEEK
		print '<table id="calendar-day" cellpadding="2">';
		print '<tr>';
		for($i=0;$i<7;$i++)
			print '<td width="43" height="25" bgcolor="#b7bab6" align="center">'. $this->wday_names[$i]. '</td>';
		print '</tr>';		
		print '</table>';		
		
		
		$wday = FSCalendar::dayOfWeek($this->month,$this->year);
		$no_days = FSCalendar::daysInMonth($this->month,$this->year);
		$count = 1;
		
		print '<table id="calendar-table" >';
		print '<tr>';
		for($i=1;$i<=$wday;$i++)
		{
			print '<td align="center" width="45" height="40">&nbsp;</td>';
			$count++;
		}
		for($i=1;$i<=$no_days;$i++)
		{
			$class= '';
			if(in_array($i,$array_days)){
				$link = FSRoute::_('index.php?module=training&views=training&Itemid=46&month='.$this->month.'&year='.$this->year.'&day='.$i);
				$html = '<a href="'.$link.'" title="Các buổi training trong ngày '.$i.'/'.$this->month.'/'.$this->year.'"><strong>'.$i.'</strong></a>';
				$class .= ' events ';
			} else { 
				$html = $i;
			}
				
			if($count > 6)
			{
				if($i == $this->today)
				{
					if($this->month==strftime("%m",time())){
						print '<td align="center" width="45" height="40" class="'.$class.'"><font color="#ffff00"> ' . $html . '</font></td></tr>';	
					}
					else{
						print '<td align="center" width="45" height="40" class="'.$class.'"><font color="#ffffff"> ' . $html . '</font></td></tr>';
					}
				}
				else
				{
					print '<td align="center" width="45" height="40" class="'.$class.'"><font color="#ffffff"> ' . $html . '</font></td></tr>';
				}
				$count = 0;
			}
			else
			{
				if($i == $this->today)
				{
					if($this->month==strftime("%m",time())){
						print '<td align="center" width="45" height="40" class="'.$class.'"><font color="#ffff00"> ' . $html . '</font></td>';	
					}else{
						print '<td align="center" width="45" height="40" class="'.$class.'"><font color="#ffffff"> ' . $html . '</font></td>';
					}
				}
				else
				{
					print '<td align="center" width="45" height="40" class="'.$class.'"><font color="#ffffff"> ' . $html . '</font></td>';
				}
			}
			$count++;
		}
		print '</tr></table>';
	} 
}

?>