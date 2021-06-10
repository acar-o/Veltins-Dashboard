## Project Description

This project is about developing a web-based dashboard used to create all the statistics and evaluations of Veltins competition and present them with graphics.

## Development Environment and Libraries

Visual Studio Code was used as a development environment. 

PHP was used to communicate with the existing MySQL database. 

JavaScript was used for front-end logic.

HTML, CSS, Bootstrap were used for the basic structure and styling of the dashboard, and Chart.js for statistics and graphics.

NPM and Composer were used as the package manager.

Although the participant data structure did not contain any gender-specific information, it was necessary to rank participants by gender. The [tuqqu/gender-detector](https://github.com/tuqqu/gender-detector) package was used for this purpose.

Participants' postal codes were present in the data structure, but state information was not available. A table showing the state distribution was required. For this purpose, a JSON file containing all postal codes and federal states for Germany has been added to the project. In this JSON file, federal states and postal codes were compared with the postal codes in the database, and the federal states of the participants were determined and a distribution table was created by the federal states.

Communication between JavaScript file and PHP and JSON files is established by AJAX queries.

## Result
The project has been successfully implemented, documented and submitted. Click [here](https://github.com/acar-o/Veltins-Dashboard/blob/master/Documentation/Projektbericht.pdf) to see the documentation. 

## Screenshot for the Dashboard
![screenshot](https://github.com/acar-o/Veltins-Dashboard/blob/master/images/sreenshot.png)
