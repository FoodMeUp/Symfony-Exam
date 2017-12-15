# Symfony-Exam

CIQUAL importation
====

A famous nutritionist is in need of a search engine dedicated to nutrional data.
As for now, he only has access to the following CIQUAL table : https://ciqual.anses.fr/cms/sites/default/files/inline-files/TableCiqual2017_ExcelFR_2017%2011%2017.xls

He is asking you to help him build a modern REST API to look into this database and match a string against the value of columns ORIGGPFR
 and ORIGFDNM.

Features
----

- You will download the file directly from the web and parse it programatically. Import will be made without phpmyadmin.
- You provide a template with an input which acts like a search bar. Users will enter ingredient names in this search bar.
- You will return a list of possible matches against this search string (ingredient names from the CSV file)
- When the user clicks a match, he gets the list of nutrients
- Next step : the user is able to exclude responses where the ingredient contains a specific allergen.

How to
----

- You should import the CSV file in a MySQL format without phpmyadmin, programatically
- You use code best practices : dry, formating, architecture, model
- Requests are made through a REST API
- JSON data is sent back


Extra
----

- You are free to impress us with a nice design
- You can add extra features (display nutrient pictures, etc)
- You can optimize the UX search process

Stack
----

Last stable versions of :
- mySQL
- Symfony3
- php7

FAQ
----

### How do I start the project?

You need a clean install of a symfony3 repository.

### What about sort ordering and text filtering?

Try to display the most relevant results first. You're free to opimize the search query stirng and the search process.

### What should I do when I'm finished?

Please make a PR on the repository and send us an email to let us know we can check it.

### How is the exam graded?

We are looking for idiomatic use of php/symfony, and the ability to solve the problems with code that is clean and easy to read. Even though it's very small in scope, please show us how you would use the language and conventions to structure things in a clear and maintainable way.

Think of it as part of an application : the organisation has to be compatible with a larger project. Try to use Symfony best standards.

### This looks like it will take a while and I'm pretty busy

You're right! With something open-ended like this you could easily spend a week polishing and getting it just right. We don't expect you to do this, and we'll do our best to make sure you're not disadvantaged by this.

When we grade this exam we're not giving you a "score out of 100" for how many features you complete. We're trying to get some insight into your process, to see the way you work. So, by all means, spend more time if you want to. But you are also free to leave certain features out and give a written explanation of how you would approach it. The best approach is to spend your time on the features that you think is the best way to show us your strengths and experience.
