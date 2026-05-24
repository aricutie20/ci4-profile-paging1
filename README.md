If you want to test and run this project on your local computer, just follow these simple steps:

1. **Download or Clone this Repository.**
2. **Set up the Database:**
   * Open XAMPP and start both Apache and MySQL.
   * Go to `http://localhost/phpmyadmin/` and create a new database named `ci4_profile_db`.
   * Import or create the `users` table inside it.
3. **Configure the Environment Settings (.env):**
   * Make sure your database setup matches the lines inside your `.env` file:
     ```env
     database.default.database = ci4_profile_db
     database.default.username = root
     database.default.password = 
     ```
4. **Start the Local Server:**
   * Open your terminal inside the project folder and type:
     ```bash
     php spark serve
     ```
5. **Open in your Web Browser:**
   * Go to `http://localhost:8080/users` to see the working project.
