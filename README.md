# barapplication - Bobby's Bar
A simple bar ordering system designed for my ISAD251 project.

<b>Application fact sheet:</b><br>
My application provides customers of Bobby's bar with an online resource enabling them to view a menu and place an order. The application also provides the bar administrators with an online resource
to remove items from sale, add new items to their menu and edit current items. They can also view all of the orders and their details placed via the web application.
The application uses classes to manipulate data stored in a mysql database.

<b>Application features:</b><br>
* Users can add items to their basket<br>
* Users can place an order and set their table number for delivery<br>
* Users can view and cancel their order<br>
* Administrators can remove and relist items on the menu<br>
* Administrators can add new items to the menu<br>
* Administrators can edit items on the menu<br>
* Administrators can view all orders placed on the system

### Using the Application
Login details for administrators are hard coded into the application and are as follows:<br>
Username: Username<br>
Password: Password

### Youtube
A video giving a brief overview of my application can be found [here](https://youtu.be/xWK3JqG9Zuk)

### Screenshots
Screenshot 1:
My index page. A basic overview of the bar and a map showing its location. Map API provided by MAPBOX.
![index](/screenshots/index.PNG)
![index](/screenshots/mapAPI.PNG)

Screenshot 2:
These screenshots show my menu that a customer can access. The menus have add to basket buttons next to every item so a user can select what they want to order.
![index](/screenshots/menu1.PNG)
![index](/screenshots/menu2.PNG)

Screenshot 3:
This screenshot details the items in my basket after I have added them from my menu, and the form below that a user is required to complete to place their order. The controller checks the database to see if this user already exists. If a user does not exist then a new customer is created.
![index](/screenshots/basketandorder.PNG)

Screenshot 4:
This screenshot details the user being able to look up their order.
![index](/screenshots/orderlookup.PNG)

Screenshot 5:
This screenshot demonstrates the admin login screen. It also shows an error message. This error message is displayed by the server side input validation checks are failed. These checks are present on any user input throughout the system.
![index](/screenshots/LoginandValidation.PNG)

Screenshot 6:
This screenshot demonstrates the control panel the administrator can access. They can choose from any of the 3 buttons to select what task they want to carry out.
![index](/screenshots/ControlPanel.PNG)

Screenshot 7:
This screenshot demonstrates the menu that an admin can view. They can view extra details such as the product supplier and sale status of an item. They also have a button to edit items or change the status. The status is used by the database views to determine what items to display on the user menu. If an items status is set to OFFSALE it will not be displayed to a customer.
![index](/screenshots/admin_menu.PNG)

Screenshot 8:
This is the form displayed to an admin when they want to edit or add an item. If an item is being edited, its data is pre populated into the form. Server side validation is also in place on these forms.
![index](/screenshots/edit-additem.PNG)

Screenshot 9:
This is the table displayed to an admin when they wish to view all orders. Beside each order is a button that displays a view detailing the order details and all of the products in the order.
![index](/screenshots/adminorders.PNG)
![index](/screenshots/adminvieworder.PNG)

Screenshot 10:
Evidence of my application operating in multiple browsers - firefox and chrome.
![index](/screenshots/firefox.PNG)
![index](/screenshots/chrome.PNG)


### Application Testing
##### User Testing
|Test|Outcome|
|---|---|
|Add 5 items to basket.|5 items were added to the basket successfully.|
|Remove 2 items at random.|2 items were removed from the basket.|
|Place an order.|The remaining 3 items were used to place an order. The order was placed successfully and an order confirmation was displayed.|
|Search for an order.|The order ID was used from the previously placed order to search for the order. The order was found and all details were displayed correctly.|
|Cancel an order.|The order was cancelled successfully.|

##### Administrator Testing
|Test|Outcome|
|---|---|
|Log in with administrator credentials.|The login details allowed me to be authenticated and enter the administrator section of the website.|
|Add an item.|An item was successfully added to the menu.|
|Edit the item just added.|All fields of the item were updated successfully.|
|Change the status of the item.|The item was taken off sale and then relisted on sale successfully.|
|View all orders.|All orders were displayed in a table successfully.|
|View a specific order.|The order was viewed successfully and a table of all the products in a table was displayed.|
|Log out.|User logged out successfully.|

##### Security Testing
|Test|Outcome|
|---|---|
|Try to access all administrator pages via URL.|Every page redirects the user back to the index page. No administrator page can be accessed without logging in first.|
|Input invalid customer details.|Error messages were displayed on screen.|
|Input customer details longer than 30 characters.|Error messages were displayed on screen.|
|Input incorrect details into the login form.|Error messages were displayed on screen.|
|Incorrect details into both add and edit item forms.|Error messages were displayed on screen. Inputted values were not saved and the form had to be re-completed.|

##### Web Accessibility Initiative
|Test|Outcome|
|---|---|
|Text alternatives for non-text content.|All buttons on the site feature text content. This could be changed and was on my to do list however it has not been completed before the project deadline.|
|Captions and other alternatives for multimedia|There is no multimedia on the site to provide alternatives for.|
|Content can be presented in different ways|Content cannot be presented in different ways. I could improve this by providing a button to change the css style to provide content in a different colour scheme.||
|Content is easy to see and hear|Colour scheme is designed to be easily visible.|
|Users have enough time to read and use the content|There is no dynamic pages in the site so no time limit on any content.|
|Content does not cause seizures or physical reactions.|No moving content on the site.|
|Users can easily navigate and determine where they are.|The website is very easy to navigate due to an always available navigation bar and clear headings.|
|Text is readable and understandable.|Colour scheme and font is easily readable.|
|Content appears and operates in predictable ways.|Website follows a predictable order structure. The typical structure that most online webstores follow.|
|Users are helped to avoid and correct mistakes.|Server side security prevents any false information from being input and provides the user with a prompt when incorrect information is input. Another confirmation page could be provided to allow a customer to double check their order before placing it.|
