These are PHP files which communicate with an SQL server which stores the database of books. The information requested by the client is sent back encoded as json.

TODO:
Create an "installer" which sets up the SQL database and possibly generates the DatabaseConfig.php file.

Implement some sort of security measures to prevent users from making malicious requests (deleting books that aren't theirs, for example). We don't really want to use accounts/authentication, so this problem is a little tricky. From the client applications there is no way to exploit these vulnerablities, the user must make the requests manually.
