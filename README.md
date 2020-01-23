# barapplication - Bobby's Bar
A simple bar ordering system designed for my ISAD251 project.

<b>Application fact sheet:</b>
My application provides a set of pages that allows a user to navigate a menu, add items to basket, and then place an order. The user can also search for their order with an order id. The user can cancel this order. When an order is cancelled it is moved to an archive table in the database.
The administrator section of the website allows the admin to view and edit the menu (add, remove, edit items) and view orders.
The website interacts with a database through the use of different classes. DBContext holds a series of functions to connect and interact with the database. This calls many views and procedures to manipulate data in the database.

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
