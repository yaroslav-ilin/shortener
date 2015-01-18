# Tiny URLs Application #

Everybody has a right to have short URLs!

Application built on top of [Slim Framework](http://slimframework.com), because I absolutely love microframeworks and have had unused PHP server.

It uses simplest .ini file to store matches of short URLs to their long friends, because I believe that deployment should not be painful.

### Realy? And that’s all it does? ###

As a side bonus for every tiny URL you automagically have QR Code.
Check this out:

![my personal page](http://mnt.so/me/qr?size=300 "Scan this picture with your mobile device’s QR Reader)

### How do I get set up? ###

* clone repository
* run `composer install`
* rewrite data.ini with your URLs
* copy whole directory contents to your PHP web server