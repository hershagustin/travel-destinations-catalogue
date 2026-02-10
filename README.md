# Travel Destinations Catalogue 

## Project Overview
The Travel Destinations Catalogue is a PHP/MySQL web application that allows users to explore a curated collection of travel destinations from around the world. The site supports keyword searching, multi-criteria filtering, pagination, and detailed destination views. A secure admin area allows authenticated users to manage catalogue content.

This project demonstrates practical use of database design, image handling, authentication, prepared statements, and user-focused interface design.

## Catalogue Topic
Travel Destinations
Each catalogue entry represents a travel destination and contains descriptive, geographical, and cultural information to help users explore and compare destinations.
The catalogue contains 25+ destinations.

## Technologies Used
- PHP
- MySQL
- Prepared Statements
- HTML5 (semantic markup)
- Bootstrap
- CSS (responsive, mobile-first design)
- JavaScript (confirmation prompts and UI behavior)

## Database Structure
### catalogue_admin
Stores administrator login credentials.
account_id  -   Primary key
users	    -   Admin username
hashed_pass	-   Securely hashed password

Two admin accounts are present:
- Instructor
Username: instructor
Password: Password2!

- Developer
Passwords are never stored in plain text.

### fun_facts
Stores rotating fun facts related to destinations.
- fact_id	    -   Primary key
- destination	-   Related destination
- fact	        -   Fun fact text
A random fun fact is displayed when the page loads or refreshes
Admins can add, edit, and delete fun facts

### travel_destinations
Stores all catalogue items.
- destination_id        -   Primary key
- filename	            -   Image file name
- image_source	        -   Image credit/source
- destination_title	    -   Destination name
- description	        -   Description of the destination
- destination_category  -   City, Landmark, Nature, Cultural Site
- region	            -   Geographic region
- popular_activity	    -   Common activities
- visited	            -   Indicates if the destination has been visited
- best_time_to_visit	-   Recommended season or months
- currency	            -   Local currency
- language	            -   Primary language
- season_type	        -   Climate pattern
- local_cuisine	        -   Traditional foods

## Admin Functionality
The admin section is secured using session-based authentication.
Admins can:
- Add new travel destinations 
- Upload destination images
- Edit existing destinations
- Delete destinations with confirmation
- Manage fun facts
All database interactions (INSERT, UPDATE, DELETE) use prepared statements.

## Public Site Features
### Homepage
- Introduction to the travel catalogue
- Description of the project purpose
- Displays a randomly selected Fun Fact
- Main navigation to browse the catalogue

## Browse Page
### Keyword Search
- Users can search using a keyword
- The keyword is matched against all relevant text-based columns in travel_destinations
- Search can be combined with filters

### Filtering
- Users may filter destinations by:
- Destination Category
- Region
- Season Type
Filters may be used together or individually
A Clear Filters option resets the catalogue to its default state

## Pagination
- Pagination is implemented for search and filtered results as well as the homepage
- Navigation controls allow users to move between result pages


## Single Destination View
- Displays all information for a selected destination
- Includes full-size image and detailed description
- Provides a clear and readable layout

## Additional Challenge Features Implemented
### Pagination
- Implemented using SQL LIMIT and OFFSET
- Applied to filtered and searched results
- Improves usability and performance

### Fun Facts
- Stored in a dedicated database table
- Random fact displayed on page load
- Fully manageable through the admin interface

### Advanced Search
- Users can search using multiple criteria simultaneously
- Queries are dynamically built based on selected filters and keyword input

## Design & Usability
- Responsive, mobile-friendly layout
- Semantic HTML structure
- Separate home and browse pages
- Thumbnail gallery and single-item views
- Filters function as natural navigation rather than raw database queries

## Image Usage
All images used in this project are copyright-free and sourced from:
- Unsplash
- Pexels
- Pixabay
Image sources are stored in the database where applicable.

## Setup Instructions
- Import the SQL file into MySQL
- Update database credentials in /includes/db.php
- Place the project in your local server directory
- Access the site via the homepage
- Admin login available at /admin/login.php

AUTHOR : 
# Hershey Agustin