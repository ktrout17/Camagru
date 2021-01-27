# Camagru
Camagru is an image sharing and editing website similar to Instagram, developed using primarily PHP.

## Requirements
- PHP
- HTML, CSS and JavaScript
- WAMP
- MySQL

## Installation
###### Download the source code
[```https://github.com/ktrout17/Camagru```](https://github.com/ktrout17/Camagru) and clone the repository
###### Set up and configure the database and web server
- Download WAMP from the Bitnami website: [```https://bitnami.com/stack/wamp```](https://bitnami.com/stack/wamp)
- Copy the Camagru folder into the ```WAMP\apache2\htdocs``` folder
- Navigate to ```http://localhost/Camagru/``` and the website should be up and running
- The database will be configured automatically once the site has loaded:
    - Navigate to ```http://localhost/phpmyadmin``` and you should see a ```camagru_users``` database has been created

## Code Breakdown & File Structure
- Backend (server-side)
    - PHP
- Frontend (client-side)
    - HTML
    - CSS
    - JavaScript
- Database Management Systems
    - MySQL
    - phpmyadmin

###### Folder breakdown
- config:
    - database.php - database connection
    - setup.php - database configuration
- editing:
    - camera.js - webcam & editing
    - delete_image.php - deleting uploaded images
    - functions.ph` - functions used for displaying images, likes, comments from database
    - save_img.php - saving images to database
    - upload_img.php - uploading images to database
- email_verification:
    - activate.php - verify email in the database
    - forgot_pwd - send an email to user to change their password if they forgot it & update it in the database
    - reset_pwd - changing current password to a new one & updating it in the database
- gallery_imgs - all images uploaded are saved here
- img - images/icons used in website design
- includes:
    - comments.inc.php - email notification for new comments & adding likes and comments to the database
    - comments_notifications.inc.php - enables the user to toggle notifications on or off
- stickers- predifined available stickers to superpose onto webcam/uploaded images
- style:
    - footer.php - style for the footer
    - header.php - style for the header
    - style.css - style for the entire website design
- author - author file containing name/s of contributers to the project
- comments.php - HTML markup for comments section
- editing.php - HTML markup for editing page
- get_images_gall.php - loading images on the website
- index.php - website landing page displaying posts, likes and comments of verified users
- login.php - login page based on database information
- logout.php - logs user out of the website & redirects back to landing page
- profile.php - displays user's profile as well as an option to update account info & view user's posts
- signup.php - captures user's information into the database & sends verification email
- update.php - updates user's information if they choose (username/password/email)
- update_email.php - updates user email in database
- update_pwd - updates user password in database
- update_user.php - updates user username in database
- user_gallery.php - displays user's posts

## Testing
Camagru marking sheet can be found [here](https://github.com/wethinkcode-students/web/blob/master/1%20-%20camagru/camagru.markingsheet.pdf).
###### Tests to be conducted & expected outcomes:
1. Preliminary tests:
    - **The application is developed in PHP**
        - Looking through the source code, only PHP has been used for the backend.
    - **It uses no framework, micro-framework or external libraries**
        - Looking through the source code, no framework, micro-framework or external libraries have been used.
    - **It does not need any package manager like "npm" or "composer"**
        - The application runs without a package manager
    - **index.php, config/database.php, config/setup.php files are present and configured**
        - Looking through the source code, all these files are present.
    - **PDO is configured**
        - PDO is setup in ```config/database.php```
2. Start the webserver 
    - WAMP server automatically starts when the computer is started
    - Navigating to ```http://localhost/Camagru/``` displays the landing page for Camagru
3. Create an Account (sign-up)
    - Navigating to the sign-up page, you should be able to sign-up, enter credentials and receive an email
4. Login
    - Navigating to the login page, you should be able to login using the credentials created
5. Editing
    - Navigating to the editor page, you should see a webcam after allowing Camagru access to your webcam
    - There should be a list of previously edited images (if already been edited)
    - A 'save' button to save an edited image
    - A list of available stickers
    - An option to upload a picture instead of using the webcam
6. Public Gallery
    - Accessible without authentification
    - Displays all images posted, ordered by creating date
    - Every picture is like-able and commentable (only if a verified user is logged in)
    - Notification email for every new comment if enabled
7. Change User Credentials
    - User can modify with no errors:
        - username
        - password
        - email
        - notification email preference
8. User Rights
    - A user can delete their own edit, not others
    - Editing view is only accessible if the user is logged in & verified
    - Gallery is public but only a verified user can like or comment
9. UI/UX
    - App is compatible on Firefox & Chrome
    - Mobile layout does not have elements that overlap
10. Security
    - PHPMyAdmin:
        - user's password is encrypted


## Final Mark : 118/125
