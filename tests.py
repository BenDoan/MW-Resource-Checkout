from selenium import webdriver
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.keys import Keys
import time

browser = webdriver.Firefox()
browser.get("http://localhost/MW-Resource-Checkout/")
assert "Resource Checkout" in browser.title
elem = browser.find_element_by_name("username")
elem.send_keys("admin")

elem = browser.find_element_by_name("password")
elem.send_keys("password" + Keys.RETURN)
time.sleep(0.2)

elem = browser.find_element_by_name()
browser.close()

