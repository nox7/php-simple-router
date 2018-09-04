
# php-simple-router
A simple setup to use a routing system for PHP websites. 

By default, this router requires you to make two folders. One called **Layouts** and one called **Views**. Your files for a layout and a view will be stored in these respective folders.

Finally, it requires an SQL database with a table named **uri_routes** which should have the following columns:

| column name | type | coalition | index |
| -- | -- | -- | -- |
| uri | varchar 255 | ascii_general | PRIMARY |
| view | varchar 255 | ascii_general | |
| layout | varchar 255 | ascii_general | |
| isRegularExpression | int | | |
| customData | text | | |

You should open /Classes/Database.php and change the **database** it connects to. A database is different from a table. A table belongs to a database. 

customData is a blank string column. What would be in there, if necessary, if a JSON string that will be decoded and all variables will be passed into the view to be used as global PHP variables (if necessary). You can normally just leave this blank.

isRegularExpression would tell the router that the **uri** is a regular expression and not a plain string. This is so you can parse URIs like the following: */forums/thread/334* and get the number (334) out of the URI.
