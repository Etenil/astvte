ASTVTE
======

Astvte is a very simple and minimal blogging engine for PHP.

Installing
----------
To install, checkout the code, then run [http://getcomposer.org](composer) like so:

    composer install

This will install the necessary dependencies.

Rename or copy the file *blog.conf.php.example* to *blog.conf.php* and modify the settings according to your web server's setup. Make sure you specify the corrent prefix for your website otherwise URL routing will not work and you'll bump into 404 error pages.

Navigate to http://*host*/*prefix*/cms, login and create a new post.

Done.
