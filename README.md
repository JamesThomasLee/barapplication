# barapplication - Bobby's Bar
A simple bar ordering system designed for my ISAD251 project.

<b>Application fact sheet:</b>
My application provides a set of pages that allows a user to navigate a menu, add items to basket, and then place an order. The user can also search for their order with an order id. The user can cancel this order. When an order is cancelled it is moved to an archive table in the database.
The administrator section of the website allows the admin to view and edit the menu (add, remove, edit items) and view orders.
The website interacts with a database through the use of different classes. DBContext holds a series of functions to connect and interact with the database. This calls many views and procedures to manipulate data in the database.
