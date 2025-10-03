Requirements:

- PHP (8.*)
- PostgreSQL
- PgAdmin4 (Well, technically not required, but recommended)
- NPM (Node.JS)
- Composer

How to run the project locally:

First, make sure you have everything installed. PHP, PostgreSQL (Preferrably) PgAdmin4, Node.JS (It contains NPM), and Composer (for managing dependencies and more).
Next, copy-paste the .env.example file into the Ominimo_rec_task folder as just .env file (removing the .example part).

Now, DB setup:

- In PgAdmin4, make sure you have a connection to your local Postgre DB set-up. The IP is probably 127.0.0.1, And the default port is 5432.
- Installing PostgreSQL creates a user 'postgre', log in as that, password -should- be empty by default.
- Create a new user in user groups. (login/group roles). name it 'ominimo', or whatever is assigned to 'DB_USERNAME' property in .env file. Set the user's password to whatever is in 'DB_PASSWORD' property in .env file (It's empty by default, set it to what you deem secure and fit. It's a password. Whatever password you choose, you must set your 'DB_PASSWORD' property in the .env file to that password.)
- After that, create a new schema on your local pgsql server. call it 'ominimorec', or, whatever is assigned to 'DB_DATABASE' property in .env file. In security tab, under privilages, add ominimo, and give it all the permissions.

Lastly:
- Navigate in console to Ominimo_rec_task folder
- Run 'php artisan key:generate' command
- Run 'npm install' command, wait for it to install project dependencies
- Run 'composer install' command, wait for it to finish (as above)

- Run 'npm run build' command. This will build the app.
- Run 'composer run dev' command. This will launch the app in dev mode.

- At this point you -should- be able to connect to the website, by going to '127.0.0.1:8000' address in your web browser.