from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import time

b = webdriver.Firefox()

def main():
    b.get("http://localhost/MW-Resource-Checkout/")
    assert "Resource Checkout" in b.title

    b.find_element_by_name("username").send_keys("admin")
    b.find_element_by_name("password").send_keys("password" + Keys.RETURN)
    time.sleep(0.2)

    makeTestUser()

    time.sleep(0.2)

    deleteTestUser()

    b.close()

def deleteTestUser():
    for x in b.find_elements_by_name("JohnDoe"):
        x.click()
        time.sleep(0.2)
        b.find_element_by_class_name("btn").click()
        time.sleep(0.2)
        b.refresh()
        time.sleep(0.2)


def makeTestUser():
    b.find_element_by_link_text("Add user").click();

    time.sleep(0.2)

    b.find_element_by_name("firstname").send_keys("John")
    b.find_element_by_name("lastname").send_keys("Doe")
    b.find_element_by_name("username").send_keys("JohnDoe")
    b.find_element_by_name("email").send_keys("JDoe@example.com")
    b.find_element_by_name("password").send_keys("password")

    b.find_element_by_class_name("btn-success").click()

main()
