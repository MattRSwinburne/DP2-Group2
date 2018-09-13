## MYSQL SETUP

By T.

__To Set Up:__

1. Fill in the db_connect_TEMPLATE.php, and save it as db_connect.php
2. Run db_setup.php
3. If you have errors, let me know!

__On Schema Changes:__

- Since we're still figuring out the schema, it may change!  If/when it does:

1. Wait for the setup script to get updated (will do asap, let me know on slack).
1b. Alternatively you can update it yourself, if you like!  But I'm happy to take care of it, so if you're not comfortable editing it it's okay.
2. Run db_drop.php
3. Run db_setup.php again
4. All done!

__Other Notes__

- Scripts are in /inc
- Also linked in the footer (/inc/footer.php)
- Easy way to get to the footer is to open layout_template.php
- (You don't need to use it as your own template it's just for my own reference, making it public for this!)
- Setup sets up your database, with the tables
- Drop deletes the entire database and all the tables
- Since I don't know what versions of MYSQL everyone is using, it's safer to drop your database and re-setup whenever the schema changes.  Theoretically you can get it to remake tables, but from what I've read that's a relatively new thing, and may not be supported in your version.  Safety first!!
- Feel free to come yell at me on slack, either because I fucked up or just because sometimes yelling is a thing that needs to happen.
