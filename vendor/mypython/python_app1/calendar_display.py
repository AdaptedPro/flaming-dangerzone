import calendar

html_calendar = calendar.HTMLCalendar(calendar.SUNDAY)
str = html_calendar.formatmonth(2013,1)
print str