DataLogger-Server
=================

This is the PHP code that runs on the server in order to replicate the DataLogger's database from the house.

To run, rename `settings.sample.inc.php` to `settings.inc.php` and fill in the setting values.

Setup
-----

The included sql script creates the database.
If you are using `MariaDB` instead of `MySQL`, you can change `ENGINE=MyISAM` to `ENGINE=Aria` for improved crash recovery. (This is more important for the house computer than the server, so it may not be necessary.)