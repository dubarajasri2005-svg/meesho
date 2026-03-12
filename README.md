Meesho E-Commerce Web Application
Project Overview
This project is a Meesho-like E-Commerce Web Application developed using HTML, CSS, PHP, and MySQL. The system allows users to browse products, add items to the cart, place orders, and track order status. It also includes user authentication, product categories, payment options, and order management features.

The main objective of this project is to demonstrate how database management concepts and web technologies can be used to develop a real-world e-commerce system.

Technologies Used

Frontend: HTML, CSS

Backend: PHP

Database: MySQL

Server: XAMPP (Apache + MySQL)

Features

User Registration and Login

Product Categories

Product Listing with Images

Search Products

Add to Cart

Buy Now Option

Checkout System

Cash on Delivery / Online Payment Option

Order Tracking

Product Reviews and Ratings

Stock Management

Project Structure
meesho_project_db/
│
├── index.php
├── product.php
├── cart.php
├── checkout.php
├── login.php
├── signup.php
├── logout.php
├── orders.php
├── db.php
│
├── images/
│   └── product_images
│
└── database/
    └── meesho-project.sql
Database Tables

The system uses the following main tables:

users

sellers

resellers

customers

categories

products

orders

order_items

payments

delivery

reviews

returns

How to Run the Project

Install XAMPP on your system.

Start Apache and MySQL from the XAMPP Control Panel.

Copy the project folder into:

xampp/htdocs/

Open phpMyAdmin.

Create a database named:

meesho-project

Import the SQL database file.

Open the browser and run:

http://localhost/meesho_project_db
Future Improvements

Mobile Application Version

AI Product Recommendation

Secure Payment Gateway Integration

Real-Time Delivery Tracking

Advanced Seller Dashboard

Author

Project Developed By:
Rajasri
