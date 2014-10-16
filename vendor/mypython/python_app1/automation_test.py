#https://pypi.python.org/pypi/selenium

from selenium import webdriver
from selenium.webdriver.common.keys import Keys

browser = webdriver.Firefox()
browser.get('http://doa.test.ucx.ucr.edu')
#assert 'Yahoo!' in browser.title

username = browser.find_element_by_name('username') 
username.send_keys('ajames')

password = browser.find_element_by_name('password') 
password.send_keys('' + Keys.RETURN)

userprofile = browser.find_element_by_link_text('Adam James')
userprofile.send_keys(Keys.RETURN)

#browser.quit()