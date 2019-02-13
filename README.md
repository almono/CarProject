# Car_Project

PROJECT DESCRIPTION

This small application was created with Laravel 5.7 framework.
Project was made with WAMP. 

To run it all that needs to be done is have configured WAMP/LAMP that let you host application on localhost.

First step is to download the github repository and then making a copy of env.example file and renaming it to .env where all the main configuration is saved.
Next step is to make a database called "cars" ( or other name but you have to remember to set the proper database name, user and password in the .env file afterwards, make sure the character encoding is set correctly! ) and then by running "php artisan migrate" command in the project directory user will get the database structure used in this project.

After launching the application user is asked for the csv file containing all the cars, models and submodels which is uploaded to the server and afterwards all the data is being inserted into the database.
Now that the data has been inserted all that is left is selecting the proper options from the dropdown lists.

Project structure:
- Application asks for file if there are no records that could be displayed
- After uploading files the first dropdown ( makes ) is being populated by the proper data 
- Changing selection of any of the dropdowns will cause an AJAX request to be sent to populate the next list
- Picking any of the options will produce a text informing user about current selection
